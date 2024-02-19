<?php

namespace App\Events;

use App\Models\Team;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    // this team has access to all users through project class - and access to the chat to get the chat token 
    protected $team;
    protected $user;
    protected $message;
    /**
     * Create a new event instance.
     */
    public function __construct(Team $team, User $user, String $message)
    {
        $this->user = $user;        
        $this->team = $team;
        $this->message = $message;
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
        $userProfileRoute = '';  // route to the user profile
        $userImageRoute = '';    // route to the user image

        if ($this->user->profile && $this->user->profile->getFirstMediaUrl("profiles")){
         $userImageRoute = $this->user->profile->getFirstMediaUrl("profiles");
        } elseif ($this->user->getFirstMediaUrl("users")) 
        {
         $userImageRoute = $this->user->getMedia("users")->first()->getUrl("thumb");
        }else{
         $userImageRoute = "{{asset('images/avatar.png')}}";
        } 

        if($this->user->profile){
            $userProfileRoute = route('admin.profiles.show',$this->user->profile->id);
        }else{
            $userProfileRoute = route('admin.statuses.notFound');
        }

        return [
            'team_id'   => $this->team->id,
            'user_name' => $this->user->name,
            'user_id' => $this->user->id,
            'user_profile_url' => $userProfileRoute, 
            'user_image_url' => $userImageRoute, 
            'message' => $this->message,
        ];
    }

}
