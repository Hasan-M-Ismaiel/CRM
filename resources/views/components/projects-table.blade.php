@props(['projects'])

<!--this is for searched users result-->
<div id="searchedProjectsTable" class="mt-4">
</div>

<!--this is for sorted users result-->
<div id="sortedProjectsTableSorted" class="mt-4">
</div>
<!--this is for basic users result-->
<div id="sortedProjectsTable" class="mt-4">
    <table class="table table-striped mt-2  border border-1" style="height: 100px;">
        <thead>
            <tr>
                <th scope="col" class="align-middle" id="pcreateProject">#</th>
                <!--title with sort button-->
                <th scope="col" class="align-middle" id="pcreateProject"> 
                    <span class="btn px-1 p-0 m-0 text-light" style="background-color: #303c54;" onclick="getSortedProjects()">
                        Title
                        <svg id="arrowkey" xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6"/>
                        </svg>
                    </span>
                </th>
                <th scope="col" class="align-middle" id="pcreateProject">Deadline</th>
                <th scope="col" class="align-middle" id="pcreateProject">Leader</th>
                <th scope="col" class="align-middle" id="pcreateProject" width="25px">Techniques</th>
                <th scope="col" class="align-middle" id="pcreateProject">Users</th>
                @if(auth()->user()->hasRole('admin'))
                <!-- <th scope="col" class="align-middle">Owner</th> -->
                @endif
                <th scope="col" class="align-middle" id="pcreateProject">Tasks</th>
                <th scope="col" class="align-middle" id="pcreateProject">Status</th>
                <th scope="col" class="align-middle" id="pcreateProject">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <!--iteration-->
                    @if(auth()->user()->hasRole('admin'))
                    <th scope="row" class="align-middle">{{ $project->id }}</th>
                    @else 
                    <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
                    @endif
                    <!--project title-->
                    <td class="align-middle">
                        <a href="{{ route('admin.projects.show', $project->id) }}" 
                            style="text-decoration: none;" >{{ $project->title }} 
                        </a>
                    </td>
                    <!--deadline-->
                    <td class="align-middle">
                        {{ $project->deadline }}
                    </td>

                    <!--teamleader-->
                    <td class="align-middle">
                        @if($project->teamleader)
                        <div>
                            @if($project->teamleader->profile)
                                <a href="{{ route('admin.profiles.show', $project->teamleader->id) }}" class="position-relative" style="text-decoration: none;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$project->teamleader->name}}">
                            @else
                                <a href="{{ route('admin.statuses.notFound') }}" class="position-relative" style="text-decoration: none;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$project->teamleader->name}}">
                            @endif
                            <!--image-->
                            @if($project->teamleader->profile && $project->teamleader->profile->getFirstMediaUrl("profiles"))
                            <div class="py-1 px-2">
                                <div class="avatar avatar-md mt-1">
                                    <img src='{{ $project->teamleader->profile->getFirstMediaUrl("profiles") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                </div>
                                <x-user-badges :user="$project->teamleader" />
                            </div>
                            @elseif($project->teamleader->getFirstMediaUrl("users"))
                            <div class="py-1 px-2">
                                <div class="avatar avatar-md mt-1">
                                    <img src='{{ $project->teamleader->getMedia("users")[0]->getUrl("thumb") }}'alt="DP"  class="avatar-img border border-success shadow mb-1">
                                </div>
                                <x-user-badges :user="$project->teamleader" />
                            </div>
                            @else
                            <div class="py-1 px-2">
                                <div class="avatar avatar-md mt-1">
                                    <img src='{{ asset("images/avatar.png") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                </div>
                                <x-user-badges :user="$project->teamleader" />
                            </div>

                            @endif
                            </a>
                        </div>
                        @else
                            #
                        @endif
                    </td>

                    <!--project skills-->
                    <td class="align-middle">
                        @if($project->skills()->count() > 0)
                            @foreach ($project->skills as $skill)
                                <span class="badge m-1" style="background: #673AB7;">{{ $skill->name }}</span>
                            @endforeach
                        @else
                            #
                        @endif
                    </td>
                    
                    <!--users-->
                    <td class="align-middle">
                        @if($project->users()->count() > 0)
                            @foreach ($project->users as $user)
                                <div>
                                    @if($user->profile)
                                        <a href="{{ route('admin.profiles.show', $user->id) }}" class="position-relative" style="text-decoration: none;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$user->name}}">
                                    @else
                                        <a href="{{ route('admin.statuses.notFound') }}" class="position-relative" style="text-decoration: none;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$user->name}}">
                                    @endif
                                    <!--image-->
                                    @if($user->profile && $user->profile->getFirstMediaUrl("profiles"))
                                    <div class="p-2">
                                        <div class="avatar avatar-md mt-1">
                                            <img src='{{ $user->profile->getFirstMediaUrl("profiles") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                        </div>
                                    <x-user-badges :user="$user" />
                                    </div>
                                    @elseif($user->getFirstMediaUrl("users"))
                                    <div class="p-2">
                                        <div class="avatar avatar-md mt-1">
                                            <img src='{{ $user->getMedia("users")[0]->getUrl("thumb") }}'alt="DP"  class="avatar-img border border-success shadow mb-1">
                                        </div>
                                    <x-user-badges :user="$user" />
                                    </div>
                                    @else
                                    <div class="p-2">
                                        <div class="avatar avatar-md mt-1">
                                            <img src='{{ asset("images/avatar.png") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                        </div>
                                    <x-user-badges :user="$user" />
                                    </div>
                                    @endif
                                    </a>
                                </div>
                            @endforeach
                        @else
                            #
                        @endif
                    </td>
                    @if(auth()->user()->hasRole('admin'))
                    <!--client name-->
                    <!-- <td class="align-middle">
                        {{ $project->client->name }}
                    </td> -->
                    @endif

                    <!--number of tasks-->
                    <td class="align-middle">
                        <span class="badge m-1" style="background: #673AB7;">{{  $project->tasks->count() }}</span>    
                    </td>

                    <!--status-->
                    <td class="align-middle">
                        <x-project-status :status="$project->status" />
                    </td>
                    <!--controll buttons-->
                    <td class="align-middle" >
                        <div style="display: flex;">
                            @can('view', $project)
                            <a type="button" class="m-1" href="{{ route('admin.teams.show', $project->id) }}" role="button" data-bs-toggle="tooltip" data-bs-placement="top" title="get into chat with team">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                                    <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                    <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2"/>
                                </svg>
                            </a>
                            @endcan

                            @can('update', $project)
                            <a type="button" class="m-1" href="{{ route('admin.projects.assignCreate', $project->id) }}" role="button" data-bs-toggle="tooltip" data-bs-placement="top" title="assign new user">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-add" viewBox="0 0 16 16">
                                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                                    <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z"/>
                                </svg>
                            </a>
                            @endcan
                            <a type="button" class="m-1" href="{{ route('admin.projects.show', $project->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="show project">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                                </svg>
                            </a>
                            @can('edit-project',$project)
                            <a type="button" class="m-1" href="{{ route('admin.projects.edit', $project->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="project edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </a>
                            @endcan
                            @can('project_delete')
                            <a type="button" class="m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="delete project">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill text-danger" viewBox="0 0 16 16"
                                    onclick="if (confirm('Deleting project will cause deleting all tasks and chats! Are you sure?') == true) {
                                                        document.getElementById('delete-item-{{$project->id}}').submit();
                                                        event.preventDefault();
                                                    } else {
                                                        return;
                                                    }
                                                    ">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                </svg>
                            </a>
                            @endcan
                            <!-- for the delete  -->
                            <form id="delete-item-{{$project->id}}" action="{{ route('admin.projects.destroy', $project) }}" class="d-none" method="POST">
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

<!--getSortedProjects()-->
<script>
    var toggleNames = false;
    var lockNames = false;
    
    var toggleRoles = false;
    var lockRoles = false;
    
    function getSortedProjects(){
        $('#loading').show();
        if(!lockNames){
            $.ajax({
                url: "{{ route('admin.projects.getSortedProjects') }}",
                method: 'get',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(output){
                    var result = $.parseJSON(output);
                    $('#searchedProjectsTable').hide();
                    $('#sortedProjectsTable').hide();
                    $('#sortedProjectsTableSorted').append(result[0]);
                    $('#sortedProjectsTableSorted').show();
                    toggleNames= false;
                    lockNames= true;  
                    $('#loading').hide();
                }
            });
        }else{
            if(!toggleNames){
                $('#sortedProjectsTableSorted').hide();
                $('#searchedProjectsTable').hide();
                $('#sortedProjectsTable').show();
                toggleNames = !toggleNames;
                $('#loading').hide();
            }else{
                $('#searchedProjectsTable').hide();
                $('#sortedProjectsTable').hide();
                $('#sortedProjectsTableSorted').show();
                toggleNames = !toggleNames;
                $('#loading').hide();
            }
        }
    }
</script>