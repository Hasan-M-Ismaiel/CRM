@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
      <div class="card">
        <h2 class="card-title mt-4 mb-4">{{ $page }}</h2>
        @can('project_create')
        <a type="button" class="action-main-create-button rounded" href="{{ route('admin.projects.create') }}" style="text-decoration: none;" role="button"><div  class="action-main-create-button px-5 text-center py-3 rounded">Create Project</div></a>
        @endcan
        @if($projects->count()>0)
          <x-projects-table :projects="$projects"  />
        @else 
          <strong> There is no projects assigned to you </strong>
          <hr>
        @endif
      </div>
  </div>
</div>
@endsection

