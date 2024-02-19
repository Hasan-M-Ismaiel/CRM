<?php

use App\Models\Project;
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

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

// note: you dont need to use token - or chat class - the project is enough because you can check if the reqeuested user is in the project
// note that the user is automatically the auth 
// Broadcast::channel('teams.{project}.{room}', function ($user, $projectId, $room) {
Broadcast::channel('teams.{project}', function ($user, $projectId) {
    $project= Project::find($projectId);
    foreach($project->users as $projectUser ){
        if($projectUser->id == $user->id){
            return true;
        }
    }
    return false;
});

// this channel is for notifications 
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Broadcast::channel('tasks.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

//running 
// Broadcast::channel('teams.{project}', function ($user, $project) {
//     return true;
// });
