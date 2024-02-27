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
                <th scope="col" class="align-middle">#</th>
                <th scope="col" class="align-middle"> 
                        <span class="btn px-1 p-0 m-0 text-light" style="background-color: #303c54;" onclick="getSortedProjects()">
                            Title
                            <svg id="arrowkey" xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6"/>
                            </svg>
                        </span>
                    </th>
                <th scope="col" class="align-middle">Deadline</th>
                <th scope="col" class="align-middle">Techniques</th>
                <th scope="col" class="align-middle">Leader</th>
                <th scope="col" class="align-middle">Users</th>
                <th scope="col" class="align-middle">Owner</th>
                <th scope="col" class="align-middle">Tasks</th>
                <th scope="col" class="align-middle">Status</th>
                <th scope="col" class="align-middle">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    @if(auth()->user()->hasRole('admin'))
                    <th scope="row" class="align-middle">{{ $project->id }}</th>
                    @else 
                    <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
                    @endif
                    <td class="align-middle">
                        <a href="{{ route('admin.projects.show', $project->id) }}" 
                            style="text-decoration: none;" >{{ $project->title }} 
                        </a>
                    </td>
                    <td class="align-middle">
                        {{ $project->deadline }}
                    </td>
                    <td class="align-middle">
                        @if($project->skills()->count() > 0)
                            @foreach ($project->skills as $skill)
                                <span class="badge m-1" style="background: #673AB7;">{{ $skill->name }}</span>
                            @endforeach
                        @else
                            #
                        @endif
                    </td>
                    
                    <td class="align-middle">
                        @if($project->teamleader)
                        <div>
                            @if($project->teamleader->profile)
                                <a href="{{ route('admin.profiles.show', $project->teamleader->id) }}" style="text-decoration: none;">
                            @else
                                <a href="{{ route('admin.statuses.notFound') }}" style="text-decoration: none;">
                            @endif
                            <!--image-->
                            @if($project->teamleader->profile && $project->teamleader->profile->getFirstMediaUrl("profiles"))
                            <div class="avatar avatar-md mt-1">
                                <img src='{{ $project->teamleader->profile->getFirstMediaUrl("profiles") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                            </div>
                            @elseif($project->teamleader->getFirstMediaUrl("users"))
                            <div class="avatar avatar-md mt-1">
                                <img src='{{ $project->teamleader->getMedia("users")[0]->getUrl("thumb") }}'alt="DP"  class="avatar-img border border-success shadow mb-1">
                            </div>
                            @else
                            <div class="avatar avatar-md mt-1">
                                <img src='{{ asset("images/avatar.png") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                            </div>
                            @endif
                            <span class="badge m-1" style="background: #673AB7;">{{ $project->teamleader->name }}</span>
                            </a>
                        </div>
                        @else
                            #
                        @endif
                    </td>

                    <td class="align-middle">
                        @if($project->users()->count() > 0)
                            @foreach ($project->users as $user)
                            <div>
                                @if($user->profile)
                                    <a href="{{ route('admin.profiles.show', $user->id) }}" style="text-decoration: none;">
                                @else
                                    <a href="{{ route('admin.statuses.notFound') }}" style="text-decoration: none;">
                                @endif
                                <!--image-->
                                @if($user->profile && $user->profile->getFirstMediaUrl("profiles"))
                                <div class="avatar avatar-md mt-1">
                                    <img src='{{ $user->profile->getFirstMediaUrl("profiles") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                </div>
                                @elseif($user->getFirstMediaUrl("users"))
                                <div class="avatar avatar-md mt-1">
                                    <img src='{{ $user->getMedia("users")[0]->getUrl("thumb") }}'alt="DP"  class="avatar-img border border-success shadow mb-1">
                                </div>
                                @else
                                <div class="avatar avatar-md mt-1">
                                    <img src='{{ asset("images/avatar.png") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                </div>
                                @endif
                                <span class="badge m-1" style="background: #673AB7;">{{ $user->name }}</span>
                                </a>
                            </div>
                            @endforeach
                        @else
                            #
                        @endif
                    </td>
                    <td class="align-middle">
                        {{ $project->client->name }}
                    </td>
                    <td class="align-middle">
                        {{ $project->tasks->count() }}
                    </td>
                    <td class="align-middle">
                        <x-project-status :status="$project->status" />
                    </td>
                    <td class="align-middle" >
                        <div style="display: flex;">
                            @can('assign_project_to_user')<a type="button" class="btn btn-success m-1" href="{{ route('admin.projects.assignCreate', $project->id) }}" role="button">Assign</a>@endcan
                            <a type="button" class="btn btn-primary m-1" href="{{ route('admin.projects.show', $project->id) }}" role="button">Show</a>
                            @can('project_edit')<a type="button" class="btn btn-secondary m-1" href="{{ route('admin.projects.edit', $project->id) }}" role="button">Edit</a>@endcan
                            @can('project_delete')<svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash-fill text-danger mt-2" viewBox="0 0 16 16"
                                    onclick="if (confirm('Are you sure?') == true) {
                                                        document.getElementById('delete-item-{{$project->id}}').submit();
                                                        event.preventDefault();
                                                    } else {
                                                        return;
                                                    }
                                                    ">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                </svg>@endcan
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