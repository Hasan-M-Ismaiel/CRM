<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class GetUsersController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $id = $request->input('id');
        $project = Project::findOrFail($id);

        $var = '<div id="content-user" class="mt-3">
                    <div>Select user:</div>';
        $iterator = 1;  
        if($project->users->count()>0){
            $var .= '<div class="row">';
            foreach ($project->users as $user){
                $var .= '<div class="col-md-6">';
                $var .= '<input type="radio" class="m-1" id="' . $user->id .'" name="user_id" value="' . $user->id . '">';
                $var .= '<label for="user">' . $user->name . '</label><br>';
                $var .= '</div>';
                if ( $iterator % 2 == 0){
                    '</div>
                    <div class="row">';
                }
            }
            $var .= '</div>';
        } else {
            $var .= '<a href="' . route('admin.projects.assignCreate', $project->id) . '">assign</a> users to the project first'; 
        }
        $var .= '</div>';

        return $var;
    }
}
