<?php

namespace App\Http\Controllers\Admin;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        Message::create([
            'team_id' => $team->id,
            'user_id' => $user->id,
            'message' => $message,
        ]);
        
        MessageSent::dispatch($team,$user,$message);

    }

    public function render ($teams, $teamItems)
    {

        if($teams != null && $teams->count()>0){
            foreach($teams as $team){
                $teamItems .= '<a href="'.route('admin.teams.show', $team).'" style="text-decoration: none;" class=" bg-secondary bg-gradient">';
                $teamItems .= '<div class="row">';
                $teamItems .= '<div class="col-4 text-right ">';
                if($team->getFirstMediaUrl("teams")){
                    $teamItems .= '<img alt="DP" class="rounded-circle img-fluid mr-3" width="25" height="25" src="' . $team->getFirstMediaUrl("teams") . '" />';
                }else{
                    $teamItems .= '<img alt="DP" class="rounded-circle img-fluid" width="45" height="40" src="'. asset('images/team.jpg') .'">';
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
}
