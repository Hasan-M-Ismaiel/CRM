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
            <div class="container border  my-3  ">
                <div class="row justify-content-center">
                    <div class="card-body pt-4 my-3 mx-3 px-3">
                        <h2 id="heading">{{ $page }}</h2>
                        <p id="pcreateProject">create your profile</p>
                        <form class="row g-3" action='{{ route("admin.profiles.store") }}' method="POST" enctype="multipart/form-data">
                            @csrf
                            <!--basic information-->
                            <div class="row border-bottom p-4 rounded mx-3 my-2 ">
                                <div class="col-md-6">
                                    <label for="nickname"><strong>Nickname</strong></label>
                                    <input type="text" name="nickname" class="form-control" id="nickname" placeholder="add the nickname of the profile" value="{{ old('nickname') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="gender"><strong>Gender</strong></label>
                                    <select name="gender" id="gender" class="form-select form-select mb-3">
                                        <option value="" selected>Choose Gender...</option>
                                        <option value="male" >male</option>   <!-- 1 male, 0 female-->
                                        <option value="female" >female</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="age"><strong>Age</strong></label>
                                    <select class="form-select form-select mb-3" name="age" aria-label=".form-select-lg example">
                                        @for ($i = 18; $i <= 41; $i++)
                                            <option value="{{$i}}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone_number"><strong>Phone number</strong></label>
                                    <input type="text" name="phone_number" class="form-control" id="phone_number" placeholder="add the phone_number of the profile" value="{{ old('phone_number') }}">
                                </div>
                            </div>
                            <!--location-->
                            <div class="row border-bottom p-4 rounded mx-3 my-2 ">
                                <div class="col-md-6">
                                    <label for="city"><strong>City</strong></label>
                                    <input type="text" name="city" class="form-control" id="city" placeholder="add the city of the profile" value="{{ old('city') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="country"><strong>Country</strong></label>
                                    <input type="text" name="country" class="form-control" id="country" placeholder="add the country of the profile" value="{{ old('country') }}">
                                </div>
                                <div class="col-md-6 mt-2">
                                    <label for="postal_code"><strong>Postal</strong></label>
                                    <input type="text" name="postal_code" class="form-control" id="postal_code" placeholder="add the postal of the profile" value="{{ old('postal_code') }}">
                                </div>
                            </div>
                            <!--social media accounts-->
                            <div class="row border-bottom p-4 rounded mx-3 my-2 ">
                                <div class="col-md-6 my-2">
                                    <div class="row">
                                        <div class="col-1 mt-2">
                                            <label for="facebook_account" class="form-label">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
                                                </svg>
                                            </label>
                                        </div>
                                        <div class="col-11">
                                            <input type="text" class="form-control" name="facebook_account" id="facebook_account" aria-describedby="facebook_addon3">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="row">
                                        <div class="col-1 mt-2">
                                            <label for="linkedin_account" class="form-label">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                                                    <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z"/>
                                                </svg>
                                            </label>
                                        </div>
                                        <div class="col-11">
                                            <input type="text" class="form-control" name="linkedin_account" id="linkedin_account" aria-describedby="linkedin_addon3">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="row">
                                        <div class="col-1 mt-2">
                                            <label for="github_account" class="form-label">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-github" viewBox="0 0 16 16">
                                                    <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27s1.36.09 2 .27c1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.01 8.01 0 0 0 16 8c0-4.42-3.58-8-8-8"/>
                                                </svg>
                                            </label>
                                        </div>
                                        <div class="col-11">
                                            <input type="text" class="form-control" name="github_account" id="github_account" aria-describedby="github_addon3">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 my-2">
                                    <div class="row">
                                        <div class="col-1 mt-2">
                                            <label for="instagram_account" class="form-label">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                                    <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                                                </svg>
                                            </label>
                                        </div>
                                        <div class="col-11">
                                            <input type="text" class="form-control" name="instagram_account" id="instagram_account" aria-describedby="instagram_addon3">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-1 mt-2">
                                            <label for="twitter_account" class="form-label">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                                                    <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
                                                </svg>
                                            </label>
                                        </div>
                                        <div class="col-11">
                                            <input type="text" class="form-control" name="twitter_account" id="twitter_account" aria-describedby="twitter_addon3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--descripe your self-->
                            <div class="row border-bottom p-4 rounded mx-3 my-2 ">
                                <!--profession-->
                                <div class="col-md-12">
                                    <label for="profession"><strong>Profession</strong></label>
                                    <input type="text" name="profession" class="form-control" id="profession" placeholder="add the profession of the profile" value="{{ old('profession') }}">
                                </div>
                                <div class="col-md-12">
                                    <label for="description"><strong>Descripe your self</strong></label>
                                    <textarea id="description" name="description" class="form-control" aria-label="With textarea" value="{{ old('description') }}"></textarea>
                                </div>
                            </div>
                            <!--select avatar-->
                            <div class="">
                                <div class="col-md-12">
                                    <input id="image" name="image" class="form-control" type="file">  
                                </div>
                                <br>
                                <br>
                                <br>
                                <!--image-->
                                <!-- select avatar -->
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-11 text-right">
                                            <strong>Or</strong>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                                <strong>Select Avatar</strong>
                                            </button>
                                        </div>
                                        <div class="col-1 text-left">
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
                                                <h4 class="modal-title"><strong>Choose an Avatar</strong></h4>
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
                            </div>
                            <x-forms.create-button />
                        </form>
                    </div>
                </div> 
            </div>
        </div>
@endsection
