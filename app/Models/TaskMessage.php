<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskMessage extends Model
{
    use HasFactory;

    protected  $fillable = ['message', 'user_id', 'task_id'];


    public function task ()
    {
        return $this->belongsTo(Task::class);
    }

    public function user ()
    {
        return $this->belongsTo(User::class);
    }
}
