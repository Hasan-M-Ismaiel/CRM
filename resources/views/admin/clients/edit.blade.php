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
                <form action='{{ route("admin.clients.update", $client) }}' method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="add the name of the client" value="{{ $client->name }}">
                    </div>
                    <div class="form-group mt-4">
                        <label for="VAT">VAT</label>
                        <input id="VAT" type="number" class="form-control @error('VAT') is-invalid @enderror"  placeholder="client's VAT here" name="VAT" value="{{ $client->VAT }}">
                    </div>
                    <div class="form-group mt-4">
                        <label for="address">address</label>
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror"  placeholder="client's address here" name="address" value="{{ $client->address }}">
                    </div>
                    <button type="submit" class="btn btn-primary mt-5">Update</button>
                </form>
            </div>
        </div> 
    </div>
</div>
@endsection
