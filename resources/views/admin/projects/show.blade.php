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
                                        <h5 class="card-title col">{{ $project->title }}</h5>
                                        <span class="border-start border-3 border-primary ps-2 "> deadLine: {{ $project->deadline }}</span>
                                        <br>
                                        <br>
                                        <span class="text-muted h6 col">Created at <time>{{ $project->created_at->diffForHumans() }}</time></span>
                                        <p class="card-text my-2">
                                            <span class="px-2 py-1 bg-secondary rounded">Project description:</span> {{ $project->description }}
                                            <br>
                                            <a href="{{ route('admin.projects.show', $project->user->id) }}">Assigned user: {{ $project->user->name }} </a>
                                            <br>
                                            <a href="{{ route('admin.clients.show', $project->client->id) }}">Project owner: {{ $project->client->name }} </a>
                                            <br>
                                            @if( $project->status)
                                                <p> Status: <span class="px-2 py-2 badge bg-danger">closed</span></p>
                                            @else 
                                                <p> Status: <span class="px-2 py-2 badge bg-success">open</span></p>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="m-4">
                                        <a class="btn btn-primary" href="{{ route('admin.projects.edit', $project) }}" role="button">Edit</a>
                                        <a class="btn btn-danger m-1" type="button"
                                                onclick="if (confirm('Are you sure?') == true) {
                                                            document.getElementById('delete-item-{{$project->id}}').submit();
                                                            event.preventDefault();
                                                        } else {
                                                            return;
                                                        }
                                                        ">
                                            {{ __('Delete') }}
                                        </a>
                                        <!-- for the delete  -->
                                        <form id="delete-item-{{$project->id}}" action="{{ route('admin.projects.destroy', $project->id) }}" class="d-none" method="POST">
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
