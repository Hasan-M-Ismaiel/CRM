<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskAssigned;
use App\Notifications\TaskUnAssigned;
use Illuminate\Support\Facades\Auth;

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

        // here is the rendering section 
        $taskItems="";
        
        if($tasks != null && $tasks->count()>0){
            $taskItems .= '<li class="nav-item has-submenu">
                                <a class="nav-link" > 
                                    <svg class="nav-icon">
                                        <use xlink:href="'. asset('vendors/@coreui/icons/svg/free.svg#cil-chat-bubble').'"></use>
                                    </svg>
                                    Teams  
                                    <span class="ms-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="8"/>
                                        </svg>
                                    </span>
                                </a>';
            $taskItems .= '<ul class="submenu collapse">';
            foreach($tasks as $task){
                $taskItems .= '<li>';
                
                $taskItems .= '<a class="nav-link" href="'. route('admin.tasks.show', $task->id).'">';
                $taskItems .= '<img alt="DP" class="rounded-circle img-fluid mr-3" width="25" height="25" src="' . asset('images/taskChat.png') .'" />'. $task->title;
                $taskItems .= '<span class="ms-2">';
                $taskItems .= '<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">';
                $taskItems .=   '<circle cx="8" cy="8" r="8"/>';
                $taskItems .= '</svg>';
                $taskItems .= '</span>';
                $taskItems .= '</a>';
                $taskItems .= '</li>';

                $taskItems .= '<hr>';

            }
            $taskItems .= '</ul>';
            $taskItems .= '</li>';
        }else{
            "";
        }
        
        return json_encode(array($taskItems));
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
        $teamChat = request()->input('project_id');

        $user = User::find($fromUser);
        $team = Team::find($teamChat);

        Message::create([
            'team_id' => $team->id,
            'user_id' => $user->id,
            'message' => $message,
        ]);
        
        MessageSent::dispatch($team,$user,$message);

    }

}
