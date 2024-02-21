@extends('layouts.app')

@section('content')
<div class="card p-5">
  <div class="container-fluid border my-3  ">
      <div class="row justify-content-center">
          <div class="card-create-project pt-4 my-3 mx-5 px-5">
            <h2 id="heading">{{ $page }}</h2>
            <p id="pcreateProject">dashboard to manage all created</p>
              @can('project_create')
              <a type="button" class="rounded" href="{{ route('admin.projects.create') }}" style="text-decoration: none;" role="button"><div  class="action-main-create-button px-5 text-center py-3 rounded">Create New Project</div></a>
              @endcan
          </div>
        </div>
    </div>
</div>
@if($projects->count()>0)
  <x-projects-table :projects="$projects"  />
  @else 
    <strong> There is no projects assigned to you </strong>
    <hr>
  @endif
@endsection

