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
                <form action='{{ route("admin.projects.store") }}' method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="add the title of the project" value="{{ old('title') }}">
                    </div>
                    <div class="form-group mt-4">
                        <label for="description">description</label>
                        <input type="textarea" name="description" class="form-control" id="description" placeholder="Project's description here"  value="{{ old('description') }}">
                    </div>
                    <div class="form-group mt-4">
                        <label for="deadline">deadline</label>
                        <input id="deadline" type="date" class="form-control @error('deadline') is-invalid @enderror"  placeholder="Project's deadline here" name="deadline">
                    </div>
                    
                    <div class="form-group mt-4">
                        <label for="client_id">Client</label>
                        <select name="client_id" id="client_id" class="form-control">
                            <option value="" selected>Choose Client ...</option>
                            @foreach ( $clients as $client )
                                <option value="{{$client->id}}" >{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-4">
                        <strong> choose users to work in this project:</strong>
                        <div class="row">
                            @foreach($users as $user)
                                <div class="col-md-4">
                                    <input type="checkbox" id="user-{{$user->id}}" name="assigned_users[]" value="{{$user->id}}">
                                    <label for="user-{{$user->id}}"><a href="{{ route('admin.users.show', $user->id) }}" style="text-decoration: none;" >{{ $user->name }} </a></label>
                                </div>
                                @if ($loop->iteration % 3 == 0)
                                    </div>
                                    <div class="row">
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-5">Create</button>
                </form>
            </div>
        </div> 
    </div>
</div>
@endsection
