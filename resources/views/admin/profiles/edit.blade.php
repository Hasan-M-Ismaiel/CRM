@extends('layouts.app')

@section('content')
 
<div class="container mb-3">
    <div class="row justify-content-center">
        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="mb-4 mt-4">
                <span class="pt-2 pb-2 pr-3 font-medium text-danger border border-danger border-rounded rounded">
                    <span class="bg-danger py-2 px-2  text-white">Whoops!</span>{{ __(' Something went wrong.') }}
                </span>

                <ul class="mt-3 list-group list-group-flush text-danger">
                    @foreach ($errors->all() as $error)
                        <li class="list-group-item text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <h2 class="card-title mb-4">{{ $page }}</h2>
                <form class="row g-3" action='{{ route("admin.profiles.update", $profile) }}' method="POST">
                    @csrf
                    @method('PATCH')
                        <div class="col-md-6">
                            <label for="nickname">Nickname</label>
                            <input type="text" name="nickname" class="form-control" id="nickname" placeholder="add the nickname of the profile" value="{{ $profile->nickname }}">
                        </div>
                        <div class="col-md-6">
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender" class="form-select form-select mb-3">
                                @if($profile->gender == "male")
                                    <option value="male" selected>male</option>
                                    <option value="female" >female</option>
                                @else
                                    <option value="female" selected>female</option>
                                    <option value="male" >male</option> 
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="age">Age</label>
                            <select class="form-select form-select mb-3" name="age" aria-label=".form-select-lg example">
                                <option value="{{$profile->age}}" selected>{{$profile->age}}</option>
                                @for ($i = 18; $i <= 41; $i++)
                                    @if ($profile->age != $i)
                                        <option value="{{$i}}">{{ $i }}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="phone_number">Phone number</label>
                            <input type="text" name="phone_number" class="form-control" id="phone_number" placeholder="add the phone_number of the profile" value="{{ $profile->phone_number }}">
                        </div>
                        <div class="col-md-6">
                            <label for="city">City</label>
                            <input type="text" name="city" class="form-control" id="city" placeholder="add the city of the profile" value="{{ $profile->city }}">
                        </div>
                        <div class="col-md-6">
                            <label for="country">Country</label>
                            <input type="text" name="country" class="form-control" id="country" placeholder="add the country of the profile" value="{{ $profile->country }}">
                        </div>
                        <div class="col-md-12">
                            <label for="postal_code">Postal</label>
                            <input type="text" name="postal_code" class="form-control" id="postal_code" placeholder="add the postal of the profile" value="{{ $profile->postal_code }}">
                        </div>
                        <div class="col-md-6">
                            <label for="facebook_account" class="form-label">facebook account</label>
                            <span class="input-group-text" id="facebook_addon3">https://facebook.com/</span>
                            <input type="text" class="form-control" name="facebook_account" id="facebook_account" aria-describedby="facebook_addon3" value="{{$profile->facebook_account}}">
                        </div>
                        <div class="col-md-6">
                            <label for="linkedin_account" class="form-label">linkedin account</label>
                            <span class="input-group-text" id="linkedin_addon3">https://linkedin.com/</span>
                            <input type="text" class="form-control" name="linkedin_account" id="linkedin_account" aria-describedby="linkedin_addon3" value="{{$profile->linkedin_account}}">
                        </div>
                        <div class="col-md-6">
                            <label for="github_account" class="form-label">github account</label>
                            <span class="input-group-text" id="github_addon3">https://github.com/</span>
                            <input type="text" class="form-control" name="github_account" id="github_account" aria-describedby="github_addon3" value="{{$profile->github_account}}">
                        </div>
                        <div class="col-md-6">
                            <label for="instagram_account" class="form-label">instagram account</label>
                            <span class="input-group-text" id="instagram_addon3">https://instagram.com/</span>
                            <input type="text" class="form-control" name="instagram_account" id="instagram_account" aria-describedby="instagram_addon3" value="{{$profile->instagram_account}}">
                        </div>
                        <div class="col-md-12">
                            <label for="twitter_account" class="form-label">twitter account</label>
                            <span class="input-group-text" id="twitter_addon3">https://twitter.com/</span>
                            <input type="text" class="form-control" name="twitter_account" id="twitter_account" aria-describedby="twitter_addon3" value="{{$profile->twitter_account}}">
                        </div>
                        <div class="col-md-12">
                            <label for="description">Descripe your self</label>
                            <textarea id="description" name="description" class="form-control" aria-label="With textarea">{{$profile->description}}</textarea>
                        </div>
                        <!--image-->
                        <div class="col-md-6">
                            <input id="image" name="image" class="form-control" type="file">  
                        </div>
                        <!-- select avatar -->
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                        Select Avatar
                                    </button>
                                </div>
                                <div class="col-6 text-right">
                                    @if(Auth::user()->profile && Auth::user()->profile->getFirstMediaUrl("profiles"))
                                        <div  class="avatar avatar-md" data-bs-toggle="modal" data-bs-target="#myModal"><img class="avatar-img" id="image_thumb" src='{{ Auth::user()->profile->getFirstMediaUrl("profiles") }}' alt="user@email.com" /></div>
                                    @elseif(Auth::user()->getFirstMediaUrl("users"))
                                        <div  class="avatar avatar-md" data-bs-toggle="modal" data-bs-target="#myModal"><img class="avatar-img" id="image_thumb" src='{{ Auth::user()->getMedia("users")[0]->getUrl("thumb") }}' alt="user@email.com" /></div>
                                    @else 
                                        <div  class="avatar avatar-md" data-bs-toggle="modal" data-bs-target="#myModal"><img class="avatar-img" id="image_thumb" src="{{ asset('images/avatar.png') }}" alt="user@email.com"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- The Modal -->
                        <div class="modal fade" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h4 class="modal-title">Choose an Avatar</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="modal-body row g-3 ">
                                        <div class="row">
                                            <div class="col-6 text-center">
                                                <div type="button" data-bs-dismiss="modal" onclick='document.getElementById("avatar_image").value="1"; document.getElementById("image_thumb").src="{{ asset('assets/avatars_basic/1.jpg') }}";'>
                                                    <img src="{{ asset('assets/avatars_basic/1.jpg') }}" alt="here is here" width="125" height="125">
                                                </div>
                                            </div>
                                            <div class="col-6 text-center">
                                                <div type="button" data-bs-dismiss="modal" onclick='document.getElementById("avatar_image").value="2"; document.getElementById("image_thumb").src="{{ asset('assets/avatars_basic/2.jpg') }}";'>
                                                    <img src="{{ asset('assets/avatars_basic/2.jpg') }}" alt="here is here" width="125" height="125">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 text-center">
                                                <div type="button" data-bs-dismiss="modal" onclick='document.getElementById("avatar_image").value="3"; document.getElementById("image_thumb").src="{{ asset('assets/avatars_basic/3.jpg') }}";'>
                                                    <img src="{{ asset('assets/avatars_basic/3.jpg') }}" alt="here is here" width="125" height="125">
                                                </div>
                                            </div>
                                            <div class="col-6 text-center">
                                                <div type="button" data-bs-dismiss="modal" onclick='document.getElementById("avatar_image").value="4"; document.getElementById("image_thumb").src="{{ asset('assets/avatars_basic/4.jpg') }}";'>
                                                    <img src="{{ asset('assets/avatars_basic/4.jpg') }}" alt="here is here" width="125" height="125">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 text-center">
                                                <div type="button" data-bs-dismiss="modal" onclick='document.getElementById("avatar_image").value="5"; document.getElementById("image_thumb").src="{{ asset('assets/avatars_basic/5.jpg') }}";'>
                                                    <img src="{{ asset('assets/avatars_basic/5.jpg') }}" alt="here is here" width="125" height="125">
                                                </div>
                                            </div>
                                            <div class="col-6 text-center">
                                                <div type="button" data-bs-dismiss="modal" onclick='document.getElementById("avatar_image").value="6"; document.getElementById("image_thumb").src="{{ asset('assets/avatars_basic/6.jpg') }}";'>
                                                    <img src="{{ asset('assets/avatars_basic/6.jpg') }}" alt="here is here" width="125" height="125">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 text-center">
                                                <div type="button" data-bs-dismiss="modal" onclick='document.getElementById("avatar_image").value="7"; document.getElementById("image_thumb").src="{{ asset('assets/avatars_basic/7.jpg') }}";'>
                                                    <img src="{{ asset('assets/avatars_basic/7.jpg') }}" alt="here is here" width="125" height="125">
                                                </div>
                                            </div>
                                            <div class="col-6 text-center">
                                                <div type="button" data-bs-dismiss="modal" onclick='document.getElementById("avatar_image").value="8"; document.getElementById("image_thumb").src="{{ asset('assets/avatars_basic/8.jpg') }}";'>
                                                    <img src="{{ asset('assets/avatars_basic/8.jpg') }}" alt="here is here" width="125" height="125">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- hidden input -->
                        <div class="col-md-6">
                            <input id="avatar_image" name="avatar_image" class="form-control" type="text" hidden>  
                        </div>
                    <button type="submit" class="btn btn-primary mt-5">Update</button>
                </form>
            </div>
        </div> 
    </div>
</div>
@endsection
