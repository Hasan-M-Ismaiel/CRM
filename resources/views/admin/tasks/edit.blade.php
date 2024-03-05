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
                        <p id="pcreateProject">change some essential information about this task</p>
                        <form action='{{ route("admin.tasks.update", $task) }}' method="POST">
                            @csrf
                            @method('PATCH')
                            <!--task title | task description-->
                            <div class="form-card border rounded pb-2 mt-3 border border-success">
                                <!--small note | Alter basic Task Information:-->
                                <div class="border px-2 pb-2 pt-3 rounded" style="background-color: #b9c9e5; background-image: linear-gradient(to bottom right, #b9c9e5, #e4eaf5);">
                                        <h2 class="fs-title">Alter basic Task Information:</h2>
                                </div>
                                <!-- task title-->
                                <div class="form-group mt-3 mx-3">
                                    <label for="title"><strong>Title</strong></label>
                                    <input type="text" name="title" class="form-control" id="title" placeholder="add the title of the task" value="{{ $task->title }}">
                                </div>
                                <!-- task description-->
                                <div class="form-group mt-4 mx-3">
                                    <label for="description"><strong>Description</strong></label>
                                    <textarea rows="5" cols="50" name="description" class="form-control" id="description" placeholder="task's description here" >{{ $task->description }}</textarea>
                                </div>
                                <!-- task deadline-->
                                <div class="form-group mt-4 mx-3">
                                    <label for="deadline"><strong>Deadline</strong></label>
                                    <input type="date" name="deadline" class="form-control" id="deadline" placeholder="task's deadline here" value="{{ $task->deadline }}" />
                                </div>
                            </div>
                            <!--appear only for the admin-->
                            @if(auth()->user()->hasRole('admin'))
                            <!--change project-->
                            <div class="form-card border rounded pb-2 mt-3 border border-success">
                                <div class="border px-2 pb-2 pt-3 rounded" style="background-color: #b9c9e5; background-image: linear-gradient(to bottom right, #b9c9e5, #e4eaf5);">
                                    <h2 class="fs-title">Select a Project</h2>
                                </div>
                                <div class="form-group mt-4 mx-3">
                                    <label for="project_id "><strong>Project</strong></label>
                                    <select name="project_id" id="project_id" class="form-control">
                                        <option selected value="{{$task->project->id}}">{{ $task->project->title }}</option>
                                        @foreach ( $projects as $project )
                                            @if ($project->title != $task->project->title)
                                                <option value="{{$project->id}}">{{ $project->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                            <!--choose user-->
                            <div class="form-card border rounded pb-2 mt-3 border border-success">
                                <div class="border px-2 pb-2 pt-3 rounded" style="background-color: #b9c9e5; background-image: linear-gradient(to bottom right, #b9c9e5, #e4eaf5);">
                                    <h2 class="fs-title">Choose User</h2>
                                </div>
                                <!--here is the generated content will be-->
                                <div class="form-group mt-4 mx-3" id="users">
                                    <div id="content-user" class="mt-3">
                                        <div>
                                            <strong>Select user:</strong>
                                        </div>
                                        @if ($taskproject->users()->count()>0)
                                        <div class="row text-center">
                                            @foreach ($taskproject->users as $user)
                                                <div class="col-md-6">
                                                    <div class="avatar avatar-md mt-2">
                                                        <label class="labelexpanded_">
                                                            <input type="radio" class="m-1" id="{{$user->id }}" name="user_id" value="{{ $user->id }}" @if($task->user->id==$user->id) checked @endif>
                                                                <div class="radio-btns_ rounded-circle border-1">
                                                                    @if($user->profile && $user->profile->getFirstMediaUrl("profiles"))
                                                                    <img src='{{$user->profile->getFirstMediaUrl("profiles")}}' alt="DP"  class="avatar-img  shadow">
                                                                    @elseif($user->getFirstMediaUrl("users"))
                                                                    <img src='{{$user->getMedia("users")[0]->getUrl("thumb")}}' alt="DP"  class="avatar-img  shadow">
                                                                    @else
                                                                    <img src='{{asset("images/avatar.png")}}' alt="DP"  class="avatar-img  shadow ">
                                                                    @endif
                                                                </div>
                                                            </input>
                                                        </label>
                                                    </div>
                                                    <label for="user_id" class="ms-2">{{ $user->name }}</label><br>
                                                </div>
                                                @if ($loop->iteration % 2 == 0)
                                                </div>
                                                <div class="row text-center">
                                                @endif
                                            @endforeach
                                        </div>
                                        @else 
                                            <a href="{{ route('admin.projects.assignCreate', $task->project->id) }}">assign</a> users to the project first
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!--task status-->
                            <div class="leftsided__">
                                <label  class="labelexpandedd__">
                                    <input type="radio" id="pending" name="status" value="pending" @if($task->status=="pending") checked @endif>   <!--pending-->
                                        <div class="radio-btnsd__">
                                            <span id="spot_light">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#FFEA4A" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                    <circle cx="8" cy="8" r="8"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </input>
                                </label>
                                <label  class="labelexpandedd__">
                                    <input type="radio" id="opened" name="status" value="opened" @if($task->status=="opened") checked @endif>   <!--opened-->
                                        <div class="radio-btnsd__">
                                            <span id="spot_light">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#3cf10e" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                    <circle cx="8" cy="8" r="8"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </input>
                                </label>
                                <label  class="labelexpandedd__">
                                    <input type="radio" id="closed" name="status" value="closed"@if($task->status=="closed") checked @endif>            <!--close-->
                                        <div class="radio-btnsd__">
                                            <span id="spot_light">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fe0131" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                                    <circle cx="8" cy="8" r="8"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </input>
                                </label>
                            </div>
                            <!--task update button-->
                            <x-forms.update-button />
                        </form>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>

<!--checked boxes-->
<style>
    .leftsided__{
        margin-left: 50px;
        margin-top: 50px;
    }

    .labelexpandedd__ {
        font-size: 12px;
    }

    .labelexpandedd__ > input{
        display: none;
    }

    .labelexpandedd__ input:checked + .radio-btnsd__ {
        background-color: #253c6a;
        color: #fff;
    }


    .radio-btnsd__ {
        width: 57px;
        height: 59px;
        border-radius: 15px;
        position: relative;
        text-align: center;
        padding: 15px 20px;
        box-shadow: 0 1px #c3c3c3;
        cursor: pointer;
        background-color: #eaeaea;
        float: left;
        margin-right: 15px;
    }

    .radio-btnsd__ > input {
        width: 28px;
        height: 30px;
    }
</style>

<!--radio-->
<style>
    .labelexpanded_ > input {
        display: none;
    }

    .labelexpanded_ input:checked + .radio-btns_ {
        border-style: solid;
        border-color: #50ef44;
    }

    .radio-btns_ {
        cursor: pointer;
        background-color: #eaeaea;
    }
</style>

<!--ajax change users according to project -->
<script>
    $('#project_id').on('change', function(){  

        $('#loading').show();     
        // to clear the list if the user change the selected option again 
        $('#users').empty();     
        $.ajax({
            url: "{{ route('admin.getUsers') }}",
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                id: $(this).val(),
            },
            success: function(result){
	            $('#users').append(result); 
                $('#loading').hide();     
            }
        });
    });
</script>
@endsection
