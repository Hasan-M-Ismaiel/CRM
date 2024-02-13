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
                                    @if($user->getFirstMediaUrl("users"))
                                        <div class="media media-2x1 gd-primary"><a class="media-content" style='background-image:url("{{ $user->getFirstMediaUrl("users") }}")' data-abc="true"></a></div>
                                    @else
                                        <div class="media media-2x1 gd-primary"><a class="media-content" style="background-image:url('/images/avatar.png')" data-abc="true"></a></div>
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title col">{{ $user->name }}</h5>
                                        <span class="border-start border-3 border-primary ps-2 "> {{ $user->email }}</span> <span class="ms-3 badge bg-secondary"> {{ $user->getRoleNames()->get('0') }}</span>
                                        <br>
                                        <br>
                                        <span class="text-muted h6 col">Created at <time>{{ $user->created_at->diffForHumans() }}</time></span>
                                        <hr>
                                        <p class="card-text mt-2">
                                            <strong># of assigned projects:</strong> {{ $user->numberOfAssignedProjects }}
                                            <br /><strong># of assigned tasks:</strong> {{ $user->numberOfAssignedTasks }}
                                            <br /><strong># of completed projects:</strong> {{ $user->numberOfCompletededProjects }}
                                            <br /><strong>stars:</strong> 0 
                                        </p>
                                    </div>
                                    <div class="m-4">
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
