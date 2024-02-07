@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
      <div class="card mb-3">
        <h2 class="card-title mt-4 mb-4">{{ $page }}</h2>
        <a type="button" class="btn btn-success m-1" href="{{ route('admin.users.create') }}" role="button">Create User</a>
        <x-users-table :users="$users"  />
      </div>
  </div>
</div>
@endsection

