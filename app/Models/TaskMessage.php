<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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


     // this is for the Team message notifications
     public function taskmessagenotifications()
     {
         return $this->hasMany(Taskmessagenotification::class);
     }
 
     public function getusersWhoReadThisMessage():Attribute
     {
         $seenByUsers = collect();
         foreach($this->taskmessagenotifications as $taskmessagenotification){
             if($taskmessagenotification->readed_at != null){
                 if($taskmessagenotification->user_id != null){
                     $user = User::find($taskmessagenotification->user_id);
                     $seenByUsers->push($user);
                 }
             }
         }
 
         return Attribute::make(
             get: fn () => $seenByUsers
         );
     }
 }
 
