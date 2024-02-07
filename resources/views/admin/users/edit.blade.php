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
                <form action='{{ route("admin.users.update", $user) }}' method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="add the name of the user" value="{{ $user->name }}">
                    </div>
                    <div class="form-group mt-4">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Users's email here"  value="{{ $user->email }}">
                    </div>
                    <div class="form-group mt-4">
                        <label for="old_password">Old Password</label>
                        <input id="old_password" name="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror"  placeholder="User's old password here" name="oldPassword" required autocomplete="new-password">
                    </div>
                    <div class="form-group mt-4">
                        <label for="password">New Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"  placeholder="Users's password here" name="password" required autocomplete="new-password">
                    </div>
                    <div class="form-group mt-4">
                        <label for="password-confirm">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control" placeholder="confirm password" name="password_confirmation" required autocomplete="new-password">
                    </div>
                    <div class="form-group mt-4">
                        <label class="form-label" for="image">Upload image</label>
                        <input type="file" name="image" class="form-control" id="image" />
                    </div>
                    <div class="form-group mt-4">
                        <label for="role_id">Role</label>
                        <select name="role_id" id="role_id" class="form-control">
                            <option selected value="{{$userRoleId}}">{{ $user->getRoleNames()->get('0') }}</option>
                            @foreach ( $roles as $role )
                                @if ($role->id != $userRoleId)
                                    <option value="{{$role->id}}">{{ $role->name }}</option>
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
