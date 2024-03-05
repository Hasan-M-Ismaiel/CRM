<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class PassOverTaskNotification extends Notification implements ShouldBroadcast, ShouldQueue
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
        return ['database', 'broadcast', 'mail'];
    }


    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase(object $notifiable)
    {
        return [
            'project_id' => $this->task->project->id,
            'project_title' => $this->task->project->title,
            'task_title' => $this->task->id,
            'task_title' => $this->task->title,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $projectTitle = $this->task->project->title;
        $taskTitle = $this->task->title;
        $url = url('/admin/tasks/'.$this->task->id);
        return (new MailMessage)
                    ->greeting('Hello!'. $notifiable->name)
                    ->line("there are tasks you have missed please be carefull the time is important!: {$taskTitle}")
                    ->line("at:{$projectTitle}")
                    ->action('View Task', $url);
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        sleep(10);

        $linkeToTask = route('admin.tasks.show', $this->task->id);
        return new BroadcastMessage([
            'notification_type' => 'TaskMissed',   
            'notification_id' => $notifiable->unreadNotifications()->latest()->first()->id,
            'project_id' => $this->task->project->id,
            'project_title' => $this->task->project->title,
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'link_to_task' => $linkeToTask,
        ]);
    }
}
