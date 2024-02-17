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
        $status = $request->input('status'); 
        $statuses =array(); 
         
        $counter = 1;
        foreach ($user_ids as $user_id) {
            $stingCounter = (string)$counter;
            array_push($statuses, $stingCounter);
            $counter=$counter+1; 
        }

        if( $user_ids !=null && sizeof($user_ids)>0 && $titles !=null && sizeof($titles)>0 && $descriptions !=null && sizeof($descriptions)>0 && $statuses !=null && sizeof($statuses)>0){
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
