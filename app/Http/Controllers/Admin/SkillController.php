<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkillStoreRequest;
use App\Http\Requests\SkillUpdateRequest;
use App\Models\Project;
use App\Services\MatcherUserProjectSkillsService;
use App\Models\Skill;
use App\Models\User;
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
        foreach ($request->get('names') as $name) {
            Skill::create([
                'name' => $name
            ]);
        }

        return redirect()->route('admin.skills.index')->with('message', 'the skill/skills has been created sucessfully');;
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
        $requiredSkills = array();

        $assigned_skills = request()->assigned_skills;
        $new_skills = request()->new_skills;
        $from = request()->from;

        // get the users for the project before editing 
        $project_id = request()->project_id;
        $project = Project::find($project_id);
        
        // return $projectUsers;

        if($assigned_skills !=null){
            $skills = Skill::find($assigned_skills);
            foreach($skills as $skill){
                array_push($requiredSkills, $skill->name);
            }
            if($new_skills != null){
                $requiredSkills = array_merge($requiredSkills, $new_skills);
            }
        } else {
            return '';
        }

        
        $MatcherUserProjectSkills = new MatcherUserProjectSkillsService($requiredSkills);
        $matchedUsers =  $MatcherUserProjectSkills->getMatchedUsersToProject();

        


        // the users after editing skills in the edit project view  +  those are users that have the required skills (generally in the edit or create)
        $users = User::find($matchedUsers);
        // Log::info($matchedUsers);
        
        Log::info($project);
        //if we create a project but we dont add any skills
        if($project == null && $users == null){
            return '<h4 class="text-center mb-5" style="color: #673AB7;">no users have those skills hire some one &#128513; </h4> ';
        }
    
        // if($project != null){
        
        // }
        $projectUsers = $project->users()->get();
        
        if($users->count() > $projectUsers->count()){
            $diffUsers = $users->diff($projectUsers);
            $affectedUsers = null;
        }elseif($users->count() < $projectUsers->count()){
            $diffUsers = $projectUsers->diff($users);
            $affectedUsers = $diffUsers;
        }else{
            $diffUsers = $users->diff($projectUsers);
            $affectedUsers = null;
        }
        $status="notAffected";
        //$affectedUsers = $projectUsers->diff($diffUsers);
        if($affectedUsers !=null){
            // info($affectedUsers); //hasan2 + hasan3 
            $status="affected";
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
                $var .= '<td style="text-align: center; vertical-align: middle;"><input type="checkbox" id="user-'.$user->id.'" name="assigned_users[]" value="'. $user->id .'"></td>';
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
            }
            $var .='</tbody>';
            $var .='</table>';

            return json_encode(array($status, $var));
        }if($from == 'edit'){
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
            foreach ($users as $user){
                $var .= '<tr style="height: 60px;">';
                $var .= '<th scope="row" class="align-middle">' . $iterator .'</th>';
                if($user->checkifAssignedToProject($project)){
                    $var .= '<td style="text-align: center; vertical-align: middle;"><input type="checkbox" id="user-'.$user->id.'" name="assigned_users[]" value="'. $user->id .'"></td>';                
                }else{
                    $var .= '<td style="text-align: center; vertical-align: middle;"><input type="checkbox" id="user-'.$user->id.'" name="assigned_users[]" value="'. $user->id .'" checked ></td>';
                }
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
            }
            $var .='</tbody>';
            $var .='</table>';

            return json_encode(array($status, $modalData, $var));
        }
        
        // return $matchedUsers;
    }

    public function getProjectsWithSkills ()
    {
        $requiredSkills = request()->skills;
        $MatcherUserProjectSkills = new MatcherUserProjectSkillsService($requiredSkills);
        $projects =  $MatcherUserProjectSkills->getMatchedProjectsToUser();
        return $projects;
    }

}
