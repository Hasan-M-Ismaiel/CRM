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
                        <p id="pcreateProject">Fill all form field to go to next step</p>
                        <form id="msform" action='{{ route("admin.projects.store") }}' method="POST">
                            @csrf
                            <!-- progressbar -->
                            <ul id="progressbar-create-project">
                                <li class="active li-create-project" id="account"><strong>Description</strong></li>
                                <li class="li-create-project" id="personal"><strong>Add Skills</strong></li>
                                <li class="li-create-project" id="payment"><strong>Add users</strong></li>
                                <li class="li-create-project" id="confirm"><strong>Finish</strong></li>
                            </ul>
                            <div class="progress-create-project">
                                <div class="progress-bar-create-project progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <br>
                            <!-- fieldsets -->
                            <!--stage one-->
                            <fieldset>
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Project Information:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 1 - 4</h2>
                                        </div>
                                    </div>
                                    <label class="fieldlabels" for="title">Title: *</label>
                                    <input id="title" type="text" name="title" placeholder="add the title of the project" value="{{ old('title') }}"/>

                                    <label class="fieldlabels" for="description">Description: *</label>
                                    <input type="textarea" name="description" id="description" placeholder="Project's description here"  value="{{ old('description') }}"/>

                                    <label class="fieldlabels" for="deadline">Deadline: *</label>
                                    <input id="deadline" type="date" placeholder="Project's deadline here" name="deadline"/>

                                    <label class="fieldlabels" for="client_id">Client: *</label>
                                    <select name="client_id" id="client_id" class="form-control">
                                        <option value="" selected>Choose Client ...</option>
                                        @foreach ( $clients as $client )
                                            <option value="{{$client->id}}" >{{ $client->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="button" name="next" class="next action-button" value="Next"/>
                            </fieldset>
                            <!--stage two-->
                            <fieldset>
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Add required Skills:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 2 - 4</h2>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @foreach($skills as $skill)
                                            <div class="col-md-4 text-center" >
                                                <div class="row">
                                                    <div class="col-3">
                                                        <input class="d-flex justify-content-end assigned_skills" type="checkbox" id="skill-{{$skill->id}}" name="assigned_skills[]" value="{{$skill->id}}">
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
                                                <div class="border pe-5">
                                                    <p id="pcreateProject" class="mt-4 ms-5 ">add more skills to the database, 
                                                        <span>
                                                            <svg width="25" height="25">
                                                                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-warning') }}"></use>
                                                            </svg>
                                                        </span>please add value to all added inputes
                                                    </p>
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
                                <input type="button" name="next" class="next action-button" value="Next" id="getUsers"/>
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                            </fieldset>
                            <!--stage three-->
                            <fieldset>
                                <div class="form-card">
                                    <div class="card border border-success rounded p-4">
                                        <!--add users-->
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Add User:</h2>
                                            </div>
                                            <div class="col-5">
                                                <h2 class="steps">Step 3 - 4</h2>
                                            </div>
                                        </div>
                                        <!-- <x-users-matched-table :users="$users"  /> -->
                                        <div id="usersTable">
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
                                                            <td style="text-align: center; vertical-align: middle;"><input type="checkbox" id="user-{{$user->id}}" name="assigned_users[]" value="{{$user->id}}"></td>
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
                                    <!--adding teamleader-->
                                    <div class=" card border border-success rounded mt-3 p-4">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Add TeamLeader:</h2>
                                            </div>
                                            <div class="col-5">
                                                <h2 class="steps">required</h2>
                                            </div>
                                        </div>
                                        <!-- <x-users-matched-table :users="$users"  /> -->
                                        <div id="teamleaderTable">
                                        </div>
                                    </div>
                                    <!--adding teamleader-->
                                    <div class=" card border border-success rounded mt-3 p-4">
                                        <div class="row">
                                            <div class="col-7">
                                                <h2 class="fs-title">Add Name for the Team:</h2>
                                            </div>
                                            <div class="col-5">
                                                <h2 class="steps">optional</h2>
                                            </div>
                                        </div>
                                        <!-- <x-users-matched-table :users="$users"  /> -->
                                        <div>
                                            <div class="form-group mt-3">
                                                <label for="teamname"><strong>Team Name</strong></label>
                                                <input type="text" name="teamname" class="form-control" id="teamname" placeholder="add the name for the team" value="{{ old('teamname') }}">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <input id="createproject" type="submit" type="button" class="next action-button" />
                                <!-- <button type="submit" class="btn btn-primary mt-5">Create</button> -->
                                <input type="button" name="previous" class="previous action-button-previous" value="Previous"/>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--this is for the users [checkbox button]-->
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


<script>
    $(document).ready(function(){
    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;

    setProgressBar(current);

    $(".next").click(function(){

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        //Add Class Active
        $("#progressbar-create-project .li-create-project").eq($("fieldset").index(next_fs)).addClass("active");

        //show the next fieldset
        next_fs.show();
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                next_fs.css({'opacity': opacity});
            },
            duration: 500
        });
        setProgressBar(++current);
    });

    $(".previous").click(function(){

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        //Remove class active
        $("#progressbar-create-project .li-create-project").eq($("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();

        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({'opacity': opacity});
            },
            duration: 500
        });
        setProgressBar(--current);
    });

    function setProgressBar(curStep){
        var percent = parseFloat(100 / steps) * curStep;
        percent = percent.toFixed();
        $(".progress-bar-create-project")
          .css("width",percent+"%")
    }

    $(".submit").click(function(){
        return false;
    })

    });
</script>

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
        var teamleader_id = $('#teamleader_id').val();
        var inputs1 = document.getElementsByClassName('assigned_skills'); // get all elements within this class
        var inputs = document.getElementsByClassName('new_skills'); // get all elements within this class

        for(var key in inputs1) {
            var value = inputs1[key].value;
            if(inputs1[key].checked)
                assigned_skills.push(value);
        }

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
                from: "create",
                teamleader_id:teamleader_id,
            },
            success: function(output){
                var result = $.parseJSON(output);
                if(result[0] =='noSkills'){
                    $('#usersTable').append(result[1]);
                    $('#createproject').prop('disabled', true);
                    $('#loading').hide();
                } else if(result[0]=='newSkillsEmptyFields')    {
                    $('#usersTable').append(result[1]);
                    $('#createproject').prop('disabled', true);
                    $('#loading').hide();
                } else if(result[0] == 'NoUsersFound'){
                    $('#usersTable').append(result[1]);
                    $('#createproject').prop('disabled', false);
                    // $('#createproject').prop('disabled', true);  // pass even if there is no users selected (project with out users)
                    $('#loading').hide();   
                }else if(result[0] == 'ok') {
                    $('#usersTable').append(result[1]);
                    $('#teamleaderTable').append(result[2]);
                    $('#createproject').prop('disabled', false);
                    $('#loading').hide();   
                }
            }
        });
    });
</script>
@endsection
