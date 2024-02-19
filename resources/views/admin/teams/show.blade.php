@extends('layouts.app')

@section('content')
<main class="content">
    <div class="container p-0 mb-5">
		<h1 class="h3 mb-3">Messages</h1>
		<div class="card">
			<div class="row g-0">
				<div class="col-12">
                    <!--the header-->
					<div class="py-2 px-4 border-bottom d-none d-lg-block">
						<div class="row ">
                                <div class="col-1 ">
                                    <img src="{{ asset('images/team.jpg') }}" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
                                </div>
								<strong class="col-2  text-center p-3">
                                    {{ $team->name}}
                                </strong>
                                @if($team->project->users()->count() > 0)
                                <div class="col-9 pt-2  text-right">
                                    <ul class="list-inline">
                                        <li class="list-inline-item"> 
                                            @foreach ($team->project->users as $user)
                                                @if($user->profile)
                                                <a href="{{ route('admin.profiles.show', $user->profile->id) }}" style="text-decoration: none;">
                                                @else
                                                <a href="{{ route('admin.statuses.notFound') }}" style="text-decoration: none;">
                                                @endif
                                                @if($user->profile && $user->profile->getFirstMediaUrl("profiles"))
                                                    <img
                                                    src='{{$user->profile->getFirstMediaUrl("profiles") }}'
                                                    alt="DP"  class="  rounded-circle img-fluid border border-success " width="35" height="35">
                                                @elseif($user->getFirstMediaUrl("users"))
                                                <img
                                                    src='{{$user->getMedia("users")[0]->getUrl("thumb") }}'
                                                    alt="DP"  class="  rounded-circle img-fluid  border border-success" width="35" height="35">
                                                @else
                                                <img
                                                    src='{{ asset("images/avatar.png") }}'
                                                    alt="DP"  class="rounded-circle img-fluid border border-success " width="35" height="35">
                                                @endif
                                            </a>
                                            @endforeach
                                        </li>
                                    </ul>
                                </div>
                                @else
                                <strong class="col-9 pt-2  text-right">no users assigned yet.</strong>
                                @endif
                                <!-- <div class="text-muted small border">
                                <em>Typing...</em>
                                </div> -->
						</div>
					</div>
                    <!--content-->
					<div class="position-relative">
						<div class="chat-messages p-4" id="parentmessages">
                        @if($team->project->users()->count() > 0)
                            @foreach($team->messages as $message)
                                @if($message->user->id == auth()->user()->id)
                                <!--sender-->
                                <div class="chat-message-right pb-4">
                                @else
                                <!--recievers-->
                                <div class="chat-message-left pb-4">
                                @endif   
                                    <div>
                                        @if($message->user->profile && $message->user->profile->getFirstMediaUrl("profiles"))
                                        <img src='{{ $message->user->profile->getFirstMediaUrl("profiles") }}' class="rounded-circle mr-1 border border-success" width="40" height="40" />
                                        @elseif($message->user->getFirstMediaUrl("users"))
                                        <img src='{{ $message->user->getMedia("users")[0]->getUrl("thumb") }}' class="rounded-circle mr-1 border border-success" width="40" height="40" />
                                        @else 
                                        <img src="{{ asset('images/avatar.png') }}" class="rounded-circle mr-1 border border-success" width="40" height="40" />
                                        @endif
                                        <div class="text-muted small text-nowrap mt-2">{{$message->created_at->format('g:i a')}}</div>
                                    </div>
                                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                        <div class="font-weight-bold mb-1">{{$message->user->name}}</div>
                                        {{$message->message}}
                                    </div>
                                </div>
                            @endforeach
                        @endif
					</div>

                    <!--place to sent-->
					<div class="flex-grow-0 py-3 px-4 border-top">
						<div class="input-group">
							<input name="message" id="message" type="text" class="form-control" placeholder="Type your message">
							<button id="send" class="btn btn-primary">Send</button>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</main>
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
            url: "{{ route('admin.teams.sendMessage') }}",
            method: 'post',
            data: {
                "_token": "{{ csrf_token() }}",
                message: message,       // the sended message
                user_id: window.userID, // the sender
                project_id:'{{$team->project->id}}', // the project id 
            },
            success: function(output){
                // var newMessageFromHere = $('<div class="chat-message-right pb-4"> <div> <img src="'+userimage+'" class="rounded-circle mr-1 border border-success" width="40" height="40" /> <div class="text-muted small text-nowrap mt-2">'+currentTime+'</div> </div> <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3"> <div class="font-weight-bold mb-1">'+username +'</div> '+ message+ '</div></div>');
                // $('#parentmessages').append(newMessageFromHere);
            }
        });
    });
</script>




@endsection
