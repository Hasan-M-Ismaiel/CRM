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
                <form action='{{ route("admin.users.store") }}' method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="add the name of the article" value="{{ old('name') }}">
                    </div>
                    <div class="form-group mt-4">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Users's email here"  value="{{ old('email') }}">
                    </div>
                    <div class="form-group mt-4">
                        <label for="password">Password</label>
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
                            <option value="" selected>Choose Role...</option>
                            @foreach ( $roles as $role )
                                <option value="{{$role->id}}" >{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <hr>
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
                        <strong> add more:</strong>
                        <div class="bodyflex">
                            <div style="width:50%;">
                                <div class="profile-edit-btn row">
                                    <p class="text-center">do not leave any input field empty</p>
                                </div>
                                <div class="">
                                    <div class="col-lg-12">
                                        <div id="row">
                                            <div class="input-group m-3">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-danger"
                                                            id="DeleteRow"
                                                            type="button">
                                                        <i class="bi bi-trash"></i>
                                                        Delete
                                                    </button>
                                                </div>
                                                <input name="new_skills[]" type="text" class="form-control m-input"> <!--the first one-->
                                            </div>
                                        </div>
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
                    <button type="submit" class="btn btn-primary mt-5">Create</button>
                </form>
            </div>
        </div> 
    </div>
</div>
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
@endsection
