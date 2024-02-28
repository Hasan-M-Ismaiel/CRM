<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class CreatingTasksStatusesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $project = $request->project;

        $project_ = Project::find($project);

        if($project_->teamleader->id == auth()->user()->id || auth()->user()->hasRole('admin')){
            return  view('admin.success_create_tasks',['project'=>$project]);
        } else {
            abort(404);
        }
    }
}
