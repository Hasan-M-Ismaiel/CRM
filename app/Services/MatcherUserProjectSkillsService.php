<?php

namespace App\Services;

use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class MatcherUserProjectSkillsService
{

    protected $requiredSkills;

    public function __construct($requiredSkills) {
        $this->requiredSkills = $requiredSkills;
    }


    // as input it will take the skills for the user -  output: the projects 
    public function getMatchedUsersToProject () : array // array of matched users ids 
    {
        $matchedUsers = array();

        $users = User::all();
        foreach($users as $user){
            foreach($user->skills as $skill){
                foreach($this->requiredSkills as $requiredSkill){
                    if($skill->name == $requiredSkill){
                        if(!in_array( $user->id, $matchedUsers)){
                            array_push($matchedUsers, $user->id);
                        }
                    }
                }   
            }
        }

        return $matchedUsers;
    }


    // as input it will take the skills for the project - output: the users 
    public function getMatchedProjectsToUser ()
    {

    }

}