<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messagenotification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'team_id', 'message_id', 'from_user_id', 'readed_at'];

    public function message ()
    {
        return $this->belongsTo(Message::class);
    }   

    public function team ()
    {
        return $this->belongsTo(Team::class);
    }

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

}
