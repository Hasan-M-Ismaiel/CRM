<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class TaskAssigned extends Notification implements ShouldBroadcast
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

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        //note you can reach to the user properties here using the $notifiable variable
        // return ['mail', 'database'];
        return ['database', 'broadcast'];
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
        //get the image for the user that notify this notifiable
        if(Auth::user()->getFirstMediaUrl("users")){
            $image =  Auth::user()->getFirstMediaUrl("users");
        } else {
            $image = asset('images/avatar.png');
        } 
        // dd($this::class);
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

    // public function broadcastOn()
    // {
    //     return new Channel('notification');
    // }
    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    // public function toArray(object $notifiable): array
    // {
    //     return [
    //         //
    //     ];
    // }
}
