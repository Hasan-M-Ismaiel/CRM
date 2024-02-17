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
                <form action='{{ route("admin.taskGroups.store",["project"=>$project]) }}' method="POST">
                    @csrf
                    <div class="bodyflex">
                        <div style="width:100%;">
                            <div class=" text-secondary mt-4 row">
                                <p class="text-center">please add value to all added inputes</p>
                            </div>
                            <div class="">
                                <div class="col-lg-12">
                                    <div id="row">
                                        <div class="mb-3">
                                            <!--remove button-->
                                            <div class="card p-4">
                                                <div class="text-right">
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                            <circle cx="8" cy="8" r="8"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                                <!--input button-->
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="texts" name="titles[]" class="form-control" id="title" placeholder="add the title of the task" value="{{ old('title') }}">
                                                </div>
                                                <!--input button-->
                                                <div class="form-group mt-4">
                                                    <label for="description">description</label>
                                                    <input type="textarea" name="descriptions[]" class="form-control" id="description" placeholder="task's description here"  value="{{ old('description') }}">
                                                </div>
                                                <!--input button-->
                                                <div class="form-group mt-4">
                                                    <label for="user_id">Users</label>
                                                    <select name="user_ids[]" id="project_id" class="form-control">
                                                        <option value="" selected>Choose User ...</option>
                                                        @foreach ( $users as $user )
                                                            <option value="{{$user->id}}" >{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <!--input button-->
                                                <div class="mt-3">
                                                    <div class="row">
                                                    <div class="col-4 text-center">
                                                        <div class="input-group-prepend">
                                                            <button class="btn btn-danger"
                                                                    id="DeleteRow"
                                                                    type="button">
                                                                <i class="bi bi-trash"></i>
                                                                Delete
                                                            </button>
                                                        </div>
                                                    </div>
                                                        <!-- <div class="col-4 text-center">
                                                            <input type="radio" id="opened" name="status-1[]" value="opened" checked>           
                                                        </div>
                                                        <div class="col-4 text-center">
                                                            <input type="radio" id="pending" name="status-1[]" value="pending">                
                                                        </div>
                                                        <div class="col-4 text-center">
                                                            <input type="radio" id="closed" name="status-1[]" value="closed">            
                                                        </div> -->
                                                    </div>
                                                    <div class="row mt-1">
                                                        <!-- <div class="col-4 text-center">
                                                            <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8"/>
                                                                </svg>
                                                            </span>
                                                        </div> -->
                                                        <!-- <div class="col-4 text-center">
                                                            <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#f7dc08" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8"/>
                                                                </svg>
                                                            </span>
                                                        </div> -->
                                                        <!-- <div class="col-4 text-center">
                                                            <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fb043c" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                                    <circle cx="8" cy="8" r="8"/>
                                                                </svg>
                                                            </span>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </div>
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
                    <div>
                        <button type="submit" class="action-create-button">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    counter = 2;
    $("#rowAdder").click(function () {
        newRowAdd =
            '<div id="row">' +
                '<div class="mb-3">' +
                    '<div class="input-group-prepend">' +
                        '<button class="btn btn-danger" id="DeleteRow" type="button">' +
                            '<i class="bi bi-trash"></i> Delete' + 
                        '</button>'+
                    '</div>'+
                    '<div class="card p-4">'
                        +'<div class="form-group">'
                            +'<label for="title">Title</label>'
                            +'<input type="texts" name="titles[]" class="form-control" id="title" placeholder="add the title of the task">'
                        +'</div>'
                        +'<div class="form-group mt-4">'
                            +'<label for="description">description</label>'
                            +'<input type="textarea" name="descriptions[]" class="form-control" id="description" placeholder="tasks description here">'
                        +'</div>'
                        +'<div class="form-group mt-4">'
                            +'<label for="user_id">Users</label>'
                            +'<select name="user_ids[]" id="project_id" class="form-control">'
                                +'<option value="" selected>Choose User ...</option>'
                                +'@foreach ( $users as $user )'
                                    +'<option value="{{$user->id}}" >{{ $user->name }}</option>'
                                +'@endforeach'
                            +'</select>'
                        +'</div>'
                        +'<div class="mt-3">'
                            +'<div class="row">'
                                +'<div class="col-4 text-center">'
                                    +'<input type="radio" id="opened" name="status-'+counter+'[]" value="opened" checked>'
                                +'</div>'
                                +'<div class="col-4 text-center">'
                                    +'<input type="radio" id="pending" name="status-'+counter+'[]" value="pending">'
                                +'</div>'
                                +'<div class="col-4 text-center">'
                                    +'<input type="radio" id="closed" name="status-'+counter+'[]" value="closed">'
                                +'</div>'
                            +'</div>'
                            +'<div class="row mt-1">'
                                +'<div class="col-4 text-center">'
                                    +'<span>'
                                        +'<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">'
                                            +'<circle cx="8" cy="8" r="8"/>'
                                        +'</svg>'
                                    +'</span>'
                                +'</div>'
                                +'<div class="col-4 text-center">'
                                    +'<span>'
                                        +'<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#f7dc08" class="bi bi-circle-fill" viewBox="0 0 16 16">'
                                            +'<circle cx="8" cy="8" r="8"/>'
                                        +'</svg>'
                                    +'</span>'
                                +'</div>'
                                +'<div class="col-4 text-center">'
                                    +'<span>'
                                        +'<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fb043c" class="bi bi-circle-fill" viewBox="0 0 16 16">'
                                            +'<circle cx="8" cy="8" r="8"/>'
                                        +'</svg>'
                                    +'</span>'
                                +'</div>'
                            +'</div>'
                        +'</div>' 
                    +'</div>'
                +'</div>'
            +'</div>';
        counter = counter + 1;
        $('#newinput').append(newRowAdd);
    });
    $(".bodyflex").on("click", "#DeleteRow", function () {
        $(this).parents("#row").remove();
    })
</script>
@endsection


