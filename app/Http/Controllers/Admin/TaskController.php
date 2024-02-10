<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskAssigned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->hasRole('admin')){
            $tasks = Task::with('project', 'user')->get();
        } else {
            $tasks = Task::where('user_id', Auth::user()->id)->get();
        }

        return view('admin.tasks.index', [
            'tasks' => $tasks,
            'page' => 'tasks List'
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Task::class);

        $projects = Project::all();
        return view('admin.tasks.create', [
            'projects' => $projects,
            'page' => 'Creating task',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        //the authorization is in the form request class 
        $AssignedUser = User::findOrFail($request->user_id);

        $task = Task::create($request->validated());
        
        $AssignedUser->notify(new TaskAssigned($task));

        return redirect()->route('admin.tasks.index')->with('message', 'the task has been created sucessfully');;
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task->with('project');
        return view('admin.tasks.show', [
            'task' => $task,
            'page' => 'Showing task',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $projects = Project::all();
        $project = $task->project()->get();
        //because we get a collection 
        // dd($project[0]->title);
        return view('admin.tasks.edit', [
            'projects' => $projects,
            'task' => $task,    // ->with('user')
            'taskproject' => $project[0], //because we get a collection 
            'page' => 'Editing Task',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);   
        $AssignedUser = User::findOrFail($request->user_id);    

        $oldTaskUserId = $task->user_id;
        $task->update($request->validated());

        // check if the user is not changed 
        if($oldTaskUserId != $AssignedUser->id){
            $AssignedUser->notify(new TaskAssigned($task));
        }
        
        return redirect()->route('admin.tasks.index')->with('message', 'the task has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();
        return redirect()->route('admin.tasks.index')->with('message','the task has been deleted successfully');
    
    }
}
