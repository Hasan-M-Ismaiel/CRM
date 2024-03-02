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
            <th scope="col" class="align-middle" id="pcreateProject">#</th>
            <th scope="col" class="align-middle" id="pcreateProject"> 
                    <span class="btn px-1 p-0 m-0 text-light" style="background-color: #303c54;" onclick="getSortedSkills()">
                        Name
                        <svg id="arrowkey" xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-arrow-bar-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M1 3.5a.5.5 0 0 1 .5-.5h13a.5.5 0 0 1 0 1h-13a.5.5 0 0 1-.5-.5M8 6a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 0 1 .708-.708L7.5 12.293V6.5A.5.5 0 0 1 8 6"/>
                        </svg>
                    </span>
                </th>
            <th scope="col" class="align-middle" id="pcreateProject">Date</th>
            <th scope="col" class="align-middle" id="pcreateProject">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($skills as $skill)
            <tr>
                <!--skill id-->
                <th scope="row" class="align-middle">{{ $skill->id }}</th>
                <!--skill name-->
                <td class="align-middle"><a href="{{ route('admin.skills.show', $skill->id) }}" style="text-decoration: none;" >{{ $skill->name }} </a></td>
                <!--skill created_at-->
                <td class="align-middle">{{ $skill->created_at->diffForHumans() }}</td>
                <!--controll buttons-->
                <td class="align-middle">
                    <div style="display: flex;" class="d-flex">
                        @can('view', $skill)
                            <a type="button" class="m-1 d-flex justify-content-center" href="{{ route('admin.skills.show', $skill->id) }}"data-bs-toggle="tooltip" data-bs-placement="top" title="show">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                                </svg>
                            </a>
                        @endcan
                        @can('update', $skill)
                            <a type="button" class="m-1 d-flex justify-content-center " href="{{ route('admin.skills.edit', $skill->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                </svg>
                            </a>
                        @endcan
                        @can('delete', $skill)
                        <a type="button" class="m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="delete" data-bs-toggle="tooltip" data-bs-placement="top" title="delete">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill text-danger" viewBox="0 0 16 16"
                                    onclick="if (confirm('Are you sure?') == true) {
                                                        document.getElementById('delete-item-{{$skill->id}}').submit();
                                                        event.preventDefault();
                                                    } else {
                                                        return;
                                                    }
                                                    ">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                            </svg>
                        </a>
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