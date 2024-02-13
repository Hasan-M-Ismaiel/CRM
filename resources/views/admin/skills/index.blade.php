@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
      <div class="card">
        <h2 class="card-title mt-4 mb-4">{{ $page }}</h2>
        <a type="button" class="btn btn-success m-1" href="{{ route('admin.skills.create') }}" role="button">Create skill</a>
        <x-skills-table :skills="$skills"  />
      </div>
  </div>
</div>
@endsection

