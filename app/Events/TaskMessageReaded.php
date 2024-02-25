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

class TaskMessageReaded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // this team has access to all users through project class - and access to the chat to get the chat token
    protected $user;
    protected $task;
    protected $readedTaskMessages;  // array of messages id tha have been readed by the user $user 
    // protected $numberOfUnreadedMessages;
    /**
     * Create a new event instance.
     */
    public function __construct(User $authUserId, $readedTaskMessages, Task $task)
    {
        $this->task = $task;
        $this->user = $authUserId;
        $this->readedTaskMessages = $readedTaskMessages;
        // $this->numberOfUnreadedMessages = $numberOfUnreadedMessages;
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
        // $userProfileRoute = '';  // route to the user profile
        $userImageRoute = '';    // route to the user image
        // $number = $this->team->numberOfUnreadedTeamMessages;
        if ($this->user->profile && $this->user->profile->getFirstMediaUrl("profiles")){
         $userImageRoute = $this->user->profile->getFirstMediaUrl("profiles");
        } elseif ($this->user->getFirstMediaUrl("users")){
         $userImageRoute = $this->user->getMedia("users")->first()->getUrl("thumb");
        }else{
         $userImageRoute = asset('images/avatar.png');
        }

        return [
            'task_id'   => $this->task->id,
            'user_id'   => $this->user->id,
            'user_name' => $this->user->name,
            'user_image_url' => $userImageRoute,
            'taskmessages_id' => $this->readedTaskMessages,
            // 'number_of_unreaded_messages' => $this->numberOfUnreadedMessages,
        ];
    }

}
