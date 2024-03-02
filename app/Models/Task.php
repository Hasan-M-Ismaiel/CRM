<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    // this is for the Team message notifications
    public function taskmessagenotifications()
    {
        return $this->hasMany(Taskmessagenotification::class);
    }


    public function numberOfUnreadedTaskMessages():Attribute
    {

        $numberOfUnreadedTaskMessages = $this->taskmessagenotifications->where('readed_at','==' ,null)
                                                                    ->where('user_id', auth()->user()->id)
                                                                    ->count();

        return Attribute::make(
            get: fn () => $numberOfUnreadedTaskMessages
        );

    }

    static function numberOfCompletedTasks()
    {
        return Task::where('status','==' ,'closed')->count();
    }

    static function numberOfTotalTasks()
    {
        return Task::all()->count();
                                                                
    }

    static function taskCompletePercentage()
    {

        return $taskCompletePercentage = (Task::numberOfCompletedTasks()*100)/Task::numberOfTotalTasks();
                                                                
    }

}
