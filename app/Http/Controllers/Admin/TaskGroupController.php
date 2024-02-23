<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskGroupsStoreRequest;
use App\Models\Project;
use App\Models\Task;
use App\Notifications\TaskAssigned;
use Illuminate\Http\Request;

class TaskGroupController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $id = request()->projectId;
        $project = Project::find($id);
        $users = $project->users()->get();
        return view('admin.taskGroups.create', [
            'users' => $users,
            'project' => $project,
            'page' => 'Creating tasks',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskGroupsStoreRequest $request)
    {
        $project = Project::find($request->project);
        $user_ids = $request->input('user_ids');
        $titles = $request->input('titles'); 
        $descriptions = $request->input('descriptions');
        $statuses =array();

        // check if the titles array is not empty
        foreach($titles as $title){
            if($title==null){
                return redirect()->back()->with('message', 'there is an error in the titles, please try again');
            }
        }
        
        // check if the user_ids array is not empty
        foreach($user_ids as $user_id){
            if($user_id==null){
                return redirect()->back()->with('message', 'there is an error in the user selection, please try again');
            }
        }

        // check if the descriptions array is not empty
        foreach($descriptions as $description){
            if($description==null){
                return redirect()->back()->with('message', 'there is an error in the description, please try again');
            }
        }

        if(sizeof($user_ids)>0 && sizeof($titles)>0 && sizeof($descriptions)>0 ){
            $counter = 1;
            foreach ($user_ids as $user_id) {
                $stingCounter = (string)$counter;
                array_push($statuses, $stingCounter);
                $counter=$counter+1; 
            }

            $counter = 0;
            foreach ($user_ids as $user_id) {
                $task = Task::create([
                    'title' => $titles[$counter],
                    'description' => $descriptions[$counter],
                    'project_id' => $project->id,
                    'user_id' => $user_ids[$counter],
                    'status' => "opened",
                    // 'status' => $request->input('status-'.$statuses[$counter]),
                ]);
                $task->user->notify(new TaskAssigned($task));
                $counter = $counter +1;
            }
            // return redirect()->route('admin.projects.index')->with('message', 'the project has been created sucessfully');;
            return  redirect()->route('admin.success_create_tasks.status', ['project'=>$project]);
        } else {
            return redirect()->back()->with('message', 'there is an error, please try again');
        }
    }
}
