@extends('layouts.app')

@section('content')
<div class="card p-5">
    <div class="row border">
    <!--header section-->
        <div class="col">
            <div class="container-fluid my-3  ">
                <div class="row justify-content-center">
                    <div class="card-create-project pt-4 my-3 mx-5 px-5">
                    <h2 id="heading">{{ $page }}</h2>
                    <p id="pcreateProject">show the skill information here</p>
                    <div class="card border-success">
                        <div class="card-body position-relative m-5">
                            <h5 class="card-title col mb-5"><strong>{{ $skill->name }}</strong></h5>
                            
                            <!--buttons-->
                            <div class=" position-absolute bottom-0 end-0">
                                @can('project_edit')<a class="btn btn-primary" href="{{ route('admin.skills.edit', $skill) }}" role="button">Edit</a>@endcan
                                @can('project_edit')
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-trash-fill text-danger mt-2" viewBox="0 0 16 16"
                                    onclick="if (confirm('Are you sure?') == true) {
                                                        document.getElementById('delete-item-{{$skill->id}}').submit();
                                                        event.preventDefault();
                                                    } else {
                                                        return;
                                                    }
                                                    ">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                </svg>@endcan
                                <!-- for the delete  -->
                                <form id="delete-item" action="{{ route('admin.skills.destroy', $skill->id) }}" class="d-none" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
