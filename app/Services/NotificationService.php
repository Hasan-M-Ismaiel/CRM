<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;
use App\Notifications\ProjectAssigned;
use App\Notifications\ProjectUnAssigned;
use Illuminate\Support\Facades\Notification;

// use ;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class NotificationService
{

    protected $assignedUsers;
    protected $project;

    public function __construct(Project $project, $assignedUsers) {
        $this->project = $project;
        $this->assignedUsers = $assignedUsers;
    }

    public function SendNotificationMessages()
    {
        //get the ids of the users those are already in the project 
        $projectUsers = $this->project->users()->pluck('users.id');

        if($this->assignedUsers != null && sizeof($this->assignedUsers)>0){    
            // get all the users 
            $users = User::all();
            $usersIds= $users->pluck('id');
            foreach ($usersIds as $usersId){
                if($projectUsers->contains($usersId) && !in_array($usersId,$this->assignedUsers)){
                    // delete notification
                    $user = User::findOrFail($usersId);
                    $user->notify(new ProjectUnAssigned($this->project));
                } else if (!$projectUsers->contains($usersId) && in_array($usersId,$this->assignedUsers)){
                    // assing notification
                    $user = User::findOrFail($usersId);
                    $user->notify(new ProjectAssigned($this->project));
                } else {
                    // nothing
                }
            }

            $this->project->users()->detach();
            foreach ($this->assignedUsers as $assignedUser) {
                $this->project->users()->attach($assignedUser);
            }
        } else {
            //special case when there is just one user in the this->project and you remove it - then the this->assignedUsers will be null
            $users = $this->project->users()->get();
            Notification::send($users, new ProjectUnAssigned($this->project));
            // if the admin uncheck all users 
            $this->project->users()->detach();
        }
    }
}
