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
                            <p id="pcreateProject">create new skill that your projects or users have</p>
                        
                            <form class="" action='{{ route("admin.skills.store") }}' method="POST">
                                @csrf
                                <div class="bodyflex">
                                    <div style="width:100%;">
                                        <div class="form-card border-success border rounded pb-2">
                                            <div class="border px-2 pb-2 pt-3 rounded" style="background-color: #b9c9e5; background-image: linear-gradient(to bottom right, #b9c9e5, #e4eaf5);">
                                                <h2 class="fs-title">Add Skills:</h2>
                                            </div>
                                            <div class="col-lg-12">
                                                <div id="row">
                                                    <div class="input-group mt-5">
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
                                                <button id="rowAdder" type="button" class=" mt-3 btn btn-dark">
                                                    <span class="bi bi-plus-square-dotted ">
                                                    </span> ADD
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <x-forms.create-button />
                            </form>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#rowAdder").click(function () {
        newRowAdd =
            '<div id="row"> <div class="input-group mt-5">' +
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
