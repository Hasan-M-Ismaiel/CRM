<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Skill;
use App\Models\TemporaryFile;
use App\Models\User;
use App\Services\NotificationService;
use App\Services\RenderUsersTableService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        //make it paginated
        // $users = User::with('category','tags')->get();
        $users = User::all();

        return view('admin.users.index', [
            'users' => $users,
            'page' => 'Users List'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);

        $roles = DB::select('select name, id from roles');
        // foreach ($roles as $role){
        //     var_dump($role->name);
        //     dd($role->id);
        // }
        $skills = Skill::all();
        return view('admin.users.create', [
            'page' => 'Creating user',
            'roles' => $roles,
            'skills' => $skills,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        //the authorization is in the form request 

        // store the new user in the database
        $user = User::create([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => Hash::make($request->validated('password')),
        ]);
        
        //if the user choose image then save it in the database media table
        // if ($request->hasFile('image')) {
            // $user->addMediaFromRequest('image')->toMediaCollection('users');
            // dd(request()->image);
            $temporaryFile = TemporaryFile::where('folder', request()->image)->first();
            if($temporaryFile){
                $user->addMedia(storage_path('app/avatars/tmp/' . request()->image . '/' . $temporaryFile->filename))
                    ->toMediaCollection('users');
                rmdir(storage_path('app/avatars/tmp/' . request()->image));
                $temporaryFile->delete();
            }
        // } 

        // get the role that set for the user and assign it 
        $role = Role::findById($request->role_id, 'web');
        $user->assignRole($role);
        
        $assignedSkills = $request->input('assigned_skills'); // the ids of the added skills 
        if($assignedSkills != null && sizeof($assignedSkills)>0 ){
            foreach ($assignedSkills as $assignedSkill) {
                $user->skills()->attach($assignedSkill);
            }
        } 

        $new_skills = $request->input('new_skills');
        if($new_skills != null && sizeof($new_skills)>0 ){
            //creating the new skill and attach it to the new user
            foreach ($request->get('new_skills') as $name) {
                $skill = Skill::create([
                    'name' => $name
                ]);
                $user->skills()->attach($skill);
            }
        }
        return redirect()->route('admin.users.index')->with('message', 'the user has been created sucessfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        $user->with('projects', 'skills');
        return view('admin.users.show', [
            'page' => 'Showing User',
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        
        // get the roles to iterate throught them in the view
        $roles = DB::select('select name, id from roles');

        // find the roles assigned for this user
        $userRole = $user->getRoleNames()->get('0'); // admin - user
        $rolesForUser = Role::whereIn('name', [$userRole])->get();

        // here is the role id for user 
        $userRoleId = $rolesForUser->first()->id;
        
        $skills = Skill::all();

        // return the edit view with the needed variables
        return view('admin.users.edit', [
            'page'       => 'Editing user',
            'roles'      => $roles,
            'userRoleId' => $userRoleId,
            'user'       => $user,
            'skills'       => $skills,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        // the authorization is in the form request 

        //check if the password match the old password - this should be like other way 
        if(request()->old_password){
            // dd(request()->old_password,request()->password, $user->password);
            if(!Hash::check($request->old_password, $user->password)){
                return back()->with("message", "old Password Doesn't match!");
            }
            $user->password = Hash::make($request->validated('password'));
            $user->save();
        }

        //update the user information
        $user->update([
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
        ]);
        
        // remove all the roles form the user
        $user->roles()->detach();
        // assign the new role to the user
        $role = Role::findById($request->role_id, 'web');
        $user->assignRole($role);

        //check if the user update the image - if true - then delete the old one from the strorage
        // if ($request->hasFile('image')) {
        //         $user->clearMediaCollection('users');
        //         $user->addMediaFromRequest('image')->toMediaCollection('users');
        // }
        
        // get the image if presented
        $temporaryFile = TemporaryFile::where('folder', request()->image)->first();
        if($temporaryFile){
            $user->addMedia(storage_path('app/avatars/tmp/' . request()->image . '/' . $temporaryFile->filename))
                ->toMediaCollection('users');
            rmdir(storage_path('app/avatars/tmp/' . request()->image));
            $temporaryFile->delete();
        }

        $assignedSkills = $request->input('assigned_skills');
        if($assignedSkills!= null && sizeof($assignedSkills)>0){
            $user->skills()->detach();
                foreach ($assignedSkills as $assignedSkill) {
                    $user->skills()->attach($assignedSkill);
                }
        } else {
            $user->skills()->detach();
        }

        $new_skills = $request->input('new_skills');
        if( $new_skills!= null && sizeof($new_skills)>0 ){
            //creating the new skill and attach it to the new user
            foreach ($request->get('new_skills') as $name) {
                $skill = Skill::create([
                    'name' => $name
                ]);
                $user->skills()->attach($skill);
            }
        }

        return redirect()->route('admin.users.index')->with('message', 'the user has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete');

        $user->delete();
        return redirect()->route('admin.users.index')->with('message','the user has been deleted successfully');
    }

    public function getSortedUsers ()
    {
        // $this->authorize('viewAny', User::class);
       
        $users = User::orderBy('name')->get();

        $renderedTable = new RenderUsersTableService($users);
        $table = $renderedTable->getTable();

        return json_encode(array($table));
    }

    //not finished yet
    public function getSortedRoles ()
    {
        // $this->authorize('viewAny', User::class);
       
        $order = 'desc';

        $users = User::with('roles')->orderBy('roles.name')->get();
        $var = '<table class="table table-striped mt-2">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Profile</th>
                <th scope="col">
                    <span class="btn px-1 p-0 m-0 text-light" style="background-color: #303c54;" id="getSortedUsers" onclick="getSortedUsers()">
                    Name
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6"/>
                        </svg>
                    </span>
                </th>
                <th scope="col">Email</th>
                <th scope="col">
                    <span class="btn px-1 p-0 m-0 text-light" style="background-color: #303c54;">
                        Role
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6"/>
                        </svg>
                    </span>
                </th>
                <th scope="col">Tasks</th>
                <th scope="col">Skills</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>';
        // $iterator = 1;  
        foreach ($users as $user){
            $var .= '<tr>';
            $var .= '<th scope="row" class="align-middle">'.$user->id.'</th>';
            $var .= '<td class="align-middle">';

            if($user->profile){
                $var .= '<a href="'. route('admin.profiles.show', $user->id) .'" class="position-relative" style="text-decoration: none;">';
            }
            else{
                $var .= '<a href="'. route('admin.statuses.notFound') .'" class="position-relative" style="text-decoration: none;">';
            }

            // user image
            if($user->profile && $user->profile->getFirstMediaUrl("profiles")){
                $var .= '<div class="p-2">';
                $var .= '<div class="avatar avatar-md">';
                $var .= '<img src="'. $user->profile->getFirstMediaUrl("profiles").'" alt="DP"  class="avatar-img border border-success shadow mb-1">';
                $var .= '</div>';
                if($user->hasRole('admin') && $user->teamleaderon->count()>0){
                    $var .= '<div class="position-absolute top-0 start-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-star-fill text-warning" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5M8.16 4.1a.178.178 0 0 0-.32 0l-.634 1.285a.18.18 0 0 1-.134.098l-1.42.206a.178.178 0 0 0-.098.303L6.58 6.993c.042.041.061.1.051.158L6.39 8.565a.178.178 0 0 0 .258.187l1.27-.668a.18.18 0 0 1 .165 0l1.27.668a.178.178 0 0 0 .257-.187L9.368 7.15a.18.18 0 0 1 .05-.158l1.028-1.001a.178.178 0 0 0-.098-.303l-1.42-.206a.18.18 0 0 1-.134-.098z"/>
                                </svg>
                            </div>';
                    }elseif(!$user->hasRole('admin') && $user->teamleaderon->count()>0){
                    $var .= '<div class="position-absolute top-0 start-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM8.146 4.992c.961 0 1.641.633 1.729 1.512h1.295v-.088c-.094-1.518-1.348-2.572-3.03-2.572-2.068 0-3.269 1.377-3.269 3.638v1.073c0 2.267 1.178 3.603 3.27 3.603 1.675 0 2.93-1.02 3.029-2.467v-.093H9.875c-.088.832-.75 1.418-1.729 1.418-1.224 0-1.927-.891-1.927-2.461v-1.06c0-1.583.715-2.503 1.927-2.503Z"/>
                                </svg>
                            </div>';
                    } elseif($user->hasRole('admin') && $user->teamleaderon->count()==0){
                    $var .= '<div class="position-absolute top-0 start-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM8.146 4.992c.961 0 1.641.633 1.729 1.512h1.295v-.088c-.094-1.518-1.348-2.572-3.03-2.572-2.068 0-3.269 1.377-3.269 3.638v1.073c0 2.267 1.178 3.603 3.27 3.603 1.675 0 2.93-1.02 3.029-2.467v-.093H9.875c-.088.832-.75 1.418-1.729 1.418-1.224 0-1.927-.891-1.927-2.461v-1.06c0-1.583.715-2.503 1.927-2.503Z"/>
                                </svg>
                            </div>';
                    }else{
                    }
                $var .= '</div>';

    
            }elseif($user->getFirstMediaUrl("users")){
                $var .= '<div class="p-2">';
                $var .= '<div class="avatar avatar-md">';
                $var .= '<img src="'. $user->getMedia("users")[0]->getUrl("thumb") .'"  alt="DP"  class="avatar-img border border-success shadow mb-1">';
                $var .= '</div>';
                if($user->hasRole('admin') && $user->teamleaderon->count()>0){
                    $var .= '<div class="position-absolute top-0 start-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-star-fill text-warning" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5M8.16 4.1a.178.178 0 0 0-.32 0l-.634 1.285a.18.18 0 0 1-.134.098l-1.42.206a.178.178 0 0 0-.098.303L6.58 6.993c.042.041.061.1.051.158L6.39 8.565a.178.178 0 0 0 .258.187l1.27-.668a.18.18 0 0 1 .165 0l1.27.668a.178.178 0 0 0 .257-.187L9.368 7.15a.18.18 0 0 1 .05-.158l1.028-1.001a.178.178 0 0 0-.098-.303l-1.42-.206a.18.18 0 0 1-.134-.098z"/>
                                </svg>
                            </div>';
                    }elseif(!$user->hasRole('admin') && $user->teamleaderon->count()>0){
                    $var .= '<div class="position-absolute top-0 start-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM8.146 4.992c.961 0 1.641.633 1.729 1.512h1.295v-.088c-.094-1.518-1.348-2.572-3.03-2.572-2.068 0-3.269 1.377-3.269 3.638v1.073c0 2.267 1.178 3.603 3.27 3.603 1.675 0 2.93-1.02 3.029-2.467v-.093H9.875c-.088.832-.75 1.418-1.729 1.418-1.224 0-1.927-.891-1.927-2.461v-1.06c0-1.583.715-2.503 1.927-2.503Z"/>
                                </svg>
                            </div>';
                    } elseif($user->hasRole('admin') && $user->teamleaderon->count()==0){
                    $var .= '<div class="position-absolute top-0 start-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM8.146 4.992c.961 0 1.641.633 1.729 1.512h1.295v-.088c-.094-1.518-1.348-2.572-3.03-2.572-2.068 0-3.269 1.377-3.269 3.638v1.073c0 2.267 1.178 3.603 3.27 3.603 1.675 0 2.93-1.02 3.029-2.467v-.093H9.875c-.088.832-.75 1.418-1.729 1.418-1.224 0-1.927-.891-1.927-2.461v-1.06c0-1.583.715-2.503 1.927-2.503Z"/>
                                </svg>
                            </div>';
                    }else{
                    }
                $var .= '</div>';
            }else{
                $var .= '<div class="p-2">';
                $var .= '<div class="avatar avatar-md">';
                $var .= '<img src="'.asset("images/avatar.png").'"  alt="DP"  class="avatar-img border border-success shadow mb-1">';
                $var .= '</div>';
                if($user->hasRole('admin') && $user->teamleaderon->count()>0){
                    $var .= '<div class="position-absolute top-0 start-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-star-fill text-warning" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5M8.16 4.1a.178.178 0 0 0-.32 0l-.634 1.285a.18.18 0 0 1-.134.098l-1.42.206a.178.178 0 0 0-.098.303L6.58 6.993c.042.041.061.1.051.158L6.39 8.565a.178.178 0 0 0 .258.187l1.27-.668a.18.18 0 0 1 .165 0l1.27.668a.178.178 0 0 0 .257-.187L9.368 7.15a.18.18 0 0 1 .05-.158l1.028-1.001a.178.178 0 0 0-.098-.303l-1.42-.206a.18.18 0 0 1-.134-.098z"/>
                                </svg>
                            </div>';
                    }elseif(!$user->hasRole('admin') && $user->teamleaderon->count()>0){
                    $var .= '<div class="position-absolute top-0 start-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM8.146 4.992c.961 0 1.641.633 1.729 1.512h1.295v-.088c-.094-1.518-1.348-2.572-3.03-2.572-2.068 0-3.269 1.377-3.269 3.638v1.073c0 2.267 1.178 3.603 3.27 3.603 1.675 0 2.93-1.02 3.029-2.467v-.093H9.875c-.088.832-.75 1.418-1.729 1.418-1.224 0-1.927-.891-1.927-2.461v-1.06c0-1.583.715-2.503 1.927-2.503Z"/>
                                </svg>
                            </div>';
                    } elseif($user->hasRole('admin') && $user->teamleaderon->count()==0){
                    $var .= '<div class="position-absolute top-0 start-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM8.146 4.992c.961 0 1.641.633 1.729 1.512h1.295v-.088c-.094-1.518-1.348-2.572-3.03-2.572-2.068 0-3.269 1.377-3.269 3.638v1.073c0 2.267 1.178 3.603 3.27 3.603 1.675 0 2.93-1.02 3.029-2.467v-.093H9.875c-.088.832-.75 1.418-1.729 1.418-1.224 0-1.927-.891-1.927-2.461v-1.06c0-1.583.715-2.503 1.927-2.503Z"/>
                                </svg>
                            </div>';
                    }else{
                    }
                $var .= '</div>';
            }
            $var .= '</a>';
            $var .= '</td>';

            // user name
            $var .= '<td class="align-middle"><a href="'. route('admin.users.show', $user->id).'" style="text-decoration: none;" >'. $user->name .'</a></td>';
           
            // email
            $var .= '<td class="align-middle">'.substr($user->email, 0, 15).'...</td>';
            // role name
            $var .= '<td class="align-middle">'. $user->getRoleNames()->get('0') .'</td>';
            // number of assigned tasks
            $var .= '<td class="align-middle">'. $user->numberOfAssignedTasks .'</td>';
            
            // user skills
            $var .= '<td class="align-middle">';
            if($user->skills()->count() > 0){
                foreach ($user->skills as $skill){
                    $var .= '<span class="badge m-1" style="background: #673AB7;">'. $skill->name .'</span>';
                }
            }else{
                $var .= '#';
            }
            $var .= '</td>';
            
            //buttons
            $var .= '<td class="align-middle">';
            $var .= '<div style="display: flex;">';
            $var .= '<a type="button" class="btn btn-primary m-1" href="'. route('admin.users.show', $user->id) .'" role="button">Show</a>';
            $var .= '<a type="button" class="btn btn-secondary m-1" href="'.route('admin.users.edit', $user->id) .'" role="button">Edit</a>';
            $var .= '<a class="btn btn-danger m-1" type="button"';
            $var .= 'onclick="if (confirm('."'Are you sure?'".') == true) {';
            $var .= 'document.getElementById('."'delete-item-".$user->id."').submit();";
            $var .= 'event.preventDefault();';
            $var .= '} else {';
            $var .= 'return;';
            $var .= '}';
            $var .= '">Delete';
            $var .= '</a>';

            $var .= '<form id="delete-item-'.$user->id.'" action="'. route('admin.users.destroy', $user).'" class="d-none" method="POST">';
            $var .= '<input type="hidden" name="_method" value="DELETE">';
            $var .= '<input type="hidden" name="_token" value="'. csrf_token() .'">';
            $var .= '</form>';
            $var .= '</div>';
            $var .= '</td>';
            $var .= '</tr>';

        }            
        $var .= '</tbody>';
        $var .= '</table>';

        return json_encode(array($var));
    }
    
    public function getSearchResult ()
    {
        $queryString = request()->queryString;

        //get all the matched users
        if ($queryString != null ) {
            $users = User::where('name', 'like', '%' . $queryString . '%')->get();
        } else {
            $users = User::all();
        }

        $renderedTable = new RenderUsersTableService($users);
        $table = $renderedTable->getTable();

        return json_encode(array($table));

    }
}
