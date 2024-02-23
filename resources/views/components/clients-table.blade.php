@props(['clients'])


<div id="searchedClientsTable" class="mt-4">
</div>

<!--this is for sorted Clients result-->
<div id="sortedClientsTableSorted" class="mt-4">
</div>


<!--this is for basic Clients result-->
<div id="sortedClientsTable" class="mt-4">
    <table class="table table-striped mt-2 border">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">
                    <span class="btn px-1 p-0 m-0 text-light" style="background-color: #303c54;" id="getSortedClients" onclick="getSortedClients()">
                    Name
                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6"/>
                        </svg>
                    </span>
                </th>
                <th scope="col">VAT</th>
                <th scope="col"># Projects</th>
                <th scope="col">Address</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <th scope="row" class="align-middle">{{ $client->id }}</th>
                    <td class="align-middle"><a href="{{ route('admin.clients.show', $client->id) }}" style="text-decoration: none;" >{{ $client->name }} </a></td>
                    <td class="align-middle">{{ $client->VAT }}</td>
                    <td class="align-middle">{{ $client->numberOfProjects }}</td>
                    <td class="align-middle">{{ substr($client->address, 0, 15) }}</td>
                    <td class="align-middle">
                        <div style="display: flex;">
                            <a type="button" class="btn btn-primary m-1" href="{{ route('admin.clients.show', $client->id) }}" role="button">Show</a>
                            <a type="button" class="btn btn-secondary m-1" href="{{ route('admin.clients.edit', $client->id) }}" role="button">Edit</a>
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash-fill text-danger mt-2" viewBox="0 0 16 16"
                                onclick="if (confirm('Are you sure?') == true) {
                                                    document.getElementById('delete-item-{{$client->id}}').submit();
                                                    event.preventDefault();
                                                } else {
                                                    return;
                                                }
                                                ">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                            </svg>
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
</div>

<script>
    var toggleNames = false;
    var lockNames = false;
    
    var toggleRoles = false;
    var lockRoles = false;
    
    function getSortedClients(){
        if(!lockNames){
            $('#loading').show();
            $.ajax({
                url: "{{ route('admin.clients.getSortedClients') }}",
                method: 'get',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(output){
                    var result = $.parseJSON(output);
                    $('#sortedClientsTable').hide(); // to clear the list if the user change the selected option again 
                    $('#sortedClientsTableSorted').append(result[0]);
                    toggleNames= false;
                    lockNames= true;  
                    $('#loading').hide();

                    // $("arrowKey").replaceWith('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-bar-up" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 10a.5.5 0 0 0 .5-.5V3.707l2.146 2.147a.5.5 0 0 0 .708-.708l-3-3a.5.5 0 0 0-.708 0l-3 3a.5.5 0 1 0 .708.708L7.5 3.707V9.5a.5.5 0 0 0 .5.5m-7 2.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5"/></svg>');
                }
            });
        }else{
            if(!toggleNames){
                $('#sortedClientsTableSorted').hide();
                $('#sortedClientsTable').show();
                toggleNames = !toggleNames;
                $('#loading').hide();
            }else{
                $('#sortedClientsTableSorted').show();
                $('#sortedClientsTable').hide();
                toggleNames = !toggleNames;
                $('#loading').hide();
            }
        }
    }
</script>