<?php

namespace App\Http\Controllers\Admin;

use App\Events\MessageReaded;
use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Messagenotification;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->hasRole('admin')){
            $teams = Team::all();
        } else {
            $user = Auth::user();
            
            $teams = collect();
            $projects = $user->projects()->get();
            $projects->map(function (Project $project) use($teams) {
                $teams->add($project->team);
            });
        }
        
        $teamItems="";
        $var = $this->render($teams,  $teamItems);

        return json_encode(array($var));
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        $this->authorize('view', $team);

        // users that read the message
        return view('admin.teams.show', [
            'team' => $team,
        ]);
    }

    public function sendMessage ()
    {
        $message = request()->input('message');
        $fromUser = request()->input('user_id');
        $teamChat = request()->input('project_id');

        $user = User::find($fromUser);
        $team = Team::find($teamChat);

        if($team->project->users->contains($user)){
            $createdmessage = Message::create([
                'team_id' => $team->id,
                'user_id' => $user->id,
                'message' => $message,
            ]);

            $createdmessageId = $createdmessage->id;

            // add the notification in the table
            foreach($team->project->users as $teamuser){
                if($teamuser->id != auth()->user()->id){
                    Messagenotification::create([
                        'user_id' => $teamuser->id,
                        'team_id' => $team->id,
                        'message_id' => $createdmessage->id,
                        // 'team_id' => $team->id,
                        'from_user_id' => auth()->user()->id,
                    ]);
                }
            }    
            // $numberOfUnreadedMessages = $team->numberOfUnreadedTeamMessages;    
            MessageSent::dispatch($team,$user,$message, $createdmessageId);
        }else{
            //unauthorized
            abort(403);
        }

    }

    public function render ($teams, $teamItems)
    {

        if($teams != null && $teams->count()>0){
            foreach($teams as $team){
                // $teamItems .= '<a id="team-'.$team->id.'" href="'.route('admin.teams.show', $team).'" style="text-decoration: none;" class=" bg-secondary bg-gradient"  onclick="markasread('.$team->id.','. auth()->user()->id.')">';
                $teamItems .= '<a id="team-'.$team->id.'" href="'.route('admin.teams.show', $team).'" style="text-decoration: none;" class=" bg-secondary bg-gradient"  onclick="markasread('.$team->id.','. auth()->user()->id .','. $team->messagenotifications->where('user_id', auth()->user()->id)->count().')">';

                $teamItems .= '<div class="row ">';
                $teamItems .= '<div class="col-4 text-right position-relative">';
                if($team->getFirstMediaUrl("teams")){
                    $teamItems .= '<img alt="DP" class="rounded-circle img-fluid mr-3" width="25" height="25" src="' . $team->getFirstMediaUrl("teams") . '" />';
                }else{
                    $teamItems .= '<img alt="DP" class="rounded-circle img-fluid" width="45" height="40" src="'. asset('images/team.jpg') .'">';
                }
                if($team->numberOfUnreadedTeamMessages==0){
                    $teamItems .= '<em id= "num_of_single_team_notifications-'.$team->id.'" class="badge bg-danger text-white px-2 rounded-4 position-absolute bottom-0 end-0" style="font-size: 0.6em"></em>';
                }else{
                    $teamItems .= '<em id= "num_of_single_team_notifications-'.$team->id.'" class="badge bg-danger text-white px-2 rounded-4 position-absolute bottom-0 end-0" style="font-size: 0.6em">'.$team->numberOfUnreadedTeamMessages.'</em>';
                }
                $teamItems .= '</div>';
                $teamItems .= '<div class="col-8">';
                $teamItems .= '<h5 class="text-left text-md pt-2">'.$team->name.'</h5>';
                $teamItems .= '</div>';
                $teamItems .= '</div>';
                $teamItems .= '</a>';
                
            }
        }else{
            $teamItems = '<h4 class="text-center mb-5" style="color: #673AB7;">there is no projects assigned to you so get rest now <span style="font-size:100px;">&#128150;</span> </h4>';
        }
        
        return $teamItems;

    }


    public function markMessagesAsReaded ()
    {
        $teamId = request()->input('teamId');
        $authUserId = request()->input('authUserId');

        $readedMessages= array();

        $user = User::find($authUserId);
        $team = Team::find($teamId);

        if($team->project->users->contains($user)){
            // get all the records from the "messagenotifications" table that match the user id - notifications that realted to this user in this team  
            $teamMessagenotifications = $team->messagenotifications->where('user_id', $authUserId);
            
            foreach($teamMessagenotifications as $teamMessagenotification){
                $teamMessagenotification->readed_at = now();
                $teamMessagenotification->save();
                array_push($readedMessages, $teamMessagenotification->message_id);
            }

            //dipatch (((messages))) readed
            MessageReaded::dispatch($user, $readedMessages, $team);
        } else {
            abort(403);
        }
    }
}
