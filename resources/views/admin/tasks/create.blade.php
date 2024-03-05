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
                        <p id="pcreateProject">please try to add value to all added inputes</p>
                        <form action='{{ route("admin.tasks.store") }}' method="POST">
                            @csrf
                            <!-- creating task card-->
                            <div class="card p-4 border-success">
                                <!--the green light-->
                                <div class="text-right">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                            <circle cx="8" cy="8" r="8"/>
                                        </svg>
                                    </span>
                                </div>
                                <!--the title-->
                                <div class="form-group">
                                    <label for="title"><strong>Title</strong></label>
                                    <input type="text" name="title" class="form-control" id="title" placeholder="add the title of the task" value="{{ old('title') }}">
                                </div>
                                <!--description-->
                                <div class="form-group mt-4">
                                    <label for="description"><strong>Description</strong></label>
                                    <input type="textarea" name="description" class="form-control" id="description" placeholder="task's description here"  value="{{ old('description') }}">
                                </div>
                                <!--project-->
                                <div class="form-group mt-4">
                                    <label for="project_id"><strong>Project</strong></label>
                                    <select name="project_id" id="project_id" class="form-control">
                                        @if(request()->input('addTaskToProject'))
                                        <option id="add_task_to_project" value="{{ request()->addTaskToProject}}" selected>{{ request()->projectTitle }}</option>

                                        @else
                                        <option value="" selected>Choose Project ...</option>
                                        @endif
                                        @foreach ( $projects as $project )
                                            @if(request()->addTaskToProject != $project->id)
                                                @if($project->teamleader->id  ==  auth()->user()->id || auth()->user()->hasRole('admin'))
                                                    <option value="{{$project->id}}" >{{ $project->title }}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                               <!--deadline-->
                               <div class="form-group mt-4">
                                    <label for="deadline"><strong>Deadline</strong></label>
                                    <input type="date" name="deadline" class="form-control" id="deadline" placeholder="task's deadline here"  value="{{ old('deadline') }}">
                                </div>
                                <!--here is the generated content will be-->
                                <div class="form-group mt-4" id="users">
                                </div>
                            </div>
                            <x-forms.create-button />
                        </form>
                        <a id="add-tasks" class="btn btn-primary mt-5" style="display: none;" >add multiple tasks</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--radio selection button-->
<style>
    .labelexpanded_ > input {
        display: none;
    }

    .labelexpanded_ input:checked + .radio-btns_ {
        border-style: solid;
        border-color: #50ef44;
    }

    .radio-btns_ {
        cursor: pointer;
        background-color: #eaeaea;
    }
</style>

<!--get users according to the project selection-->
<script>
    $('#project_id').on('change', function(){
        $('#loading').show();
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
                $('#loading').hide();

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



