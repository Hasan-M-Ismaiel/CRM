<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
