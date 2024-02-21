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

class TaskWaitingNotification extends Notification implements ShouldBroadcast, ShouldQueue
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
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'project_id' => $this->task->project->id,
            'project_name' => $this->task->project->title,
        ];
    }


    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        sleep(10);

        //get the image for the user that notify this notifiable
        if(Auth::user()->profile && Auth::user()->profile->getFirstMediaUrl("profiles")){
            $image =  Auth::user()->profile->getFirstMediaUrl("profiles");
        }elseif(Auth::user()->getFirstMediaUrl("users")){
            $image =  Auth::user()->getMedia("users")[0]->getUrl("thumb");
        }else{
            $image =  asset('images/avatar.png');
        }

        $linkeToTask = route('admin.tasks.show', $this->task->id);
        return new BroadcastMessage([
            'notification_type' => 'TaskWaitingNotification',   // the type of the notificaiton - this is for the frontend to distiguish the broadcast messages types
            'notification_id' => $notifiable->unreadNotifications()->latest()->first()->id,
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            //[to do: edit the name here - should be the [project_user_name & project_manager_image ] becasuse the sender is the user not the admin
            'project_title' => $this->task->project->title,
            'project_manager_name' => Auth::user()->name,    //comment it - because the message will be recived by the admin    //
            'project_manager_image' => $image,               //comment it - because the message will be recived by the admin    //
            'link_to_task' => $linkeToTask,
        ]);
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {

        $url = url('/admin/tasks/'.$this->task->id);

        return (new MailMessage)
                    ->greeting('Hello!')
                    ->line('the Task - '. $this->task->title .' - from project -'. $this->task->project->title .'- is waiting you to finish it out!')
                    ->line('it was taken by the user:'. $this->task->user->name )
                    ->line('by mark the task as completed, the task owner will be notifyed automatically')
                    ->line('please view is the task to check if it was done correctly and make it as completed.')
                    ->lineIf($this->task->title, "starts at: {$this->task->created_at}")
                    // ->line("deadline at: {$this->task->created_at}")
                    ->action('View Task', $url)
                    ->line('The Time is running !');
    }

}
