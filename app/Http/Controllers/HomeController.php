<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::all();
        $numberofClosedTasks = array();
        $usersIds = array();

        foreach ($users as $user){
            array_push($numberofClosedTasks, $user->numberOfClosedTasks);
            array_push($usersIds, $user->id);
        }

        $topFourUsers=collect();

        for($i=0; $i<4 ; $i++){
            $maxs = array_keys($numberofClosedTasks, max($numberofClosedTasks));
            $bestUser = User::find($usersIds[$maxs[0]]);

            $topFourUsers->push($bestUser);
            // those to remove the previouse element from the array
            unset($numberofClosedTasks[$maxs[0]]);
            unset($usersIds[$maxs[0]]);
        }
        
        $taskCompletePercentage =  Task::taskCompletePercentage();
        $projectCompletePercentage =  Project::projectCompletePercentage();


        $users = User::with('projects','tasks')->get();
        $projects = Project::with('users','tasks')->get();;
        $skills = Skill::all();
        $clients = Client::all();
        $tasks = Task::with('project','user')->get();;
        return view('home', [
            'users' => $users,
            'projects' => $projects,
            'skills' => $skills,
            'clients' => $clients,
            'tasks' => $tasks,
            'topFourUsers' => $topFourUsers,
            'taskCompletePercentage' => round($taskCompletePercentage) ,
            'projectCompletePercentage' => round($projectCompletePercentage) ,
        ]);
    }
}
