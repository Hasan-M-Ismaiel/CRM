@extends('layouts.app')

@section('content')
 
<div class="container mb-3">
    <div class="row justify-content-center">
        <div class="card p-5">
            <div class="container-fluid border my-3  ">
                <div class="row justify-content-center">
                    <div class="card-create-project pt-4 my-3 mx-5 px-5">
                        <h2 id="heading">creating project</h2>
                        <p id="pcreateProject">Fill all form field to go to next step</p>
                        <form id="msform" action='{{ route("admin.projects.store") }}' method="POST">
                            @csrf
                            <!-- progressbar -->
                            <ul id="progressbar-create-project">
                                <li class="active li-create-project" id="account"><strong>Description</strong></li>
                                <li class="li-create-project active" id="personal"><strong>Add Skills</strong></li>
                                <li class="li-create-project active" id="payment"><strong>Add users</strong></li>
                                <li class="li-create-project active" id="confirm"><strong>Finish</strong></li>
                            </ul>
                            <div class="progress-create-project">
                                <div class="progress-bar-create-project progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <br>
                            <!-- fieldsets -->
                            <!--stage four-->
                            <fieldset class="active">
                                <div class="form-card">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="fs-title">Finish:</h2>
                                        </div>
                                        <div class="col-5">
                                            <h2 class="steps">Step 4 - 4</h2>
                                        </div>
                                    </div>
                                    <br><br>
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
                                            <h5 class="purple-text text-center">Project has been created successfully</h5>
                                            <h5 class="purple-text text-center">Add Tasks to this project click <a href="{{route('admin.taskGroups.create', ['projectId' => $project])}}" >here</a>, or go <a href="{{route('admin.projects.index')}}" >home</a></h5>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>

@endsection
