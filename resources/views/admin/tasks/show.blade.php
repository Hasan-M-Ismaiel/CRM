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
                                    <div class="card-body">
                                        <h5 class="card-title col">{{ $task->title }}</h5>
                                        <span class="border-start border-3 border-primary ps-2 "> start date: {{ $task->created_at->diffForHumans() }}</span>
                                        <br>
                                        <br>
                                        <span class="text-muted h6 col">working on ... task #1</span>
                                        <p class="card-text my-2">
                                            <span class="px-2 py-1 bg-secondary rounded">task description:</span> {{ $task->description }}
                                            <br>
                                            <a href="{{ route('admin.users.show',  $task->project->user->id) }}">For user: {{ $task->project->user->name }} </a>
                                            <br>
                                            <a href="{{ route('admin.projects.show', $task->project->id) }}">For project: {{ $task->project->title }} </a>
                                            <br>
                                        <!-- maybe in the future this task could have a status or deleted -->
                                        </p>
                                    </div>
                                    <div class="m-4">
                                        <a class="btn btn-primary" href="{{ route('admin.tasks.edit', $task) }}" role="button">Edit</a>
                                        <a class="btn btn-danger m-1" type="button"
                                                onclick="if (confirm('Are you sure?') == true) {
                                                            document.getElementById('delete-item-{{$task->id}}').submit();
                                                            event.preventDefault();
                                                        } else {
                                                            return;
                                                        }
                                                        ">
                                            {{ __('Delete') }}
                                        </a>
                                        <!-- for the delete  -->
                                        <form id="delete-item-{{$task->id}}" action="{{ route('admin.tasks.destroy', $task->id) }}" class="d-none" method="POST">
                                            @csrf
                                            @method('DELETE')
                                        </form>
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
@endsection
