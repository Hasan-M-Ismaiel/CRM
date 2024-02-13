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
                                        <h5 class="card-title col">{{ $skill->name }}</h5>
                                    </div>
                                    <div class="m-4">
                                        @can('skill_edit')<a class="btn btn-primary" href="{{ route('admin.skills.edit', $skill) }}" role="button">Edit</a>@endcan
                                        @can('skill_edit')<a class="btn btn-danger m-1" type="button"
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
                                        <form id="delete-item" action="{{ route('admin.skills.destroy', $skill->id) }}" class="d-none" method="POST">
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
