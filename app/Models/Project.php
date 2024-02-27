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

}
