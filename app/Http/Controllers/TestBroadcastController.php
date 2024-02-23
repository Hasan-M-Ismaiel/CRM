<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Team;
use Illuminate\Http\Request;

class TestBroadcastController extends Controller
{
    
    public function sendbroadcast ()
    {
        $team = Team::find(2);
        $user = auth()->user();
        MessageSent::dispatch($team,$user);
    }
}
