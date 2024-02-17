@extends('layouts.app')

@section('content')
 
<div class="container mb-3">
    <div class="row justify-content-center">
        <div class="card p-5">
            <div class="container-fluid border my-3  ">
                <div class="row justify-content-center">
                    <div class="card-create-project pt-4 my-3 mx-5 px-5">
                        <h2 id="heading">creating task</h2>
                        <h2 class="purple-text text-center"><strong>SUCCESS !</strong></h2>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-3">
                                <img src="{{ asset('images/success.png') }}" class="fit-image">
                            </div>
                        </div>
                        <br><br>
                        <div class="row justify-content-center">
                            <div class="col-7 text-center">
                                <h5 class="purple-text text-center">tasks has been created successfully</h5>
                                <h5 class="purple-text text-center">Add Tasks another tasks to this project click <a href="{{route('admin.taskGroups.create', ['projectId' => $project])}}" >here</a>, or go <a href="{{route('admin.projects.index')}}" >home</a></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>

@endsection
