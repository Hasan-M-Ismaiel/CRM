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

    protected function numberOfCompletedProjectTasks(): Attribute
    {
        $numberOfCompletedProjectTasks = $this->tasks->where('status','closed')->count();

        return Attribute::make(
            get: fn () => $numberOfCompletedProjectTasks
        );
    }

    protected function numberOfTotalProjectTasks(): Attribute
    {
        $numberOfTotalProjectTasks = $this->tasks->count();

        return Attribute::make(
            get: fn () => $numberOfTotalProjectTasks
        );
    }


    protected function projectCompletePercent(): Attribute
    {
        $projectCompletePercent = round(($this->numberOfCompletedProjectTasks *100)/$this->numberOfTotalProjectTasks);

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
}
