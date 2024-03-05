<?php

namespace App\Jobs;

use App\Models\Task;
use App\Notifications\PassOverTaskNotification;

class CheckTasksFinishedTime
{


    public function __invoke()
    {
        $tasks = Task::all();
        foreach($tasks as $task){
            if($task->deadline < now() && $task->status == "opened"){
                $task->user->notify(new PassOverTaskNotification($task));
            }
        }
    }


}