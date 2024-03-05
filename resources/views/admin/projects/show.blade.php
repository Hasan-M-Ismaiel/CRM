@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="page-content page-container" id="page-content">
                    <div class="padding">
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body cardParentEditClass">
                                        
                                            <div class="x-project-card row">
                                            @can('update', $project)<div><a class="x-task-card text-secondary btn p-0" style="text-decoration: none;" href="{{ route('admin.projects.edit', $project) }}">Edit</a></div>@endcan
                                            @can('delete', $project)<div><a class="x-task-card text-secondary btn p-0" style="text-decoration: none;"  onclick="if (confirm('Are you sure?') == true) {
                                                                                                                                        document.getElementById('delete-item-{{$project->id}}').submit();
                                                                                                                                        event.preventDefault();
                                                                                                                                        } else {
                                                                                                                                            return;
                                                                                                                                        }">Delete</a></div>@endcan
                                            @can('update', $project)<div><a class="x-task-card text-secondary btn p-0" style="text-decoration: none;" href="{{ route('admin.taskGroups.create', ['projectId'=> $project->id]) }}">Add Tasks</a></div>@endcan
                                            @can('update', $project)<div><a class="x-task-card text-secondary btn p-0" style="text-decoration: none;" href="{{ route('admin.projects.assignCreate', $project->id) }}">Assign Users</a></div>@endcan
                                            </div>
                                        
                                        <!--this for the deletion-->
                                        <form id="delete-item-{{$project->id}}" action="{{ route('admin.projects.destroy', $project->id) }}" class="d-none" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <h5 class="card-title col">
                                            {{ $project->title }}
                                            @can('view', $project)
                                            <a type="button" class="m-1" href="{{ route('admin.teams.show', $project->id) }}" role="button" data-bs-toggle="tooltip" data-bs-placement="top" title="get into chat with team">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                                                    <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                                    <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2"/>
                                                </svg>
                                            </a>
                                            @endcan
                                        </h5>
                                        <!--green | red -->
                                        <x-project-status :status="$project->status" />
                                        <span class="border-start border-3 border-primary ps-2 "> deadLine: {{ $project->deadline }}</span>
                                        @can('client_show')
                                            <br><strong>owner:</strong> 
                                            <a href="{{ route('admin.clients.show', $project->client->id) }}" style="text-decoration: none;">{{ $project->client->name }} </a>
                                        @endcan
                                        <br><span class="text-muted h6 col">Created at <time>{{ $project->created_at->diffForHumans() }}</time></span>
                                        <span class="text-muted h6 col"># of tasks <span id="number_of_tasks" class="badge m-1" style="background: #673AB7;">{{ $project->tasks->count()}}</span></span>
                                        
                                        <hr class="shadow-sm mb-1">
                                        
                                        <!--progress bar-->
                                        <div class="progress blue">
                                            <div class="progress-bar" style="width:{{$project->projectCompletePercent}}%; background:#1a4966;">
                                                <div class="progress-value">{{$project->projectCompletePercent}}%</div>
                                            </div>
                                        </div>

                                        <!--description | skills | users -->
                                        <p class="card-text my-2">
                                            <!--description-->
                                            <div class="container ">
                                                <div class="card pt-2 pb-2 px-3">
                                                    <div class="bg-white px-0 py-2 ">
                                                        <div class="row">
                                                            <div class=" col-md-auto ">
                                                                    <svg width="20" height="20" >
                                                                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-warning') }}"></use>
                                                                    </svg> 
                                                                    <small>project description</small>
                                                                    <span class="vl ml-3 ">|</span>
                                                            </div>
                                                            <div class="col-md-auto ">
                                                                <span class="text-primary">{{ $project->description }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--skills-->
                                            <div class="container my-3">
                                                <div class="card pt-3 pb-3  pb-0 px-3">
                                                    <div class="bg-white px-0 ">
                                                        <div class="row">
                                                            <div class=" col-md-auto ">
                                                                <a class="btn btn-outlined btn-black text-muted bg-transparent"
                                                                    data-wow-delay="0.7s">
                                                                    <svg width="20" height="20">
                                                                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-settings') }}"></use>
                                                                    </svg> 
                                                                    <small>assigned skills</small>
                                                                </a>
                                                                <span class="vl ml-3">|</span>
                                                            </div>
                                                            @if($project->skills->count()>0)
                                                            <div class="col-md-auto pt-1">
                                                                @foreach ($project->skills as $skill)
                                                                    <span class="badge m-1" style="background: #673AB7;"><a href="{{ route('admin.skills.show', $skill->id) }}" class="text-white" style="text-decoration: none;">{{ $skill->name }}</a></span>
                                                                @endforeach
                                                            </div>
                                                            @else
                                                            <div class="col-md-auto pt-2 ">
                                                                <span class="text-danger">no skills assigned yet.</span>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--users-->
                                            <div class="container">
                                                <div class="card pt-2 pb-0 pb-3 px-3">
                                                    <div class="bg-white px-0 ">
                                                        <div class="row mt-2">
                                                            <div class=" col-md-auto ">
                                                                <a href="#" class="btn btn-outlined btn-black text-muted bg-transparent"
                                                                    data-wow-delay="0.7s">
                                                                    <svg width="20" height="20">
                                                                        <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-user-follow') }}"></use>
                                                                    </svg> 
                                                                    <small>assigned users</small></a>
                                                                <span class="vl ml-3">|</span>
                                                            </div>
                                                            @if($project->users()->count() > 0)
                                                            <div class="col-md-auto ">
                                                                <ul class="list-inline">
                                                                    <li class="list-inline-item"> 
                                                                        @foreach ($project->users as $user)
                                                                            <a href="{{ route('admin.users.show', $user->id) }}" style="text-decoration: none;" class="position-relative py-2 px-3" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$user->name}}">
                                                                                @if($user->profile && $user->profile->getFirstMediaUrl("profiles"))
                                                                                    <!--badges-->
                                                                                    <x-badges :user="$user" :project="$project" />
                                                                                    <div class="avatar avatar-md">
                                                                                        <img src='{{ $user->profile->getFirstMediaUrl("profiles") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                                                                    </div>
                                                                                @elseif($user->getFirstMediaUrl("users"))
                                                                                    <x-badges :user="$user" :project="$project" />
                                                                                    <div class="avatar avatar-md">
                                                                                        <img src='{{ $user->getMedia("users")[0]->getUrl("thumb") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                                                                    </div>
                                                                                @else
                                                                                    <x-badges :user="$user" :project="$project" />
                                                                                    <div class="avatar avatar-md">
                                                                                        <img src='{{ asset("images/avatar.png") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                                                                    </div>
                                                                                @endif
                                                                            </a>
                                                                        @endforeach
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            @else
                                                            <div class="col-md-auto py-2">
                                                                <span class="text-danger">no users assigned yet.</span>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </p>
                                    </div>
                                    <!--tasks-->
                                    <div class="ms-2">
                                        @if($project->tasks->count()>0)
                                            @foreach($project->tasks as $task)
                                                <!--pending task style (need approved)-->
                                                @if($task->status == "opened")
                                                <div id="{{$task->id}}" class="card p-3 ms-3 mb-3 ms-1 border-start-5 border-success shadow-lg p-3 mb-5 bg-body rounded" style="max-width: 600px;">
                                                @elseif($task->status == "pending")
                                                <div id="{{$task->id}}" class="card p-3 ms-3 mb-3 ms-1 border-start-5 border-warning shadow-lg p-3 mb-5 bg-body rounded" style="max-width: 600px;">
                                                @elseif($task->status == "closed")
                                                <div id="{{$task->id}}" class="card p-3 ms-3 mb-3 ms-1 border-start-5 border-danger shadow-lg p-3 mb-5 bg-body rounded" style="max-width: 600px;">
                                                @endif
                                                    <div class="row no-gutters cardParentClass">
                                                        @can('delete', $task)
                                                        <svg class="x-task-card" id="xbutton" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x float-right mark-as-read ml-4" onclick="deleteTask('{{ $task->id }}')" data-id="{{ $task->id }}" viewBox="0 0 16 16">
                                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                                        </svg>
                                                        @endcan
                                                        <div class="col-md-8">
                                                            <div class="card-body ">
                                                                <h5 class="card-title">{{ $task->title }}</h5>
                                                                <p class="card-text">{{substr($task->description, 0, 15)}}</p>
                                                                <hr>
                                                                @can('update', $task)
                                                                    <a class="btn btn-primary" 
                                                                        href="{{ route('admin.tasks.edit', $task) }}" 
                                                                        role="button">alter user</a>
                                                                @endcan
                                                                @can('update', $task)
                                                                    @if($task->status == "pending")
                                                                        <button class="btn btn-primary ms-1" 
                                                                            role="button"
                                                                            id="mark_task_as_read"
                                                                            onclick="markAsAccepted({{$task->id}})"
                                                                            >mark as complete</button>
                                                                    @endif 
                                                                @endcan
                                                                @can('view', $task)
                                                                    <a class="btn btn-primary" 
                                                                        href="{{ route('admin.tasks.show', $task) }}" 
                                                                        role="button">details</a>
                                                                @endcan
                                                                                
                                                            </div>
                                                            <!--this is if the user not finish the task on the time - the admin should be notified  also-->
                                                            @if($task->deadline < now() && $task->status!="closed")
                                                            <div class="position-absolute top-0 start-0" data-bs-toggle="tooltip" data-bs-placement="top" title="not finished on the time">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ee2811" class="bi bi-patch-exclamation-fill" viewBox="0 0 16 16">
                                                                    <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zM8 4c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995A.905.905 0 0 1 8 4m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                                                                </svg>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-4 mt-4">
                                                            @if($task->user)
                                                            <div class="card-text"><small class="text-muted">taken By {{$task->user->name}}</small></div>
                                                            @else
                                                            <div class="card-text"><small class="text-muted">taken By --- </small></div>
                                                            @endif
                                                            <div class="card-text"><small class="text-muted">started at {{$task->created_at->diffForHumans()}}</small></div>
                                                            <div class="card-text"><small class="text-muted">deadline: {{$task->deadline}}</small></div>
                                                            @if($task->status == "closed")
                                                            <div id="finished" class="card-text"><small class="text-muted">finished at {{$task->finished_at}}</small></div>
                                                            @else
                                                            <div id="notfinished" class="card-text"><small class="text-muted">not finished yet</small></div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="card border-secondary mb-3 shadow-lg p-3 mb-5 bg-body rounded" style="max-width: 18rem;">
                                                <div class="card-header">Tasks</div>
                                                <div class="card-body text-secondary">
                                                    <h5 class="card-title">There is no tasks</h5>
                                                    @can('task_create')<p class="card-text">click <a href="{{ route('admin.taskGroups.create', ['projectId'=> $project->id]) }}">here</a> to add new tasks.</p>@endcan
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--delete task | mark task as accepted-->
<script>
    function deleteTask(taskId){
        numberOfTasks = {!! $project->tasks->count() !!};
        if (confirm('There could be a messages in this task chat, Are you sure?') == true) {
            $('#loading').show();
            $.ajax({
                url: "{{ route('admin.tasks.remove') }}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    task_id: taskId,
                },
                success: function(result){
                    document.getElementById(taskId).remove();
                    $("#number_of_tasks").html(numberOfTasks - 1);
                    numberOfTasks = numberOfTasks - 1;
                    $('#loading').hide();
                }
            });
        }
    }

    function markAsAccepted(taskId){

        if (confirm('Are you sure?') == true) {
            $('#loading').show();
            $.ajax({
                url: "{{ route('admin.tasks.accept') }}",
                method: 'get',
                data: {
                    "_token": "{{ csrf_token() }}",
                    task_id: taskId,
                },
                success: function(result){
                    document.getElementById(taskId).classList.replace("border-warning", "border-danger");
                    $('#mark_task_as_read').hide();
                    $('#notfinished').hide();
                    $('#finished').show();
                    $('#loading').hide();
                }
            });
        }
    }

</script>
@endsection
