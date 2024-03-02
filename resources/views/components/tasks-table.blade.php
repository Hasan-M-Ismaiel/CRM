@props(['tasks'])

<!--this is for searched tasks result-->
<div id="searchedTasksTable" class="mt-4">
</div>

<!--this is for sorted tasks result-->
<div id="sortedTasksTableSorted" class="mt-4">
</div>

<!--this is for basic tasks result-->
<div id="sortedTasksTable" class="mt-4">
    <table class="table table-striped mt-2 border" style="height: 100px;">
        <thead>
            <tr>
                <th scope="col" id="pcreateProject">#</th>
                <th scope="col" id="pcreateProject" class="align-middle">
                    <span class="btn px-1 p-0 m-0 text-light" style="background-color: #303c54;" id="getSortedUsers" onclick="getSortedTasks()">
                    Title
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6"/>
                        </svg>
                    </span>
                </th>
                <th scope="col" id="pcreateProject">Project</th>
                <th scope="col" id="pcreateProject">Leader</th>
                <th scope="col" id="pcreateProject">To User</th>
                <th scope="col" id="pcreateProject">Start</th>
                <th scope="col" id="pcreateProject">status</th>
                <th scope="col" id="pcreateProject">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <!--iteration-->
                    @if(auth()->user()->hasRole('admin'))
                    <th scope="row" class="align-middle">{{ $task->id }}</th>
                    @else 
                    <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
                    @endif

                    <!-- task title-->
                    <td class="align-middle">
                        <a href="{{ route('admin.tasks.show', $task->id) }}" 
                        style="text-decoration: none;">{{ substr($task->title, 0, 10) }}...</a>
                    </td>

                    <!-- project title-->
                    <td class="align-middle">
                        <a href="{{ route('admin.projects.show', $task->project->id) }}" 
                        style="text-decoration: none;">{{ $task->project->title }}</a>
                    </td>
                    
                    <!--teamleader-->
                    <td class="align-middle">
                        @if($task->project->teamleader)
                        <div>
                            @if($task->project->teamleader->profile)
                                <a href="{{ route('admin.profiles.show', $task->project->teamleader->id) }}" class="position-relative" style="text-decoration: none;"  data-bs-toggle="tooltip" data-bs-placement="top" title="{{$task->project->teamleader->name}}">
                            @else
                                <a href="{{ route('admin.statuses.notFound') }}" class="position-relative" style="text-decoration: none;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$task->project->teamleader->name}}">
                            @endif
                            <!--image-->
                            @if($task->project->teamleader->profile && $task->project->teamleader->profile->getFirstMediaUrl("profiles"))
                            <div class="py-1 px-2">
                                <div class="avatar avatar-md mt-1">
                                    <img src='{{ $task->project->teamleader->profile->getFirstMediaUrl("profiles") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                </div>
                                <x-user-badges :user="$task->project->teamleader" />
                            </div>
                            @elseif($task->project->teamleader->getFirstMediaUrl("users"))
                            <div class="py-1 px-2">
                                <div class="avatar avatar-md mt-1">
                                    <img src='{{ $task->project->teamleader->getMedia("users")[0]->getUrl("thumb") }}'alt="DP"  class="avatar-img border border-success shadow mb-1">
                                </div>
                                <x-user-badges :user="$task->project->teamleader" />
                            </div>
                            @else
                            <div class="py-1 px-2">
                                <div class="avatar avatar-md mt-1">
                                    <img src='{{ asset("images/avatar.png") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                </div>
                                <x-user-badges :user="$task->project->teamleader" />
                            </div>
                            @endif
                            </a>
                        </div>
                        @else
                            #
                        @endif
                    </td>

                    <!--to user -->
                    <td class="align-middle">
                        @if($task->user->profile)
                            <a href="{{ route('admin.profiles.show', $task->user->id) }}" class="position-relative" style="text-decoration: none;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$task->user->name}}">
                        @else
                            <a href="{{ route('admin.statuses.notFound') }}" class="position-relative" style="text-decoration: none;"  data-bs-toggle="tooltip" data-bs-placement="top" title="{{$task->user->name}}">
                        @endif
                        <!--image-->
                        @if($task->user->profile && $task->user->profile->getFirstMediaUrl("profiles"))
                        <div class="p-2">
                        <div class="avatar avatar-md">
                            <img src='{{ $task->user->profile->getFirstMediaUrl("profiles") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                        </div>
                        <x-user-badges :user="$task->user" />
                        </div>
                        @elseif($task->user->getFirstMediaUrl("users"))
                        <div class="p-2">
                        <div class="avatar avatar-md">
                            <img src='{{ $task->user->getMedia("users")[0]->getUrl("thumb") }}'alt="DP"  class="avatar-img border border-success shadow mb-1">
                        </div>
                        <x-user-badges :user="$task->user" />
                        </div>
                        @else
                        <div class="p-2">
                        <div class="avatar avatar-md">
                            <img src='{{ asset("images/avatar.png") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                        </div>
                        <x-user-badges :user="$task->user" />
                        </div>
                        @endif
                        </a>
                    </td>

                    <!-- created_at -->
                    <td class="align-middle">
                        {{ $task->created_at->diffForHumans() }}
                    </td>

                    <!-- status -->
                    <td class="align-middle">
                        <x-task-status :status="$task->status" />
                    </td>

                    <!-- controll buttons -->
                    <td class="align-middle">
                        <div style="display: flex;">

                            @can('showTaskChat', $task)
                            <a type="button" class="m-1" href="{{ route('admin.tasks.showTaskChat', $task->id) }}" role="button" data-bs-toggle="tooltip" data-bs-placement="top" title="get into chat teamleader">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chat-dots" viewBox="0 0 16 16">
                                    <path d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                                    <path d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9 9 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a11 11 0 0 1-.244.637c-.079.186.074.394.273.362a22 22 0 0 0 .693-.125m.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6-3.004 6-7 6a8 8 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a11 11 0 0 0 .398-2"/>
                                </svg>
                            </a>
                            @endcan
                                <a type="button" class="m-1" href="{{ route('admin.tasks.show', $task->id) }}" role="button" style="text-decoration: none;" data-bs-toggle="tooltip" data-bs-placement="top" title="show">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                                    </svg>
                                </a>
                            @can('update', $task)
                                <a type="button" class="m-1" href="{{ route('admin.tasks.edit', $task->id) }}" role="button" style="text-decoration: none;" data-bs-toggle="tooltip" data-bs-placement="top" title="edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                    </svg>
                                </a>
                            @endcan

                            @can('delete', $task)
                                <a type="button" class="m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="delete">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill text-danger" viewBox="0 0 16 16"
                                        onclick="if (confirm('This task may have messages.  Are you sure?') == true) {
                                                            document.getElementById('delete-item-{{$task->id}}').submit();
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
                            <form id="delete-item-{{$task->id}}" 
                                action="{{ route('admin.tasks.destroy', $task) }}" 
                                class="d-none" 
                                method="POST">
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

<!--get sorted tasks-->
<script>
    var toggleNames = false;
    var lockNames = false;
    
    var toggleRoles = false;
    var lockRoles = false;
    
    function getSortedTasks(){
        $('#loading').show();
        if(!lockNames){
            $.ajax({
                url: "{{ route('admin.tasks.getSortedTasks') }}",
                method: 'get',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(output){
                    var result = $.parseJSON(output);
                    $('#searchedTasksTable').hide();
                    $('#sortedTasksTable').hide(); 
                    $('#sortedTasksTableSorted').append(result[0]);
                    $('#sortedTasksTableSorted').show();
                    toggleNames= false;
                    lockNames= true;  
                    $('#loading').hide();
                }
            });
        }else{
            if(!toggleNames){
                $('#sortedTasksTableSorted').hide();
                $('#searchedTasksTable').hide();
                $('#sortedTasksTable').show();
                toggleNames = !toggleNames;
                $('#loading').hide();
            }else{
                $('#searchedTasksTable').hide();
                $('#sortedTasksTable').hide();
                $('#sortedTasksTableSorted').show();
                toggleNames = !toggleNames;
                $('#loading').hide();
            }
        }
    }
</script>