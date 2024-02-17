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

class ProjectAssigned extends Notification implements ShouldBroadcast, ShouldQueue
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

        $linkeToProject = route('admin.projects.show', $this->project->id);
        return new BroadcastMessage([
            'notification_type' => 'ProjectAssigned',   // the type of the notificaiton - this is for the frontend to distiguish the broadcast messages types
            'notification_id' => $notifiable->unreadNotifications()->latest()->first()->id,
            'project_id' => $this->project->id,
            'project_title' => $this->project->title,
            'project_manager_name' => Auth::user()->name,
            'project_manager_image' => $image,
            'link_to_project' => $linkeToProject,
        ]);
    }

    public function toMail(object $notifiable): MailMessage
    {
        $projectTitle = $this->project->title;
        $url = url('/admin/projects/'.$this->project->id);
        return (new MailMessage)
                    ->greeting('Hello!')
                    ->line("You are now one of the team member of this project : {$projectTitle}")
                    ->line("at:{$this->project->created_at}")
                    ->action('View Project', $url)
                    ->line('Wait for tasks in this project soon!');
    }
}
