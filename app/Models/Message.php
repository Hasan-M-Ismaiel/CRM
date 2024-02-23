<?php

namespace App\Models;

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
}
