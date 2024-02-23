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
                  <p id="pcreateProject">dashboard to manage all created tasks</p>
                    @can('project_create')
                    <a type="button" class="rounded" href="{{ route('admin.tasks.create') }}" style="text-decoration: none;" role="button"><div  class="action-main-create-button px-5 text-center py-3 rounded">Create New Task</div></a>
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

@if ($tasks->count()>0)
  <x-tasks-table :tasks="$tasks"  />
  @else 
      <span class="text-center mb-5" style="color: #673AB7;"> <strong><h4> There is no tasks yet <span> &#128513;</span></h4></strong></span>
  @endif

  
<script>
  $('#search_button').on('click', function(){  
    $('#loading').show();
    queryString = $('#search-input').val(); 
        $.ajax({
            url: "{{ route('admin.tasks.getSearchResult') }}",
            method: 'get',
            data: {
                "_token": "{{ csrf_token() }}",
                queryString: queryString,
            },
            success: function(output){
                var result = $.parseJSON(output);
                if(result != null){
                  $('#searchedTasksTable').empty();
                  $('#sortedTasksTable').hide(); 
                  $('#sortedTasksTableSorted').hide();
                  $('#searchedTasksTable').append(result[0]);
                  $('#searchedTasksTable').show();
                  $('#loading').hide();
                }
            }
        });
    });
</script>

<script>
  $('#reset').on('click', function(){  
      $('#sortedTasksTable').show();    
      $('#sortedTasksTableSorted').hide();
      $('#searchedTasksTable').hide();
    });
</script>
@endsection