@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card position-relative">
                <div class="page-content page-container" id="page-content">
                    <div class="padding">
                        <div class="row">
                            <div class="col">
                                @if($task->status=="opened")
                                <div  id="{{$task->id}}" class="card border-success cardTaskParentEditClass">
                                @elseif($task->status=="pending")
                                <div  id="{{$task->id}}" class="card border-warning cardTaskParentEditClass">
                                @elseif($task->status=="closed")
                                <div  id="{{$task->id}}" class="card border-danger cardTaskParentEditClass">
                                @endif
                                    <div class="x-task-card">
                                        <div>@can('task_edit')<a class="text-secondary btn" style="text-decoration: none;" href="{{ route('admin.tasks.edit', $task) }}">Edit</a>@endcan</div>
                                        <div> @can('task_delete')<a class="text-secondary btn" style="text-decoration: none;" href="#" onclick="if (confirm('There could be messages in the task chat! Are you sure?') == true) {
                                                                                                                                document.getElementById('delete-item-{{$task->id}}').submit();
                                                                                                                                event.preventDefault();
                                                                                                                                } else {
                                                                                                                                    return;
                                                                                                                                }">Delete</a>@endcan
                                        </div>
                                        <!--this for the deletion-->
                                        <form id="delete-item-{{$task->id}}" action="{{ route('admin.tasks.destroy', $task->id) }}" class="d-none" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                    </div>
                                    <div class="card-body">
                                        
                                        <h5 class="card-title col">
                                            {{ $task->title }}
                                            @can('showTaskChat', $task)
                                            <a type="button" class="m-1" href="{{ route('admin.tasks.showTaskChat', $task->id) }}" role="button" data-bs-toggle="tooltip" data-bs-placement="top" title="get into chat teamleader">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                                                    <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                                    <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2"/>
                                                </svg>
                                            </a>
                                            @endcan
                                        </h5>
                                        <x-task-status :status="$task->status" />
                                        <span class="border-start border-3 border-primary ps-2 "> start date: {{ $task->created_at->diffForHumans() }}</span>
                                        <br>
                                        <br>
                                        @if($task->status=="opened")
                                        <span class="text-muted h6 col">working on</span>
                                        @elseif($task->status=="pending")
                                            @if($task->project->teamleader->id == auth()->user()->id || auth()->user()->hasRole('admin'))
                                            <span class="text-muted h6 col">waiting for <a href="{{ route('admin.tasks.accept',['task_id'=>$task->id]) }}" >accept</a></span>
                                            @endif
                                        @elseif($task->status=="closed")
                                        <span class="text-muted h6 col">finished</span>
                                        @endif
                                        <hr>
                                        <p class="card-text my-2">
                                            <strong>Task description:</strong> {{ $task->description }}
                                            <br>
                                            <strong>in project:</strong><span class="badge"><a href="{{ route('admin.projects.show', $task->project->id) }}" style="text-decoration: none;"> {{ $task->project->title }} </a></span>
                                            <br>
                                            <strong>for user:</strong><span class="badge"><a href="{{ route('admin.users.show', $task->user->id) }}" style="text-decoration: none;" >{{ $task->user->name }}</a></span>
                                            <br>
                                            <strong>deadline:</strong><span> {{ $task->deadline }}</span>
                                            <br>
                                            <!--this is just for the user not for the admin -->
                                            @if($task->status=="opened")
                                            @can('markTaskAsCompleted-task', $task)
                                            <div class="text-right" id="disable">
                                                <a  id="markAsCompleted" class="btn" onclick="markascompleted({{$task->id}})">Mark as completed</a>
                                            </div>
                                            @endcan
                                            @endif
                                        <!-- maybe in the future this task could have a status or deleted -->
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--this is if the user not finish the task on the time - the admin should be notified  also-->
                @if($task->deadline < now() && $task->status!="closed")
                <div class="position-absolute top-0 start-0 m-2" data-bs-toggle="tooltip" data-bs-placement="top" title="not finished on the time">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ee2811" class="bi bi-patch-exclamation-fill" viewBox="0 0 16 16">
                        <path d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zM8 4c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995A.905.905 0 0 1 8 4m.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
                    </svg>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>


<!--markascompleted-->
<script>
    function markascompleted(taskId){
        if (confirm('Are you sure?') == true) {
            $('#loading').show();
            $.ajax({
                url: "{{ route('admin.tasks.markascompleted') }}",
                method: 'get',
                data: {
                    "_token": "{{ csrf_token() }}",
                    task_id: taskId,
                },
                success: function(result){
                    // this is for altering the card border
                    document.getElementById(taskId).classList.replace("border-success", "border-warning");
                    // this for alter the spot light to yellow
                    var pendingSpotLight = '<span id="spot_light"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFEA4A" class="bi bi-circle-fill" viewBox="0 0 16 16"><circle cx="8" cy="8" r="8"/></svg></span> '
                    $("#spot_light").replaceWith(pendingSpotLight);
                    $('#markAsCompleted').addClass('disabled');
                    $('#loading').hide();   
                }
            });
        }
    }
</script>
@endsection

