<?php

namespace App\Notifications;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class TaskUnAssigned extends Notification implements ShouldBroadcast, ShouldQueue
{
    use Queueable;

    protected $task;
    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
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
        return ['database','broadcast', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable)
    {
        return [    
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'project_id' => $this->task->project->id,
            'project_name' => $this->task->project->title,
        ];
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

        // project
        $linkeToProject = route('admin.notifications.index', $this->task->project->id);
        return new BroadcastMessage([
            'notification_type' => 'TaskUnAssigned',
            'notification_id' => $notifiable->unreadNotifications()->latest()->first()->id, //id for the last notification
            // 'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'project_name' => $this->task->project->title,
            'project_manager_name' => Auth::user()->name,
            'project_manager_image' => $image,
            'link_to_task' => $linkeToProject,
        ]);
    }
    
    public function toMail(object $notifiable): MailMessage
    {
        $taskTitle = $this->task->title;
        $projectTitle = $this->task->project->title;
        $url = url('/admin/projects/'.$this->task->project->id);
        $unassignTime = Carbon::now();
        return (new MailMessage)
                    ->greeting('Hello!')
                    ->line("The task: {$taskTitle} was removed from your  duties.")
                    ->line("in the project: {$projectTitle} at:{$unassignTime->toDateTimeString()}")
                    ->action('View Project', $url)
                    ->line('Wait for another task in this project soon!');
    }
}
