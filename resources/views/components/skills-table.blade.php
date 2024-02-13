@props(['skills'])

<table class="table table-striped mt-2">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Date</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($skills as $skill)
            <tr>
                <th scope="row" class="align-middle">{{ $skill->id }}</th>
                <td class="align-middle"><a href="{{ route('admin.skills.show', $skill->id) }}" >{{ $skill->name }} </a></td>
                <td class="align-middle">{{ $skill->created_at->diffForHumans() }}</td>
                <td class="align-middle">
                    <div style="display: flex;" class="d-flex">
                        <a type="button" class="btn btn-primary m-1 d-flex justify-content-center " href="{{ route('admin.skills.show', $skill->id) }}" role="button">Show</a>
                        <a type="button" class="btn btn-secondary m-1 d-flex justify-content-center " href="{{ route('admin.skills.edit', $skill->id) }}" role="button">Edit</a>
                        <a class="btn btn-danger m-1 d-flex justify-content-center " type="button"
                                onclick="if (confirm('Are you sure?') == true) {
                                            document.getElementById('delete-item-{{$skill->id}}').submit();
                                            event.preventDefault();
                                        } else {
                                            return;
                                        }
                                        ">
                                {{ __('Delete') }}
                        </a>
                        <!-- for the delete  -->
                        <form id="delete-item-{{$skill->id}}" action="{{ route('admin.skills.destroy', $skill) }}" class="d-none" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>