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
                    <button type="submit" class="btn btn-primary mt-5">Update</button>
                </form>
            </div>
        </div> 
    </div>
</div>
@endsection
