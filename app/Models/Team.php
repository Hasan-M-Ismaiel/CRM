<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Team extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['name', 'project_id'];
    
    public function project ()
    {
        return $this->belongsTo(Project::class);
    }


    public function messages ()
    {
        return $this->hasMany(Message::class);
    }

    // this is for the Team message notifications
    public function messagenotifications()
    {
        return $this->hasMany(Messagenotification::class);
    }

    
    public function numberOfUnreadedTeamMessages():Attribute
    {

        $numberOfUnreadedTeamMessages = $this->messagenotifications->where('readed_at','==' ,null)
                                                                    ->where('user_id', auth()->user()->id)
                                                                    ->count();
        

        return Attribute::make(
            get: fn () => $numberOfUnreadedTeamMessages
        );
    }

}
