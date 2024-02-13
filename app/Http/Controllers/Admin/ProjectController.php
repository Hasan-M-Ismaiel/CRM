<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignUserStoreRequest;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Client;
use App\Models\Project;
use App\Models\User;
use App\Notifications\ProjectAssigned;
use App\Notifications\ProjectUnAssigned;
use App\Notifications\TaskAssigned;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rules\NotIn;
use Symfony\Component\VarDumper\VarDumper;
use App\Services\NotificationService;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // this method does not need protection - because we assume that we have just ( admin - user ) roles and we handle this using if-else
    public function index()
    {
        if(auth()->user()->hasRole('admin')){
            $projects = Project::all();
        } else {
            $user = Auth::user();
            $projects = $user->Projects()->get();
        }
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
        $this->authorize('create', Project::class);

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
        // $this->authorize('restore');

        $assignedUsers = $request->input('assigned_users');
        

        if( sizeof($assignedUsers)>0){
            $project = Project::create($request->validated());
            
            foreach ($assignedUsers as $assignedUser) {
                $project->users()->attach($assignedUser);
            }
            
        } else {
            return redirect()->back()->with('message', 'please do not leave the project without users');
        }
        
        Notification::send($project->users, new ProjectAssigned($project));
        return redirect()->route('admin.projects.index')->with('message', 'the project has been created sucessfully');;
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        if(request('notificationId')){
            auth()->user()->unreadNotifications
            ->when(request('notificationId'), function ($query) {
                return $query->where('id', request('notificationId'));
            })
            ->markAsRead();
        }
        
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
        $this->authorize('update', $project);

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
        $this->authorize('update', $project);   
        
        $project->update([
            'title'       => $request->validated('title'),
            'description' => $request->validated('description'),
            'deadline'    => $request->validated('deadline'),
            'client_id'   => $request->validated('client_id'),
        ]);
        

        $assignedUsers = $request->input('assigned_users');
        $sendNotification = new NotificationService($project, $assignedUsers);
        $sendNotification->SendNotificationMessages();

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
        $this->authorize('delete', $project);

        $project->delete();
        return redirect()->route('admin.projects.index')->with('message','the project has been deleted successfully');
    }

    // protect this method using meddleware
    public function assignCreate(Project $project)
    {
        $users = User::all();

        return view('admin.projects.assignCreate', [
            'users' => $users,
            'project' => $project,
            'page' => 'Assigning users to the project',
        ]);
    }

    // protect this method using meddleware
    public function assignStore(AssignUserStoreRequest $request, Project $project)
    {
        // the users those are been passed to here form the page  
        $assignedUsers = $request->input('assigned_users'); //associative array 

        $sendNotification = new NotificationService($project, $assignedUsers);
        $sendNotification->SendNotificationMessages();

        return redirect()->route('admin.projects.index')->with('message', 'the project has been updated sucessfully');
    }
}
