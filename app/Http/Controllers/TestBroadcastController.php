<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TestBroadcastController extends Controller
{
    
    // public function sendbroadcast ()
    // {
    //     $team = Team::find(2);
    //     $user = auth()->user();
    //     MessageSent::dispatch($team,$user);
    // }
    public function sendbroadcast ()
    {
        $user = User::find(13);
        dd($user->teamleaderon->count());
    }

}
