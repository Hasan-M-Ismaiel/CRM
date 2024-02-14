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

    protected function numberOfAssignedProjects(): Attribute
    {
        $numeberOfAssignedProjects = $this->projects()->count();
        return Attribute::make(
            get: fn () => $numeberOfAssignedProjects,
        );
    }

    protected function numberOfCompletededProjects(): Attribute
    {
        $numeberOfCompletedProjects = $this->projects()
                            ->where('status', true)
                            ->count();

        return Attribute::make(
            get: fn () => $numeberOfCompletedProjects
        );
    }
    
    public function checkifAssignedToProject(Project $project)
    {
        $numeberOfAssignedProjects = $this->projects()
                    ->where('projects.id', $project->id)
                    ->count();
        return $numeberOfAssignedProjects>0 ? false : true; 
    }

    public function numberOfAssignedTasks():Attribute
    {
        $numeberOfAssignedTasks = $this->tasks()
                    ->count();

        return Attribute::make(
            get: fn () => $numeberOfAssignedTasks
        );
    }
}
