<html lang="en">
    <head>
        <base href="./">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
        <meta name="author" content="Łukasz Holeczek">
        <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
        <title>{{ config('app.name') }}</title>
        <link rel="icon"  type="image/png" href="{!! asset('assets/icons/brands/titleIcon.png') !!}"/>
        <!-- <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/favicon/android-icon-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/favicon/apple-icon-76x76.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}"> -->
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/favicon/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/favicon/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/favicon/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/favicon/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/favicon/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/favicon/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/favicon/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/favicon/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-icon-180x180.png') }}">
        <link rel="manifest" href="{{ asset('assets/favicon/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('assets/favicon/ms-icon-144x144.png') }}">
        <meta name="theme-color" content="#ffffff">

        
        <!-- Option 1: CoreUI for Bootstrap CSS -->
        <!-- <link href="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.3.2/dist/css/coreui.min.css" rel="stylesheet" integrity="sha384-H8oVKJOQVGGCdfFNM+9gLKN0xagtq9oiNLirmijheEuqD3kItTbTvoOGgxVKqNiB" crossorigin="anonymous"> -->
        <!-- Option 1: CoreUI for Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/@coreui/coreui@4.3.2/dist/js/coreui.bundle.min.js" integrity="sha384-yaqfDd6oGMfSWamMxEH/evLG9NWG7Q5GHtcIfz8Zg1mVyx2JJ/IRPrA28UOLwAhi" crossorigin="anonymous"></script>

        <!--alpine js library for the flash message-->
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

        <!--ajax-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        
        <!--bootstrap icons-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <!--for the profile template-->
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!--for the create project multible steps-->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Vendors styles-->
        <link rel="stylesheet" href='{{ asset("css/vendors/simplebar.css") }}'>
        <link rel="stylesheet" href='{{ asset("vendors/simplebar/css/simplebar.css") }}'>
        <link href='{{ asset("css/style.css") }}' rel="stylesheet">

        <!--for file pond-->
        <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />

        <!--for the calender-->
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
        <!--for the notification template-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css" integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />
        
        <!--emoji-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.css" />

        <title>Hello, world!</title>
        @vite(['resources/js/app.js', 'resources/css/app.css', 'resources/css/profile.css', 'resources/css/createProject.css', 'resources/sass/app.scss', 'resources/css/editProject.css', 'resources/css/radioButton.styl', 'resources/css/chat.css', 'resources/css/carddashboard.css','resources/css/notificationTemplate.css' ])

    </head>
    <body style onload="loadteams_tasks();" class="area">
    
        @include('partials.menu')
        <div class="wrapper d-flex flex-column min-vh-100 bg-light">
            @include('partials.header')
            <div class="body flex-grow-1 px-3">
                <div class="container-lg ">
                    @yield('content')
                </div>
            </div>
            
            <x-toast-notification />
            <x-loader />

            <footer class="footer">
                <div><a href="http://account.infinityfreeapp.com/index.php?i=2">TeamWork</a>/<a href="http://account.infinityfreeapp.com/index.php?i=2">collaborative work</a> © 2024 beInTech.</div>
                <div class="ms-auto">Powered by&nbsp;<a href="http://account.infinityfreeapp.com/index.php?i=2">Hasan Ismaiel</a></div>
            </footer>
        </div>
        
        <x-flash />
 
        <!-- Modal -->
        <!--team modal -->
        <div class="modal fade" id="myModalTeam" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content clearfix">
                    <div class="modal-content clearfix">
                        <div class="modal-body" id="modal_content_team">
                            <div class="row text-center">
                                <span class="material-icons">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                        <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                                    </svg>
                                </span>
                            </div>
                            <h3 class="title">Team Chat!</h3>
                            <p class="description">here you can chat with your team mates about the same project</p>
                            <!--here we should add the rendered items-->
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <!--task modal -->
        <div class="modal fade" id="myModalTask" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content clearfix">
                    <div class="modal-content clearfix">
                        <div class="modal-body" id="modal_content_task">
                            <div class="row text-center">
                                <span class="material-icons">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                                        <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                                    </svg>
                                </span>
                            </div>
                            <h3 class="title">Task Chat!</h3>
                            <p class="description">here you can chat with your team leader directly about the each task</p>
                            <!--here we should add the rendered items-->
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
        <!--fab button-->
        <div class="fab-container" style="position: fixed;">
            <!-- the main fab button to show the total number of messages-->
            <div class="fab shadow">
                <div class="fab-content position-relative">
                    <span class="material-icons">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
                        </svg>  
                    </span>
                    @if(auth()->user()->numberOfTotalMessageNotifications==0)
                    <em id= "num_of_total_messages_notifications" class="badge bg-danger text-white px-2 rounded-4 position-absolute bottom-0 start-0" style="font-size: 0.9em"></em>
                    @else
                    <em id= "num_of_total_messages_notifications" class="badge bg-danger text-white px-2 rounded-4 position-absolute bottom-0 start-0" style="font-size: 0.9em">{{ auth()->user()->numberOfTotalMessageNotifications }}</em>
                    @endif
                </div>
            </div>
            <!--for the task fab button | number of messages for all the tasks -->
            <div class="sub-button shadow">
                <a href="google.com" target="_blank" data-bs-toggle="modal" data-bs-target="#myModalTask" >
                    <span class="material-icons">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
                        </svg>
                    </span>
                </a>
                @if(auth()->user()->numberOfTaskMessageNotifications==0)
                <em id= "num_of_task_messages_notifications" class="badge bg-danger text-white px-2 rounded-4 position-absolute bottom-0 start-0" style="font-size: 0.9em"></em>
                @else
                <em id= "num_of_task_messages_notifications" class="badge bg-danger text-white px-2 rounded-4 position-absolute bottom-0 start-0" style="font-size: 0.9em">{{ auth()->user()->numberOfTaskMessageNotifications }}</em>
                @endif
            </div>
            <!--for the team fab button | number of messages for all the teams -->
            <div class="sub-button shadow">
                <a href="google.com" target="_blank" data-bs-toggle="modal" data-bs-target="#myModalTeam">
                    <span class="material-icons">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                            <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
                        </svg>
                    </span>
                </a>
                @if(auth()->user()->numberOfTeamMessageNotifications==0)
                <em id= "num_of_team_messages_notifications" class="badge bg-danger text-white px-2 rounded-4 position-absolute bottom-0 start-0" style="font-size: 0.9em"></em>
                @else
                <em id= "num_of_team_messages_notifications" class="badge bg-danger text-white px-2 rounded-4 position-absolute bottom-0 start-0" style="font-size: 0.9em">{{ auth()->user()->numberOfTeamMessageNotifications }}</em>
                @endif
            </div>
        </div>

        <!--js variables-->
        <script>
            
            // user loged in id 
            window.userID = {{ auth()->id() }};
            // number of general notifications 
            window.NumberOfNotifications = {!! auth()->user()->unreadNotifications->count() !!};
            // total messages number 
            window.NumberOfTotalMessageNotifications = {!! auth()->user()->numberOfTotalMessageNotifications !!};   
            // team messages number           
            window.NumberOfTeamMessageNotifications = {!! auth()->user()->numberOfTeamMessageNotifications !!}; 
            // task messages number
            window.NumberOfTaskMessageNotifications = {!! auth()->user()->numberOfTaskMessageNotifications !!}; 
            // number of opened tasks to show in the header section for each user 
            window.NumberOfTasks = {!! auth()->user()->numberOfOpenedTasks !!};
            
            // number of total tasks to show in the dropdown header section for each user 
            window.NumberOfTasksForAllProjects = {!! auth()->user()->numberOfTasksForAllProjects !!};

            // number of total projects to show in the dropdown header section for each user 
            window.NumberOfAssignedProjects = {!! auth()->user()->numberOfAssignedProjects !!};

            // projects ids for the loged in user to show in the header section - from what i remember 
            window.projectIds =  {!! auth()->user()->projects()->pluck('projects.id') !!};
            // tasks ids for the loged in user to show in the header section - from what i remember 
            window.taskIds =  {!! auth()->user()->tasks()->where('user_id',auth()->id())->get()->pluck('id') !!};
            // check if the current user is the admin - then the number of ids is all the tasks in the database
            window.checkIfAdmin = {!! auth()->user()->hasRole('admin') ? 'true' : 'false' ; !!};
            window.checkIfTeamleader = {!! auth()->user()->teamleaderon->count()>0 ? 'true' : 'false' ; !!};
            if(window.checkIfAdmin){
                window.taskIds =  {!! App\Models\Task::all()->pluck('id') !!};
            }
            if(window.checkIfTeamleader){
                window.teamleadertaskIds =  <?php  $tasks = App\Models\Task::all(); $teamleaderTasks =collect(); foreach($tasks as $task){if(auth()->user()->id == $task->project->teamleader->id){$teamleaderTasks->push($task);} } if($teamleaderTasks->count()>0){ echo  $teamleaderTasks->pluck('id');} else {echo 'none';} ?>;
                window.taskIdstemp = window.taskIds.concat(window.teamleadertaskIds);
                //remove the duplication from the array 
                let unique = [];
                window.taskIdstemp.forEach(element => {
                    if (!unique.includes(element)) {
                        unique.push(element);
                    }
                });
                window.taskIds=unique ;
                // alert(window.taskIds);
                // alert(window.userID);
            }
        </script>

        <!--load teams & tasks-->
        <script>
            function loadteams_tasks(){

                $.ajax({
                    url: "{{ route('admin.teams.index') }}",
                    method: 'get',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(output){
                        var result = $.parseJSON(output);
                        $('#modal_content_team').append(result[0]);
                    }
                });

                $.ajax({
                    url: "{{ route('admin.tasks.showTasks') }}",
                    method: 'get',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(output){
                        var result = $.parseJSON(output);
                        $('#modal_content_task').append(result[0]);
                        // $("task").addClass("bg-secondary");
                        // $("#modal_content_task").listview('refresh');
                    }
                });
            }
        </script>

        <!--mark task/team - messages as readed clicked from the rendered items in the task/team controller render method and show it in the model here up ^ -->
        <script>
            //mark team messages as readed
            function markasread(teamId, authUserId, numberOfReadedMessages){
                // number of readed messages from this chat 
                // alert(numberOfReadedMessages);
                // alert(teamId);
                // alert(authUserId);
                $.ajax({
                    url: "{{ route('admin.teams.markMessagesAsReaded') }}",
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        teamId: teamId,
                        authUserId: authUserId,
                    },
                    success: function(output){
                        // alert('get');
                        // $('#num_of_team_messages_notifications').html(NumberOfTotalMessageNotifications - numberOfReadedMessages);
                        // $('#num_of_total_messages_notifications').html(NumberOfTotalMessageNotifications - numberOfReadedMessages);
                        // var result = $.parseJSON(output);
                        //decrease the numbers in the ui 
                    }
                });
            }

            //mark task messages as readed
            function markasreadtask(taskId, authUserId, numberOfReadedTaskMessages, url){
                // number of readed messages from this chat 
                
                // alert(numberOfReadedTaskMessages);
                // alert(taskId);
                // alert(authUserId);
                $.ajax({
                    url: "{{ route('admin.tasks.markTaskMessagesAsReaded') }}",
                    method: 'post',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        taskId: taskId,
                        authUserId: authUserId,
                    },
                    success: function(output){
                        alert('get in task');
                        window.location.replace(url); 

                        // $('#num_of_team_messages_notifications').html(NumberOfTotalMessageNotifications - numberOfReadedMessages);
                        // $('#num_of_total_messages_notifications').html(NumberOfTotalMessageNotifications - numberOfReadedMessages);
                        // var result = $.parseJSON(output);
                        //decrease the numbers in the ui 
                    }
                });
            } 
        </script>

        <!--for file pond-->
        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
        <script>
            // Get a reference to the file input element
            const inputElement = document.querySelector('input[id="image"]');

            // Create a FilePond instance
            const pond = FilePond.create(inputElement);

            FilePond.setOptions({
                server: {
                   url: '/admin/upload',
                   headers:{
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                   }

                }
            });
        </script>

        <!--emoji-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/emojionearea/3.4.2/emojionearea.js"></script>
        <script>
            // this is for team chat
            $('.emojiarea').emojioneArea();
            // this is for task chat
            $('.emojiareaTask').emojioneArea();
        </script>

        <!--for the spinner on each click button - like create - update-->
        <!-- <script>
            function showUpdatingSpinner(){
                    $('#spinner').show();
                    $('#create-button').text('updating...');
                }
        </script> -->

        <!--for the spinner on each click button - like create - update-->
        <!-- <script>
            function showSpinner(){
                    $('#spinner').show();
                    $('#create-button').text('creating...');
                }
        </script> -->
    </body>
</html>