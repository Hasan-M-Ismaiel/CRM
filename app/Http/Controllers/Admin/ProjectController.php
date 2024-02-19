<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignUserStoreRequest;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Client;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Team;
use App\Models\User;
use App\Notifications\ProjectAssigned;
use App\Services\MatcherUserProjectSkillsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
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
        $skills = Skill::all();
        return view('admin.projects.create', [
            'users' => $users,
            'clients' => $clients,
            'skills' => $skills,
            'page' => 'Creating project',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        // $this->authorize('restore');
        
        $assignedUsers = $request->input('assigned_users'); // the ids of the added users 
        // if( $assignedUsers !=null && sizeof($assignedUsers)>0){
            $project = Project::create($request->validated());

            //create the team Group that belongs to this project 
            $team = Team::create([
                'project_id' => $project->id,
                'name' => 'team-'.$project->id,   // this is by default
            ]);

            // if ($request->hasFile('image')) {
            //     $team->addMediaFromRequest('image')->toMediaCollection('teams');
            // } 
            
            if($assignedUsers !=null && sizeof($assignedUsers)>0){
                foreach ($assignedUsers as $assignedUser) {
                    $project->users()->attach($assignedUser);
                }
            }
        
            $assignedSkills = $request->input('assigned_skills'); // the ids of the added skills 
            if( $assignedSkills !=null && sizeof($assignedSkills)>0 ){
                foreach ($assignedSkills as $assignedSkill) {
                    $project->skills()->attach($assignedSkill);
                }
            } 

            $new_skills = $request->input('new_skills');
            if( $new_skills !=null && sizeof($new_skills)>0 ){
                //creating the new skill and attach it to the new user
                foreach ($request->get('new_skills') as $name) {
                    $skill = Skill::create([                            // ! note -  it should be find or create && and the name should be unique in the table
                        'name' => $name
                    ]);
                    $project->skills()->attach($skill);
                }
            }
            
            Notification::send($project->users, new ProjectAssigned($project));

            // return redirect()->route('admin.projects.index')->with('message', 'the project has been created sucessfully');;
            return  redirect()->route('admin.success_create_project.status', ['project'=>$project]);
        // }
        // back those to the uncomment - this is just for testing 
        // } else {
        //     return redirect()->back()->with('message', 'please do not leave the project without users');
        // }
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
        
        $requiredSkills = array();
        // the skills for the project should not be null
        foreach($project->skills as $skill){
            array_push($requiredSkills, $skill->name);
        }

        $MatcherUserProjectSkills = new MatcherUserProjectSkillsService($requiredSkills);
        $matchedUsers =  $MatcherUserProjectSkills->getMatchedUsersToProject();
        $users = User::find($matchedUsers);

        // $users = User::all();
        $clients = Client::all();
        $skills = Skill::all();
        return view('admin.projects.edit', [
            'users' => $users,
            'clients' => $clients,
            'project' => $project,
            'skills' => $skills,
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
        
        $assignedSkills = $request->input('assigned_skills'); // the ids of the added skills 
        if( $assignedSkills !=null && sizeof($assignedSkills)>0 ){
            foreach ($assignedSkills as $assignedSkill) {
                $project->skills()->attach($assignedSkill);
            }
        } 

        $new_skills = $request->input('new_skills');
        if( $new_skills !=null && sizeof($new_skills)>0 ){
            //creating the new skill and attach it to the new user
            foreach ($request->get('new_skills') as $name) {
                $skill = Skill::create([                            // ! note -  it should be find or create && and the name should be unique in the table
                    'name' => $name
                ]);
                $project->skills()->attach($skill);
            }
        }

        
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
