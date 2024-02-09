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

                    <button type="submit" class="btn btn-primary mt-5">Create</button>
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
                alert(projectId);
            }
        });
    }

    send();
    // alert(projectId);

</script>


