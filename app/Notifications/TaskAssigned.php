<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class TaskAssigned extends Notification implements ShouldBroadcast, ShouldQueue
{
    use Queueable;

    protected $task;
    // protected $notifiable;    // you have to update the database column for user_id to not be nullable
    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;

        // $userId = $task->user_id;
        // $this->user = \App\User::find($userId);
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
        // $this->notifiable = $notifiable;
        //note you can reach to the user properties here using the $notifiable variable
        // return ['mail', 'database'];
        return ['database', 'broadcast', 'mail'];
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
            'project_title' => $this->task->project->title,
        ];
    }


    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/admin/tasks/'.$this->task->id);

        return (new MailMessage)
                    ->greeting('Hello!')
                    ->line('New task is waiting to complete!')
                    ->line($this->task->title)
                    ->lineIf($this->task->title, "starts at: {$this->task->created_at}")
                    ->line("deadline at: {$this->task->created_at}")
                    ->action('View Task', $url)
                    ->line('The Time is running !');
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

        $linkeToTask = route('admin.tasks.show', $this->task->id);
        return new BroadcastMessage([
            'notification_type' => 'TaskAssigned',
            'notification_id' => $notifiable->unreadNotifications()->latest()->first()->id,
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'project_title' => $this->task->project->title,
            'project_manager_name' => Auth::user()->name,
            'project_manager_image' => $image,
            'link_to_task' => $linkeToTask,
        ]);
    }
}
