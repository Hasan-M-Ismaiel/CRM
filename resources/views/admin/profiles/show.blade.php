@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="page-content page-container" id="page-content">
            <div class="container emp-profile">
                <div class="row"><!--add icons to this page-->
                    <div class="col-md-4">
                        <div class="profile-img">
                            @if(Auth::user()->profile && Auth::user()->profile->getFirstMediaUrl("profiles"))
                            <img src='{{ Auth::user()->profile->getFirstMediaUrl("profiles") }}' />
                            @elseif(Auth::user()->getFirstMediaUrl("users"))
                            <img class="avatar-img" src='{{ Auth::user()->getMedia("users")[0]->getUrl("thumb") }}' />
                            @else 
                            <img class="avatar-img" src="{{ asset('images/avatar.png') }}" />
                            @endif
                            <div class="file btn btn-lg btn-primary">
                                {{ $profile->user->name }}
                                <input type="file" name="file"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5>
                                        {{ $profile->nickname }}
                                    </h5>
                                    <h6>
                                        Web Developer and Designer
                                    </h6>
                                    <p><span class="proile-rating mr-3">RANKINGS : <span>8/10</span></span><span class="proile-rating">TOTLE PROJECTS : <span>20</span></span></p><br><br>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Address</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <a class="profile-edit-btn" href="{{ route('admin.profiles.edit', $profile) }}" style="text-decoration: none;" role="button">Edit Profile</a>
                        <a class="profile-edit-btn" type="button"
                                onclick="if (confirm('Are you sure?') == true) {
                                            document.getElementById('delete-item-{{$profile->id}}').submit();
                                            event.preventDefault();
                                        } else {
                                            return; alert();
                                        }
                                        ">
                            {{ __('Delete') }}
                        </a>
                        <!-- for the delete  -->
                        <form id="delete-item-{{$profile->id}}" action="{{ route('admin.profiles.destroy', $profile->id) }}" class="d-none" method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-work">
                            <p>IMPORTANT LINKS</p>
                            <a href="{{ url($profile->facebook_account) }}">facebook</a><br/>
                            <a href="{{ url($profile->linkedin_account) }}">linkedin</a><br/>
                            <a href="{{ url($profile->instagram_account) }}">instagram</a><br/>
                            <a href="{{ url($profile->twitter_account) }}">twitter</a><br/>
                            <a href="{{ url($profile->github_account) }}">github</a><br/>
                            <p>SKILLS</p>
                            @if($profile->user->skills()->count() > 0)
                            <div>
                            <strong>skills:</strong>
                                @foreach ($profile->user->skills as $skill)
                                    <span class="badge bg-dark m-1">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                            @else
                                #
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>User Id</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Kshiti123</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p> {{ $profile->user->name }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ $profile->user->email }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Phone</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ $profile->phone_number }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Gender</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ $profile->gender }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Description</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ $profile->description }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Profession</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Web Developer and Designer use here $profile->user->techniques / skills</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Experience</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Expert</p>
                                            </div>
                                        </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>City</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ $profile->city }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Country</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ $profile->country }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Postal code</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ $profile->postal_code}}</p>
                                            </div>
                                        </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Your Bio</label><br/>
                                        <p>chat with me</p>
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
