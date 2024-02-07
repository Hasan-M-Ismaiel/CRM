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
                                        <h5 class="card-title col">{{ $client->name }}</h5>
                                        <span class="border-start border-3 border-primary ps-2 "> VAT: {{ $client->VAT }}</span>
                                        <br>
                                        <hr>
                                        <p class="card-text my-2">
                                            <div><strong>Client address:</strong> {{ $client->address }}</div>
                                            <div><strong>#Projects: </strong>{{ $client->numberOfProjects }}</div>
                                            @foreach ($client->projects as $project)
                                                <div><strong>Project #{{$loop->iteration}}:</strong> <a href="{{ route('admin.projects.show', $project) }}" style="text-decoration: none;">{{ $project->title }}</a></div>
                                            @endforeach
                                        </p>
                                    </div>
                                    <div class="m-4">
                                        <a class="btn btn-primary" href="{{ route('admin.clients.edit', $client) }}" role="button">Edit</a>
                                        <a class="btn btn-danger m-1" type="button"
                                                onclick="if (confirm('Are you sure?') == true) {
                                                            document.getElementById('delete-item-{{ $client->id }}').submit();
                                                            event.preventDefault();
                                                        } else {
                                                            return;
                                                        }
                                                        ">
                                            {{ __('Delete') }}
                                        </a>
                                        <!-- for the delete  -->
                                        <form id="delete-item-{{$client->id}}" action="{{ route('admin.clients.destroy', $client->id) }}" class="d-none" method="POST">
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
