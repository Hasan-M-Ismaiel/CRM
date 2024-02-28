@props(['skills'])

<!--this is for searched skills result-->
<div id="searchedSkillsTable" class="mt-4">
</div>

<!--this is for sorted skills result-->
<div id="sortedSkillsTableSorted" class="mt-4">
</div>

<!--this is for basic skills result-->
<div id="sortedSkillsTable" class="mt-4">
<table class="table table-striped mt-2 border">
    <thead>
        <tr>
            <th scope="col" class="align-middle">#</th>
            <th scope="col" class="align-middle" class="align-middle"> 
                    <span class="btn px-1 p-0 m-0 text-light" style="background-color: #303c54;" onclick="getSortedSkills()">
                        Name
                        <svg id="arrowkey" xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6"/>
                        </svg>
                    </span>
                </th>
            <th scope="col" class="align-middle">Date</th>
            <th scope="col" class="align-middle">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($skills as $skill)
            <tr>
                <th scope="row" class="align-middle">{{ $skill->id }}</th>
                <td class="align-middle"><a href="{{ route('admin.skills.show', $skill->id) }}" style="text-decoration: none;" >{{ $skill->name }} </a></td>
                <td class="align-middle">{{ $skill->created_at->diffForHumans() }}</td>
                <!--buttons-->
                <td class="align-middle">
                    <div style="display: flex;" class="d-flex">
                        @can('view', $skill)<a type="button" class="btn btn-primary m-1 d-flex justify-content-center " href="{{ route('admin.skills.show', $skill->id) }}" role="button">Show</a>@endcan
                        @can('update', $skill)<a type="button" class="btn btn-secondary m-1 d-flex justify-content-center " href="{{ route('admin.skills.edit', $skill->id) }}" role="button">Edit</a>@endcan
                        @can('delete', $skill)
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-trash-fill text-danger mt-2" viewBox="0 0 16 16"
                                    onclick="if (confirm('Are you sure?') == true) {
                                                        document.getElementById('delete-item-{{$skill->id}}').submit();
                                                        event.preventDefault();
                                                    } else {
                                                        return;
                                                    }
                                                    ">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                            </svg>
                        @endcan
                        <!-- for the delete -->
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
</div>

<script>
    var toggleNames = false;
    var lockNames = false;
    
    var toggleRoles = false;
    var lockRoles = false;
    
    function getSortedSkills(){
        $('#loading').show();
        if(!lockNames){
            $.ajax({
                url: "{{ route('admin.skills.getSortedSkills') }}",
                method: 'get',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function(output){
                    var result = $.parseJSON(output);
                    $('#searchedSkillsTable').hide();
                    $('#sortedSkillsTable').hide(); 
                    $('#sortedSkillsTableSorted').append(result[0]);
                    $('#sortedSkillsTableSorted').show();
                    toggleNames= false;
                    lockNames= true;  
                    $('#loading').hide();
                }
            });
        }else{
            if(!toggleNames){
                $('#sortedSkillsTableSorted').hide();
                $('#searchedSkillsTable').hide();
                $('#sortedSkillsTable').show();
                toggleNames = !toggleNames;
                $('#loading').hide();
            }else{
                $('#searchedSkillsTable').hide();
                $('#sortedSkillsTable').hide();
                $('#sortedSkillsTableSorted').show();
                toggleNames = !toggleNames;
                $('#loading').hide();
            }
        }
    }
</script>