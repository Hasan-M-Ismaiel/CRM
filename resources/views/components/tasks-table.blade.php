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
                <th scope="col">#</th>
                <th scope="col" class="align-middle">
                    <span class="btn px-1 p-0 m-0 text-light" style="background-color: #303c54;" id="getSortedUsers" onclick="getSortedTasks()">
                    Title
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6"/>
                        </svg>
                    </span>
                </th>
                <th scope="col">Description</th>
                <th scope="col">Project</th>
                <th scope="col">To User</th>
                <th scope="col">Start</th>
                <th scope="col">status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    @if(auth()->user()->hasRole('admin'))
                    <th scope="row" class="align-middle">{{ $task->id }}</th>
                    @else 
                    <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
                    @endif
                    <td class="align-middle">
                        <a href="{{ route('admin.tasks.show', $task->id) }}" 
                        style="text-decoration: none;">{{ $task->title }}</a>
                    </td>
                    <td class="align-middle">
                        {{ substr($task->description, 0, 15) }}...
                    </td>
                    <td class="align-middle">
                        <a href="{{ route('admin.projects.show', $task->project->id) }}" 
                        style="text-decoration: none;">{{ $task->project->title }}</a>
                    </td>
                    
                    <td class="align-middle">
                        @if($task->user->profile)
                            <a href="{{ route('admin.profiles.show', $task->user->id) }}" style="text-decoration: none;">
                        @else
                            <a href="{{ route('admin.statuses.notFound') }}" style="text-decoration: none;">
                        @endif
                        <!--image-->
                        @if($task->user->profile && $task->user->profile->getFirstMediaUrl("profiles"))
                        <div class="avatar avatar-md">
                            <img src='{{ $task->user->profile->getFirstMediaUrl("profiles") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                        </div>
                        @elseif($task->user->getFirstMediaUrl("users"))
                        <div class="avatar avatar-md">
                            <img src='{{ $task->user->getMedia("users")[0]->getUrl("thumb") }}'alt="DP"  class="avatar-img border border-success shadow mb-1">
                        </div>
                        @else
                        <div class="avatar avatar-md">
                            <img src='{{ asset("images/avatar.png") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                        </div>
                        @endif
                        <span class="badge m-1" style="background: #673AB7;">{{ $task->user->name }}</span>
                        </a>
                    </td>

                    <td class="align-middle">
                        {{ $task->created_at->diffForHumans() }}
                    </td>
                    <td class="align-middle">
                        <x-task-status :status="$task->status" />
                    </td>   
                    <td class="align-middle">
                        <div style="display: flex;">
                            <a type="button" 
                            class="btn btn-primary m-1" 
                                href="{{ route('admin.tasks.show', $task->id) }}" 
                                role="button" 
                                style="text-decoration: none;">Show</a>
                            @can('task_edit')
                                <a type="button" 
                                    class="btn btn-secondary m-1" 
                                    href="{{ route('admin.tasks.edit', $task->id) }}" 
                                    role="button" style="text-decoration: none;">Edit</a>@endcan
                            @can('task_delete')
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash-fill text-danger mt-2" viewBox="0 0 16 16"
                                    onclick="if (confirm('Are you sure?') == true) {
                                                        document.getElementById('delete-item-{{$task->id}}').submit();
                                                        event.preventDefault();
                                                    } else {
                                                        return;
                                                    }
                                                    ">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                </svg>
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