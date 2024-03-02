@props(['users'])


<!--this is for searched users result-->
<div id="searchedUsersTable" class="mt-4">
</div>

<!--this is for sorted users result-->
<div id="sortedUsersTableSorted" class="mt-4">
</div>

<!--this is for basic users result-->
<div id="sortedUsersTable" class="mt-4">
    <table class="table table-striped mt-2">
        <thead>
            <tr>
                <th scope="col" class="align-middle" id="pcreateProject">#</th>
                <th scope="col" class="align-middle" id="pcreateProject">Profile</th>
                <th scope="col" class="align-middle" id="pcreateProject"> 
                    <span class="btn px-1 p-0 m-0 text-light" style="background-color: #303c54;" onclick="getSortedUsers()">
                        Name
                        <svg id="arrowkey" xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6"/>
                        </svg>
                    </span>
                </th>
                <th scope="col" class="align-middle" id="pcreateProject">Email</th>
                <th scope="col" class="align-middle" id="pcreateProject">Role</th>
                <th scope="col" class="align-middle" id="pcreateProject">Tasks</th>
                <th scope="col" class="align-middle" id="pcreateProject">Skills</th>
                <th scope="col" class="align-middle" id="pcreateProject">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <!--user id -->
                    <th scope="row" class="align-middle">{{ $user->id }}</th>
                    <!--profile avatar-->
                    <td class="align-middle">
                        @if($user->profile)
                            <a href="{{ route('admin.profiles.show', $user->id) }}" class="position-relative" style="text-decoration: none;">
                        @else
                            <a href="{{ route('admin.statuses.notFound') }}" class="position-relative" style="text-decoration: none;">
                        @endif
                        <!--image-->
                        @if($user->profile && $user->profile->getFirstMediaUrl("profiles"))
                        <div class="p-2">
                            <div class="avatar avatar-md">
                                <img src='{{ $user->profile->getFirstMediaUrl("profiles") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                            </div>
                            <x-user-badges :user="$user" />
                        </div>
                        @elseif($user->getFirstMediaUrl("users"))
                        <div class="p-2">
                            <div class="avatar avatar-md">
                                <img src='{{ $user->getMedia("users")[0]->getUrl("thumb") }}'alt="DP"  class="avatar-img border border-success shadow mb-1">
                            </div>
                            <x-user-badges :user="$user" />
                        </div>
                        @else
                        <div class="p-2">
                            <div class="avatar avatar-md">
                                    <img src='{{ asset("images/avatar.png") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                            </div>
                            <x-user-badges :user="$user" />
                        </div>
                        @endif
                        </a>
                    </td>
                    <!--name-->
                    <td  class="align-middle"><a href="{{ route('admin.users.show', $user->id) }}" style="text-decoration: none;" >{{ $user->name }} </a></td>
                    <!--email-->
                    <td  id="test" class="align-middle">{{ substr($user->email, 0, 15) }}...</td>
                    <!--role name-->
                    <td class="align-middle">{{ $user->getRoleNames()->get('0') }}</td>
                    <!--number of assigned tasks-->
                    <td class="align-middle">
                        <span class="badge m-1" style="background: #673AB7;"> {{ $user->numberOfAssignedTasks }} </span>
                    </td>
                    <!--skills-->
                    <td class="align-middle">
                        @if($user->skills()->count() > 0)
                            @foreach ($user->skills as $skill)
                                <span class="badge m-1" style="background: #673AB7;">{{ $skill->name }}</span>
                            @endforeach
                        @else
                            #
                        @endif
                    </td>
                    <!--controll buttons-->
                    <td class="align-middle">
                        <div style="display: flex;">
                            <!--show-->
                            <a type="button" class="m-1" href="{{ route('admin.users.show', $user->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="show">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                                </svg>
                            </a>
                            <!--edit-->
                            <a type="button" class="m-1" href="{{ route('admin.users.edit', $user->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </a>
                            <!--delete-->
                            <a type="button" class="m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="delete" data-bs-toggle="tooltip" data-bs-placement="top" title="delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill text-danger" viewBox="0 0 16 16"
                                    onclick="if (confirm('All the messages realated to this user will be deleted! and the user will not be any more in the projects, the tasks related to this user will be without user so try to assign users to user tasks  Are you sure?') == true) {
                                                        document.getElementById('delete-item-{{$user->id}}').submit();
                                                        event.preventDefault();
                                                    } else {
                                                        return;
                                                    }
                                                    ">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                </svg>
                            </a>
                            <!-- for the delete  -->
                            <form id="delete-item-{{$user->id}}" action="{{ route('admin.users.destroy', $user) }}" class="d-none" method="POST">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


<!--getSortedUsers-->
<script>
    var toggleNames = false;
    var lockNames = false;
    
    var toggleRoles = false;
    var lockRoles = false;
    
    function getSortedUsers(){
        $('#loading').show();
        if(!lockNames){
            $.ajax({
                url: "{{ route('admin.users.getSortedUsers') }}",
                method: 'get',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(output){
                    var result = $.parseJSON(output);
                    $('#searchedUsersTable').hide();
                    $('#sortedUsersTable').hide();
                    $('#sortedUsersTableSorted').append(result[0]);
                    $('#sortedUsersTableSorted').show();

                    toggleNames= false;
                    lockNames= true;  
                    $('#loading').hide();

                    // $("arrowKey").replaceWith('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-up" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 10a.5.5 0 0 0 .5-.5V3.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 3.707V9.5a.5.5 0 0 0 .5.5m-7 2.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5"/></svg>');
                }
            });
        }else{
            if(!toggleNames){
                $('#sortedUsersTableSorted').hide();
                $('#searchedUsersTable').hide();
                $('#sortedUsersTable').show();
                toggleNames = !toggleNames;
                $('#loading').hide();
            }else{
                $('#searchedUsersTable').hide();
                $('#sortedUsersTable').hide();
                $('#sortedUsersTableSorted').show();
                toggleNames = !toggleNames;
                $('#loading').hide();
            }
        }
    }

    // function getSortedRoles(){
    //     if(!lockRoles){
    //         $.ajax({
    //             url: "{{ route('admin.users.getSortedRoles') }}",
    //             method: 'get',
    //             data: {
    //                 "_token": "{{ csrf_token() }}",
    //             },
    //             success: function(output){
    //                 var result = $.parseJSON(output);
    //                 $('#sortedUersTable').hide(); // to clear the list if the user change the selected option again 
    //                 $('#sortedUersTableSorted').append(result[0]);
    //                 toggleRoles= false;
    //                 lockRoles= true;  
    //             }
    //         });
    //     }else{
    //         if(!toggleRoles){
    //             $('#sortedUersTableSorted').hide();
    //             $('#sortedUersTable').show();
    //             toggleRoles = !toggleRoles;

    //         }else{
    //             $('#sortedUersTableSorted').show();
    //             $('#sortedUersTable').hide();
    //             toggleRoles = !toggleRoles;
    //         }
    //     }
    // }

</script>