<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Profile extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['nickname', 'phone_number', 'postal_code', 'age', 'gender', 'facebook_account', 'linkedin_account', 'country', 'city', 'github_account', 'instagram_account', 'twitter_account', 'description', 'user_id'];

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

}
