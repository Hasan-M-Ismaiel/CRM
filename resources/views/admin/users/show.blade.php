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
                                        <div class="cardParentEditClass">
                                            @if($user->profile && $user->profile->getFirstMediaUrl("profiles"))
                                                <img
                                                src='{{ $user->profile->getFirstMediaUrl("profiles") }}'
                                                alt="DP"  class="  rounded-circle img-fluid  border border-success shadow mb-1 x-project-card" width="50" height="50">
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
                                            @elseif($user->getFirstMediaUrl("users"))
                                            <img
                                                src='{{ $user->getMedia("users")[0]->getUrl("thumb") }}'
                                                alt="DP"  class="  rounded-circle img-fluid border border-success shadow mb-1 x-project-card" width="50" height="50">
                                            @else
                                            <img
                                                src='{{ asset("images/avatar.png") }}'
                                                alt="DP"  class="  rounded-circle img-fluid border border-success shadow mb-1 x-project-card" width="50" height="50">
                                            @endif
                                        </div>
                                        <h5 class="card-title col">{{ $user->name }}</h5>
                                        <span class="ms-3 badge bg-secondary me-3"> {{ $user->getRoleNames()->get('0') }}</span><span class="border-start border-3 border-primary ps-2 "> {{ $user->email }}</span> 
                                        <br>
                                        <span class="text-muted h6 col">Created at <time>{{ $user->created_at->diffForHumans() }}</time></span>
                                        <hr class="mt-4">
                                        @if($user->skills()->count() > 0)
                                        <div>
                                        <strong>skills:</strong>
                                            @foreach ($user->skills as $skill)
                                                <span class="badge m-1" style="background: #673AB7;">{{ $skill->name }}</span>
                                            @endforeach
                                        </div>
                                        @else
                                            #
                                        @endif
                                        <p class="card-text mt-2">
                                            <strong># of assigned projects:</strong> {{ $user->numberOfAssignedProjects }}
                                            <br /><strong># of assigned tasks:</strong> {{ $user->numberOfAssignedTasks }}
                                            <br /><strong># of completed projects:</strong> {{ $user->numberOfCompletededProjects }}
                                        </p>
                                        
                                    </div>
                                    <div class="m-4">
                                        @if($user->profile)
                                            <!--add profile profile protection--><a class="btn btn-primary" href="{{ route('admin.profiles.show', $user->id) }}" role="button">Show profile</a>
                                        @else
                                            <a href="{{ route('admin.statuses.notFound') }}" style="text-decoration: none;">
                                        @endif
                                        @can('user_edit')<a class="btn btn-primary" href="{{ route('admin.users.edit', $user) }}" role="button">Edit</a>@endcan
                                        @can('user_delete')<a class="btn btn-danger m-1" type="button"
                                                onclick="if (confirm('Are you sure?') == true) {
                                                            document.getElementById('delete-item').submit();
                                                            event.preventDefault();
                                                        } else {
                                                            return;
                                                        }
                                                        ">
                                            {{ __('Delete') }}
                                        </a>@endcan
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
