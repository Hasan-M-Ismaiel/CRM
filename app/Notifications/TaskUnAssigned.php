<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class TaskUnAssigned extends Notification implements ShouldBroadcast
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
        return ['database','broadcast'];
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
