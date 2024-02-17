@props(['tasks'])

<table class="table table-striped mt-2" style="height: 100px;">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Project</th>
            <th scope="col">To User</th>
            <th scope="col">Start date</th>
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
                    {{ substr($task->description, 0, 50) }}...
                </td>
                <td class="align-middle">
                    <a href="{{ route('admin.projects.show', $task->project->id) }}" 
                       style="text-decoration: none;">{{ $task->project->title }}</a>
                </td>
                <td class="align-middle">
                    <span class="badge">
                        <a href="{{ route('admin.users.show', $task->user->id) }}" 
                           style="text-decoration: none;" >{{ $task->user->name }}</a>
                    </span>
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