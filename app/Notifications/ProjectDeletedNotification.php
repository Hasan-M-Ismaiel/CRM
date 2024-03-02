<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ProjectDeletedNotification extends Notification implements ShouldBroadcast, ShouldQueue
{
    use Queueable;

    protected $projectTitle;
    /**
     * Create a new notification instance.
     */
    public function __construct(String $projectTitle)
    {
        $this->projectTitle = $projectTitle;
    }

    public function viaConnections(): array
    {
        return [
            'mail' => 'database',
            'database' => 'database',
            'broadcast' => 'sync',
        ];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable)
    {
        return [
            'project_title' => $this->projectTitle,
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $projectTitle = $this->projectTitle;
        return (new MailMessage)
                    ->greeting('Hello!')
                    ->line("the project that you are a member in it, have been deleted : {$projectTitle}")
                    ->line('be a ware what is happening!');
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        sleep(10);

        // the auth here is the admin because he is the only one who is able to fire the notification.
        if(Auth::user()->profile && Auth::user()->profile->getFirstMediaUrl("profiles")){
            $image =  Auth::user()->profile->getFirstMediaUrl("profiles");
        }elseif(Auth::user()->getFirstMediaUrl("users")){
            $image =  Auth::user()->getMedia("users")[0]->getUrl("thumb");
        }else{
            $image =  asset('images/avatar.png');
        }

        return new BroadcastMessage([
            'notification_type' => 'ProjectDeleted',
            //'notification_id' => $notifiable->unreadNotifications()->latest()->first()->id,  // we dont need that because we will not go to project page 
            'project_title' => $this->projectTitle,
            'project_manager_name' => Auth::user()->name,
            'project_manager_image' => $image,
        ]);
    }
}
