<?php

namespace App\Notifications;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ProjectUnAssigned extends Notification implements ShouldBroadcast, ShouldQueue
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
            'project_id' => $this->project->id,
            'project_title' => $this->project->title,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        sleep(10);

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
    public function toMail(object $notifiable): MailMessage
    {
        $projectTitle = $this->project->title;
        $unassignTime = Carbon::now();
        return (new MailMessage)
                    ->greeting('Hello!')
                    ->line("Now you are out of this project's team: {$projectTitle}.")
                    ->line("at:{$unassignTime->toDateTimeString()}")
                    ->line('Wait for another projects to be in!');
    }
}
