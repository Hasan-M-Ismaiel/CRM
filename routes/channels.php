<?php

use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/



// note: you dont need to use token - or chat class - the project is enough because you can check if the reqeuested user is in the project
// note that the user is automatically the auth 
// Broadcast::channel('teams.{project}.{room}', function ($user, $projectId, $room) {
Broadcast::channel('teams.{project}', function ($user, $projectId) {
    $project= Project::find($projectId);
    foreach($project->users as $projectUser ){
        if($projectUser->id == $user->id || $user->hasRole('admin') || $user->id == $project->teamleader->id){
            return true;
        }
    }
    return false;
});


Broadcast::channel('tasks.{task}', function ($user, $taskId) {
    $task= Task::find($taskId);
    if($task->user->id == $user->id || $user->hasRole('admin') || $user->id == $task->project->teamleader->id){
        return true;
    }
    return false;
});


// this channel is for notifications 
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
