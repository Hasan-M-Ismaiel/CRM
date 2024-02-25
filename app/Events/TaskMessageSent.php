<?php

namespace App\Events;

use App\Models\Task;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaskMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    // this task has access to all users through project class - and access to the chat to get the chat token 
    protected $task;
    protected $user;
    protected $message;
    protected $createdtaskmessageId;

    /**
     * Create a new event instance.
     */
    public function __construct(Task $task, User $user, String $message, $createdtaskmessageId)
    {
        $this->user = $user;        
        $this->task = $task;
        $this->message = $message;
        $this->createdtaskmessageId = $createdtaskmessageId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('tasks.'.$this->task->id),
        ];
    }

    public function broadcastWith(): array
    {
        $userProfileRoute = '';  // route to the user profile
        $userImageRoute = '';    // route to the user image

        // get the image url for the user 
        if ($this->user->profile && $this->user->profile->getFirstMediaUrl("profiles")){
         $userImageRoute = $this->user->profile->getFirstMediaUrl("profiles");
        } elseif ($this->user->getFirstMediaUrl("users")) {
         $userImageRoute = $this->user->getMedia("users")->first()->getUrl("thumb");
        }else{
         $userImageRoute = asset('images/avatar.png');
        } 

        // get the profile url for the user 
        if($this->user->profile){
            $userProfileRoute = route('admin.profiles.show',$this->user->profile->id);
        } else {
            $userProfileRoute = route('admin.statuses.notFound');
        }

        return [
            'task_id'   => $this->task->id,
            'user_name' => $this->user->name,
            'user_id' => $this->user->id,
            'user_profile_url' => $userProfileRoute, 
            'user_image_url' => $userImageRoute, 
            'message' => $this->message,
            'taskmessage_id'=> $this->createdtaskmessageId,
        ];
    }

}
