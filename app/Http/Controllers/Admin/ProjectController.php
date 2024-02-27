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
use App\Notifications\TeamleaderRoleAssigned;
use App\Notifications\TeamleaderRoleUnAssigned;
use App\Services\MatcherUserProjectSkillsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Services\NotificationService;
use App\Services\RenderProjectsTableService;

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
        $teamleader = User::findOrFail($request->teamleader_id);

        $assignedUsers = $request->input('assigned_users'); // the ids of the added users 
            // if( $assignedUsers !=null && sizeof($assignedUsers)>0){
            $project = Project::create($request->validated());

            //create the team Group that belongs to this project 
            $team = Team::create([
                // here we should add field as user_id - refer to the teamleader - but it is fine becasue you can get the teamleader [$team->project->teamleader]
                'project_id' => $project->id,
                'name' => 'team-'.$project->id,   // this is by default
            ]);

            // if ($request->hasFile('image')) {
            //     $team->addMediaFromRequest('image')->toMediaCollection('teams');
            // } 
            
            if($assignedUsers !=null && sizeof($assignedUsers)>0){
                $preCreatedUsers = User::find($assignedUsers);
                foreach ($preCreatedUsers as $preCreatedUser) {
                    if(!$preCreatedUser->hasRole('admin')){   // becasue we add it later down - if the super admin make a mistake and add the admin(teamleader) as a user we have to exclude the admin (teamleader) here
                        $project->users()->attach($preCreatedUser);
                    }
                }
            }

            //check if the super admin add the teamleader in the selected users - and add it as teamleader
            // if the super admin does not add him in the table above then we have to assign him to the project. [it is nessesary to make the teamleader on of the project member]
            if(!$project->users->contains($teamleader) && !$teamleader->hasRole('admin')){
                $project->users()->attach($teamleader);
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
            
            // attach the admin to every project new created
            if(!$project->users->contains(auth()->user())){
                $project->users()->attach(auth()->user());
            }

            $teamleader->notify(new TeamleaderRoleAssigned($project));
            
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
        $oldTeamleader = $project->teamleader;
        $teamleader = User::findOrFail($request->teamleader_id);

        $project->update([
            'title'       => $request->validated('title'),
            'description' => $request->validated('description'),
            'deadline'    => $request->validated('deadline'),
            'client_id'   => $request->validated('client_id'),
            'teamleader_id'   => $request->validated('teamleader_id'),
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
        
        if(!$project->users->contains($teamleader)){
            $project->users()->attach($teamleader);
        }

        //check if the new teamleader is not the old one [to send the notifications]
        if($teamleader->id != $oldTeamleader->id){
            $teamleader->notify(new TeamleaderRoleAssigned($project));
            $oldTeamleader->notify(new TeamleaderRoleUnAssigned($project));
        }


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

    public function getSortedProjects ()
    {
        // $this->authorize('viewAny', User::class);
       
        $projects = Project::orderBy('title')->get();

        $renderedTable = new RenderProjectsTableService($projects);
        $table = $renderedTable->getTable();

        return json_encode(array($table));
    }

    public function getSearchResult ()
    {
        $queryString = request()->queryString;

        //get all the matched projects
        if ($queryString != null ) {
            $projects = Project::where('title', 'like', '%' . $queryString . '%')->get();
        } else {
            $projects = Project::all();
        }

        $renderedTable = new RenderProjectsTableService($projects);
        $table = $renderedTable->getTable();

        return json_encode(array($table));

    }
}
