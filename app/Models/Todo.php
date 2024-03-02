<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable =['user_id', 'description', 'status', 'to_finish_at'];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function checkifFinished()
    {
        return $this->status=="done" ? true : false; 
    }
}
