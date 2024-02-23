<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'project_id', 'user_id', 'status'];


    // this is not used 
    public function project ()
    {
        return $this->belongsTo(Project::class);
    }

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function taskMessages()
    {
        return $this->hasMany(TaskMessage::class);
    }

}
