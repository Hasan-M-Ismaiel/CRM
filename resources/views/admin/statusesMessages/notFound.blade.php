@extends('layouts.app')

@section('content')
 
<div class="container mb-3">
    <div class="row justify-content-center">
        <div class="card p-5">
            <div class="container-fluid border my-3  ">
                <div class="row justify-content-center">
                    <div class="card-create-project pt-4 my-3 mx-5 px-5">
                        <h2 id="heading">Status Message</h2>
                        <p id="pcreateProject">status about your request</p>
                        <ul id="progressbar-create-project">
                            
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
                                        <!-- <h2 class="fs-title">Finish:</h2> -->
                                    </div>
                                    <div class="col-5">
                                        <!-- <h2 class="steps">Step 4 - 4</h2> -->
                                    </div>
                                </div>
                                <br><br>
                                <h2 class="purple-text text-center"><strong>NOT FOUND !</strong></h2>
                                <br>
                                <div class="row justify-content-center">
                                    <div class="col-3">
                                        <img src="{{ asset('assets/gifs/notFound.gif') }}" class="fit-image">
                                    </div>
                                </div>
                                <br><br>
                                <div class="row justify-content-center">
                                    <div class="col-7 text-center">
                                        <h5 class="purple-text text-center">The user you are trying to access does not have a profile yet.</h5>
                                        <h5 class="purple-text text-center">if you have one this is cool, but if you don't you can make one <a href="{{route('admin.profiles.create')}}" >here</a></h5>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>

@endsection
