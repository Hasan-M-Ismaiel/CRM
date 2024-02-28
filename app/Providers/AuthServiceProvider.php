<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Client;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use App\Policies\ClientPolicy;
use App\Policies\ProfilePolicy;
use App\Policies\ProjectPolicy;
use App\Policies\TeamPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Project::class => ProjectPolicy::class,
        User::class => UserPolicy::class,
        Profile::class => ProfilePolicy::class,
        Team::class => TeamPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // for the use in the blade profile view 
        // to authorize the routes we used the policy [ProfilePolicy]
        Gate::define('update-profile', function (User $user, Profile $profile) {
            return $user->id === $profile->user_id;
        });

        // for the use in the blade profile view 
        // to authorize the routes we used the policy [ProfilePolicy]
        Gate::define('delete-profile', function (User $user, Profile $profile) {
            return $user->id === $profile->user_id;
        });

        // for the use in the blade team view 
        // to authorize the routes we used the policy [TeamPolicy]
        // Gate::define('sendTeamMessage-team', function (User $user, Team $team) {
        //     return $user->id === $team->user_id;
        // });


        // to authorize the routes [mark task as readed]
        Gate::define('markTaskAsCompleted-task', function (User $user, Task $task) {
            return $user->id === $task->user_id;
        });

        // for the use in the task chat view 
        // to authorize the routes to [view the task chat]
        // this should be the teamleader of the project that this task belongs to 
        Gate::define('showTaskChat', function (User $user, Task $task) {
            if($user->hasRole('admin') || $user->id === $task->user_id || $user->id === $task->project->teamleader->id){
                return true;
            }else{
                return false;
            }
        });


        // using in the blade projects-table
        Gate::define('edit-project', function (User $user, Project $project) {
            if($user->hasRole('admin') || $project->teamleader->id == $user->id ){
                return true;
            }else{
                return false;
            }
        });

        // using in the blade index blade tasks
        Gate::define('create-task', function (User $user) {
            
            if($user->hasRole('admin') ){
                return true;
            }

            $projects = Project::all();
            foreach($projects as $project){
                if($project->teamleader->id == $user->id){
                    return true;
                }
            }
            return false;
        });

        // using in the blade projects-table
        Gate::define('create-group-tasks', function (User $user, Project $project) {
            if($user->hasRole('admin') || $project->teamleader->id == $user->id ){
                return true;
            } else {
                return false;
            }
        });

        // getUsersWithSkills method in the Skill Controller 
        Gate::define('get-users-with-skills', function (User $user) {
            if($user->hasRole('admin') || $user->teamleaderon->count()>0 ){
                return true;
            }else{
                return false;
            }
        });

        // getSortedSkills method in the Skill Controller 
        Gate::define('get-sorted-skills', function (User $user) {
            if($user->hasRole('admin') || $user->teamleaderon->count()>0 ){
                return true;
            } else {
                return false;
            }
        });

        // getSortedSkills method in the Skill Controller 
        Gate::define('get-search-result', function (User $user) {
            if($user->hasRole('admin') || $user->teamleaderon->count()>0 ){
                return true;
            } else {
                return false;
            }
        });
    }
}
