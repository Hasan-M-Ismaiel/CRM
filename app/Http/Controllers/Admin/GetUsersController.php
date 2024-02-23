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
                    <div><strong>Select user:</strong></div>';
        $iterator = 1;  
        if($project->users->count()>0){
            $var .= '<div class="row text-center">';
            foreach ($project->users as $user){
                $var .= '<div class="col-md-6">';
                $var .= '<div class="avatar avatar-md mt-2">';
                $var .= '<label class="labelexpanded_">';
                $var .= '<input type="radio" class="m-1" id="' . $user->id .'" name="user_id" value="' . $user->id . '">';
                $var .= '<div class="radio-btns_ rounded-circle border-1">';

                if($user->profile && $user->profile->getFirstMediaUrl("profiles")){
                    $var .= '<img src="'. $user->profile->getFirstMediaUrl("profiles").'" alt="DP"  class="avatar-img  shadow ">';
                }elseif($user->getFirstMediaUrl("users")){
                    $var .= '<img src="'. $user->getMedia("users")[0]->getUrl("thumb").'" alt="DP"  class="avatar-img  shadow ">';
                }else{
                    $var .= '<img src="'. asset("images/avatar.png").'" alt="DP"  class="avatar-img  shadow ">';
                }
                $var .= '</div>';
                $var .= '</input>';
                $var .= '</label>';
                $var .= '</div>';
                $var .= '<label for="user_id" class="ms-2">' . $user->name . '</label><br>';
                $var .= '</div>';
                if ( $iterator % 2 == 0){
                    '</div>
                    <div class="row text-center">';
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
