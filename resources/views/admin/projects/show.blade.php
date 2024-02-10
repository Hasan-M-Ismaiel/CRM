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
                                        <h5 class="card-title col">{{ $project->title }}</h5>
                                        <!--green | red -->
                                        <x-project-status :status="$project->status" />
                                        <span class="border-start border-3 border-primary ps-2 "> deadLine: {{ $project->deadline }}</span>
                                        @can('client_show')
                                        <br><strong>owner:</strong> <a href="{{ route('admin.clients.show', $project->client->id) }}" style="text-decoration: none;">{{ $project->client->name }} </a>@endcan
                                        <br>
                                        <hr>
                                        <span class="text-muted h6 col">Created at <time>{{ $project->created_at->diffForHumans() }}</time></span>
                                        <p class="card-text my-2">
                                            <strong>Project description:</strong> {{ $project->description }}
                                            <br>
                                            <span><strong>assigned users:</strong></span>
                                            @if($project->users()->count() > 0)
                                                @foreach ($project->users as $user)
                                                    <span><a href="{{ route('admin.users.show', $user->id) }}" style="text-decoration: none;">{{ $user->name }} @if(!$loop->last) <strong>|</strong> @endif </a></span>
                                                @endforeach
                                            @else
                                                <strong>no users assigned yet.</strong>
                                            @endif
                                            
                                            <br>
                                        </p>
                                    </div>
                                    <div class="ms-2">
                                        <!--staging task style (need approved)-->
                                        <div class="card mb-3 ms-1 border-start-5 border-warning" style="max-width: 600px;">
                                            <div class="row no-gutters">
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Card title</h5>
                                                        <p class="card-text">This is a wider card tent is a little bit longer.</p>
                                                        <hr>
                                                        @can('task_create')
                                                            <a class="btn btn-primary" 
                                                                href="{{ route('admin.tasks.create', ['addTaskToProject'=> $project->id, 'projectTitle'=> $project->title ]) }}" 
                                                                role="button">alter user</a>@endcan
                                                        @can('task_create')
                                                            <a class="btn btn-primary" 
                                                                href="{{ route('admin.tasks.create', ['addTaskToProject'=> $project->id, 'projectTitle'=> $project->title ]) }}" 
                                                                role="button">mark as complete</a>@endcan
                                                        @can('task_create')
                                                            <a class="btn btn-primary" 
                                                                href="{{ route('admin.tasks.create', ['addTaskToProject'=> $project->id, 'projectTitle'=> $project->title ]) }}" 
                                                                role="button">details</a>@endcan
                                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-4">
                                                    <div class="card-text"><small class="text-muted">taken By user Hasan</small></div>
                                                    <div class="card-text"><small class="text-muted">started at 3 mins ago</small></div>
                                                    <div class="card-text"><small class="text-muted">estimated time 3 mins ago</small></div>
                                                    <div class="card-text"><small class="text-muted">finished at 3 mins ago</small></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--finished task style-->
                                        <div class="card mb-3 ms-1 border-start-5 border-danger" style="max-width: 600px;">
                                            <div class="row no-gutters">
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Card title</h5>
                                                        <p class="card-text">This is a wider card tent is a little bit longer.</p>
                                                        <hr>
                                                        @can('task_create')
                                                            <a class="btn btn-primary disabled" 
                                                                href="{{ route('admin.tasks.create', ['addTaskToProject'=> $project->id, 'projectTitle'=> $project->title ]) }}" 
                                                                role="button">alter user</a>@endcan
                                                        @can('task_create')
                                                            <a class="btn btn-primary disabled" 
                                                                href="{{ route('admin.tasks.create', ['addTaskToProject'=> $project->id, 'projectTitle'=> $project->title ]) }}" 
                                                                role="button">mark as complete</a>@endcan
                                                        @can('task_create')
                                                            <a class="btn btn-primary" 
                                                                href="{{ route('admin.tasks.create', ['addTaskToProject'=> $project->id, 'projectTitle'=> $project->title ]) }}" 
                                                                role="button">details</a>@endcan
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-4">
                                                    <div class="card-text"><small class="text-muted">taken By user Hasan</small></div>
                                                    <div class="card-text"><small class="text-muted">started at 3 mins ago</small></div>
                                                    <div class="card-text"><small class="text-muted">estimated time 3 mins ago</small></div>
                                                    <div class="card-text"><small class="text-muted">finished at 3 mins ago</small></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--opened task style-->
                                        <div class="card mb-3 ms-1 border-start-5 border-success" style="max-width: 600px;">
                                            <div class="row no-gutters">
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Card title</h5>
                                                        <p class="card-text">This is a wider card tent is a little bit longer.</p>
                                                        <hr>
                                                        @can('task_create')
                                                            <a class="btn btn-primary" 
                                                                href="{{ route('admin.tasks.create', ['addTaskToProject'=> $project->id, 'projectTitle'=> $project->title ]) }}" 
                                                                role="button">alter user</a>@endcan
                                                        @can('task_create')
                                                            <a class="btn btn-primary" 
                                                                href="{{ route('admin.tasks.create', ['addTaskToProject'=> $project->id, 'projectTitle'=> $project->title ]) }}" 
                                                                role="button">mark as complete</a>@endcan
                                                        @can('task_create')
                                                            <a class="btn btn-primary" 
                                                                href="{{ route('admin.tasks.create', ['addTaskToProject'=> $project->id, 'projectTitle'=> $project->title ]) }}" 
                                                                role="button">details</a>@endcan
                                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-4">
                                                    <div class="card-text"><small class="text-muted">taken By user Hasan</small></div>
                                                    <div class="card-text"><small class="text-muted">started at 3 mins ago</small></div>
                                                    <div class="card-text"><small class="text-muted">estimated time 3 mins ago</small></div>
                                                    <div class="card-text"><small class="text-muted">finished at 3 mins ago</small></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--hanged task style-->
                                        <div class="card mb-3 ms-1 border-start-5 border-secondary" style="max-width: 600px;">
                                            <div class="row no-gutters">
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Card title</h5>
                                                        <p class="card-text">This is a wider card tent is a little bit longer.</p>
                                                        <hr>
                                                        @can('task_create')
                                                            <a class="btn btn-primary" 
                                                                href="{{ route('admin.tasks.create', ['addTaskToProject'=> $project->id, 'projectTitle'=> $project->title ]) }}" 
                                                                role="button">alter user</a>@endcan
                                                        @can('task_create')
                                                            <a class="btn btn-primary" 
                                                                href="{{ route('admin.tasks.create', ['addTaskToProject'=> $project->id, 'projectTitle'=> $project->title ]) }}" 
                                                                role="button">mark as complete</a>@endcan
                                                        @can('task_create')
                                                            <a class="btn btn-primary" 
                                                                href="{{ route('admin.tasks.create', ['addTaskToProject'=> $project->id, 'projectTitle'=> $project->title ]) }}" 
                                                                role="button">details</a>@endcan
                                                                        
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mt-4">
                                                    <div class="card-text"><small class="text-muted">taken By user Hasan</small></div>
                                                    <div class="card-text"><small class="text-muted">started at 3 mins ago</small></div>
                                                    <div class="card-text"><small class="text-muted">estimated time 3 mins ago</small></div>
                                                    <div class="card-text"><small class="text-muted">finished at 3 mins ago</small></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--buttons-->
                                    <div class="m-4">
                                        @can('task_create')
                                            <a class="btn btn-primary" 
                                                href="{{ route('admin.tasks.create', ['addTaskToProject'=> $project->id, 'projectTitle'=> $project->title ]) }}" 
                                                role="button">add tasks</a>@endcan
                                        @can('assign_project_to_user')
                                            <a type="button" 
                                                href="{{ route('admin.projects.assignCreate', $project->id) }}" 
                                                role="button" 
                                                @if($project->status)  
                                                    class="btn btn-primary disabled" 
                                                    @else 
                                                    class="btn btn-primary"  
                                                @endif>Assign</a>@endcan
                                        @can('project_edit')
                                            <a class="btn btn-primary" 
                                                href="{{ route('admin.projects.edit', $project) }}" 
                                                role="button">edit</a>@endcan
                                        @can('project_delete')
                                            <a class="btn btn-danger m-1" type="button"
                                                onclick="if (confirm('Are you sure?') == true) {
                                                            document.getElementById('delete-item-{{$project->id}}').submit();
                                                            event.preventDefault();
                                                        } else {
                                                            return;
                                                        }
                                                        ">{{ __('delete') }}</a>@endcan
                                        <!-- for the delete  -->
                                        <form id="delete-item-{{$project->id}}" action="{{ route('admin.projects.destroy', $project->id) }}" class="d-none" method="POST">
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
