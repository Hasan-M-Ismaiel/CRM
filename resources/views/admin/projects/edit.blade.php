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
                        <p id="pcreateProject">Fill all form field to update the project correctly</p>
                        <form id="msformEdit" action='{{ route("admin.projects.update", $project) }}' method="POST">
                            @csrf
                            @method('PATCH')
                            <!--project information-->
                            <fieldset class="mt-5">
                                <div class="form-card border px-2 pb-2">
                                    <div class="row border px-3 pb-2 pt-3 rounded" style="background-color: #b9c9e5; background-image: linear-gradient(to bottom right, #b9c9e5, #e4eaf5);">
                                        <div class="col-7">
                                            <h2 class="fs-title">Project Information:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 1 - 4</h2>
                                        </div>
                                    </div>
                                    <label class="fieldlabels mt-2" for="title">Title:</label>
                                    <input id="title" type="text" name="title" placeholder="add the title of the project" value="{{ $project->title }}"/>
                                    
                                    <label class="fieldlabels" for="description">Description:</label>
                                    <input type="textarea" name="description" id="description" placeholder="Project's description here"  value="{{ $project->description }}"/>
                                    
                                    <label class="fieldlabels" for="deadline">Deadline:</label>
                                    <input id="deadline" type="date" placeholder="Project's deadline here" name="deadline" value="{{ $project->deadline }}" />
                                    
                                    <label class="fieldlabels" for="client_id">Client:</label>
                                    <select name="client_id" id="client_id" class="form-control">
                                        <option selected value="{{$project->client->id}}">{{ $project->client->name }}</option>
                                        @foreach ( $clients as $client )
                                            @if ($client->name != $project->client->name)
                                                <option value="{{$client->id}}" >{{ $client->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </fieldset>
                            <!--skills-->
                            <fieldset class="mt-5">
                                <div class="form-card border px-2 pb-2">
                                    <div class="row border px-3 pb-2 pt-3 rounded" style="background-color: #b9c9e5; background-image: linear-gradient(to bottom right, #b9c9e5, #e4eaf5);">
                                        <div class="col-7">
                                            <h2 class="fs-title">Alter required Skills:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 2 - 4</h2>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        @foreach($skills as $skill)
                                            <div class="col-md-4 text-center" >
                                                <div class="row">
                                                    <div class="col-3"> 
                                                        <input class="d-flex justify-content-end assigned_skills" type="checkbox" id="skill-{{$skill->id}}" name="assigned_skills[]" value="{{$skill->id}}" {{ $skill->checkifAssignedToProject($project) ? 'checked' : ''}}>
                                                    </div>
                                                    <div class="col-9">
                                                        <label class="d-flex justify-content-start" for="skill-{{$skill->id}}"><a href="{{ route('admin.skills.show', $skill->id) }}" style="text-decoration: none;" >{{ $skill->name }} </a></label>
                                                    </div>
                                                </div>
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
                                                                    <!-- <div id="row" class="row">
                                                                        <div class="col-md-2">
                                                                            <div class="input-group-prepend pt-1">
                                                                                <button class="btn btn-danger"
                                                                                        id="DeleteRow"
                                                                                        type="button">
                                                                                    <i class="bi bi-trash"></i>
                                                                                    Delete
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <input name="new_skills[]" type="text" class="form-control m-input new_skills"> 
                                                                        </div>
                                                                    </div> -->
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
                            </fieldset>
                            <button type="button" id="getUsers" class="btn btn-primary">Press To get Users</button>
                            <fieldset class="mt-5">
                                <div class="form-card border px-2 pb-2">
                                    <div class="row border px-3 pb-2 pt-3 rounded" style="background-color: #b9c9e5; background-image: linear-gradient(to bottom right, #b9c9e5, #e4eaf5);">
                                        <div class="col-7">
                                            <h2 class="fs-title">Alter Users:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 3 - 5</h2>
                                        </div>
                                    </div>
                                    <div id="usersTable" class="mt-4">
                                        <table class="table table-striped mt-2">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Select</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Skills</th>
                                                    <th scope="col">Profile</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                    <tr style="height: 60px;">
                                                        <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
                                                        @if($project != null)
                                                        <td style="text-align: center; vertical-align: middle;"><input type="checkbox" id="user-{{$user->id}}" name="assigned_users[]" value="{{$user->id}}" {{ $user->checkifAssignedToProject($project) ? '' : 'checked' }}></td>
                                                        @else 
                                                        <td style="text-align: center; vertical-align: middle;"><input type="checkbox" id="user-{{$user->id}}" name="assigned_users[]" value="{{$user->id}}"></td>
                                                        @endif
                                                        <td class="align-middle"><a href="{{ route('admin.users.show', $user->id) }}" >{{ $user->name }} </a></td>
                                                        @if($user->skills->count() >0)
                                                        <td class="align-middle">
                                                            @foreach($user->skills as $skill)
                                                                <span class="badge bg-dark m-1">{{ $skill->name }}</span>
                                                            @endforeach
                                                        </td>
                                                        @else
                                                        <td class="align-middle"> # </td>
                                                        @endif
                                                        @if($user->profile != null)
                                                        <td class="align-middle"><a href="{{ route('admin.profiles.show', $user->id) }}" >{{ $user->profile->nickname }} </a></td>
                                                        @else
                                                        <td class="align-middle"> # </td>
                                                        @endif
                                                        <td class="align-middle"> open/close</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- <x-users-matched-table :users="$users" :project="$project"  /> -->
                                </div>
                            </fieldset>
                            <fieldset class="mt-5">
                                <div class="form-card border px-2 pb-5">
                                    <div class="row border px-3 pb-5 pt-3 rounded" style="background-color: #b9c9e5; background-image: linear-gradient(to bottom right, #b9c9e5, #e4eaf5);" >
                                        <div class="col-7">
                                            <h2 class="fs-title">Alter project status:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 5 - 5</h2>
                                        </div>
                                    </div>
                                    <div class="mt-5  mb-5">
                                    @if($project->status)
                                        <input type="radio" name="status" id="close" value="true" checked />
                                        <input type="radio" name="status" id="open" value="false"/>
                                        <div class="switch">
                                            <label for="close">close</label>
                                            <label for="open">open</label>
                                            <span></span>
                                        </div>
                                    @else
                                        <input type="radio" name="status" id="close" value="true" />
                                        <input type="radio" name="status" id="open"  value="false" checked/>
                                        <div class="switch">
                                            <label for="close">close</label>
                                            <label for="open">open</label>
                                            <span></span>
                                        </div>
                                    @endif
                                    </div>
                                </div>
                                <input type="submit" type="button" class="next action-button mt-5" />
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Modal: modalPush-->
<div class="modal fade" id="modalPush" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;">
  <div class="modal-dialog modal-notify modal-info" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center bg-danger">
        <p class="heading">Alert !</p>
      </div>

      <!--Body-->
      <div class="modal-body">

      <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-bell-fill text-danger" viewBox="0 0 16 16">
        <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901"/>
      </svg>
        <!-- <i class="bi bi-bell bi-4x animated rotateIn mb-4"></i> -->

        <p>You are trying to unassign users from this project by altering the skills:</p>
        <p>affected users: </p>
        <p id="affectedUsers"></p>

      </div>
    </div>
  </div>
</div>
<!--Modal: modalPush-->

<script type="text/javascript">
    $("#rowAdder").click(function () {
        newRowAdd =
            '<div id="row" class="row"> <div class="col-md-2">' +
            '<div class="input-group-prepend pt-1">' +
            '<button class="btn btn-danger" id="DeleteRow" type="button">' +
            '<i class="bi bi-trash"></i> Delete</button> </div></div>' +
            '<div class="col-md-10"><input name="new_skills[]" type="text" class="form-control m-input new_skills"> </div> </div>';

        $('#newinput').append(newRowAdd);
    });
    $(".bodyflex").on("click", "#DeleteRow", function () {
        $(this).parents("#row").remove();
    })
</script>
<script>
    $('#getUsers').on('click', function(){  
        var assigned_skills = [];
        var new_skills = [];
        var inputs1 = document.getElementsByClassName('assigned_skills'); // get all elements within this class 
        var inputs = document.getElementsByClassName('new_skills'); // get all elements within this class 

        //make array with the ids of the assigned skills
        for(var key in inputs1) {
            var value = inputs1[key].value;
            if(inputs1[key].checked)
                assigned_skills.push(value);
        }

        //make array with the names of the new skills
        for(var key in inputs) {
            var value = inputs[key].value;
            if(inputs[key].value)
                new_skills.push(value);
        }

        // to clear the list if the user change the selected option again 
        $('#usersTable').empty();     

        $.ajax({
            url: "{{ route('admin.skills.getUsersWithSkills') }}",
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                assigned_skills: assigned_skills,
                new_skills: new_skills,
                from: "edit",
                project_id:'{{$project->id}}',
            },
            success: function(output){
                var result = $.parseJSON(output);
                if(result[0] =='affected'){
                    $('#usersTable').append(result[2]);  
                    $('#affectedUsers').append(result[1]);
                    $('#modalPush').modal('show'); 
                    // alert(result[0]);
                }else if(result[0] == 'notAffected'){
                    $('#usersTable').append(result[2]);  
                }
                //  alert(result);
            }
        });
    });
</script>

@endsection
