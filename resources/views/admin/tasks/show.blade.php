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
                                @if($task->status=="opened")
                                <div  id="{{$task->id}}" class="card border-success cardTaskParentEditClass">
                                @elseif($task->status=="pending")
                                <div  id="{{$task->id}}" class="card border-warning cardTaskParentEditClass">
                                @elseif($task->status=="closed")
                                <div  id="{{$task->id}}" class="card border-danger cardTaskParentEditClass">
                                @endif
                                    <div class="x-task-card">
                                        <div>@can('task_edit')<a class="text-secondary btn" style="text-decoration: none;" href="{{ route('admin.tasks.edit', $task) }}">Edit</a>@endcan</div>
                                        <div> @can('task_delete')<a class="text-secondary btn" style="text-decoration: none;" href="#" onclick="if (confirm('Are you sure?') == true) {
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
                                        
                                        <h5 class="card-title col">{{ $task->title }}</h5>
                                        <x-task-status :status="$task->status" />
                                        <span class="border-start border-3 border-primary ps-2 "> start date: {{ $task->created_at->diffForHumans() }}</span>
                                        <br>
                                        <br>
                                        @if($task->status=="opened")
                                        <span class="text-muted h6 col">working on</span>
                                        @elseif($task->status=="pending")
                                        <span class="text-muted h6 col">waiting for <a href="{{ route('admin.tasks.accept',['task_id'=>$task->id]) }}" >accept</a></span>
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
                                            <!--this is just for the user not for the admin -->
                                            @if($task->status!="closed")
                                            <div class="text-right" id="disable">
                                                <a  id="markAsCompleted" class="btn" onclick="markascompleted({{$task->id}})">Mark as completed</a>
                                            </div>
                                            @endif
                                        <!-- maybe in the future this task could have a status or deleted -->
                                        </p>
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

