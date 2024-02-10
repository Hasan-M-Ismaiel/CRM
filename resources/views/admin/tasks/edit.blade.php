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
        <div class="card">
            <div class="card-body">
                <h2 class="card-title mb-4">{{ $page }}</h2>
                <form action='{{ route("admin.tasks.update", $task) }}' method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="add the title of the task" value="{{ $task->title }}">
                    </div>
                    <div class="form-group mt-4">
                        <label for="description">description</label>
                        <textarea rows="10" cols="50" name="description" class="form-control" id="description" placeholder="task's description here" >{{ $task->description }}</textarea>
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
                    
                    <hr>
                    <!--here is the generated content will be-->
                    <div class="form-group mt-4" id="users">
                        <div class="mt-3">
                            <div>Select user:</div>
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


                    <button type="submit" class="btn btn-primary mt-5">Update</button>
                </form>
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
