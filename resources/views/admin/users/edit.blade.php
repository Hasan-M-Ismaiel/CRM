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
                        <p id="pcreateProject">change some essential information but let the user know</p>
                        <form action='{{ route("admin.users.update", $user) }}' method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="form-card border border-success rounded pb-2 mt-3">
                                <div class="border m-0 pb-2 pt-3 rounded" style="background-color: #b9c9e5; background-image: linear-gradient(to bottom right, #b9c9e5, #e4eaf5);">
                                    <div class="col-7">
                                        <h2 class="fs-title">Alter basic User Information:</h2>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <div class="form-group mt-3">
                                        <label for="name"><strong>Name</strong></label>
                                        <input type="text" name="name" class="form-control" id="name" placeholder="add the name of the user" value="{{ $user->name }}">
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="email"><strong>Email</strong></label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Users's email here"  value="{{ $user->email }}">
                                    </div>
                                    <div>
                                        <button id="passwordAdder" type="button" class="btn btn-dark">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1"/>
                                            </svg> change password
                                        </button>
                                    </div>
                                    <div id="change_password" >
                                        <!-- <div class="form-group mt-4">
                                            <label for="old_password"><strong>Old Password</strong></label>
                                            <input id="old_password" name="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror"  placeholder="User's old password here" name="oldPassword"  autocomplete="new-password">
                                        </div>
                                        <div class="form-group mt-4">
                                            <label for="password"><strong>New Password</strong></label>
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"  placeholder="Users's password here" name="password" autocomplete="new-password">
                                        </div>
                                        <div class="form-group mt-4">
                                            <label for="password-confirm"><strong>Confirm Password</strong></label>
                                            <input id="password-confirm" type="password" class="form-control" placeholder="confirm password" name="password_confirmation" autocomplete="new-password">
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                            <div class="form-card border border-success rounded pb-2 mt-3">
                                <div class="border m-0 pb-2 pt-3 rounded" style="background-color: #b9c9e5; background-image: linear-gradient(to bottom right, #b9c9e5, #e4eaf5);">
                                    <div class="col-7">
                                        <h2 class="fs-title">Alter user Image:</h2>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <div class="form-group mt-4">
                                        <label class="form-label" for="image">Upload image</label>
                                        <input type="file" name="image" class="form-control" id="image" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-card border border-success rounded pb-2 mt-3">
                                <div class="border m-0 pb-2 pt-3 rounded" style="background-color: #b9c9e5; background-image: linear-gradient(to bottom right, #b9c9e5, #e4eaf5);">
                                    <div class="col-7">
                                        <h2 class="fs-title">Alter user Role:</h2>
                                    </div>
                                </div>
                                <div class="p-5">
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
                                </div>
                            </div>
                            <div class="form-card border border-success rounded pb-2 mt-3">
                                <div class="border m-0 pb-2 pt-3 rounded" style="background-color: #b9c9e5; background-image: linear-gradient(to bottom right, #b9c9e5, #e4eaf5);">
                                    <div class="col-7">
                                        <h2 class="fs-title">Alter required Skills:</h2>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <div class="row mt-4">
                                        @foreach($skills as $skill)
                                            <div class="col-md-4">
                                                <input type="checkbox" id="skill-{{$skill->id}}" name="assigned_skills[]" value="{{$skill->id}}" {{ $skill->checkifAssignedToUser($user) ? 'checked' : '' }}>
                                                <label for="skill-{{$skill->id}}"><a href="{{ route('admin.skills.show', $skill->id) }}" style="text-decoration: none;" >{{ $skill->name }} </a></label>
                                            </div>
                                            @if ($loop->iteration % 3 == 0)
                                                </div>
                                                <div class="row">
                                            @endif
                                        @endforeach
                                    </div>
                                    <div class="form-group mt-4">
                                        <div class="bodyflex">
                                            <div style="width:100%;">
                                                <div class="form-group mt-4">
                                                    <div class="bodyflex">
                                                        <div style="width:100%;">
                                                            <div class="border pe-5">
                                                                <p id="pcreateProject" class="mt-4 ms-5 ">add more skills to the database, 
                                                                    <span>
                                                                        <svg width="25" height="25">
                                                                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-warning') }}"></use>
                                                                        </svg>
                                                                    </span>please add value to all added inputes</p>
                                                                <div class="col-lg-12 p-4">
                                                                    
                                                                    <div id="newinput"></div>   <!--the added one-->
                                                                    <button id="rowAdder" type="button" class="btn btn-dark">
                                                                        <span class="bi bi-plus-square-dotted">
                                                                        </span> ADD
                                                                    </button>
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
                            <x-forms.update-button />
                        </form>
                    </div>
                </div> 
            </div>
        </div>

<!--for adding skills-->
<script type="text/javascript">
    $("#rowAdder").click(function () {
        newRowAdd =
            '<div id="row"> <div class="input-group m-3">' +
            '<div class="input-group-prepend">' +
            '<button class="btn btn-danger" id="DeleteRow" type="button">' +
            '<i class="bi bi-trash"></i> Delete</button> </div>' +
            '<input name="new_skills[]" type="text" class="form-control m-input"> </div> </div>';

        $('#newinput').append(newRowAdd);
    });
    $(".bodyflex").on("click", "#DeleteRow", function () {
        $(this).parents("#row").remove();
    })
</script>

<!--for the changing password-->
<script type="text/javascript">
    $("#passwordAdder").click(function () {
        passwordAdder =
            '<div class="form-group mt-4">' +
                '<label for="old_password"><strong>Old Password</strong></label>' +
                '<input id="old_password" name="old_password" type="password" class="form-control"  placeholder="User\'s old password here" name="oldPassword" required autocomplete="new-password">' +
            '</div>' +
            '<div class="form-group mt-4">' +
                '<label for="password"><strong>New Password</strong></label>'+
                '<input id="password" type="password" class="form-control"  placeholder="Users\'s password here" name="password" required autocomplete="password">'+
            '</div>' +
            '<div class="form-group mt-4">' +
                '<label for="password-confirm"><strong>Confirm Password</strong></label>' +
                '<input id="password-confirm" type="password" class="form-control" placeholder="confirm password" name="password_confirmation" required autocomplete="new-password">' +
            '</div>';

        $('#change_password').append(passwordAdder);
        $('#passwordAdder').addClass('disabled');
    });
</script>

@endsection
