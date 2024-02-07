<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', [
            'projects' => $projects,
            'page' => 'projects List'
        ]);   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $clients = Client::all();
        return view('admin.projects.create', [
            'users' => $users,
            'clients' => $clients,
            'page' => 'Creating project',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        $project = Project::create($request->validated());
        
        return redirect()->route('admin.projects.index')->with('message', 'the project has been created sucessfully');;
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->with('user', 'client');
        return view('admin.projects.show', [
            'project' => $project,
            'page' => 'Showing project',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $users = User::all();
        $clients = Client::all();
        return view('admin.projects.edit', [
            'users' => $users,
            'clients' => $clients,
            'project' => $project,
            'page' => 'Editing Project',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {

        $project->update([
            'title'       => $request->validated('title'),
            'description' => $request->validated('description'),
            'deadline'    => $request->validated('deadline'),
            'user_id'     => $request->validated('user_id'),
            'client_id'   => $request->validated('client_id'),
        ]);
        
        if($request->status == 'true') {
            $project->status = true;  
        } 
        elseif ($request->status == 'false') {
            $project->status = false;  
        } 
        
        $project->save();

        return redirect()->route('admin.projects.index')->with('message', 'the project has been updated successfully');
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('admin.projects.index')->with('message','the project has been deleted successfully');
    
    }
}
