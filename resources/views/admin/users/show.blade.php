@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="page-content page-container" id="page-content">
                    <div class="padding">
                        <div class="row">
                            <div class="col">
                                <div class="card">
                                    <div class="card-body">
                                        <!--user name & role & date creating-->
                                        <div class="row">
                                            <div class="col-6 ">
                                                <h5 class="card-title col">{{ $user->name }}</h5>
                                                <x-user-badges :user="$user" />
                                                <span class="ms-3 badge bg-secondary me-3"> {{ $user->getRoleNames()->get('0') }}</span><span class="border-start border-3 border-primary ps-2 "> {{ $user->email }}</span> 
                                                <br>
                                                <span class="text-muted h6 col">Created at <time>{{ $user->created_at->diffForHumans() }}</time></span>
                                            </div>
                                            
                                            <div class="col-6 text-right pe-5 pt-2">
                                                @if($user->profile && $user->profile->getFirstMediaUrl("profiles"))
                                                <div class="avatar avatar-md">
                                                    <img src='{{ $user->profile->getFirstMediaUrl("profiles") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                                </div>
                                                <!--stars-->
                                                <div>
                                                    <span class="x-star-card">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16" >
                                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16" >
                                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16" >
                                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16" >
                                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                                @elseif($user->getFirstMediaUrl("users"))
                                                <div class="avatar avatar-md">
                                                    <img src='{{ $user->getMedia("users")[0]->getUrl("thumb") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                                </div>
                                                <!--stars-->
                                                <div>
                                                    <span class="x-star-card">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16" >
                                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16" >
                                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16" >
                                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                                @else
                                                <div class="avatar avatar-md">
                                                    <img src='{{ asset("images/avatar.png") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                                </div>
                                                <!--stars-->
                                                <div>
                                                    <!--stars-->
                                                    <span class="x-star-card">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16" >
                                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16" >
                                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16" >
                                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                                                        </svg>
                                                    </span>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        <!--line-->
                                        <hr class="mt-4">
                                        <!--information-->
                                        <table class="table project-list-table table-nowrap align-middle table-borderless">
                                            <tbody>
                                                <tr>
                                                    <td><span class="badge badge-soft-success mb-0">skills</span></td>
                                                    <td>
                                                    @if($user->skills()->count() > 0)
                                                        @foreach ($user->skills as $skill)
                                                            <span class="badge m-1" style="background: #673AB7;">{{ $skill->name }}</span>
                                                        @endforeach
                                                    @else   
                                                        <h6 class="text-secondary">There is no skills for this user</h6>
                                                    @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="badge badge-soft-success mb-0"># of assigned projects</span></td>
                                                    <td>
                                                        <span class="badge m-1" style="background: #673AB7;">{{ $user->numberOfAssignedProjects }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="badge badge-soft-success mb-0"># of assigned tasks:</span></td>
                                                    <td>
                                                        <span class="badge m-1" style="background: #673AB7;">{{ $user->numberOfAssignedTasks }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="badge badge-soft-success mb-0"># of finished tasks:</span></td>
                                                    <td>
                                                        <span class="badge m-1" style="background: #673AB7;">{{ $user->numberOfClosedTasks }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><span class="badge badge-soft-success mb-0"># of completed projects:</span></td>
                                                    <td>
                                                        <span class="badge m-1" style="background: #673AB7;">{{ $user->numberOfCompletedProjects }}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!--buttons-->
                                    <div class="m-4 position-relative">
                                        @if($user->profile)
                                            <a class="btn btn-primary" href="{{ route('admin.profiles.show', $user->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="show profile">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0"/>
                                                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7"/>
                                                </svg>
                                            </a>
                                        @else
                                            <a href="{{ route('admin.statuses.notFound') }}" style="text-decoration: none;">
                                        @endif
                                        <!--edit-->
                                        @can('user_edit')
                                            <a class="btn btn-primary" href="{{ route('admin.users.edit', $user) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                </svg>
                                            </a>
                                        @endcan
                                        
                                        <!--delete-->
                                        @can('user_delete')
                                            <a type="button" class="m-1" data-bs-toggle="tooltip" data-bs-placement="top" title="delete" data-bs-toggle="tooltip" data-bs-placement="top" title="delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash-fill text-danger mt-2 position-absolute top-0 end-0" viewBox="0 0 16 16"
                                                    onclick="if (confirm('Are you sure?') == true) {
                                                                        document.getElementById('delete-item').submit();
                                                                        event.preventDefault();
                                                                    } else {
                                                                        return;
                                                                    }
                                                                    ">
                                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                                </svg>
                                            </a>
                                        @endcan
                                        <!-- for the delete  -->
                                        <form id="delete-item" action="{{ route('admin.users.destroy', $user->id) }}" class="d-none" method="POST">
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
    </div>
</div>
@endsection
