@extends('layouts.app')

@section('content')
<div class="card p-5">
    <div class="container-fluid border my-3  ">
        <div class="row justify-content-center">
            <div class="card-create-project pt-4 my-3 mx-5 px-5">
                <h2 id="heading">Task Chat</h2>
                <p id="pcreateProject">chat with your team leader</p>
                <div class="card rounded">
                    <div class="row g-0 rounded">
                        <div class="col-12 rounded">
                            <!--the header-->
                            <div class="py-2 px-4 border-bottom" style="background-image: linear-gradient(to left,#303c54 , #303c54);">
                                <div class="row ">
                                    <div class="col-1 text-center pt-2">
                                        <img src="{{ asset('images/taskChat.png') }}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                    </div>
                                    <strong class="col-6 text-white  text-center p-3" style="color: #673AB7;">
                                        {{ $task->title}} | {{$task->project->title}}
                                    </strong>
                                    @if($task->user)
                                        <div class="col-4 pt-2  text-right">
                                            <ul class="list-inline">
                                                <li class="list-inline-item"> 
                                                    @foreach($users as $user)
                                                        <!-- if($user->hasRole('admin')) -->
                                                        @if($user->id == $task->project->teamleader->id)
                                                            @if($user->profile)
                                                                <a href="{{ route('admin.profiles.show', $user->id) }}" style="text-decoration: none;">
                                                            @else
                                                                <a href="{{ route('admin.statuses.notFound') }}" style="text-decoration: none;">
                                                            @endif

                                                            <!--badges for the teamleader-->
                                                            @if($user->profile && $user->profile->getFirstMediaUrl("profiles"))
                                                                <div class="avatar avatar-md">
                                                                    <img src='{{$user->profile->getFirstMediaUrl("profiles") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                                                    <x-badges :user="$user" :project="$task->project" />
                                                                </div>
                                                            @elseif($user->getFirstMediaUrl("users"))
                                                                <div class="avatar avatar-md">
                                                                    <img src='{{$user->getMedia("users")[0]->getUrl("thumb") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                                                    <x-badges :user="$user" :project="$task->project" />
                                                                </div>
                                                            @else
                                                                <div class="avatar avatar-md">
                                                                    <img src='{{ asset("images/avatar.png") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                                                    <x-badges :user="$user" :project="$task->project" />
                                                                </div>
                                                            @endif

                                                            </a>
                                                        @elseif($task->user->id == $user->id)
                                                            @if($user->profile)
                                                                <a href="{{ route('admin.profiles.show', $user->profile->id) }}" class="position-relative" style="text-decoration: none;">
                                                            @else
                                                                <a href="{{ route('admin.statuses.notFound') }}" class="position-relative" style="text-decoration: none;">
                                                            @endif
                                                            
                                                            <!--badges for the user-->
                                                            @if($user->profile && $user->profile->getFirstMediaUrl("profiles"))
                                                                <div class="avatar avatar-md">
                                                                    <img src='{{$user->profile->getFirstMediaUrl("profiles") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                                                    <x-badges :user="$user" :project="$task->project" />
                                                                </div>
                                                            @elseif($user->getFirstMediaUrl("users"))
                                                                <div class="avatar avatar-md">
                                                                    <img src='{{$user->getMedia("users")[0]->getUrl("thumb") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                                                    <x-badges :user="$user" :project="$task->project" />
                                                                </div>
                                                            @else
                                                                <div class="avatar avatar-md">
                                                                    <img src='{{ asset("images/avatar.png") }}' alt="DP"  class="avatar-img border border-success shadow mb-1">
                                                                    <x-badges :user="$user" :project="$task->project" />
                                                                </div>
                                                            @endif
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                </li>
                                            </ul>
                                        </div>
                                    @else
                                        <strong class="col-4 pt-2 text-white  text-right">no users assigned yet.</strong>
                                    @endif
                                </div>
                            </div>
                            <!--content-->
                            <div class="position-relative">
                                <!--chat messages-->
                                <div class="chat-messages p-4" id="parenttaskmessages" class="bg-image" 
                                        style="background-image: url('https://mdbootstrap.com/img/Photos/Others/images/76.jpg'); height: 100vh">
                                    @if($task->user && $task->taskmessages != null)
                                        @foreach($task->taskmessages as $message)
                                            @if($message->user->id == auth()->user()->id)
                                            <!--sender-->
                                            <div class="chat-message-right pb-4">
                                            <div class="ms-2">
                                            @else
                                            <!--recievers-->
                                            <div class="chat-message-left pb-4">
                                            <div>
                                            @endif   
                                                    @if($message->user->profile && $message->user->profile->getFirstMediaUrl("profiles"))
                                                    <img src='{{ $message->user->profile->getFirstMediaUrl("profiles") }}' class="rounded-circle mr-1 border border-success" width="40" height="40" />
                                                    @elseif($message->user->getFirstMediaUrl("users"))
                                                    <img src='{{ $message->user->getMedia("users")[0]->getUrl("thumb") }}' class="rounded-circle mr-1 border border-success" width="40" height="40" />
                                                    @else 
                                                    <img src="{{ asset('images/avatar.png') }}" class="rounded-circle mr-1 border border-success" width="40" height="40" />
                                                    @endif
                                                    <div class="text-muted small text-nowrap mt-2">{{$message->created_at->format('g:i a')}}</div>
                                                </div>

                                                <div>
                                                    <!--name and message-->

                                            @if($message->user->id == auth()->user()->id)
                                                <div class="flex-shrink-1 bg-primary text-white rounded py-2 px-3 ml-3">
                                            @else
                                                <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                            @endif
                                                    <div class="font-weight-bold mb-1">{{$message->user->name}}</div>
                                                        <div>{{$message->message}}</div>
                                                    </div>
                                                    <!--the readed users-->
                                                    <div id="taskmessage-{{$message->id}}">
                                                        @foreach($message->getusersWhoReadThisMessage as $user)
                                                            @if($user->profile && $user->profile->getFirstMediaUrl("profiles"))
                                                            <img id="image-{{$user->id}}" src='{{ $user->profile->getFirstMediaUrl("profiles") }}' class="rounded-circle mr-1 border border-success" width="15" height="15" />
                                                            @elseif($user->getFirstMediaUrl("users"))
                                                            <img id="image-{{$user->id}}" src='{{ $user->getMedia("users")[0]->getUrl("thumb") }}' class="rounded-circle mr-1 border border-success" width="15" height="15" />
                                                            @else 
                                                            <img id="image-{{$user->id}}" src="{{ asset('images/avatar.png') }}" class="rounded-circle mr-1 border border-success" width="15" height="15" />
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <!--place to sent-->
                                <div class="flex-grow-0 py-3 px-4 border-top" style="background-image: linear-gradient(to left, rgba(255,0,0,0), #303c54);">
                                    <div class="input-group">
                                        <input name="message" id="message" type="text" class="form-control" placeholder="Type your message">
                                        <button id="send" class="btn btn-primary">Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--send message-->
<script>
    $('#send').on('click', function(){  
        
        // get the user image
        <?php 
        if (auth()->user()->profile && auth()->user()->profile->getFirstMediaUrl("profiles")){
         ?>
        userimage = '{{Auth::user()->profile->getFirstMediaUrl("profiles")}}';
        <?php } elseif (auth()->user()->getFirstMediaUrl("users")) 
        {?>
        userimage = '{{Auth::user()->getMedia("users")->first()->getUrl("thumb")}}';
        <?php }else{?>
        userimage = "{{asset('images/avatar.png')}}";
        <?php } ?>

        username= "<?php echo auth()->user()->name ?>";
        // get the message
        var message = $('#message').val(); 

        // the current time
        time1= new Date();
        currentTime = time1.toLocaleTimeString().replace(/(.*)\D\d+/, '$1');
        
        // to clear the message box  
        $('#message').val('');     

        
        $.ajax({
            url: "{{ route('admin.tasks.sendTaskMessage') }}",
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                message: message,       // the sended message
                user_id: window.userID, // the sender
                task_id: '{{$task->id}}', // the task_id
            },
            success: function(output){
                // var newMessageFromHere = $('<div class="chat-message-right pb-4"> <div> <img src="'+userimage+'" class="rounded-circle mr-1 border border-success" width="40" height="40" /> <div class="text-muted small text-nowrap mt-2">'+currentTime+'</div> </div> <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3"> <div class="font-weight-bold mb-1">'+username +'</div> '+ message+ '</div></div>');
                // $('#parentmessages').append(newMessageFromHere);
            }
        });
    });
</script>

@endsection
