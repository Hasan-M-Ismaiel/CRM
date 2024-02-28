<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;


// use ;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class RenderTasksTableService{

    protected $tasks;

    public function __construct($tasks) {
        $this->tasks = $tasks;
    }


    public function getTable ()
    {
        $var = '<table class="table table-striped mt-2 border" style="height: 100px;">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" class="align-middle">
                        <span class="btn px-1 p-0 m-0 text-light" style="background-color: #303c54;" id="getSortedUsers" onclick="getSortedTasks()">
                        Title
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6"/>
                            </svg>
                        </span>
                    </th>
                    <th scope="col">Project</th>
                    <th scope="col">Leader</th>
                    <th scope="col">To User</th>
                    <th scope="col">Start</th>
                    <th scope="col">status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>';

        $iterator = 1;  
        foreach ($this->tasks as $task){
            $var .= '<tr>';

            if(auth()->user()->hasRole('admin')){
                $var .= '<th scope="row" class="align-middle">'. $task->id.'</th>';
            } else {
                $var .= '<th scope="row" class="align-middle">'. $iterator.'</th>';
            }

            // task title
            $var .= '<td class="align-middle">';
            $var .= '<a href="'. route('admin.projects.show', $task->id).'" style="text-decoration: none;" >'. substr($task->title, 0,10) .'...</a>';
            $var .= '</td>';

            // project title
            $var .= '<td class="align-middle">';
            $var .= '<a href="'. route('admin.projects.show', $task->project->id) .'" style="text-decoration: none;">'. $task->project->title .'</a>';
            $var .= '</td>';

            // teamleader
            $var .= '<td class="align-middle">';
            if($task->project->teamleader){
                $var .='<div>';
                if($task->project->teamleader->profile)
                    if($task->project->teamleader->profile){
                        $var .='<a href="'. route('admin.profiles.show', $task->project->teamleader).'" class="position-relative" style="text-decoration: none;">';
                    }else{
                        $var .='<a href="'.route('admin.statuses.notFound') .'" class="position-relative" style="text-decoration: none;">';
                    }

                    if($task->project->teamleader->profile && $task->project->teamleader->profile->getFirstMediaUrl("profiles")){
                        $var .= ' <div class="py-1 px-2">';
                        $var .= '<div class="avatar avatar-md mt-1">';
                        $var .= '<img src="'. $task->project->teamleader->profile->getFirstMediaUrl("profiles").'" alt="DP"  class="  rounded-circle img-fluid  border border-success shadow mb-1" width="35" height="35">';
                        $var .= '</div>';
                        if($task->project->teamleader->hasRole('admin') && $task->project->teamleader->teamleaderon->count()>0){
                            $var .= '<div class="position-absolute top-0 start-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-star-fill text-warning" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5M8.16 4.1a.178.178 0 0 0-.32 0l-.634 1.285a.18.18 0 0 1-.134.098l-1.42.206a.178.178 0 0 0-.098.303L6.58 6.993c.042.041.061.1.051.158L6.39 8.565a.178.178 0 0 0 .258.187l1.27-.668a.18.18 0 0 1 .165 0l1.27.668a.178.178 0 0 0 .257-.187L9.368 7.15a.18.18 0 0 1 .05-.158l1.028-1.001a.178.178 0 0 0-.098-.303l-1.42-.206a.18.18 0 0 1-.134-.098z"/>
                                        </svg>
                                    </div>';
                            }elseif(!$task->project->teamleader->hasRole('admin') && $task->project->teamleader->teamleaderon->count()>0){
                            $var .= '<div class="position-absolute top-0 start-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM8.146 4.992c.961 0 1.641.633 1.729 1.512h1.295v-.088c-.094-1.518-1.348-2.572-3.03-2.572-2.068 0-3.269 1.377-3.269 3.638v1.073c0 2.267 1.178 3.603 3.27 3.603 1.675 0 2.93-1.02 3.029-2.467v-.093H9.875c-.088.832-.75 1.418-1.729 1.418-1.224 0-1.927-.891-1.927-2.461v-1.06c0-1.583.715-2.503 1.927-2.503Z"/>
                                        </svg>
                                    </div>';
                            } elseif($task->project->teamleader->hasRole('admin') && $task->project->teamleader->teamleaderon->count()==0){
                            $var .= '<div class="position-absolute top-0 start-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM8.146 4.992c.961 0 1.641.633 1.729 1.512h1.295v-.088c-.094-1.518-1.348-2.572-3.03-2.572-2.068 0-3.269 1.377-3.269 3.638v1.073c0 2.267 1.178 3.603 3.27 3.603 1.675 0 2.93-1.02 3.029-2.467v-.093H9.875c-.088.832-.75 1.418-1.729 1.418-1.224 0-1.927-.891-1.927-2.461v-1.06c0-1.583.715-2.503 1.927-2.503Z"/>
                                        </svg>
                                    </div>';
                            }else{
                            }
                        $var .= '</div>';
                    }elseif($task->project->teamleader->getFirstMediaUrl("users")){
                        $var .= ' <div class="py-1 px-2">';
                        $var .= '<div class="avatar avatar-md mt-1">';
                        $var .= '<img src="'. $task->project->teamleader->getMedia("users")[0]->getUrl("thumb").'" alt="DP"  class="  rounded-circle img-fluid border border-success shadow mb-1" width="35" height="35">';
                        $var .= '</div>';
                        if($task->project->teamleader->hasRole('admin') && $task->project->teamleader->teamleaderon->count()>0){
                            $var .= '<div class="position-absolute top-0 start-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-star-fill text-warning" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5M8.16 4.1a.178.178 0 0 0-.32 0l-.634 1.285a.18.18 0 0 1-.134.098l-1.42.206a.178.178 0 0 0-.098.303L6.58 6.993c.042.041.061.1.051.158L6.39 8.565a.178.178 0 0 0 .258.187l1.27-.668a.18.18 0 0 1 .165 0l1.27.668a.178.178 0 0 0 .257-.187L9.368 7.15a.18.18 0 0 1 .05-.158l1.028-1.001a.178.178 0 0 0-.098-.303l-1.42-.206a.18.18 0 0 1-.134-.098z"/>
                                        </svg>
                                    </div>';
                            }elseif(!$task->project->teamleader->hasRole('admin') && $task->project->teamleader->teamleaderon->count()>0){
                            $var .= '<div class="position-absolute top-0 start-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM8.146 4.992c.961 0 1.641.633 1.729 1.512h1.295v-.088c-.094-1.518-1.348-2.572-3.03-2.572-2.068 0-3.269 1.377-3.269 3.638v1.073c0 2.267 1.178 3.603 3.27 3.603 1.675 0 2.93-1.02 3.029-2.467v-.093H9.875c-.088.832-.75 1.418-1.729 1.418-1.224 0-1.927-.891-1.927-2.461v-1.06c0-1.583.715-2.503 1.927-2.503Z"/>
                                        </svg>
                                    </div>';
                            } elseif($task->project->teamleader->hasRole('admin') && $task->project->teamleader->teamleaderon->count()==0){
                            $var .= '<div class="position-absolute top-0 start-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM8.146 4.992c.961 0 1.641.633 1.729 1.512h1.295v-.088c-.094-1.518-1.348-2.572-3.03-2.572-2.068 0-3.269 1.377-3.269 3.638v1.073c0 2.267 1.178 3.603 3.27 3.603 1.675 0 2.93-1.02 3.029-2.467v-.093H9.875c-.088.832-.75 1.418-1.729 1.418-1.224 0-1.927-.891-1.927-2.461v-1.06c0-1.583.715-2.503 1.927-2.503Z"/>
                                        </svg>
                                    </div>';
                            }else{
                            }
                        $var .= '</div>';
                    }else{
                        $var .= ' <div class="py-1 px-2">';
                        $var .= '<div class="avatar avatar-md mt-1">';
                        $var .= '<img src="'. asset("images/avatar.png").'" alt="DP"  class="  rounded-circle img-fluid border border-success shadow mb-1" width="35" height="35">';
                        $var .= '</div>';
                        if($task->project->teamleader->hasRole('admin') && $task->project->teamleader->teamleaderon->count()>0){
                            $var .= '<div class="position-absolute top-0 start-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-star-fill text-warning" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5M8.16 4.1a.178.178 0 0 0-.32 0l-.634 1.285a.18.18 0 0 1-.134.098l-1.42.206a.178.178 0 0 0-.098.303L6.58 6.993c.042.041.061.1.051.158L6.39 8.565a.178.178 0 0 0 .258.187l1.27-.668a.18.18 0 0 1 .165 0l1.27.668a.178.178 0 0 0 .257-.187L9.368 7.15a.18.18 0 0 1 .05-.158l1.028-1.001a.178.178 0 0 0-.098-.303l-1.42-.206a.18.18 0 0 1-.134-.098z"/>
                                        </svg>
                                    </div>';
                            }elseif(!$task->project->teamleader->hasRole('admin') && $task->project->teamleader->teamleaderon->count()>0){
                            $var .= '<div class="position-absolute top-0 start-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM8.146 4.992c.961 0 1.641.633 1.729 1.512h1.295v-.088c-.094-1.518-1.348-2.572-3.03-2.572-2.068 0-3.269 1.377-3.269 3.638v1.073c0 2.267 1.178 3.603 3.27 3.603 1.675 0 2.93-1.02 3.029-2.467v-.093H9.875c-.088.832-.75 1.418-1.729 1.418-1.224 0-1.927-.891-1.927-2.461v-1.06c0-1.583.715-2.503 1.927-2.503Z"/>
                                        </svg>
                                    </div>';
                            } elseif($task->project->teamleader->hasRole('admin') && $task->project->teamleader->teamleaderon->count()==0){
                            $var .= '<div class="position-absolute top-0 start-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle-fill" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM8.146 4.992c.961 0 1.641.633 1.729 1.512h1.295v-.088c-.094-1.518-1.348-2.572-3.03-2.572-2.068 0-3.269 1.377-3.269 3.638v1.073c0 2.267 1.178 3.603 3.27 3.603 1.675 0 2.93-1.02 3.029-2.467v-.093H9.875c-.088.832-.75 1.418-1.729 1.418-1.224 0-1.927-.891-1.927-2.461v-1.06c0-1.583.715-2.503 1.927-2.503Z"/>
                                        </svg>
                                    </div>';
                            }else{
                            }
                        $var .= '</div>';
                    }
                    $var .='<span class="badge m-1" style="background: #673AB7;">'. $task->project->teamleader->name .'</span>';
                    $var .='</a>';
                    $var .='</div>';
                } else {
                $var .= '#';
            }
            $var .= '</td>';

            // user image
            $var .= '<td class="align-middle">';
            if($task->user->profile){
                $var .= '<a href="'. route('admin.profiles.show', $task->user->id) .'" class="position-relative" style="text-decoration: none;">';

            } else {
                $var .= '<a href="'. route('admin.statuses.notFound') .'" class="position-relative" style="text-decoration: none;">';
            }

            if($task->user->profile && $task->user->profile->getFirstMediaUrl("profiles")){
                $var .= '<div class="p-2">';
                $var .= '<div class="avatar avatar-md">';
                $var .= '<img src="'. $task->user->profile->getFirstMediaUrl("profiles").'" alt="DP"  class="avatar-img border border-success shadow mb-1">';
                $var .= '</div>';
                if($task->user->hasRole('admin') && $task->user->teamleaderon->count()>0){
                    $var .= '<div class="position-absolute top-0 start-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-star-fill text-warning" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5M8.16 4.1a.178.178 0 0 0-.32 0l-.634 1.285a.18.18 0 0 1-.134.098l-1.42.206a.178.178 0 0 0-.098.303L6.58 6.993c.042.041.061.1.051.158L6.39 8.565a.178.178 0 0 0 .258.187l1.27-.668a.18.18 0 0 1 .165 0l1.27.668a.178.178 0 0 0 .257-.187L9.368 7.15a.18.18 0 0 1 .05-.158l1.028-1.001a.178.178 0 0 0-.098-.303l-1.42-.206a.18.18 0 0 1-.134-.098z"/>
                                </svg>
                            </div>';
                    }elseif(!$task->user->hasRole('admin') && $task->user->teamleaderon->count()>0){
                    $var .= '<div class="position-absolute top-0 start-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM8.146 4.992c.961 0 1.641.633 1.729 1.512h1.295v-.088c-.094-1.518-1.348-2.572-3.03-2.572-2.068 0-3.269 1.377-3.269 3.638v1.073c0 2.267 1.178 3.603 3.27 3.603 1.675 0 2.93-1.02 3.029-2.467v-.093H9.875c-.088.832-.75 1.418-1.729 1.418-1.224 0-1.927-.891-1.927-2.461v-1.06c0-1.583.715-2.503 1.927-2.503Z"/>
                                </svg>
                            </div>';
                    } elseif($task->user->hasRole('admin') && $task->user->teamleaderon->count()==0){
                    $var .= '<div class="position-absolute top-0 start-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM8.146 4.992c.961 0 1.641.633 1.729 1.512h1.295v-.088c-.094-1.518-1.348-2.572-3.03-2.572-2.068 0-3.269 1.377-3.269 3.638v1.073c0 2.267 1.178 3.603 3.27 3.603 1.675 0 2.93-1.02 3.029-2.467v-.093H9.875c-.088.832-.75 1.418-1.729 1.418-1.224 0-1.927-.891-1.927-2.461v-1.06c0-1.583.715-2.503 1.927-2.503Z"/>
                                </svg>
                            </div>';
                    }else{
                    }
                $var .= '</div>';

            }elseif($task->user->getFirstMediaUrl("users")){
                $var .= '<div class="p-2">';
                $var .= '<div class="avatar avatar-md">';
                $var .= '<img src="'. $task->user->getMedia("users")[0]->getUrl("thumb").'" alt="DP"  class="avatar-img border border-success shadow mb-1">';
                $var .= '</div>';
                if($task->user->hasRole('admin') && $task->user->teamleaderon->count()>0){
                    $var .= '<div class="position-absolute top-0 start-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-star-fill text-warning" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5M8.16 4.1a.178.178 0 0 0-.32 0l-.634 1.285a.18.18 0 0 1-.134.098l-1.42.206a.178.178 0 0 0-.098.303L6.58 6.993c.042.041.061.1.051.158L6.39 8.565a.178.178 0 0 0 .258.187l1.27-.668a.18.18 0 0 1 .165 0l1.27.668a.178.178 0 0 0 .257-.187L9.368 7.15a.18.18 0 0 1 .05-.158l1.028-1.001a.178.178 0 0 0-.098-.303l-1.42-.206a.18.18 0 0 1-.134-.098z"/>
                                </svg>
                            </div>';
                    }elseif(!$task->user->hasRole('admin') && $task->user->teamleaderon->count()>0){
                    $var .= '<div class="position-absolute top-0 start-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM8.146 4.992c.961 0 1.641.633 1.729 1.512h1.295v-.088c-.094-1.518-1.348-2.572-3.03-2.572-2.068 0-3.269 1.377-3.269 3.638v1.073c0 2.267 1.178 3.603 3.27 3.603 1.675 0 2.93-1.02 3.029-2.467v-.093H9.875c-.088.832-.75 1.418-1.729 1.418-1.224 0-1.927-.891-1.927-2.461v-1.06c0-1.583.715-2.503 1.927-2.503Z"/>
                                </svg>
                            </div>';
                    } elseif($task->user->hasRole('admin') && $task->user->teamleaderon->count()==0){
                    $var .= '<div class="position-absolute top-0 start-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM8.146 4.992c.961 0 1.641.633 1.729 1.512h1.295v-.088c-.094-1.518-1.348-2.572-3.03-2.572-2.068 0-3.269 1.377-3.269 3.638v1.073c0 2.267 1.178 3.603 3.27 3.603 1.675 0 2.93-1.02 3.029-2.467v-.093H9.875c-.088.832-.75 1.418-1.729 1.418-1.224 0-1.927-.891-1.927-2.461v-1.06c0-1.583.715-2.503 1.927-2.503Z"/>
                                </svg>
                            </div>';
                    }else{
                    }
                $var .= '</div>';

            }else{
                $var .= '<div class="p-2">';
                $var .= '<div class="avatar avatar-md">';
                $var .= '<img src="'. asset("images/avatar.png").'" alt="DP"  class="avatar-img border border-success shadow mb-1">';
                $var .= '</div>';
                if($task->user->hasRole('admin') && $task->user->teamleaderon->count()>0){
                    $var .= '<div class="position-absolute top-0 start-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-star-fill text-warning" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5M8.16 4.1a.178.178 0 0 0-.32 0l-.634 1.285a.18.18 0 0 1-.134.098l-1.42.206a.178.178 0 0 0-.098.303L6.58 6.993c.042.041.061.1.051.158L6.39 8.565a.178.178 0 0 0 .258.187l1.27-.668a.18.18 0 0 1 .165 0l1.27.668a.178.178 0 0 0 .257-.187L9.368 7.15a.18.18 0 0 1 .05-.158l1.028-1.001a.178.178 0 0 0-.098-.303l-1.42-.206a.18.18 0 0 1-.134-.098z"/>
                                </svg>
                            </div>';
                    }elseif(!$task->user->hasRole('admin') && $task->user->teamleaderon->count()>0){
                    $var .= '<div class="position-absolute top-0 start-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM8.146 4.992c.961 0 1.641.633 1.729 1.512h1.295v-.088c-.094-1.518-1.348-2.572-3.03-2.572-2.068 0-3.269 1.377-3.269 3.638v1.073c0 2.267 1.178 3.603 3.27 3.603 1.675 0 2.93-1.02 3.029-2.467v-.093H9.875c-.088.832-.75 1.418-1.729 1.418-1.224 0-1.927-.891-1.927-2.461v-1.06c0-1.583.715-2.503 1.927-2.503Z"/>
                                </svg>
                            </div>';
                    } elseif($task->user->hasRole('admin') && $task->user->teamleaderon->count()==0){
                    $var .= '<div class="position-absolute top-0 start-0">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle-fill" viewBox="0 0 16 16">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM8.146 4.992c.961 0 1.641.633 1.729 1.512h1.295v-.088c-.094-1.518-1.348-2.572-3.03-2.572-2.068 0-3.269 1.377-3.269 3.638v1.073c0 2.267 1.178 3.603 3.27 3.603 1.675 0 2.93-1.02 3.029-2.467v-.093H9.875c-.088.832-.75 1.418-1.729 1.418-1.224 0-1.927-.891-1.927-2.461v-1.06c0-1.583.715-2.503 1.927-2.503Z"/>
                                </svg>
                            </div>';
                    }else{
                    }
                $var .= '</div>';
            }
            $var .=  '<span class="badge m-1" style="background: #673AB7;">'. $task->user->name .'</span>';
            $var .= '</a>';
            $var .= '</td>';

            $var .= '<td class="align-middle">';
                    $task->created_at->diffForHumans();
            $var .= '</td>';

            //status
            $var .= '<td class="align-middle">';
                if($task->status=="opened"){
                    $var .= '<span id="spot_light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8"/>
                            </svg>
                        </span>';
                } elseif($task->status=="pending") {
                    $var .= '<span id="spot_light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFEA4A" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8"/>
                            </svg>
                        </span>';
                } elseif($task->status=="closed"){
                    $var .= '<span id="spot_light">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fe0131" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8"/>
                            </svg>
                        </span>';
                }
            $var .= '</td>';

            // control buttons
            $var .= '<td class="align-middle">';
            $var .= '<div style="display: flex;">';
            $var .= '<a type="button" class="btn btn-primary m-1" href="'. route('admin.tasks.show', $task->id).'" role="button">Show</a>';
            if(auth()->user()->hasRole('admin')){  
                $var .= '<a type="button" class="btn btn-secondary m-1" href="'.route('admin.tasks.edit', $task->id) .'" role="button">Edit</a>';
            }
            if(auth()->user()->hasRole('admin')){  
                $var .='<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash-fill text-danger mt-2" viewBox="0 0 16 16"';
            
                $var .= 'onclick="if (confirm('."'Are you sure?'".') == true) {';
                $var .= 'document.getElementById('."'delete-item-".$task->id."').submit();";
                $var .= 'event.preventDefault();';
                $var .= '} else {';
                $var .= 'return;';
                $var .= '}">';
                $var .= '<path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>';
                $var .= '</svg>';


                $var .= '<form id="delete-item-'.$task->id.'" action="'. route('admin.tasks.destroy', $task).'" class="d-none" method="POST">';
                $var .= '<input type="hidden" name="_method" value="DELETE">';
                $var .= '<input type="hidden" name="_token" value="'. csrf_token() .'">';
                $var .= '</form>';

                $var .= '</div>';
                $var .= '</td>';
                $var .= '</tr>';

                } 
                $iterator = $iterator +1 ;
            }           
        $var .= '</tbody>';
        $var .= '</table>';
        return $var;
    }
}