<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkillStoreRequest;
use App\Http\Requests\SkillUpdateRequest;
use App\Models\Project;
use App\Services\MatcherUserProjectSkillsService;
use App\Models\Skill;
use App\Models\User;
use App\Services\RenderSkillsTableService;
use Illuminate\Support\Facades\Log;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skill::all();

        return view('admin.skills.index', [
            'skills' => $skills,
            'page' => 'Skills List',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.skills.create', [
            'page' => 'Creating skill',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SkillStoreRequest $request)
    {
        $skills = $request->get('names');

        //double check for the validation
        foreach($skills as $skill){
            if($skill== null){
                return redirect()->back()->with('message', 'the skill/skills not filled');;
            }
        }

        // if the user click create without adding information in the fields
        if(sizeof($skills)>0){
            foreach ($request->get('names') as $name) {
                Skill::create([
                    'name' => $name
                ]);
            }
            return redirect()->route('admin.skills.index')->with('message', 'the skill/skills has been created sucessfully');;
        } else {
            return redirect()->back()->with('message', 'the skill/skills not filled');;
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        return view('admin.skills.show', [
            'page' => 'Showing skill',
            'skill' => $skill,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', [
            'page'        => 'Editing skill',
            'skill'       => $skill,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SkillUpdateRequest $request, Skill $skill)
    {
        $skill->update($request->validated());

        return redirect()->route('admin.skills.index')->with('message', 'the skill has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        $skill->delete();

        $skills = Skill::all();
        if ($skills == null){
            return redirect()->route('admin.skills.create')->with('message','the database does not have any skills please add atleast one');
        }
        return redirect()->route('admin.skills.index')->with('message','the skill has been deleted successfully');
    }

    // this not should be here - it should be in another service class 
    public function getUsersWithSkills ()
    {
        //all skills from database to compare with 
        $Basicskills = Skill::all();

        $affectedUsers = collect();
        $status="notAffected";
        // the matched users
        $users = null;

        //all the skills - assigned + new added
        $requiredSkills = array();

        $assigned_skills = request()->assigned_skills;
        $new_skills = request()->new_skills;
        $from = request()->from; //create | edit

        if($from == "edit"){
            // get the users for the project before editing 
            $project_id = request()->project_id;
            $project = Project::find($project_id);
        }

        if($from=="create"){
            // not check any item and not add any field
            if($assigned_skills==null && $new_skills== null){
                $message = '<h4 class="text-center mb-5" style="color: #673AB7;">there is no skills selected please add at least one </h4>';
                $statusCreate='noSkills';
                return json_encode(array($statusCreate, $message));
            }

            // if check some skills and were number of selected skills > 0 // then add them to the requrired array
            if($assigned_skills!=null && sizeof($assigned_skills) > 0){
                $skills = Skill::find($assigned_skills);
                foreach($skills as $skill){
                    array_push($requiredSkills, $skill->name);
                }
            }
            
            // if the user does add new skills 
            if($new_skills!=null){
                if(sizeof($new_skills) > 0){    //this is worthless
                    foreach($new_skills as $new_skill){ // check if the skilled that entered is not exist in the database
                        foreach($Basicskills as $skill){
                            if($skill->name == $new_skill){
                                $message = '<h4 class="text-center mb-5" style="color: #673AB7;">there is added skills that already exist in the list please select them from the list </h4>';
                                $statusCreate='noSkills';
                                return json_encode(array($statusCreate, $message));
                            }
                        }
                    }
                    // add the new skills to the required skills 
                    $requiredSkills = array_merge($requiredSkills, $new_skills);
                }
            }
        }elseif($from=="edit"){ //edit page

            // if the user add skills in the check boxes - and even if the old skilles is let as it - then we have a assigned_skills array
            // we get all the skills that it gives us 
            if($assigned_skills!=null){
                if(sizeof($assigned_skills) > 0){
                    $skills = Skill::find($assigned_skills);
                    foreach($skills as $skill){
                        array_push($requiredSkills, $skill->name);
                    }
                }
            }

            // get all the skills if the user add new skills in the page 
            // if those skills are already in the database then return error message
            //--->      // but the problem is when the user add field but let it empty - this case the request will back an ambisious error 
            if($new_skills!=null){
                if(sizeof($new_skills) > 0){
                    foreach($new_skills as $new_skill){
                        foreach($Basicskills as $skill){
                            if($skill->name == $new_skill){
                                $message = '<h4 class="text-center mb-5" style="color: #673AB7;">there is added skills that already exist in the list please select them from the list </h4>';
                                $statusCreate='newSkillsEmptyFields';
                                return json_encode(array($statusCreate, $message));
                            }
                        }
                    }
                    $requiredSkills = array_merge($requiredSkills, $new_skills);
                }
            }
        }

        // this heppen if the page is edit and we dont add any additional skills - there is just the old project skills
        if(empty($requiredSkills)){
        //--->     // if there is not skills then we have to return nothing 
            $users = null;
        }else{
            $MatcherUserProjectSkills = new MatcherUserProjectSkillsService($requiredSkills); //$MatcherUserProjectSkills is an array of user matched ids
            $matchedUsers =  $MatcherUserProjectSkills->getMatchedUsersToProject();
            $users = User::find($matchedUsers);
        }

        //if we are in create project page and we dont have users matched with project skills
        if(($from == "create" && $users->count()==0) || ($from == "create" && $users==null)){
            $message = '<h4 class="text-center mb-5" style="color: #673AB7;">no users have those skills - alter skills or hire some one &#128513; dont warry the project will be created and you can assign the users later</h4> ';
            $statusCreate='NoUsersFound';
            return json_encode(array($statusCreate, $message));
        }
    
        // here we are in the edit page 
        if($from =="edit"){
            //old project users
            $projectUsers = $project->users()->get();
            if($users != null){
                foreach($projectUsers as $projectUser){
                    if(!$users->contains($projectUser)){
                        $affectedUsers->add($projectUser);
                    }
                }

                if($affectedUsers->count()>0){
                    $status="affected";
                }else{
                    $status="notAffected";
                }
                // if the users that we get from the mateched skills is more than the users project
                // if($users->count() > $projectUsers->count()){
                //     $diffUsers = $users->diff($projectUsers);
                //     $affectedUsers = null;
                // }elseif($users->count() < $projectUsers->count()){
                //     $diffUsers = $projectUsers->diff($users);
                //     $affectedUsers = $diffUsers;
                // }else{
                //     $diffUsers = $users->diff($projectUsers);
                //     $affectedUsers = null;
                // }
                // $status="notAffected";
                // if($affectedUsers !=null){
                //     $status="affected";
                // }
            } else {
                $affectedUsers = $project->users()->get();
                $status="affected";
            }
        }
        
        // rendering the table
        if($from == 'create'){
            $var = '<table class="table table-striped mt-2">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Select</th>
                    <th scope="col">Name</th>
                    <th scope="col">Skills</th>
                    <th scope="col">Profile</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>';
            $iterator = 1;  
            foreach ($users as $user){
                $var .= '<tr style="height: 60px;">';
                $var .= '<th scope="row" class="align-middle">' . $iterator .'</th>';
                
                //new added
                $var .= '<td style="text-align: center; vertical-align: middle;">';
                $var .= '<div class="avatar avatar-md mt-2">';
                $var .= '<label class="labelexpanded_">';
                $var .= '<input type="checkbox" class="m-1" id=user-"' . $user->id .'" name="assigned_users[]" value="'. $user->id .'">';
                $var .= '<div class="checkbox-btns_ rounded-circle border-1">';

                if($user->profile && $user->profile->getFirstMediaUrl("profiles")){
                    $var .= '<img src="'. $user->profile->getFirstMediaUrl("profiles").'" alt="DP"  class="avatar-img  shadow ">';
                }elseif($user->getFirstMediaUrl("users")){
                    $var .= '<img src="'. $user->getMedia("users")[0]->getUrl("thumb").'" alt="DP"  class="avatar-img  shadow ">';
                }else{
                    $var .= '<img src="'. asset("images/avatar.png").'" alt="DP"  class="avatar-img  shadow ">';
                }
                $var .= '</div>';
                $var .= '</input>';
                $var .= '</label>';
                $var .= '</div>';
                $var .= '</td>';
                // new added




                // $var .= '<td style="text-align: center; vertical-align: middle;"><input type="checkbox" id="user-'.$user->id.'" name="assigned_users[]" value="'. $user->id .'"></td>';
                $var .= '<td class="align-middle"><a href="'. route('admin.users.show', $user->id) .'" > '. $user->name . '</a></td>';
                if($user->skills->count() >0){
                    $var .= '<td class="align-middle">';
                    foreach($user->skills as $skill){
                        $var .= '<span class="badge bg-dark m-1">' . $skill->name . '</span>';
                    }
                    $var .= '</td>';
                } else {
                    $var .= '<td class="align-middle"> # </td>';
                }
                if($user->profile != null){
                    $var .= '<td class="align-middle"><a href="'. route('admin.profiles.show', $user->id) . '" >'. $user->profile->nickname .'</a></td>';
                }else {
                    $var .= '<td class="align-middle"> # </td>';
                }
                $var .= '<td class="align-middle"> open/close</td>';
                $var .= '</tr>';
                $iterator=$iterator+1;
            }
            $var .='</tbody>';
            $var .='</table>';

            $status ='ok';
            return json_encode(array($status, $var));

        }elseif($from == 'edit'){
            $modalData="";
            if($affectedUsers != null){
                $modalData = '<div>';
                $modalData .= '<ul class="list-group list-group-flush">';
                foreach($affectedUsers as $affectedUser){
                    $modalData .= '<li class="list-group-item">'. $affectedUser->name .' | ' . $affectedUser->numberOfAssignedTasks.' tasks | ' . $affectedUser->numberOfOpenedTasks. ' opened | '. $affectedUser->numberOfClosedTasks. ' closed | '.$affectedUser->numberOfPendingTasks. ' pending</li>';
                }
                $modalData .= '</div>';
                $modalData .= '</ul>';
            }else{
                $status = "notAffected";
            }

            $var = '<table class="table table-striped mt-2">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Select</th>
                    <th scope="col">Name</th>
                    <th scope="col">Skills</th>
                    <th scope="col">Profile</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>';
            $iterator = 1;
            if($users!=null){  
                foreach ($users as $user){
                    $var .= '<tr style="height: 60px;">';
                    $var .= '<th scope="row" class="align-middle">' . $iterator .'</th>';

                    //new added
                    $var .= '<td style="text-align: center; vertical-align: middle;">';
                    $var .= '<div class="avatar avatar-md mt-2">';
                    $var .= '<label class="labelexpanded_">';
                    if($user->checkifAssignedToProject($project)){
                        $var .= '<input type="checkbox" class="m-1" id=user-"' . $user->id .'" name="assigned_users[]" value="'. $user->id .'">';
                    }else{
                        $var .= '<input type="checkbox" class="m-1" id=user-"' . $user->id .'" name="assigned_users[]" value="'. $user->id .'" checked>';
                    }
                    $var .= '<div class="checkbox-btns_ rounded-circle border-1">';
    
                    if($user->profile && $user->profile->getFirstMediaUrl("profiles")){
                        $var .= '<img src="'. $user->profile->getFirstMediaUrl("profiles").'" alt="DP"  class="avatar-img  shadow ">';
                    }elseif($user->getFirstMediaUrl("users")){
                        $var .= '<img src="'. $user->getMedia("users")[0]->getUrl("thumb").'" alt="DP"  class="avatar-img  shadow ">';
                    }else{
                        $var .= '<img src="'. asset("images/avatar.png").'" alt="DP"  class="avatar-img  shadow ">';
                    }
                    $var .= '</div>';
                    $var .= '</input>';
                    $var .= '</label>';
                    $var .= '</div>';
                    $var .= '</td>';
                    //new added


                    // the olde version
                    // if($user->checkifAssignedToProject($project)){
                    //     $var .= '<td style="text-align: center; vertical-align: middle;"><input type="checkbox" id="user-'.$user->id.'" name="assigned_users[]" value="'. $user->id .'"></td>';                
                    // }else{
                    //     $var .= '<td style="text-align: center; vertical-align: middle;"><input type="checkbox" id="user-'.$user->id.'" name="assigned_users[]" value="'. $user->id .'" checked ></td>';
                    // }
                    $var .= '<td class="align-middle"><a href="'. route('admin.users.show', $user->id) .'" > '. $user->name . '</a></td>';
                    if($user->skills->count() >0){
                        $var .= '<td class="align-middle">';
                        foreach($user->skills as $skill){
                            $var .= '<span class="badge bg-dark m-1">' . $skill->name . '</span>';
                        }
                        $var .= '</td>';
                    } else {
                        $var .= '<td class="align-middle"> # </td>';
                    }
                    if($user->profile != null){
                        $var .= '<td class="align-middle"><a href="'. route('admin.profiles.show', $user->id) . '" >'. $user->profile->nickname .'</a></td>';
                    }else {
                        $var .= '<td class="align-middle"> # </td>';
                    }
                    $var .= '<td class="align-middle"> open/close</td>';
                    $var .= '</tr>';
                    $iterator=$iterator+1;
                }
                $var .='</tbody>';
                $var .='</table>';

                return json_encode(array($status, $modalData, $var));
            }else{
                $var = '<h4 class="text-center mb-5" style="color: #673AB7;">no users appear because there is not skills required for this project please add skills </h4>';
                return json_encode(array($status, $modalData, $var));
            }
        }
    }

    public function getProjectsWithSkills ()
    {
        $requiredSkills = request()->skills;
        $MatcherUserProjectSkills = new MatcherUserProjectSkillsService($requiredSkills);
        $projects =  $MatcherUserProjectSkills->getMatchedProjectsToUser();
        return $projects;
    }


    public function getSortedSkills ()
    {
        // $this->authorize('viewAny', User::class);
       
        $skills = Skill::orderBy('name')->get();

        $renderedTable = new RenderSkillsTableService($skills);
        $table = $renderedTable->getTable();

        return json_encode(array($table));
    }

    public function getSearchResult ()
    {
        $queryString = request()->queryString;

        //get all the matched users
        if ($queryString != null ) {
            $skills = Skill::where('name', 'like', '%' . $queryString . '%')->get();
        } else {
            $skills = Skill::all();
        }

        $renderedTable = new RenderSkillsTableService($skills);
        $table = $renderedTable->getTable();

        return json_encode(array($table));

    }

}
