<?php

namespace App\Http\Controllers\Admin;

use App\Events\TaskMessageReaded;
use App\Events\TaskMessageSent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskMessage;
use App\Models\Taskmessagenotification;
use App\Models\User;
use App\Notifications\TaskAssigned;
use App\Notifications\TaskUnAssigned;
use App\Notifications\TaskWaitingNotification;
use App\Services\RenderTasksTableService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use function PHPUnit\Framework\throwException;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // this is unauthorized because every role can see multiple tasks 
    public function index()
    {
        if(auth()->user()->hasRole('admin')){
            $tasks = Task::with('project', 'user')->get();
        } else {
            $tasks = Task::where('user_id', Auth::user()->id)->get();
        }

        return view('admin.tasks.index', [
            'tasks' => $tasks,
            'page' => 'tasks List'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Task::class);

        $projects = Project::all();
        return view('admin.tasks.create', [
            'projects' => $projects,
            'page' => 'Creating task',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        //the authorization is in the form request class
        $assignedUser = User::findOrFail($request->user_id);

        $task = Task::create($request->validated());
        $task->status = 'opened';
        $task->save();

        $assignedUser->notify(new TaskAssigned($task));

        return redirect()->route('admin.tasks.index')->with('message', 'the task has been created sucessfully');;

    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        if(request('notificationId')){
            auth()->user()->unreadNotifications
            ->when(request('notificationId'), function ($query) {
                return $query->where('id', request('notificationId'));
            })
            ->markAsRead();
        }

        $task->with('project');
        return view('admin.tasks.show', [
            'task' => $task,
            'page' => 'Showing task',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $projects = Project::all();
        $project = $task->project()->get();
        //because we get a collection
        // dd($project[0]->title);
        return view('admin.tasks.edit', [
            'projects' => $projects,
            'task' => $task,                // ->with('user')
            'taskproject' => $project[0],  //because we get a collection
            'page' => 'Editing Task',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $assignedUser = User::findOrFail($request->user_id);
        $oldTaskUserId = $task->user_id;
        $oldUser = User::findOrFail($oldTaskUserId);

        $task->update($request->validated());
        

        // check if the user is not changed
        if ($assignedUser->id != $oldTaskUserId){
            $oldUser->notify(new TaskUnAssigned($task));
            $assignedUser->notify(new TaskAssigned($task));
        }

        // return redirect()->route('admin.tasks.index')->with('message', 'the task has been updated successfully');
        return back()->with('message', 'the task has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    //[you have to remove the old policy and ]
    // with out having to add gate to authServiceProvider | in the view you can use the if(auth()->user()->id == $task->project->teamleader_id) because the person how responsible for accept the task can delete it 
    // if(auth()->user()->id == $task->project->teamleader_id){
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();
        return redirect()->route('admin.tasks.index')->with('message','the task has been deleted successfully');

    }

    //[todo]
    public function remove()
    {
        // $this->destroy( request()->task_id);
        $task = Task::find(request()->task_id);
        // with out having to add gate to authServiceProvider | in the view you can use the if(auth()->user()->id == $task->project->teamleader_id) because the person how responsible for accept the task can delete it 
        // if(auth()->user()->id == $task->project->teamleader_id){
        $task->delete();
        //}
        return true;
    }

    //[todo]
    public function accept()
    {
        $task = Task::find(request()->task_id);

        // [to do ] - using gate
        // if(auth()->user()->id == $task->project->teamleader_id)
        // $this->authorize('accept-task', $task);
        $task->update([
            'status' => "closed",
        ]);

        return back()->with('message', 'the task status has been updated');
    }

    // authorized 
    public function showTasks()
    {
        // this should like this 
        // here the end user see the same tasks that the teamleader see [ the admin here is the super admin]
        if(auth()->user()->hasRole('admin')){
            $tasks = Task::all();
        } else {
            $user = Auth::user();
            
            // get all the tasks related to the registered user 
            $tasks = collect();
            $projects = $user->projects()->get();
            $projects->map(function (Project $project) use($tasks, $user) {
                foreach($project->tasks as $task){
                    if($task->user_id == $user->id){
                        $tasks->add($task);
                    }
                }
            });
        }

        $taskItems="";
        $var = $this->render($tasks,  $taskItems);

        return json_encode(array($var));
    }

    // authorized using gate in the AuthServiceProvider
    public function showTaskChat(Task $task)
    {
        $this->authorize('showTaskChat', $task);

        $users = User::all();
        return view('admin.tasks.showTaskChat', [
            'task' => $task,
            'users' => $users,
        ]);
    }

    // authorized by the own of this task chat and the admin role [here should be the team leader of the project that this task belongs to ] 
    public function sendTaskMessage ()
    {
        $message = request()->input('message');
        $fromUser = request()->input('user_id');
        $taskChat = request()->input('task_id');
        
        $user = User::find($fromUser);
        $task = Task::find($taskChat);
        
        //this check is for authorization
        if($user->id == $task->user_id || auth()->user()->hasRole('admin')){
            $createdtaskmessage = TaskMessage::create([
                'task_id' => $task->id,
                'user_id' => $user->id,
                'message' => $message,
            ]);

            $createdtaskmessageId = $createdtaskmessage->id;

            // if the sender was the admin
            if($user->hasRole('admin')){
                Taskmessagenotification::create([
                    'user_id' => $task->user->id,
                    'task_id' => $task->id,
                    'task_message_id' => $createdtaskmessage->id,  
                    'from_user_id' => $user->id,
                ]);
            } else {
                // search for the admin /// in the future you have to alter this because the admin could be muiple teamleaders 
                // this should be in the future as this :  if($adminuser->hasRole('teamleader') && in the $task->project->users)
                $adminUser = null;
                $users = User::all();
                foreach($users as $admin_user){
                    if($admin_user->hasRole('admin')){
                        $adminUser = $admin_user;
                    }
                }
                if($adminUser != null){
                    Taskmessagenotification::create([
                        'user_id' => $adminUser->id,
                        'task_id' => $task->id,
                        'task_message_id' => $createdtaskmessage->id,  
                        'from_user_id' => $user->id,
                    ]);
                }else{
                    Log::info('error : there is no admins in the database- this error in the task controller - send message');
                    abort('error : there is no admins in the database');
                }
            }


            TaskMessageSent::dispatch($task,$user,$message, $createdtaskmessageId);
        }else{
            //unauthorized
            abort(403);   
        }

    }

    // this should [not] be [public] its [private] in just here
    // render the task modal items [every one has different amount of tasks]
    public function render ($tasks, $taskItems)
    {
        if($tasks != null && $tasks->count()>0){
            foreach($tasks as $task){
                $taskItems .= '<a id="task-'.$task->id.'" href="'.route('admin.tasks.showTaskChat', $task).'" style="text-decoration: none;" class="" onclick="markasreadtask('.$task->id.','. auth()->user()->id .','. $task->taskmessagenotifications->where('user_id', auth()->user()->id)->count().')">';
                $taskItems .= '<div class="row">';
                $taskItems .= '<div class="col-4 text-right ">';
                $taskItems .= '<img alt="DP" class="rounded-circle img-fluid" width="45" height="40" src="'. asset('images/taskChat.png') .'">';
                if($task->numberOfUnreadedTaskMessages==0){
                    $taskItems .= '<em id= "num_of_single_task_notifications-'.$task->id.'" class="badge bg-danger text-white px-2 rounded-4 position-absolute bottom-0 end-0" style="font-size: 0.6em"></em>';
                }else{
                    $taskItems .= '<em id= "num_of_single_task_notifications-'.$task->id.'" class="badge bg-danger text-white px-2 rounded-4 position-absolute bottom-0 end-0" style="font-size: 0.6em">'.$task->numberOfUnreadedTaskMessages.'</em>';
                }
                $taskItems .= '</div>';
                $taskItems .= '<div class="col-8">';
                $taskItems .= '<h5 class="text-left text-md pt-2">'. substr($task->title, 0, 20) .'...</h5>';
                $taskItems .= '</div>';
                $taskItems .= '</div>';
                $taskItems .= '</a>';
            }
        }else{
            $taskItems = '<h4 class="text-center mb-5" style="color: #673AB7;">there is no tasks assigned to you so get rest now <span style="font-size:100px;">&#128150;</span> </h4> ';
        }
        
        return $taskItems;
    }

    // this method is just for the user  - not for the admin
    // this is authorized by only the owner of this task
    public function markascompleted()
    {
        $task = Task::find(request()->task_id);
        
        if(auth()->user()->tasks->contains($task)){
            $task->update([
                'status' => "pending",
            ]);

            // here you have to notify the admin tha the task is waiting to be accepted
            //notify the team leader
            foreach($task->project->users as $user){    
                if($user->hasRole('admin')){
                    $user->notify(new TaskWaitingNotification($task));
                } else {
                    //throwException();  // and catch it // in the case that the admin delete him self - 'admin not exist on this project'
                }
            }

            return back()->with('message', 'the task status has been updated');

        } else {
            //un authorized
            abort(403);
        }

    }

    // the sorted tasks by title
    // not need to authorize this feature
    public function getSortedTasks ()
    {
        // $this->authorize('viewAny', User::class);
       
        $tasks = Task::orderBy('title')->get();

        $renderedTable = new RenderTasksTableService($tasks);
        $table = $renderedTable->getTable();

        return json_encode(array($table));
    }
    
    // the result for the searched task title
    // not need to authorize this feature
    public function getSearchResult ()
    {
        $queryString = request()->queryString;

        //get all the matched users
        if ($queryString != null ) {
            $tasks = Task::where('title', 'like', '%' . $queryString . '%')->get();
        } else {
            $tasks = Task::all();
        }

        $renderedTable = new RenderTasksTableService($tasks);
        $table = $renderedTable->getTable();

        return json_encode(array($table));

    }

    // this is authorized by only the owner of the task and the admin
    public function markTaskMessagesAsReaded ()
    {
        $taskId = request()->input('taskId');           // in this conversation 
        $authUserId = request()->input('authUserId');   // by this user 

        $readedTaskMessages= array();                   // it could be alot of un readed messages - it contains the ids of readed messages 

        $user = User::find($authUserId);                // find the user that see the notification
        $task = Task::find($taskId);                    // find the task

        if($user->id == $task->user_id || auth()->user()->hasRole('admin')){

            // get all the records from the "messagenotifications" table that match the user id - notifications that realted to this user in this team  
            $taskMessagenotifications = $task->taskmessagenotifications->where('user_id','=', $authUserId);
            // Log::info($taskMessagenotifications);
            
            foreach($taskMessagenotifications as $taskMessagenotification){
                $taskMessagenotification->readed_at = now();
                $taskMessagenotification->save();
                array_push($readedTaskMessages, $taskMessagenotification->task_message_id);
            }

            // Log::info($readedTaskMessages);
            //dipatch (((messages))) readed
            // the [user] see the [task messages] with ids [readedTaskMessages]
            TaskMessageReaded::dispatch($user, $readedTaskMessages, $task);
        }else{
            //unauthorized
            abort(403);
        }
    }
}
