@extends('layouts.app')

@section('content')
<div class="card p-5">
  <div class="container-fluid border my-3  ">
      <div class="row justify-content-center">
          <div class="card-create-project pt-4 my-3 mx-5 px-5">
            <h2 id="heading">{{ $page }}</h2>
            <p id="pcreateProject">dashboard to manage all created</p>
            @can('task_create')
            <a type="button" class="rounded" href="{{ route('admin.tasks.create') }}" style="text-decoration: none;" role="button"><div  class="action-main-create-button px-5 text-center py-3 rounded">Create New Task</div></a>
            @endcan
          </div>
        </div>
        @if ($tasks->count()>0)
          <x-tasks-table :tasks="$tasks"  />
          @else 
            <span class="text-center mb-5" style="color: #673AB7;"> <strong><h4> There is no tasks yet <span> &#128513;</span></h4></strong></span>
        @endif
    </div>
</div>
@endsection

