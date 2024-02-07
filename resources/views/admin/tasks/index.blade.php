@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
      <div class="card">
        <h2 class="card-title mt-4 mb-4">{{ $page }}</h2>
        <a type="button" class="btn btn-success m-1" href="{{ route('admin.tasks.create') }}" role="button">Create Task</a>
        <x-tasks-table :tasks="$tasks"  />
      </div>
  </div>
</div>
@endsection

