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
                <form class="row g-3" action='{{ route("admin.profiles.store") }}' method="POST">
                    @csrf
                        <div class="col-md-6">
                            <label for="nickname">Nickname</label>
                            <input type="text" name="nickname" class="form-control" id="nickname" placeholder="add the nickname of the profile" value="{{ old('nickname') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender" class="form-select form-select mb-3">
                                <option value="" selected>Choose Gender...</option>
                                <option value="male" >male</option>   <!-- 1 male, 0 female-->
                                <option value="female" >female</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="age">Age</label>
                            <select class="form-select form-select mb-3" name="age" aria-label=".form-select-lg example">
                                <option value="18">18</option>
                                <option value="19">19</option>
                                <option value="20">20</option>
                                <option value="21">21</option>
                                <option value="22">22</option>
                                <option value="23">23</option>
                                <option value="24">24</option>
                                <option value="25">25</option>
                                <option value="26">26</option>
                                <option value="27">27</option>
                                <option value="28">28</option>
                                <option value="29">29</option>
                                <option value="30">30</option>
                                <option value="31">31</option>
                                <option value="32">32</option>
                                <option value="33">33</option>
                                <option value="34">34</option>
                                <option value="35">35</option>
                                <option value="36">36</option>
                                <option value="37">37</option>
                                <option value="38">38</option>
                                <option value="39">39</option>
                                <option value="40">40</option>
                                <option value="41">41</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="phone_number">Phone number</label>
                            <input type="text" name="phone_number" class="form-control" id="phone_number" placeholder="add the phone_number of the profile" value="{{ old('phone_number') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="city">City</label>
                            <input type="text" name="city" class="form-control" id="city" placeholder="add the city of the profile" value="{{ old('city') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="country">Country</label>
                            <input type="text" name="country" class="form-control" id="country" placeholder="add the country of the profile" value="{{ old('country') }}">
                        </div>
                        <div class="col-md-12">
                            <label for="postal_code">Postal</label>
                            <input type="text" name="postal_code" class="form-control" id="postal_code" placeholder="add the postal of the profile" value="{{ old('postal_code') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="facebook_account" class="form-label">facebook account</label>
                            <span class="input-group-text" id="facebook_addon3">https://facebook.com/</span>
                            <input type="text" class="form-control" name="facebook_account" id="facebook_account" aria-describedby="facebook_addon3">
                        </div>
                        <div class="col-md-6">
                            <label for="linkedin_account" class="form-label">linkedin account</label>
                            <span class="input-group-text" id="linkedin_addon3">https://linkedin.com/</span>
                            <input type="text" class="form-control" name="linkedin_account" id="linkedin_account" aria-describedby="linkedin_addon3">
                        </div>
                        <div class="col-md-6">
                            <label for="github_account" class="form-label">github account</label>
                            <span class="input-group-text" id="github_addon3">https://github.com/</span>
                            <input type="text" class="form-control" name="github_account" id="github_account" aria-describedby="github_addon3">
                        </div>
                        <div class="col-md-6">
                            <label for="instagram_account" class="form-label">instagram account</label>
                            <span class="input-group-text" id="instagram_addon3">https://instagram.com/</span>
                            <input type="text" class="form-control" name="instagram_account" id="instagram_account" aria-describedby="instagram_addon3">
                        </div>
                        <div class="col-md-12">
                            <label for="twitter_account" class="form-label">twitter account</label>
                            <span class="input-group-text" id="twitter_addon3">https://twitter.com/</span>
                            <input type="text" class="form-control" name="twitter_account" id="twitter_account" aria-describedby="twitter_addon3">
                        </div>
                        <div class="col-md-12">
                            <label for="description">Descripe your self</label>
                            <textarea id="description" name="description" class="form-control" aria-label="With textarea"></textarea>
                        </div>
                        <!--image-->
                        <div class="col-md-6">
                            <input id="image" name="image" class="form-control" type="file">  
                        </div>
                        <!-- select avatar -->
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Select Avatar
                            </button>
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
                                                <div type="button" data-bs-dismiss="modal" onclick='document.getElementById("avatar_image").value="1"; alert("the avatar has been selected");'>
                                                    <img src="{{ asset('assets/avatars_basic/1.jpg') }}" alt="here is here" width="125" height="125">
                                                </div>
                                            </div>
                                            <div class="col-6 text-center">
                                                <div type="button" data-bs-dismiss="modal" onclick='document.getElementById("avatar_image").value="2"; alert("the avatar has been selected")'>
                                                    <img src="{{ asset('assets/avatars_basic/2.jpg') }}" alt="here is here" width="125" height="125">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 text-center">
                                                <div type="button" data-bs-dismiss="modal" onclick='document.getElementById("avatar_image").value="3"; alert("the avatar has been selected")'>
                                                    <img src="{{ asset('assets/avatars_basic/3.jpg') }}" alt="here is here" width="125" height="125">
                                                </div>
                                            </div>
                                            <div class="col-6 text-center">
                                                <div type="button" data-bs-dismiss="modal" onclick='document.getElementById("avatar_image").value="4"; alert("the avatar has been selected")'>
                                                    <img src="{{ asset('assets/avatars_basic/4.jpg') }}" alt="here is here" width="125" height="125">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 text-center">
                                                <div type="button" data-bs-dismiss="modal" onclick='document.getElementById("avatar_image").value="5"; alert("the avatar has been selected")'>
                                                    <img src="{{ asset('assets/avatars_basic/5.jpg') }}" alt="here is here" width="125" height="125">
                                                </div>
                                            </div>
                                            <div class="col-6 text-center">
                                                <div type="button" data-bs-dismiss="modal" onclick='document.getElementById("avatar_image").value="6"; alert("the avatar has been selected")'>
                                                    <img src="{{ asset('assets/avatars_basic/6.jpg') }}" alt="here is here" width="125" height="125">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 text-center">
                                                <div type="button" data-bs-dismiss="modal" onclick='document.getElementById("avatar_image").value="7"; alert("the avatar has been selected")'>
                                                    <img src="{{ asset('assets/avatars_basic/7.jpg') }}" alt="here is here" width="125" height="125">
                                                </div>
                                            </div>
                                            <div class="col-6 text-center">
                                                <div type="button" data-bs-dismiss="modal" onclick='document.getElementById("avatar_image").value="8"; alert("the avatar has been selected")'>
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
                    <button type="submit" class="btn btn-primary mt-5">Create</button>
                </form>
            </div>
        </div> 
    </div>
</div>
@endsection