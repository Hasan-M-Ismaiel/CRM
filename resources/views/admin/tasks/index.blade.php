@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
      <div class="card">
        <h2 class="card-title mt-4 mb-4">{{ $page }}</h2>
        @can('task_create')<a type="button" class="btn btn-success m-1" href="{{ route('admin.tasks.create') }}" role="button">Create Task</a>@endcan
        @if ($tasks->count()>0)
          <x-tasks-table :tasks="$tasks"  />
          @else 
            <span class="text-center mb-5"> <strong><h4> There is no tasks yet <span> &#128513;</span></h4></strong></span>
        @endif
      </div>
  </div>
</div>
@endsection

