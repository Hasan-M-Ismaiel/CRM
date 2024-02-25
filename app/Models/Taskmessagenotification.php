<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taskmessagenotification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'task_id', 'task_message_id', 'from_user_id', 'readed_at'];

    public function taskmessage ()
    {
        return $this->belongsTo(TaskMessage::class);
    }   

    public function task ()
    {
        return $this->belongsTo(Task::class);
    }

    public function user ()
    {
        return $this->belongsTo(User::class);
    }
}
