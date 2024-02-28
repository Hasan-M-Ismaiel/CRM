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
        <div class="card p-5">
            <div class="row border">
            <!--header section-->
                <div class="col">
                    <div class="container-fluid my-3  ">
                        <div class="row justify-content-center">
                            <div class="card-create-project pt-4 my-3 mx-5 px-5">
                            <h2 id="heading">{{ $page }}</h2>
                            <p id="pcreateProject">edit the skill information here</p>
                            <form class="row g-3" action='{{ route("admin.skills.update", $skill) }}' method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="card border-success p-3">
                                    <label for="name"><strong> Skill name</strong></label>
                                    <input type="text" name="name" class="form-control" id="name" placeholder="add the name of the skill" value="{{ $skill->name }}">
                                </div>
                                <x-forms.update-button />
                            </form>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
@endsection
