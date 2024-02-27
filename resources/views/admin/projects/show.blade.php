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
                                        @can('task_edit')
                                        <div class="x-project-card row">
                                            <div><a class="x-task-card text-secondary btn p-0" style="text-decoration: none;" href="{{ route('admin.projects.edit', $project) }}">Edit</a></div>
                                            <div><a class="x-task-card text-secondary btn p-0" style="text-decoration: none;"  onclick="if (confirm('Are you sure?') == true) {
                                                                                                                                    document.getElementById('delete-item-{{$project->id}}').submit();
                                                                                                                                    event.preventDefault();
                                                                                                                                    } else {
                                                                                                                                        return;
                                                                                                                                    }">Delete</a></div>
                                            <div><a class="x-task-card text-secondary btn p-0" style="text-decoration: none;" href="{{ route('admin.taskGroups.create', ['projectId'=> $project->id]) }}">Add Tasks</a></div>
                                            <div><a class="x-task-card text-secondary btn p-0" style="text-decoration: none;" href="{{ route('admin.projects.assignCreate', $project->id) }}">Assign Users</a></div>
                                        </div>
                                        @endcan

                                        <!--this for the deletion-->
                                        <form id="delete-item-{{$project->id}}" action="{{ route('admin.projects.destroy', $project->id) }}" class="d-none" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <h5 class="card-title col">{{ $project->title }}</h5>
                                        <!--green | red -->
                                        <x-project-status :status="$project->status" />
                                        <span class="border-start border-3 border-primary ps-2 "> deadLine: {{ $project->deadline }}</span>
                                        @can('client_show')
                                        <br><strong>owner:</strong> <a href="{{ route('admin.clients.show', $project->client->id) }}" style="text-decoration: none;">{{ $project->client->name }} </a>@endcan
                                        <br><span class="text-muted h6 col">Created at <time>{{ $project->created_at->diffForHumans() }}</time></span>
                                        <br>
                                        <br>
                                        <span># of tasks <span id="number_of_tasks" class="badge bg-danger">{{ $project->tasks->count()}}</span></span>
                                        <hr class="shadow-sm mb-1">
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
                                                                <a href="#" class="btn btn-outlined btn-black text-muted bg-transparent"
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
                                                <div class="card pt-2 pb-0 px-3">
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
                                                                            <a href="{{ route('admin.users.show', $user->id) }}" style="text-decoration: none;" class="position-relative py-2 px-3">
                                                                                @if($user->profile && $user->profile->getFirstMediaUrl("profiles"))
                                                                                    <!--badges-->
                                                                                    @if($user->hasRole('admin') && $user->id == $project->teamleader_id)
                                                                                    <div class="position-absolute top-0 start-0">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-star-fill text-warning" viewBox="0 0 16 16">
                                                                                            <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5M8.16 4.1a.178.178 0 0 0-.32 0l-.634 1.285a.18.18 0 0 1-.134.098l-1.42.206a.178.178 0 0 0-.098.303L6.58 6.993c.042.041.061.1.051.158L6.39 8.565a.178.178 0 0 0 .258.187l1.27-.668a.18.18 0 0 1 .165 0l1.27.668a.178.178 0 0 0 .257-.187L9.368 7.15a.18.18 0 0 1 .05-.158l1.028-1.001a.178.178 0 0 0-.098-.303l-1.42-.206a.18.18 0 0 1-.134-.098z"/>
                                                                                        </svg>
                                                                                    </div>
                                                                                    @elseif(!$user->hasRole('admin') && $user->id == $project->teamleader_id)
                                                                                    <div class="position-absolute top-0 start-0">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-c-circle-fill" viewBox="0 0 16 16">
                                                                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0ZM8.146 4.992c.961 0 1.641.633 1.729 1.512h1.295v-.088c-.094-1.518-1.348-2.572-3.03-2.572-2.068 0-3.269 1.377-3.269 3.638v1.073c0 2.267 1.178 3.603 3.27 3.603 1.675 0 2.93-1.02 3.029-2.467v-.093H9.875c-.088.832-.75 1.418-1.729 1.418-1.224 0-1.927-.891-1.927-2.461v-1.06c0-1.583.715-2.503 1.927-2.503Z"/>
                                                                                        </svg>
                                                                                    </div>
                                                                                    @elseif($user->hasRole('admin') && $user->id != $project->teamleader_id)
                                                                                    <div class="position-absolute top-0 start-0">
                                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bootstrap-fill" viewBox="0 0 16 16">
                                                                                            <path d="M6.375 7.125V4.658h1.78c.973 0 1.542.457 1.542 1.237 0 .802-.604 1.23-1.764 1.23zm0 3.762h1.898c1.184 0 1.81-.48 1.81-1.377 0-.885-.65-1.348-1.886-1.348H6.375z"/>
                                                                                            <path d="M4.002 0a4 4 0 0 0-4 4v8a4 4 0 0 0 4 4h8a4 4 0 0 0 4-4V4a4 4 0 0 0-4-4zm1.06 12V3.545h3.399c1.587 0 2.543.809 2.543 2.11 0 .884-.65 1.675-1.483 1.816v.1c1.143.117 1.904.931 1.904 2.033 0 1.488-1.084 2.396-2.888 2.396z"/>
                                                                                        </svg>
                                                                                    </div>
                                                                                    @else
                                                                                    @endif
                                                                                    <div class="avatar avatar-md">
                                                                                        <img src='{{ $user->profile->getFirstMediaUrl("profiles") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                                                                    </div>
                                                                                @elseif($user->getFirstMediaUrl("users"))
                                                                                    <div class="avatar avatar-md">
                                                                                        <img src='{{ $user->getMedia("users")[0]->getUrl("thumb") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                                                                    </div>
                                                                                @else
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
                                                                <strong>no users assigned yet.</strong>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </p>
                                    </div>
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
                                                        <svg class="x-task-card" id="xbutton" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x float-right mark-as-read ml-4" onclick="deleteTask('{{ $task->id }}')" data-id="{{ $task->id }}" viewBox="0 0 16 16">
                                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                                        </svg>
                                                        <div class="col-md-8" >
                                                            <div class="card-body ">
                                                                <h5 class="card-title">{{ $task->title }}</h5>
                                                                <p class="card-text">{{substr($task->description, 0, 15)}}</p>
                                                                <hr>
                                                                @can('task_edit')
                                                                    <a class="btn btn-primary" 
                                                                        href="{{ route('admin.tasks.edit', $task) }}" 
                                                                        role="button">alter user</a>@endcan
                                                                @can('task_edit')
                                                                @if($task->status == "pending")
                                                                    <button class="btn btn-primary ms-1" 
                                                                        role="button"
                                                                        id="mark_task_as_read"
                                                                        onclick="markAsAccepted({{$task->id}})"
                                                                        >mark as complete</button>@endif @endcan
                                                                @can('task_show')
                                                                    <a class="btn btn-primary" 
                                                                        href="{{ route('admin.tasks.show', $task) }}" 
                                                                        role="button">details</a>@endcan
                                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 mt-4">
                                                            @if($task->user)
                                                            <div class="card-text"><small class="text-muted">taken By {{$task->user->name}}</small></div>
                                                            @else
                                                            <div class="card-text"><small class="text-muted">taken By --- </small></div>
                                                            @endif
                                                            <div class="card-text"><small class="text-muted">started at {{$task->created_at->diffForHumans()}}</small></div>
                                                            @if($task->status == "closed")
                                                            <div id="finished" class="card-text"><small class="text-muted">finished at 3 mins ago</small></div>
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
<script>
    function deleteTask(taskId){
        numberOfTasks = {!! $project->tasks->count() !!};
        if (confirm('Are you sure?') == true) {
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
