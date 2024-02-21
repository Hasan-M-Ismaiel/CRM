@props(['tasks'])

<table class="table table-striped mt-2" style="height: 100px;">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
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
                    @if($task->user->profile && $task->user->profile->getFirstMediaUrl("profiles"))
                        <img
                        src='{{ $task->user->profile->getFirstMediaUrl("profiles") }}'
                        alt="DP"  class="  rounded-circle img-fluid  border border-success shadow mb-1" width="35" height="35">
                    @elseif($task->user->getFirstMediaUrl("users"))
                    <img
                        src='{{ $task->user->getMedia("users")[0]->getUrl("thumb") }}'
                        alt="DP"  class="  rounded-circle img-fluid border border-success shadow mb-1" width="35" height="35">
                    @else
                    <img
                        src='{{ asset("images/avatar.png") }}'
                        alt="DP"  class="  rounded-circle img-fluid border border-success shadow mb-1" width="35" height="35">
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
                            <a class="btn btn-danger m-1" 
                                type="button"
                                onclick="if (confirm('Are you sure?') == true) {
                                            document.getElementById('delete-item-{{$task->id}}').submit();
                                            event.preventDefault();
                                        } else {
                                            return;
                                        }
                                        ">
                                {{ __('Delete') }}</a>@endcan
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