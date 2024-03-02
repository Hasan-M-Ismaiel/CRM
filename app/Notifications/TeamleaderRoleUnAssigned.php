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

class TeamleaderRoleUnAssigned extends Notification implements ShouldBroadcast, ShouldQueue
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

    public function toMail(object $notifiable): MailMessage
    {
        $projectTitle = $this->project->title;
        $unassignTime = Carbon::now();
        return (new MailMessage)
                    ->greeting('Hello!')
                    ->line("Now you are not the teamleader of this project's team: {$projectTitle}.")
                    ->line("at:{$unassignTime->toDateTimeString()}");
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

        $linkeToProject = route('admin.projects.show', $this->project->id);
        return new BroadcastMessage([
            'notification_type' => 'TeamleaderRoleUnAssigned',
            'notification_id' => $notifiable->unreadNotifications()->latest()->first()->id,
            'project_title' => $this->project->title,
            'project_manager_name' => Auth::user()->name,
            'project_manager_image' => $image,
            'linke_to_project' => $linkeToProject,
        ]);
    }
}
