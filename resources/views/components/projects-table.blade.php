@props(['projects'])

<table class="table table-striped mt-2" style="height: 100px;">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Deadline</th>
            <th scope="col">Assined User</th>
            <th scope="col">Owner</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
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
                    {{ substr($project->description, 0, 40) }}...
                </td>
                <td class="align-middle">
                    {{ $project->deadline }}
                </td>
                <td class="align-middle">
                    @if($project->users()->count() > 0)
                        @foreach ($project->users as $user)
                            <span class="badge bg-dark m-1">{{ $user->name }}</span>
                        @endforeach
                    @else
                        #
                    @endif
                </td>
                <td class="align-middle">
                    {{ $project->client->name }}
                </td>
                <td class="align-middle">
                    <x-project-status :status="$project->status" />
                </td>
                <td class="align-middle" >
                    <div style="display: flex;">
                        @can('assign_project_to_user')<a type="button" class="btn btn-success m-1" href="{{ route('admin.projects.assignCreate', $project->id) }}" role="button">Assign</a>@endcan
                        <a type="button" class="btn btn-primary m-1" href="{{ route('admin.projects.show', $project->id) }}" role="button">Show</a>
                        @can('project_edit')<a type="button" class="btn btn-secondary m-1" href="{{ route('admin.projects.edit', $project->id) }}" role="button">Edit</a>@endcan
                        @can('project_delete')<a class="btn btn-danger m-1" type="button"
                                onclick="if (confirm('Are you sure?') == true) {
                                            document.getElementById('delete-item-{{$project->id}}').submit();
                                            event.preventDefault();
                                        } else {
                                            return;
                                        }
                                        ">
                                {{ __('Delete') }}
                        </a>@endcan
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