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
                <div class="row">
                    <div class="col-6">
                        <h2 class="card-title mb-4">{{ $page }}</h2>
                    </div>
                </div>
                
                <form class="row g-3" action='{{ route("admin.skills.store") }}' method="POST">
                    @csrf
                    <div class="bodyflex">
                        <div style="width:50%;">
                            <div class="profile-edit-btn mt-4 row">
                                <p class="text-center">please add value to all added inputes</p>
                            </div>
                            <div class="">
                                <div class="col-lg-12">
                                    <div id="row">
                                        <div class="input-group m-3">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-danger"
                                                        id="DeleteRow"
                                                        type="button">
                                                    <i class="bi bi-trash"></i>
                                                    Delete
                                                </button>
                                            </div>
                                            <input name="names[]" type="text" class="form-control m-input"> <!--the first one-->
                                        </div>
                                    </div>

                                    <div id="newinput"></div>   <!--the added one-->
                                    <button id="rowAdder" type="button" class="btn btn-dark">
                                        <span class="bi bi-plus-square-dotted">
                                        </span> ADD
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-5">Create</button>
                </form>
            </div>
        </div> 
    </div>
</div>
<script type="text/javascript">
    $("#rowAdder").click(function () {
        newRowAdd =
            '<div id="row"> <div class="input-group m-3">' +
            '<div class="input-group-prepend">' +
            '<button class="btn btn-danger" id="DeleteRow" type="button">' +
            '<i class="bi bi-trash"></i> Delete</button> </div>' +
            '<input name="names[]" type="text" class="form-control m-input"> </div> </div>';

        $('#newinput').append(newRowAdd);
    });
    $(".bodyflex").on("click", "#DeleteRow", function () {
        $(this).parents("#row").remove();
    })
</script>
@endsection
