<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;


// use ;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class RenderUsersTableService{

    protected $users;

    public function __construct($users) {
        $this->users = $users;
    }


    public function getTable ()
    {
        $var = '<table class="table table-striped mt-2 border">
        <thead>
            <tr>
                <th scope="col" class="align-middle">#</th>
                <th scope="col" class="align-middle">Profile</th>
                <th scope="col" class="align-middle">
                    <span class="btn px-1 p-0 m-0 text-light" style="background-color: #303c54;" id="getSortedUsers" onclick="getSortedUsers()">
                    Name
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6"/>
                        </svg>
                    </span>
                </th>
                <th scope="col" class="align-middle">Email</th>
                <th scope="col" class="align-middle">Role</th>
                <th scope="col" class="align-middle">Tasks</th>
                <th scope="col" class="align-middle">Skills</th>
                <th scope="col" class="align-middle">Action</th>
            </tr>
            </thead>
            <tbody>';
        // $iterator = 1;  
        foreach ($this->users as $user){
            $var .= '<tr>';
            $var .= '<th scope="row" class="align-middle">'.$user->id.'</th>';
            $var .= '<td class="align-middle">';

            if($user->profile){
                $var .= '<a href="'. route('admin.profiles.show', $user->id) .'" style="text-decoration: none;">';
            }
            else{
                $var .= '<a href="'. route('admin.statuses.notFound') .'" style="text-decoration: none;">';
            }

            if($user->profile && $user->profile->getFirstMediaUrl("profiles")){
                $var .= '<div class="avatar avatar-md">';
                $var .= '<img src="'. $user->profile->getFirstMediaUrl("profiles").'" alt="DP"  class="  rounded-circle img-fluid  border border-success shadow mb-1" width="35" height="35">';
                $var .= '</div>';
            }elseif($user->getFirstMediaUrl("users")){
                $var .= '<div class="avatar avatar-md">';
                $var .= '<img src="'. $user->getMedia("users")[0]->getUrl("thumb").'" alt="DP"  class="  rounded-circle img-fluid border border-success shadow mb-1" width="35" height="35">';
                $var .= '</div>';
            }else{
                $var .= '<div class="avatar avatar-md">';
                $var .= '<img src="'. asset("images/avatar.png").'" alt="DP"  class="  rounded-circle img-fluid border border-success shadow mb-1" width="35" height="35">';
                $var .= '</div>';
            }

            $var .= '</a>';
            $var .= '</td>';

            $var .= '<td class="align-middle"><a href="'. route('admin.users.show', $user->id).'" style="text-decoration: none;" >'. $user->name .'</a></td>';
           
            $var .= '<td class="align-middle">'.substr($user->email, 0, 15).'...</td>';
            $var .= '<td class="align-middle">'. $user->getRoleNames()->get('0') .'</td>';
            $var .= '<td class="align-middle">'. $user->numberOfAssignedTasks .'</td>';
            $var .= '<td class="align-middle">';

            if($user->skills()->count() > 0){
                foreach ($user->skills as $skill){
                    $var .= '<span class="badge m-1" style="background: #673AB7;">'. $skill->name .'</span>';
                }
            }else{
                $var .= '#';
            }
            $var .= '</td>';

            $var .= '<td class="align-middle">';
            $var .= '<div style="display: flex;">';
            $var .= '<a type="button" class="btn btn-primary m-1" href="'. route('admin.users.show', $user->id) .'" role="button">Show</a>';
            $var .= '<a type="button" class="btn btn-secondary m-1" href="'.route('admin.users.edit', $user->id) .'" role="button">Edit</a>';
           
            
            $var .='<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash-fill text-danger mt-2" viewBox="0 0 16 16"';
            
            // $var .= '<a class="btn btn-danger m-1" type="button"';
            $var .= 'onclick="if (confirm('."'Are you sure?'".') == true) {';
            $var .= 'document.getElementById('."'delete-item-".$user->id."').submit();";
            $var .= 'event.preventDefault();';
            $var .= '} else {';
            $var .= 'return;';
            $var .= '}">';
            $var .= '<path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>';
            $var .= '</svg>';
           
            $var .= '<form id="delete-item-'.$user->id.'" action="'. route('admin.users.destroy', $user).'" class="d-none" method="POST">';
            $var .= '<input type="hidden" name="_method" value="DELETE">';
            $var .= '<input type="hidden" name="_token" value="'. csrf_token() .'">';
            $var .= '</form>';
            $var .= '</div>';
            $var .= '</td>';
            $var .= '</tr>';

        }            
        $var .= '</tbody>';
        $var .= '</table>';

        return $var;
    }
}