<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'deadline', 'user_id', 'client_id', 'status'];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks ()
    {
        return $this->hasMany(Task::class);
    }

    public function client ()
    {
        return $this->belongsTo(Client::class);
    }

    protected function statusOfProject(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status ? 'closed' : 'opened'
        );
    }

}
