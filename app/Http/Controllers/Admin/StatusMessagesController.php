<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatusMessagesController extends Controller
{
    public function notFound ()
    {
        return view('admin.statusesMessages.notFound');
    }
}
