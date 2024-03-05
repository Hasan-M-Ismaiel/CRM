<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
                ->width(128)
                ->height(128)
                ->nonQueued();
    }

    // start realationships----------------------------------------------
    public function projects ()
    {
        return $this->belongsToMany(Project::class);
    }

    public function tasks ()
    {
        return $this->hasMany(Task::class);
    }

    public function profile ()
    {
        return $this->hasOne(Profile::class);
    }

    public function skills(): MorphToMany
    {
        return $this->morphToMany(Skill::class, 'skillable');
    }

    public function messages()
    {
        return $this->hasMay(Message::class);
    }

    public function taskmessages()
    {
        return $this->hasMany(TaskMessage::class);
    }

    // this is for the Team message notifications
    public function messagenotifications()
    {
        return $this->hasMany(Messagenotification::class);
    }

    //this is for the Task message notifications
    public function taskmessagenotifications()
    {
        return $this->hasMany(Taskmessagenotification::class);
    }


    public function teamleaderon()
    {
        return $this->hasMany(Project::class, 'teamleader_id');
    }

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }
    // end realationships----------------------------------------------


    // # of assigned projects
    protected function numberOfAssignedProjects(): Attribute
    {
        $numeberOfAssignedProjects = $this->projects()->count();
        return Attribute::make(
            get: fn () => $numeberOfAssignedProjects,
        );
    }

    // # of completed projects
    protected function numberOfCompletedProjects(): Attribute
    {
        $numeberOfCompletedProjects = $this->projects()
                            ->where('status', true)
                            ->count();

        return Attribute::make(
            get: fn () => $numeberOfCompletedProjects
        );
    }

    // check if assigned to project
    public function checkifAssignedToProject(Project $project)
    {
        $numeberOfAssignedProjects = $this->projects()
                    ->where('projects.id', $project->id)
                    ->count();
        return $numeberOfAssignedProjects>0 ? false : true;
    }


    // # of assigned tasks
    public function numberOfAssignedTasks():Attribute
    {
        $numberOfAssignedTasks = $this->tasks()
                                        ->count();

        return Attribute::make(
            get: fn () => $numberOfAssignedTasks
        );
    }


    // # of pending tasks
    public function numberOfPendingTasks():Attribute
    {
        $numberOfPendingTasks = $this->tasks()
                    ->where('status', 'pending')
                    ->count();

        return Attribute::make(
            get: fn () => $numberOfPendingTasks
        );
    }

    // # of opened tasks
    public function numberOfOpenedTasks():Attribute
    {
        $numberOfOpenedTasks = $this->tasks()
                    ->where('status', 'opened')
                    ->count();

        return Attribute::make(
            get: fn () => $numberOfOpenedTasks
        );
    }

    // # of closed tasks
    public function numberOfClosedTasks():Attribute
    {
        $numberOfClosedTasks = $this->tasks()
                    ->where('status', 'closed')
                    ->count();

        return Attribute::make(
            get: fn () => $numberOfClosedTasks
        );
    }

    // # of tasks notifications
    public function numberOfTaskMessageNotifications():Attribute
    {

        $numberOfTaskMessageNotifications = $this->taskmessagenotifications->where('readed_at',null)->count();

        return Attribute::make(
            get: fn () => $numberOfTaskMessageNotifications
        );
    }

    // # of team notifications
    public function numberOfTeamMessageNotifications():Attribute
    {

        $numberOfTeamMessageNotifications = $this->messagenotifications->where('readed_at',null)->count();

        return Attribute::make(
            get: fn () => $numberOfTeamMessageNotifications
        );
    }

    // # of total notifications
    public function numberOfTotalMessageNotifications():Attribute
    {

        // you have to update that later to add the Task message notification to this
        // $numberOfTotalMessageNotifications = $this->messagenotifications->where('readed_at',null)->count();
        $numberOfTotalMessageNotifications = $this->numberOfTeamMessageNotifications + $this->numberOfTaskMessageNotifications;

        return Attribute::make(
            get: fn () => $numberOfTotalMessageNotifications
        );
    }

    // this is for teamleader only
    // number of tasks for all the projects that he is teamleader on it
    public function numberOfTasksForAllProjects():Attribute
    {
        $totalTasks=0;
        $totalTasks = $this->tasks()->count();

        if($this->teamleaderon()->count()>0){
            foreach($this->teamleaderon as $project){
                foreach($project->tasks as $projecttask){
                    if($projecttask->user->id != $this->id){
                        $totalTasks +=1;
                    }
                }
            }
        }

        return Attribute::make(
            get: fn () => $totalTasks
        );
    }

    public function numberOfClosedTasksForAllProjects():Attribute
    {

        // the tasks related to him and related to the project that he is teamleader on
        $totalClosedTasks=0;
        if($this->teamleaderon()->count()>0){
            foreach($this->teamleaderon as $project){
                $totalClosedTasks += $project->tasks->where('status', 'closed')->count();
                foreach($this->tasks as $task){
                    if($task->project->id != $project->id){
                        $totalClosedTasks += 1 ;
                    }
                }
            }
        }

        return Attribute::make(
            get: fn () => $totalClosedTasks
        );
    }

    // %
    protected function closedTasksForAllProjectsPercentage(): Attribute
    {
        if($this->numberOfTasksForAllProjects != 0){
            $closedTasksForAllProjectsPercentage = round((($this->numberOfClosedTasks + $this->numberOfCompleteTasksCreatedByTeamleader) *100)/$this->numberOfTasksForAllProjects);
        } else{
            $closedTasksForAllProjectsPercentage = 0 ;
        }


        return Attribute::make(
            get: fn () => $closedTasksForAllProjectsPercentage
        );
    }

    // %
    protected function projectCompletePercentage(): Attribute
    {
        if($this->numberOfAssignedProjects !=0){
            $projectCompletePercentage = round(($this->numberOfCompletedProjects *100)/$this->numberOfAssignedProjects);
        } else {
            $projectCompletePercentage = 0;
        }

        return Attribute::make(
            get: fn () => $projectCompletePercentage
        );
    }

    // %
    protected function numberOfCompleteTasksCreatedByTeamleader(): Attribute
    {
        $numberOfCompleteTasksCreatedByTeamleader = 0;
        if($this->teamleaderon()->count()>0){
            foreach($this->teamleaderon as $project){
                foreach($project->tasks as $task){
                    if($task->status =="closed"){
                        $numberOfCompleteTasksCreatedByTeamleader +=1;    
                    }
                }
            }
        }

        return Attribute::make(
            get: fn () => $numberOfCompleteTasksCreatedByTeamleader
        );
    }

    // %
    protected function CompleteProjectsTeamleaderPercentage(): Attribute
    {
        
        $completeProjectsTeamleaderPercentage = round(($this->numberOfCompletedProjects * 100)/$this->numberOfAssignedProjects);
        return Attribute::make(
            get: fn () => $completeProjectsTeamleaderPercentage
        );
    }

}
