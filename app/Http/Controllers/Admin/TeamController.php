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

        //teams
        // here is the rendering section 
        $teamItems="";
        
        if($teams != null && $teams->count()>0){
            $teamItems .= '<li class="nav-item has-submenu">
                                <a class="nav-link" > 
                                    <svg class="nav-icon">
                                        <use xlink:href="'. asset('vendors/@coreui/icons/svg/free.svg#cil-chat-bubble').'"></use>
                                    </svg>
                                    Teams  
                                    <span class="ms-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="8"/>
                                        </svg>
                                    </span>
                                </a>';
            $teamItems .= '<ul class="submenu collapse">';
            foreach($teams as $team){
                $teamItems .= '<li>';
                $teamItems .= '<a class="nav-link" href="'. route('admin.teams.show', $team->id).'">';
                if($team->getFirstMediaUrl("teams")){
                    $teamItems .= '<img alt="DP" class="rounded-circle img-fluid mr-3" width="25" height="25" src="' . $team->getFirstMediaUrl("teams") . '" />' . $team->name;
                }else{
                    $teamItems .= '<img alt="DP" class="rounded-circle img-fluid mr-3" width="25" height="25" src="' . asset('images/team.jpg') .'" />'. $team->name;
                }
                    $teamItems .= '<span class="ms-2">';
                    $teamItems .= '<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">';
                    $teamItems .=   '<circle cx="8" cy="8" r="8"/>';
                    $teamItems .= '</svg>';
                    $teamItems .= '</span>';
                $teamItems .= '</a>';
                $teamItems .= '</li>';

                $teamItems .= '<hr>';

            }
            $teamItems .= '</ul>';
            $teamItems .= '</li>';
        }else{
            "";
        }
        
        return json_encode(array($teamItems));
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

}
