<?php

namespace App\Events;

use App\Models\Team;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageReaded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // this team has access to all users through project class - and access to the chat to get the chat token
    protected $user;
    protected $team;
    protected $readedMessages;  // array of messages id tha have been readed by the user $user 
    // protected $numberOfUnreadedMessages;
    /**
     * Create a new event instance.
     */
    public function __construct(User $authUserId, $readedMessages, Team $team)
    {
        $this->team = $team;
        $this->user = $authUserId;
        $this->readedMessages = $readedMessages;
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
            new PrivateChannel('teams.'.$this->team->id),
        ];
    }

    public function broadcastWith(): array
    {
        // $userProfileRoute = '';  // route to the user profile
        $userImageRoute = '';    // route to the user image
        // $number = $this->team->numberOfUnreadedTeamMessages;
        if ($this->user->profile && $this->user->profile->getFirstMediaUrl("profiles")){
         $userImageRoute = $this->user->profile->getFirstMediaUrl("profiles");
        } elseif ($this->user->getFirstMediaUrl("users"))
        {
         $userImageRoute = $this->user->getMedia("users")->first()->getUrl("thumb");
        }else{
         $userImageRoute = asset('images/avatar.png');
        }

        return [
            'team_id'   => $this->team->id,
            'user_id'   => $this->user->id,
            'user_name' => $this->user->name,
            'user_image_url' => $userImageRoute,
            'messages_id' => $this->readedMessages,
            // 'number_of_unreaded_messages' => $this->numberOfUnreadedMessages,
        ];
    }

}
