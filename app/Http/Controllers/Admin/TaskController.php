<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('project')->get();
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
        $task = Task::create($request->validated());
        
        return redirect()->route('admin.tasks.index')->with('message', 'the task has been created sucessfully');;
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
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
        $projects = Project::all();
        return view('admin.tasks.edit', [
            'projects' => $projects,
            'task' => $task,
            'page' => 'Editing Task',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $task->update($request->validated());
        
        return redirect()->route('admin.tasks.index')->with('message', 'the task has been updated successfully');
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('admin.tasks.index')->with('message','the task has been deleted successfully');
    
    }
}
