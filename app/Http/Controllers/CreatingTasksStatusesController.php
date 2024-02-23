<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreatingTasksStatusesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $project = $request->project;
        return  view('admin.success_create_tasks',['project'=>$project]);
    }
}
