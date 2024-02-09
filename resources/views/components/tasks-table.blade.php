@props(['tasks'])

<table class="table table-striped mt-2">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Project</th>
            <th scope="col">To User</th>
            <th scope="col">Start date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
            <tr>
                <th scope="row">{{ $task->id }}</th>
                <td><a href="{{ route('admin.tasks.show', $task->id) }}" style="text-decoration: none;">{{ $task->title }} </a></td>
                <td>{{ substr($task->description, 0, 50) }}...</td>
                <td><a href="{{ route('admin.projects.show', $task->project->id) }}" style="text-decoration: none;">{{ $task->project->title }}</a></td>
                <td>
                <span class="badge"><a href="{{ route('admin.users.show', $task->user->id) }}" style="text-decoration: none;" >{{ $task->user->name }}</a></span>
                </td>
                <td>{{ $task->created_at->diffForHumans() }}</td>
                <td>
                    <div style="display: flex;">
                        <a type="button" class="btn btn-primary m-1" href="{{ route('admin.tasks.show', $task->id) }}" role="button" style="text-decoration: none;">Show</a>
                        @can('task_edit')<a type="button" class="btn btn-secondary m-1" href="{{ route('admin.tasks.edit', $task->id) }}" role="button" style="text-decoration: none;">Edit</a>@endcan
                        @can('task_delete')<a class="btn btn-danger m-1" type="button"
                                onclick="if (confirm('Are you sure?') == true) {
                                            document.getElementById('delete-item-{{$task->id}}').submit();
                                            event.preventDefault();
                                        } else {
                                            return;
                                        }
                                        ">
                                {{ __('Delete') }}
                        </a>@endcan
                        <!-- for the delete  -->
                        <form id="delete-item-{{$task->id}}" action="{{ route('admin.tasks.destroy', $task) }}" class="d-none" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>