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
                <form action='{{ route("admin.tasks.store") }}' method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="add the title of the task" value="{{ old('title') }}">
                    </div>
                    <div class="form-group mt-4">
                        <label for="description">description</label>
                        <input type="textarea" name="description" class="form-control" id="description" placeholder="task's description here"  value="{{ old('description') }}">
                    </div>
                    <div class="form-group mt-4">
                        <label for="project_id">Project</label>
                        <select name="project_id" id="project_id" class="form-control">
                            @if(request()->input('addTaskToProject'))
                            <option id="add_task_to_project" value="{{ request()->addTaskToProject}}" selected>{{ request()->projectTitle }}</option>

                            @else
                            <option value="" selected>Choose Project ...</option>
                            @endif
                            @foreach ( $projects as $project )
                                @if(request()->addTaskToProject != $project->id)
                                    <option value="{{$project->id}}" >{{ $project->title }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <hr>

                    <!--here is the generated content will be-->
                    <div class="form-group mt-4" id="users">
                    </div>

                    <div class="mt-3">
                        <div class="row">
                            <div class="col-4 text-center">
                                <input type="radio" id="opened" name="status" value="0" checked>    <!--open-->
                            </div>
                            <div class="col-4 text-center">
                                <input type="radio" id="pending" name="status" value="1">           <!--pending-->
                            </div>
                            <div class="col-4 text-center">
                                <input type="radio" id="closed" name="status" value="2">            <!--close-->
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

                    <button type="submit" class="btn btn-primary mt-5">Create</button>
                    <a id="add-tasks" class="btn btn-primary mt-5" style="display: none;" >add multiple tasks</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#project_id').on('change', function(){
        // to clear the list if the user change the selected option again
        project_id =$(this).val();
        project_id.toString();
        href="{{route('admin.taskGroups.create')}}";
        addTaskHref = href.concat('?projectId='+project_id);
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
                
                $('#add-tasks').show();
                $('#add-tasks').prop('href', addTaskHref);
            }
        });
    });

    @if(request()->input('addTaskToProject'))
        var projectId = {!! request()->addTaskToProject !!};
        function send() {
            $.ajax({
                url: "{{ route('admin.getUsers') }}",
                method: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: projectId,
                },
                success: function(result){
                    $('#users').append(result);
                    alert(projectId);
                }
            });
        }

        send();
    @endif
</script>
@endsection

<!-- this is rubbish try to remove it--> 
<script>
    var projectId = {!! request()->addTaskToProject !!};
    function send() {
        $.ajax({
            url: "{{ route('admin.getUsers') }}",
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                id: projectId,
            },
            success: function(result){
                $('#users').append(result);
                // alert(projectId);
            }
        });
    }

    send();
</script>


