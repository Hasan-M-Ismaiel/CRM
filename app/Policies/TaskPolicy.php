<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    // /**
    //  * Determine whether the user can view any models.
    //  */
    // public function viewAny(User $user): bool
    // {
    //     // how can see multiple tasks 
    //     //if ($user->hasRole('admin') || $user->teamleaderOn)
    // }

    /**
     * Determine whether the user can view the model.
     */
    //[todo]
    public function view(User $user, Task $task): bool
    {

        if($user->hasRole('admin') || $user->id == $task->project->teamleader_id){
            return true;
        }

        return $user->tasks->contains($task);

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->hasRole('admin')){
            return true;
        }
        // if ($user->teamleaderOn()){return true;}

        // check if the user has projects as teamleader
        $projects = Project::all();
        foreach($projects as $project){
            if($project->teamleader->id == $user->id){
                return true;
            }
        }

        return false;
        // return $user->hasRole('admin') || $user->teamleaderon;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->id == $task->project->teamleader_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->id == $task->project->teamleader_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        return $user->id == $task->project->teamleader_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return $user->id == $task->project->teamleader_id || $user->hasRole('admin');
    }
}
