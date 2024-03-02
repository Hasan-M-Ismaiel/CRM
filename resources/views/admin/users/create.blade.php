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
                        <p id="pcreateProject">if you have person in your company then create an account form him</p>
                        <form action='{{ route("admin.users.store") }}' method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-card border border-success rounded pb-2 mt-3">
                                <div class="border m-0 pb-2 pt-3 rounded" style="background-color: #b9c9e5; background-image: linear-gradient(to bottom right, #b9c9e5, #e4eaf5);">
                                    <div class="col-7">
                                        <h2 class="fs-title">Add basic User Information:</h2>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <div class="form-group mt-3">
                                        <label for="name"><strong>Name</strong></label>
                                        <input type="text" name="name" class="form-control" id="name" placeholder="add the name of the article" value="{{ old('name') }}">
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="email"><strong>Email</strong></label>
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Users's email here"  value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="password"><strong>Password</strong></label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"  placeholder="Users's password here" name="password" required autocomplete="new-password">
                                    </div>
                                    <div class="form-group mt-4">
                                        <label for="password-confirm"><strong>Confirm Password</strong></label>
                                        <input id="password-confirm" type="password" class="form-control" placeholder="confirm password" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>
                            </div>
                            <div class="form-card border border-success rounded pb-2 mt-3">
                                <div class=" border pb-2 pt-3 rounded" style="background-color: #b9c9e5; background-image: linear-gradient(to bottom right, #b9c9e5, #e4eaf5);">
                                    <div class="col-7">
                                        <h2 class="fs-title">Add Image to the User</h2>
                                    </div>
                                </div>
                                <div class="form-group p-5 mt-4">
                                    <label class="form-label" for="image"><strong>Upload image</strong></label>
                                    <input type="file" name="image" id="image" />
                                </div>
                            </div>
                            <div class="form-card border border-success rounded pb-2 mt-3">
                                <div class="border pb-2 pt-3 rounded" style="background-color: #b9c9e5; background-image: linear-gradient(to bottom right, #b9c9e5, #e4eaf5);">
                                    <div class="col-7">
                                        <h2 class="fs-title">Add Role to the User</h2>
                                    </div>
                                </div>
                                <div class="form-group mt-4 p-5">
                                    <label for="role_id"><strong>Role</strong></label>
                                    <select name="role_id" id="role_id" class="form-control">
                                        <option value="" selected>Choose Role...</option>
                                        @foreach ( $roles as $role )
                                            <option value="{{$role->id}}" >{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-card border border-success rounded pb-2 mt-3">
                                <div class="border pb-2 pt-3 rounded" style="background-color: #b9c9e5; background-image: linear-gradient(to bottom right, #b9c9e5, #e4eaf5);">
                                    <div class="col-7">
                                        <h2 class="fs-title">Add the skills that this user has</h2>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <div class="form-group mt-4">
                                        <strong> choose skills for this new user:</strong><span class="profile-edit-btn">optional</span>
                                        <div class="row mt-2">
                                            @foreach($skills as $skill)
                                                <div class="col-md-4">
                                                    <input type="checkbox" id="skill-{{$skill->id}}" name="assigned_skills[]" value="{{$skill->id}}">
                                                    <label for="skill-{{$skill->id}}"><a href="{{ route('admin.skills.show', $skill->id) }}" style="text-decoration: none;" >{{ $skill->name }} </a></label>
                                                </div>
                                                @if ($loop->iteration % 3 == 0)
                                                    </div>
                                                    <div class="row">
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group mt-4">
                                        <div class="bodyflex">
                                            <div style="width:100%;">
                                                <p id="pcreateProject" class="mt-4 ms-5 ">add more skills to the database, 
                                                    <span>
                                                        <svg width="25" height="25">
                                                            <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-warning') }}"></use>
                                                        </svg>
                                                    </span>please add value to all added inputes
                                                </p>
                                                <div class="col-lg-12">
                                                    <div id="newinput"></div>   <!--the added one-->
                                                    <button id="rowAdder" type="button" class="btn btn-dark mt-3">
                                                        <span class="bi bi-plus-square-dotted">
                                                        </span> ADD
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <x-forms.create-button />
                        </form>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>

<!--adder for new skills-->
<script type="text/javascript">
    $("#rowAdder").click(function () {
        newRowAdd =
            '<div id="row" class="row ">'+
            '<div class="col-md-2 ">' +
            '<div class="input-group-prepend  pb-1">' +
            '<button class="btn btn-danger" id="DeleteRow" type="button">' +
            '<i class="bi bi-trash"></i>'+
            'Delete</button> '+
            '</div></div>' +
            '<div class="col-md-10">'+
            '<input name="new_skills[]" type="text" class="form-control m-input new_skills">'+
            '</div> </div>';

        $('#newinput').append(newRowAdd);
    });
    $(".bodyflex").on("click", "#DeleteRow", function () {
        $(this).parents("#row").remove();
    })
</script>
@endsection
