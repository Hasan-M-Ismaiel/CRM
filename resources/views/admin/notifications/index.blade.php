@extends('layouts.app')

@section('content')
    <div class="card p-5">
      <div class="container-fluid border my-3  ">
        <div class="row justify-content-center">
          <div class="card-create-project pt-4 my-3 mx-5 px-5">
            <h2 id="heading">{{ $page }}</h2>
            <p id="pcreateProject">dashboard to manage all created</p>
            <span id="ringing_bell" class="bi bi-bell-fill"></span>
            <main class="flex-grow p-4">
              <div class="w-full bg-white p-4 rounded-lg">
                @forelse ($notifications as $notification)
                  @if($notification->type == 'App\Notifications\TaskAssigned')
                    <div class="alert alert-success" role="alert" id="{{ $notification->id }}">
                      <svg id="xbutton" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x float-right mark-as-read ml-4" onclick="markasread('{{ $notification->id }}')" data-id="{{ $notification->id }}" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                      </svg>
                      Task 
                      <a href="{{ route('admin.tasks.show', $notification->data['task_id']) }}"> 
                        {{ $notification->data['task_title'] }} 
                      </a> has been assigned to you for project {{ $notification->data['project_name'] }} - At - <span class="font-medium">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                  @elseif ($notification->type == 'App\Notifications\TaskUnAssigned')
                    <div class="alert alert-success" role="alert" id="{{ $notification->id }}">
                      <svg id="xbutton" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x float-right mark-as-read ml-4" onclick="markasread('{{ $notification->id }}')" data-id="{{ $notification->id }}" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                      </svg>
                      Task {{ $notification->data['task_title'] }} has been unassigned to you for project
                      <a href="{{ route('admin.projects.show', $notification->data['project_id']) }}"> 
                      {{ $notification->data['project_name'] }} </a> - At - <span class="font-medium">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                  @elseif ($notification->type == 'App\Notifications\ProjectAssigned')
                    <div class="alert alert-success" role="alert" id="{{ $notification->id }}">
                      <svg id="xbutton" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x float-right mark-as-read ml-4" onclick="markasread('{{ $notification->id }}')" data-id="{{ $notification->id }}" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                      </svg>
                      now you are one of the team for this Project 
                      <a href="{{ route('admin.projects.show', $notification->data['project_id']) }}"> 
                      {{ $notification->data['project_title'] }} </a> - At - <span class="font-medium">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                  @elseif ($notification->type == 'App\Notifications\ProjectUnAssigned')
                    <div class="alert alert-success" role="alert" id="{{ $notification->id }}">
                      <svg id="xbutton" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x float-right mark-as-read ml-4" onclick="markasread('{{ $notification->id }}')" data-id="{{ $notification->id }}" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                      </svg>
                      now you are not one of the team for this Project 
                      <a href="{{ route('admin.projects.index') }}"> 
                      {{ $notification->data['project_title'] }} </a> - At - <span class="font-medium">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                  @elseif ($notification->type == 'App\Notifications\TaskWaitingNotification')
                    <div class="alert alert-success" role="alert" id="{{ $notification->id }}">
                      <svg id="xbutton" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x float-right mark-as-read ml-4" onclick="markasread('{{ $notification->id }}')" data-id="{{ $notification->id }}" viewBox="0 0 16 16">
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                      </svg>
                      there is a task waiting for you to check it out. 
                      <a href="{{ route('admin.tasks.show' ,$notification->data['task_id']) }}"> 
                      show it - {{ $notification->data['task_title'] }} </a> - At - <span class="font-medium">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                  @endif  
                  @if ($loop->last)
                  <button id="mark_all" type="button" class="btn btn-primary btn-lg btn-block" style="background-color: #311B92" onclick="markallread()">Mark all as read</button>
                  @endif
                @empty
                  <strong id="no_notifications" class="text-gray-600">No new notifications</strong>
                @endforelse
              </div>
            </main>
          </div>
        </div>
      </div>
    </div>


<script>
  function markasread(notificationId){
    axios.post("{{ route('admin.notifications.markNotification') }}" , {'notificationId': notificationId})
      .then(response => {
          //remove element
          document.getElementById(notificationId).remove();
          
          if(window.NumberOfNotifications - 1 == 0){
            $("#num_of_notification").remove();
          } else {
            $("#num_of_notification").html(window.NumberOfNotifications - 1); //  is in the app.blade layout file
            window.NumberOfNotifications = window.NumberOfNotifications - 1;
          }
      })
      .catch(errors => {
          if (errors.response.status == 401) {
      }});
  }

  function markallread(){
      axios.post("{{ route('admin.notifications.markNotification') }}")
        .then(response => {
            //remove elements
            const alerts = document.querySelectorAll('.alert');

            alerts.forEach(alert => {
            alert.remove();
            });
          $("#num_of_notification").remove();
          $("#mark_all").remove();
          $("#no_notifications").html("your notificaitons are readed");

        })
        .catch(errors => {
            if (errors.response.status == 401) {
      }});
  }
</script>

{{ $notifications->links() }}
@endsection

