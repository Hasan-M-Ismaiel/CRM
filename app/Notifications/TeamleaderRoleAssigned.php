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

class TeamleaderRoleAssigned extends Notification implements ShouldBroadcast, ShouldQueue
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
        $url = url('/admin/projects/'.$this->project->id);
        return (new MailMessage)
                    ->greeting('Hello!')
                    ->line("You are now the team leader of this project : {$projectTitle}")
                    ->line("at:{$this->project->created_at}")
                    ->action('View Project', $url)
                    ->line('you are now responsible for creating tasks and make this project be greate!');
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
            'notification_type' => 'TeamleaderRoleAssigned',   // the type of the notificaiton - this is for the frontend to distiguish the broadcast messages types
            'notification_id' => $notifiable->unreadNotifications()->latest()->first()->id,
            'project_id' => $this->project->id,
            'project_title' => $this->project->title,
            'project_manager_name' => Auth::user()->name,
            'project_manager_image' => $image,
            'link_to_project' => $linkeToProject,
        ]);
    }

}
