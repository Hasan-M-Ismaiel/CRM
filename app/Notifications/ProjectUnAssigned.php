<?php

namespace App\Notifications;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ProjectUnAssigned extends Notification implements ShouldBroadcast
{
    use Queueable;

    protected $project;
    /**
     * Create a new notification instance.
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable)
    {
        return [
            'project_id' => $this->project->id,
            'project_title' => $this->project->title,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        //get the image for the user that notify this notifiable
        if(Auth::user()->getFirstMediaUrl("users")){
            $image =  Auth::user()->getFirstMediaUrl("users");
        } else {
            $image = asset('images/avatar.png');
        } 

        return new BroadcastMessage([
            'notification_type' => 'ProjectUnAssigned',
            'notification_id' => $notifiable->unreadNotifications()->latest()->first()->id,
            'project_title' => $this->project->title,
            'project_manager_name' => Auth::user()->name,
            'project_manager_image' => $image,
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
