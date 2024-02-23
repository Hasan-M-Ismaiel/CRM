@extends('layouts.app')

@section('content')

<div class="card p-5">
  <div class="row border">
    <!--header section-->
    <div class="col">
      <div class="container-fluid my-3  ">
          <div class="row justify-content-center">
              <div class="card-create-project pt-4 my-3 mx-5 px-5">
                <h2 id="heading">{{ $page }}</h2>
                <p id="pcreateProject">dashboard to manage all created clients</p>
                  @can('project_create')
                  <a type="button" class="rounded" href="{{ route('admin.clients.create') }}" style="text-decoration: none;" role="button"><div  class="action-main-create-button px-5 text-center py-3 rounded">Add New User</div></a>
                  @endcan
              </div>
          </div>
      </div>
    </div>
    <!--search button section-->
    <div class="col position-relative  ">
      <div class="col mx-auto position-absolute bottom-0 end-0">
          <div class="input-group mb-3 me-3">
              <input class="form-control border-end-0 border rounded-pill" type="search" placeholder="search" id="search-input">
              <span class="input-group-append">
                  <button class="btn btn-outline-secondary bg-white border-bottom-0 border rounded-pill ms-n5" type="button" id="search_button">
                      <i class="bi bi-search"></i>
                  </button>
              </span>
              <div class="btn" id="reset">reset</div>
          </div>
      </div>
    </div>
  </div>
</div>

@if($clients->count()>0)
<!--users table section-->
<x-clients-table :clients="$clients"  />
@else 
<strong> There is no clients yet in your company </strong>
<hr>
@endif

<!--for the search -->
<script>
  $('#search_button').on('click', function(){  
    $('#loading').show();
    queryString = $('#search-input').val(); 
        $.ajax({
            url: "{{ route('admin.clients.getSearchResult') }}",
            method: 'get',
            data: {
                "_token": "{{ csrf_token() }}",
                queryString: queryString,
            },
            success: function(output){
                var result = $.parseJSON(output);
                if(result != null){
                  $('#searchedClientsTable').empty();
                  $('#sortedClientsTable').hide(); 
                  $('#sortedClientsTableSorted').hide();
                  $('#searchedClientsTable').append(result[0]);
                  $('#searchedClientsTable').show();
                  $('#loading').hide();
                }
            }
        });
    });
</script>

<!--for the reset search and sort-->
<script>
  $('#reset').on('click', function(){  
      $('#sortedClientsTable').show();    
      $('#sortedClientsTableSorted').hide();
      $('#searchedClientsTable').hide();
    });
</script>
@endsection
