@props(['projects'])

<table class="table table-striped mt-2">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Deadline</th>
            <th scope="col">Assined User</th>
            <th scope="col">Owner</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($projects as $project)
            <tr>
                <th scope="row">{{ $project->id }}</th>
                <td><a href="{{ route('admin.projects.show', $project->id) }}" >{{ $project->title }} </a></td>
                <td>{{ $project->description }}...</td>
                <td>{{ $project->deadline }}</td>
                <td>
                    @if($project->users()->count() > 0)
                        @foreach ($project->users as $user)
                            <span class="badge bg-dark m-1">{{ $user->name }}</span>
                        @endforeach
                    @else
                        #
                    @endif
                </td>
                <td>{{ $project->client->name }}</td>
                <td>{{ $project->statusOfProject }}</td>
                <td>
                    <div style="display: flex;">
                        <a type="button" class="btn btn-success m-1" href="{{ route('admin.projects.assignCreate', $project->id) }}" role="button">Assign</a>
                        <a type="button" class="btn btn-primary m-1" href="{{ route('admin.projects.show', $project->id) }}" role="button">Show</a>
                        <a type="button" class="btn btn-secondary m-1" href="{{ route('admin.projects.edit', $project->id) }}" role="button">Edit</a>
                        <a class="btn btn-danger m-1" type="button"
                                onclick="if (confirm('Are you sure?') == true) {
                                            document.getElementById('delete-item-{{$project->id}}').submit();
                                            event.preventDefault();
                                        } else {
                                            return;
                                        }
                                        ">
                                {{ __('Delete') }}
                        </a>
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