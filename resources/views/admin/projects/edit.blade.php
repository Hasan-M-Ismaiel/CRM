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
                            @if(auth()->user()->hasRole('admin'))
                            <!--project information-->
                            <fieldset class="mt-5">
                                <div class="form-card border px-3  pb-3 border-success rounded">
                                    <div class="row px-2 pb-2 pt-3 rounded" >
                                        <div class="col-7">
                                            <h2 class="fs-title">Project Information:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 1 - 6</h2>
                                        </div>
                                    </div>
                                    <label class="fieldlabels mt-3" for="title">Title:</label>
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
                            @endif
                            <!--skills-->
                            <fieldset class="mt-5">
                                <div class="form-card border px-3  pb-3 border-success rounded">
                                    <div class="row px-2 pb-2 pt-3 rounded">
                                        <div class="col-7">
                                            <h2 class="fs-title">Alter required Skills:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 2 - 6</h2>
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
                                                                    <button id="rowAdder" type="button" class="btn btn-dark" data-bs-toggle="tooltip" data-bs-placement="top" title="add more skills">
                                                                        <span class="bi bi-plus-square-dotted">
                                                                        </span>
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
                            <!--get users button-->
                            <button type="button" id="getUsers" class="btn btn-primary">Press To get Users</button>
                            <!--users-->
                            <fieldset class="mt-5">
                                <div class="form-card border px-3  pb-3 border-success rounded">
                                    <div class="row px-2 pb-2 pt-3 rounded">
                                        <div class="col-7">
                                            <h2 class="fs-title">Alter Users:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 3 - 6</h2>
                                        </div>
                                    </div>
                                    <div id="usersTable" class="mt-4">
                                        <table class="table table-striped mt-2">
                                            <thead>
                                                <tr>
                                                    <th scope="col" id="pcreateProject">#</th>
                                                    <th scope="col" id="pcreateProject">Select</th>
                                                    <th scope="col" id="pcreateProject">Name</th>
                                                    <th scope="col" id="pcreateProject">Skills</th>
                                                    <th scope="col" id="pcreateProject">Profile</th>
                                                    <th scope="col" id="pcreateProject">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                    <tr style="height: 60px;">
                                                        <th scope="row" class="align-middle">{{ $loop->iteration }}</th>

                                                        @if($project != null)
                                                        <td style="text-align: center; vertical-align: middle;">
                                                            <div class="avatar avatar-md mt-2">
                                                                <label class="labelexpanded_">
                                                                    <input type="checkbox" class="m-1" id="user-{{$user->id}}" name="assigned_users[]" value="{{$user->id}}"  {{ $user->checkifAssignedToProject($project) ? '' : 'checked' }}>
                                                                        <div class="checkbox-btns_ rounded-circle border-1">
                                                                            @if($user->profile && $user->profile->getFirstMediaUrl("profiles"))
                                                                            <img src='{{$user->profile->getFirstMediaUrl("profiles")}}' alt="DP"  class="avatar-img  shadow">
                                                                            @elseif($user->getFirstMediaUrl("users"))
                                                                            <img src='{{$user->getMedia("users")[0]->getUrl("thumb")}}' alt="DP"  class="avatar-img  shadow">
                                                                            @else
                                                                            <img src='{{asset("images/avatar.png")}}' alt="DP"  class="avatar-img  shadow">
                                                                            @endif
                                                                        </div>
                                                                    </input>
                                                                </label>
                                                            </div>
                                                        </td>
                                                        @else   
                                                        <td style="text-align: center; vertical-align: middle;">
                                                            <div class="avatar avatar-md mt-2">
                                                                <label class="labelexpanded_">
                                                                    <input type="checkbox" class="m-1" id="user-{{$user->id}}" name="assigned_users[]" value="{{$user->id}}">
                                                                        <div class="checkbox-btns_ rounded-circle border-1">
                                                                            @if($user->profile && $user->profile->getFirstMediaUrl("profiles"))
                                                                            <img src='{{$user->profile->getFirstMediaUrl("profiles")}}' alt="DP"  class="avatar-img  shadow">
                                                                            @elseif($user->getFirstMediaUrl("users"))
                                                                            <img src='{{$user->getMedia("users")[0]->getUrl("thumb")}}' alt="DP"  class="avatar-img  shadow">
                                                                            @else
                                                                            <img src='{{asset("images/avatar.png")}}' alt="DP"  class="avatar-img  shadow">
                                                                            @endif
                                                                        </div>
                                                                    </input>
                                                                </label>
                                                            </div>
                                                        </td>
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
                                </div>
                            </fieldset>
                            @if(auth()->user()->hasRole('admin'))
                            <!--teamleader-->
                            <fieldset class="mt-5">
                                <div class="form-card border px-3  pb-3 border-success rounded">
                                    <div class="row px-2 pb-2 pt-3 rounded">
                                        <div class="col-7">
                                            <h2 class="fs-title">Alter the teamleader:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 4 - 6</h2>
                                        </div>
                                    </div>
                                    <div id="teamleaderTable" class="mt-4">
                                        <table class="table table-striped mt-2">
                                            <thead>
                                                <tr>
                                                    <th scope="col" id="pcreateProject">#</th>
                                                    <th scope="col" id="pcreateProject">Select</th>
                                                    <th scope="col" id="pcreateProject">Name</th>
                                                    <th scope="col" id="pcreateProject">Skills</th>
                                                    <th scope="col" id="pcreateProject">Profile</th>
                                                    <th scope="col" id="pcreateProject">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $user)
                                                    <tr style="height: 60px;">
                                                        <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
                                                        <td style="text-align: center; vertical-align: middle;">
                                                            <div class="avatar avatar-md mt-2">
                                                                <label class="labelexpanded_teamleader">
                                                                    @if($user->id==$project->teamleader->id)
                                                                    <input type="radio" class="m-1" id="{{$user->id}}" name="teamleader_id" value="{{$user->id}}" checked>
                                                                    @else
                                                                    <input type="radio" class="m-1" id="{{$user->id}}" name="teamleader_id" value="{{$user->id}}">
                                                                    @endif
                                                                        <div class="radio-btns_teamleader rounded-circle border-1">
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
                                                        </td>
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
                                </div>
                                <div class=" card border border-success rounded mt-3 p-4">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Alter the Name for the Team:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 5 - 6 | optional</h2>
                                        </div>
                                    </div>
                                    <!-- <x-users-matched-table :users="$users"  /> -->
                                    <div>
                                        <div class="form-group mt-5">
                                            <label for="teamname"><strong>Team Name</strong></label>
                                            <input type="text" name="teamname" class="form-control" id="teamname" placeholder="add the name for the team" value="{{$project->team->name}}">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <!--update status and click submit button-->
                            <fieldset class="mt-5">
                                <div class="form-card border px-3  pb-5 border-success rounded">
                                    <div class="row px-2 pb-3 pt-3 rounded"  >
                                        <div class="col-7">
                                            <h2 class="fs-title">Alter project status:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 6 - 6</h2>
                                        </div>
                                    </div>
                                    <!--radio button [project status]-->
                                    <div class="mt-5 mb-5">
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
                            </fieldset>
                            @endif
                            <button id="updateproject" type="submit" class="action-create-button" onclick="showSpinner()">
                                <span id="spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none;"></span>
                                Update
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--this is for the teamleader [redio button]-->
<style>
    .labelexpanded_teamleader > input {
        display: none;
    }

    .labelexpanded_teamleader input:checked + .radio-btns_teamleader {
        border-style: solid;
        border-color: #50ef44;
    }

    .radio-btns_teamleader {
        cursor: pointer;
        background-color: #eaeaea;
    }
</style>

<!--Modal: modalPush-->
<div class="modal fade" id="modalPush" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" style="display: none;">
  <div class="modal-dialog modal-notify modal-info" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center bg-danger">
        <p class="heading text-white">Alert !</p>
      </div>

      <!--Body-->
      <div class="modal-body">

        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-bell-fill text-danger" viewBox="0 0 16 16">
            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901"/>
        </svg>
        <!-- <i class="bi bi-bell bi-4x animated rotateIn mb-4"></i> -->

        <p>You are trying to unassign users from this project by altering the skills:</p>
        <p><strong>affected users: </strong></p>
        <p id="affectedUsers"></p>
      </div>
    </div>
  </div>
</div>

<!--this is for the checkbox image-->
<style>
    .labelexpanded_ > input {
        display: none;
    }

    .labelexpanded_ input:checked + .checkbox-btns_ {
        border-style: solid;
        border-color: #50ef44;
    }

    .checkbox-btns_ {
        cursor: pointer;
        background-color: #eaeaea;
    }
</style>

<!--Modal: modalPush-->
<script type="text/javascript">
    $("#rowAdder").click(function () {
        newRowAdd =
            '<div id="row" class="row"> <div class="col-md-2">' +
            '<div class="input-group-prepend pt-1">' +
            '<button class="btn btn-danger mt-1 text-center" id="DeleteRow" type="button">' +
            '<i class="bi bi-trash"></i>'+ 
            '</button></div></div>' +
            '<div class="col-md-10"><input name="new_skills[]" type="text" class="form-control m-input new_skills rounded"> </div> </div>';

        $('#newinput').append(newRowAdd);
    });
    $(".bodyflex").on("click", "#DeleteRow", function () {
        $(this).parents("#row").remove();
    })
</script>

<!--get users-->
<script>
    $('#getUsers').on('click', function(){  
        var assigned_skills = [];
        var new_skills = [];
        var teamleader_id = $('#teamleader_id').val();
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
        $('#teamleaderTable').empty();     
        $('#loading').show();     
        $.ajax({
            url: "{{ route('admin.skills.getUsersWithSkills') }}",
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                assigned_skills: assigned_skills,
                new_skills: new_skills,
                from: "edit",
                project_id:'{{$project->id}}',
                teamleader_id:teamleader_id,
            },
            success: function(output){
                var result = $.parseJSON(output);
                if(result[0] =='affected'){
                    $('#usersTable').append(result[2]);
                    $('#teamleaderTable').append(result[3]);
                    $('#affectedUsers').empty();        //clear the old data
                    $('#affectedUsers').append(result[1]);
                    $('#updateproject').prop('disabled', false);
                    $('#loading').hide();     
                    $('#modalPush').modal('show'); 
                }else if(result[0] == 'notAffected'){
                    $('#usersTable').append(result[2]);  
                    $('#teamleaderTable').append(result[3]);
                    $('#updateproject').prop('disabled', false);
                    $('#loading').hide();     
                }else if(result[0]=='FieldsEmpty'){
                    $('#usersTable').append(result[1]);
                    $('#updateproject').prop('disabled', false);
                    $('#loading').hide();     
                }else if(result[0]=='newSkillsEmptyFields'){
                    $('#usersTable').append(result[1]);
                    $('#updateproject').prop('disabled', true);
                    $('#loading').hide();     
                }
            }
        });
    });
</script>

<!--show spinner-->
<script>
    function showSpinner(){
        $('#spinner').show();
        $('#updateproject').text('updating...');
    }
</script>

@endsection
