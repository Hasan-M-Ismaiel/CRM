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
                <form action='{{ route("admin.projects.update", $project) }}' method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="add the title of the project" value="{{ $project->title }}">
                    </div>
                    <div class="form-group mt-4">
                        <label for="description">description</label>
                        <textarea rows="10" cols="50" name="description" class="form-control" id="description" placeholder="Project's description here" >{{ $project->description }}</textarea>
                    </div>
                    <div class="form-group mt-4">
                        <label for="deadline">deadline</label>
                        <input id="deadline" type="date" class="form-control @error('deadline') is-invalid @enderror"  placeholder="Project's deadline here" name="deadline" value="{{ $project->deadline }}">
                    </div>
                    <div class="form-group mt-4">
                        <label for="user_id">User</label>
                        <select name="user_id" id="user_id" class="form-control">
                            <option selected value="{{$project->user->id}}">{{ $project->user->name }}</option>
                            @foreach ( $users as $user )
                                @if ($user->name != $project->user->name)
                                    <option value="{{$user->id}}">{{ $user->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-4">
                        <label for="client_id">Client</label>
                        <select name="client_id" id="client_id" class="form-control">
                            <option selected value="{{$project->client->id}}">{{ $project->client->name }}</option>
                            @foreach ( $clients as $client )
                                @if ($client->name != $project->client->name)
                                    <option value="{{$client->id}}">{{ $client->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-3">
                            <div>Select status:</div>
                            @if($project->status)
                            <input type="radio" id="close" name="status" value="true" checked>
                            <label for="close">close</label><br>
                            <input type="radio" id="open" name="status" value="false">
                            <label for="open">open</label><br>
                            @else
                            <input type="radio" id="close" name="status" value="true">
                            <label for="close">close</label><br>
                            <input type="radio" id="open" name="status" value="false" checked>
                            <label for="open">open</label><br>
                            @endif
                    </div>
                    <button type="submit" class="btn btn-primary mt-5">Update</button>
                </form>
            </div>
        </div> 
    </div>
</div>
@endsection
