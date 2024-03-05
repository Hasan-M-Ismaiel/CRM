<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'deadline', 'user_id', 'client_id', 'status', 'teamleader_id'];

    public function users ()
    {
        return $this->belongsToMany(User::class);
    }

    public function tasks ()
    {
        return $this->hasMany(Task::class);
    }

    public function client ()
    {
        return $this->belongsTo(Client::class);
    }

    public function skills(): MorphToMany
    {
        return $this->morphToMany(Skill::class, 'skillable');
    }

    public function team()
    {
        return $this->hasOne(Team::class);
    }

    public function teamleader()
    {
        return $this->belongsTo(User::class);
    }
    //

    protected function statusOfProject(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status ? 'closed' : 'opened'
        );
    }

    static function numberOfCompletedProjects()
    {
        return Project::where('status','==' , 1)->count();
    }

    static function numberOfTotalProjects()
    {
        return Project::all()->count();
                                                                
    }

    static function projectCompletePercentage()
    {

        return $projectCompletePercentage = (Project::numberOfCompletedProjects()*100)/Project::numberOfTotalProjects();
                                                                
    }


    protected function numberOfTotalProjectTasks(): Attribute
    {
        $numberOfTotalProjectTasks = $this->tasks->count();

        return Attribute::make(
            get: fn () => $numberOfTotalProjectTasks
        );
    }

    protected function numberOfCompletedProjectTasks(): Attribute
    {
        $numberOfCompletedProjectTasks = $this->tasks->where('status','closed')->count();

        return Attribute::make(
            get: fn () => $numberOfCompletedProjectTasks
        );
    }

    protected function projectCompletePercent(): Attribute
    {
        // if there is no tasks yet in the project
        if($this->numberOfTotalProjectTasks!=0){
            $projectCompletePercent = round(($this->numberOfCompletedProjectTasks *100)/$this->numberOfTotalProjectTasks);
        } else {
            $projectCompletePercent = 0;
        }

        return Attribute::make(
            get: fn () => $projectCompletePercent
        );
    }

    protected function numberOfUnFinishedTasks(): Attribute
    {
        
        $numberOfUnFinishedTasks = $this->tasks->where('status', '!=', 'closed')->count();
        
        return Attribute::make(
            get: fn () => $numberOfUnFinishedTasks
        );
    }


    // number of total tasks for this project
    protected function numberOfTotalTasks(): Attribute
    {
        
        $numberOfTotalTasks = $this->tasks->count();
        
        return Attribute::make(
            get: fn () => $numberOfTotalTasks
        );
    }

    // number of closed tasks for this project
    protected function numberOfClosedTasks(): Attribute
    {
        
        $numberOfClosedTasks = $this->tasks->where('status', 'closed')->count();
        
        return Attribute::make(
            get: fn () => $numberOfClosedTasks
        );
    }

    // percentage of task completing
    protected function taskClosedPercentage(): Attribute
    {
        
        if($this->numberOfTotalTasks!=0){
            $taskClosedPercentage = round(($this->numberOfClosedTasks *100)/$this->numberOfTotalTasks);
        } else {
            $taskClosedPercentage = 0;
        }

        return Attribute::make(
            get: fn () => $taskClosedPercentage
        );
    }

    // number of closed tasks for this project
    protected function numberOfPendingTasks(): Attribute
    {
        
        $numberOfPendingTasks = $this->tasks->where('status', 'pending')->count();
        
        return Attribute::make(
            get: fn () => $numberOfPendingTasks
        );
    }

    // percentage of task completing
    protected function taskPendedPercentage(): Attribute
    {
        
        if($this->numberOfTotalTasks!=0){
            $taskPendedPercentage = round(($this->numberOfPendingTasks *100)/$this->numberOfTotalTasks);
        } else {
            $taskPendedPercentage = 0;
        }

        return Attribute::make(
            get: fn () => $taskPendedPercentage
        );
    }

    // number of opened tasks for this project
    protected function numberOfOpenedTasks(): Attribute
    {
        
        $numberOfOpenedTasks = $this->tasks->where('status', 'opened')->count();
        
        return Attribute::make(
            get: fn () => $numberOfOpenedTasks
        );
    }

    // percentage of task completing
    protected function taskOpenedPercentage(): Attribute
    {
        
        if($this->numberOfTotalTasks!=0){
            $taskOpenedPercentage = round(($this->numberOfOpenedTasks *100)/$this->numberOfTotalTasks);
        } else {
            $taskOpenedPercentage = 0;
        }

        return Attribute::make(
            get: fn () => $taskOpenedPercentage
        );
    }

    // percentage of task completing
    protected function taskCompletePercentage(): Attribute
    {
        
        if($this->numberOfTotalTasks!=0){
            $taskCompletePercentage = round(($this->numberOfClosedTasks *100)/$this->numberOfTotalTasks);
        } else {
            $taskCompletePercentage = 0;
        }

        return Attribute::make(
            get: fn () => $taskCompletePercentage
        );
    }
}
