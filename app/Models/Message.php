<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected  $fillable = ['message', 'user_id', 'team_id'];


    public function team ()
    {
        return $this->belongsTo(Team::class);
    }

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    // this is for the Team message notifications
    public function messagenotifications()
    {
        return $this->hasMany(Messagenotification::class);
    }

    public function getusersWhoReadThisMessage():Attribute
    {
        $seenByUsers = collect();
        foreach($this->messagenotifications as $messagenotification){
            if($messagenotification->readed_at != null){
                if($messagenotification->user_id != null){
                    $user = User::find($messagenotification->user_id);
                    $seenByUsers->push($user);
                }
            }
        }

        return Attribute::make(
            get: fn () => $seenByUsers
        );
    }
}
