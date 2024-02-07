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
                <form action='{{ route("admin.projects.assignStore", $project) }}' method="POST">
                    @csrf
                    @method('PATCH')
                    <table class="table table-striped mt-2">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">profission</th>
                                <th scope="col">Assign/De-assign</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td><a href="{{ route('admin.users.show', $user->id) }}" >{{ $user->name }} </a></td>
                                    <td>{{ $user->email  }}...</td>
                                    <td>{{ $user->getRoleNames()->get('0') }}</td>
                                    <td><span class="badge bg-info text-dark mx-1">java</span><span class="badge bg-info text-dark mx-1">c++</span><span class="badge bg-info text-dark mx-1">ajax</span></td>
                                    <td>
                                        <input type="checkbox" id="user-{{$user->id}}" name="assigned_users[]" value="{{$user->id}}" {{ $user->checkifAssignedToProject($project) ? '' : 'checked' }}>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary mt-5">Assign</button>
                </form>
            </div>
        </div> 
    </div>
</div>
@endsection
