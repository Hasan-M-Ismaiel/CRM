<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    

      /**
     * Get all of the users that are assigned this skill.
     */
    public function users(): MorphToMany
    {
        return $this->morphedByMany(User::class, 'skillable');
    }
 
    /**
     * Get all of the projects that are assigned this skill.
     */
    public function projects(): MorphToMany
    {
        return $this->morphedByMany(Project::class, 'skillable');
    }

    public function checkifAssignedToUser(User $user)
    {
        $numeberOfAssignedusers = $this->users()
                    ->where('users.id', $user->id)
                    ->count();
        return $numeberOfAssignedusers>0 ? true : false; 
    }

    public function checkifAssignedToProject(Project $project)
    {
        $numeberOfAssignedProjects = $this->projects()
                    ->where('projects.id', $project->id)
                    ->count();
        return $numeberOfAssignedProjects>0 ? true : false; 
    }
}
