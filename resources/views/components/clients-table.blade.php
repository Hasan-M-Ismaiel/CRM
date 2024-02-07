@props(['clients'])

<table class="table table-striped mt-2">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">VAT</th>
            <th scope="col">address</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clients as $client)
            <tr>
                <th scope="row">{{ $client->id }}</th>
                <td><a href="{{ route('admin.clients.show', $client->id) }}" >{{ $client->name }} </a></td>
                <td>{{ $client->VAT }}...</td>
                <td>{{ $client->address }}</td>
                <td>
                    <div style="display: flex;">
                        <a type="button" class="btn btn-primary m-1" href="{{ route('admin.clients.show', $client->id) }}" role="button">Show</a>
                        <a type="button" class="btn btn-secondary m-1" href="{{ route('admin.clients.edit', $client->id) }}" role="button">Edit</a>
                        <a class="btn btn-danger m-1" type="button"
                                onclick="if (confirm('Are you sure?') == true) {
                                            document.getElementById('delete-item-{{$client->id}}').submit();
                                            event.preventDefault();
                                        } else {
                                            return;
                                        }
                                        ">
                                {{ __('Delete') }}
                        </a>
                        <!-- for the delete  -->
                        <form id="delete-item-{{$client->id}}" action="{{ route('admin.clients.destroy', $client) }}" class="d-none" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>