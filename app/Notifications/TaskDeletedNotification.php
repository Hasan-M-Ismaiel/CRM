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

class TaskDeletedNotification extends Notification implements ShouldBroadcast, ShouldQueue
{
    use Queueable;

    protected $taskTitle;
    protected $taskProject;
    /**
     * Create a new notification instance.
     */
    public function __construct(String $taskTitle, Project $taskProject)
    {
        $this->taskTitle = $taskTitle;
        $this->taskProject = $taskProject;
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
            'task_title' => $this->taskTitle,
            'project_title' => $this->taskProject->title,
            'project_id' => $this->taskProject->id,
        ];
    }


    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $taskTitle = $this->taskTitle;
        $projectTitle = $this->taskProject->title;
        $url = url('/admin/projects/'.$this->taskProject->id);
        return (new MailMessage)
                    ->greeting('Hello!')
                    ->line("the task that assined to you , have been deleted : {$taskTitle}")
                    ->line("from the project : {$projectTitle}")
                    ->line('be a ware what is happening!')
                    ->line("check the project here : {$url}");
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

        $linkeToProject = route('admin.projects.show', $this->taskProject->id);

        return new BroadcastMessage([
            'notification_type' => 'TaskDeleted',
            'notification_id' => $notifiable->unreadNotifications()->latest()->first()->id,
            'task_title' => $this->taskTitle,
            'project_title' => $this->taskProject->title,
            'project_manager_name' => Auth::user()->name,
            'project_manager_image' => $image,
            'link_to_project' => $linkeToProject,
        ]);
    }
}
