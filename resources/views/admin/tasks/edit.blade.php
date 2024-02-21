@extends('layouts.app')

@section('content')
 
<div class="container mb-3">
    <div class="row justify-content-center">
        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-4 mt-4">
                <span class="pt-2 pb-2 pr-3 font-medium text-danger border border-danger border-rounded rounded">
                    <span class="bg-danger py-2 px-2  text-white">Whoops!</span>{{ __(' Something went wrong.') }}
                </span>

                <ul class="mt-3 list-group list-group-flush text-danger">
                    @foreach ($errors->all() as $error)
                        <li class="list-group-item text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card p-5">
            <div class="container-fluid border my-3  ">
                <div class="row justify-content-center">
                    <div class="card-create-project pt-4 my-3 mx-5 px-5">
                        <h2 id="heading">{{ $page }}</h2>
                        <p id="pcreateProject">change some essential information about this task</p>
                        <form action='{{ route("admin.tasks.update", $task) }}' method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="form-card border px-2 pb-2 mt-3">
                                <div class="row border px-3 pb-2 pt-3 rounded" style="background-color: #b9c9e5; background-image: linear-gradient(to bottom right, #b9c9e5, #e4eaf5);">
                                    <div class="col-7">
                                        <h2 class="fs-title">Alter basic Task Information:</h2>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id="title" placeholder="add the title of the task" value="{{ $task->title }}">
                                </div>
                                <div class="form-group mt-4">
                                    <label for="description">Description</label>
                                    <textarea rows="5" cols="50" name="description" class="form-control" id="description" placeholder="task's description here" >{{ $task->description }}</textarea>
                                </div>
                            </div>
                            <div class="form-card border px-2 pb-2 mt-3">
                                <div class="row border px-3 pb-2 pt-3 rounded" style="background-color: #b9c9e5; background-image: linear-gradient(to bottom right, #b9c9e5, #e4eaf5);">
                                    <div class="col-7">
                                        <h2 class="fs-title">Select a Project</h2>
                                    </div>
                                </div>
                                <div class="form-group mt-4">
                                    <label for="project_id">Project</label>
                                    <select name="project_id" id="project_id" class="form-control">
                                        <option selected value="{{$task->project->id}}">{{ $task->project->title }}</option>
                                        @foreach ( $projects as $project )
                                            @if ($project->title != $task->project->title)
                                                <option value="{{$project->id}}">{{ $project->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-card border px-2 pb-2 mt-3">
                                <div class="row border px-3 pb-2 pt-3 rounded" style="background-color: #b9c9e5; background-image: linear-gradient(to bottom right, #b9c9e5, #e4eaf5);">
                                    <div class="col-7">
                                        <h2 class="fs-title">Choose User</h2>
                                    </div>
                                </div>
                                <!--here is the generated content will be-->
                                <div class="form-group mt-4" id="users">
                                    <div class="mt-3">
                                        @if ($taskproject->users()->count()>0)
                                            <div class="row">
                                                @foreach ($taskproject->users as $user)
                                                    <div class="col-md-6">
                                                        @if($user->id == $task->user->id)
                                                        <input type="radio" id="{{$user->id}}" name="user_id" value="{{$user->id}}" checked>
                                                        <label for="user">{{ $user->name }}</label><br>
                                                        @else 
                                                        <input type="radio" id="{{$user->id}}" name="user_id" value="{{$user->id}}" >
                                                        <label for="user">{{ $user->name }}</label><br>
                                                        @endif
                                                    </div>
                                                    @if ($loop->iteration % 2 == 0)
                                                        </div>
                                                        <div class="row">
                                                    @endif
                                                @endforeach 
                                            </div>
                                        @else 
                                            <a href="{{ route('admin.projects.assignCreate', $task->project->id) }}">assign</a> users to the project first
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <input type="radio" id="opened" name="status" value="opened" @if($task->status=="opened") checked @endif>    <!--open-->
                                    </div>
                                    <div class="col-4 text-center">
                                        <input type="radio" id="pending" name="status" value="pending" @if($task->status=="pending") checked @endif>           <!--pending-->
                                    </div>
                                    <div class="col-4 text-center">
                                        <input type="radio" id="closed" name="status" value="closed"@if($task->status=="closed") checked @endif>            <!--close-->
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-4 text-center">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                <circle cx="8" cy="8" r="8"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col-4 text-center">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#f7dc08" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                <circle cx="8" cy="8" r="8"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="col-4 text-center">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fb043c" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                <circle cx="8" cy="8" r="8"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="action-create-button mt-5">Update</button>
                        </form>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
<script>
    $('#project_id').on('change', function(){  
        // to clear the list if the user change the selected option again 
        $('#users').empty();     
        $.ajax({
            url: "{{ route('admin.getUsers') }}",
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                id: $(this).val(),
            },
            success: function(result){
	            $('#users').append(result);  
            }
        });
    });
</script>
@endsection
