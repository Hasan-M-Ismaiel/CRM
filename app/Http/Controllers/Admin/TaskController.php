<?php

namespace App\Http\Controllers\Admin;

use App\Events\TaskMessageSent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskMessage;
use App\Models\User;
use App\Notifications\TaskAssigned;
use App\Notifications\TaskUnAssigned;
use App\Notifications\TaskWaitingNotification;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\throwException;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();
        return redirect()->route('admin.tasks.index')->with('message','the task has been deleted successfully');

    }

    public function remove()
    {
        // $this->destroy( request()->task_id);
        $task = Task::find(request()->task_id);
        $task->delete();
        return true;
    }

    public function accept()
    {
        $task = Task::find(request()->task_id);

        $task->update([
            'status' => "closed",
        ]);

        return back()->with('message', 'the task status has been updated');
    }

    public function showTasks()
    {
        if(auth()->user()->hasRole('admin')){
            $tasks = Task::all();
        } else {
            $user = Auth::user();
            
            // get all the tasks related to the  registered user 
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

    public function showTaskChat(Task $task)
    {
        $users = User::all();
        return view('admin.tasks.showTaskChat', [
            'task' => $task,
            'users' => $users,
        ]);
    }

    public function sendMessage ()
    {

        $message = request()->input('message');
        $fromUser = request()->input('user_id');
        $taskChat = request()->input('task_id');

        $user = User::find($fromUser);
        $task = Task::find($taskChat);

        TaskMessage::create([
            'task_id' => $task->id,
            'user_id' => $user->id,
            'message' => $message,
        ]);
        
        TaskMessageSent::dispatch($task,$user,$message);

    }

    public function render ($tasks, $taskItems)
    {
        if($tasks != null && $tasks->count()>0){
            foreach($tasks as $task){
                $taskItems .= '<a id="task" href="'.route('admin.tasks.showTaskChat', $task).'" style="text-decoration: none;" class="">';
                $taskItems .= '<div class="row">';
                $taskItems .= '<div class="col-4 text-right ">';
                $taskItems .= '<img alt="DP" class="rounded-circle img-fluid" width="45" height="40" src="'. asset('images/taskChat.png') .'">';
                $taskItems .= '</div>';
                $taskItems .= '<div class="col-8">';
                $taskItems .= '<h5 class="text-left text-md pt-2">'. substr($task->title, 0, 15) .'...</h5>';
                $taskItems .= '</div>';
                $taskItems .= '</div>';
                $taskItems .= '</a>';
            }
        }else{
            $taskItems = '<h4 class="text-center mb-5" style="color: #673AB7;">there is no tasks assigned to you so get rest now <span style="font-size:100px;">&#128150;</span> </h4> ';
        }
        
        return $taskItems;
    }

    // this method is just for the 
    public function markascompleted()
    {
        $task = Task::find(request()->task_id);
        
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
    }

}
