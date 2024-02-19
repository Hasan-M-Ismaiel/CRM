import './bootstrap';

Echo.private(`App.Models.User.`+userID)
    .notification((notification) => {
        if(notification['notification_type'] == 'TaskAssigned'){
            $("#toast_link_to_notification_target").attr("href",notification['link_to_task']+'?notificationId='+notification['notification_id']);
            // $("#toast_link_to_notification_target").on('click', function(){
            //     $.ajax({
            //         url: "{{ route('admin.notifications.markNotification') }}",
            //         method: 'post',
            //         data: {
            //             "_token": "{{ csrf_token() }}",
            //         notificationId: notification['notification_id'],
            //         },
            //         success: function(result){
            //             alert(result);  
            //         }
            //     });
            // });
            $("#toast_image").attr("src",notification['project_manager_image']);
            $("#toast_project_manager_name").html(notification['project_manager_name']);
            $("#toast_title").html("finish this new task");
            $("#toast_body").html(notification['task_title']);
            $("#toast_content").html(notification['project_title']);
            $(".toast").toast('show');
            //update the number of notification on the screen 
            $("#num_of_notification").html(window.NumberOfNotifications + 1);
            window.NumberOfNotifications = window.NumberOfNotifications +1 ;
        } else if (notification['notification_type'] == 'TaskUnAssigned'){
            $("#toast_link_to_notification_target").attr("href",notification['link_to_project']+'?notificationId='+notification['notification_id']);
            $("#toast_image").attr("src",notification['project_manager_image']);
            $("#toast_project_manager_name").html(notification['project_manager_name']);
            $("#toast_title").html("the task is unassigned from you ");
            $("#toast_body").html(notification['task_title']);
            $("#toast_content").html(notification['project_title']);
            $(".toast").toast('show');
            //update the number of notification on the screen 
            $("#num_of_notification").html(window.NumberOfNotifications + 1);
            window.NumberOfNotifications = window.NumberOfNotifications +1 ;
        } else if (notification['notification_type'] == 'ProjectAssigned'){
            $("#toast_link_to_notification_target").attr("href",notification['link_to_project']+'?notificationId='+notification['notification_id']);
            $("#toast_image").attr("src",notification['project_manager_image']);
            $("#toast_project_manager_name").html(notification['project_manager_name']);
            $("#toast_title").html(" you are now one of team member for this project ");
            $("#toast_body").html(notification['project_title']);
            $(".toast").toast('show');
            //update the number of notification on the screen 
            $("#num_of_notification").html(window.NumberOfNotifications + 1);
            window.NumberOfNotifications = window.NumberOfNotifications +1 ;
        } else if (notification['notification_type'] == 'ProjectUnAssigned'){
            $("#toast_image").attr("src",notification['project_manager_image']);
            $("#toast_project_manager_name").html(notification['project_manager_name']);
            $("#toast_title").html(" you are now not one of team member for this project ");
            $("#toast_body").html(notification['project_title']);
            $(".toast").toast('show');
            //update the number of notification on the screen 
            $("#num_of_notification").html(window.NumberOfNotifications + 1);
            window.NumberOfNotifications = window.NumberOfNotifications +1 ;
        }
        
});


//${this.user.id} i think this is how you can get the user id - this is real and worked in my opinoin

// Echo.private(`teams.${this.user.id}`)
//     .listen('.PostUpdated', (e) => {
//         console.log(e.model);
//     });


window.projectIds.forEach(element => {
    Echo.private(`teams.`+element)
    .listen('MessageSent', (e) => {
    alert(e.message);

        var userimage = e.user_image_url;
        var message = e.message;
        var username = e.user_name;
        var teamId = e.team_id;
        var userprofile = e.user_profile_url;
            
        //current time for the message received
        time1= new Date();
        currentTime = time1.toLocaleTimeString().replace(/(.*)\D\d+/, '$1');

        if(e.user_id == window.userID){ // is the auth // for user experince you can comment this first line and add the message from the sender side that is faster to render the sender message
            var newMessageFromHere = $('<div class="chat-message-right pb-4"> <div> <img src="'+userimage+'" class="rounded-circle mr-1 border border-success" width="40" height="40" /> <div class="text-muted small text-nowrap mt-2">'+currentTime+'</div> </div> <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3"> <div class="font-weight-bold mb-1">'+username +'</div> '+ message+ '</div></div>');
        }else{
            var newMessageFromHere = $('<div class="chat-message-left pb-4"> <div> <img src="'+userimage+'" class="rounded-circle mr-1 border border-success" width="40" height="40" /> <div class="text-muted small text-nowrap mt-2">'+currentTime+'</div> </div> <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3"> <div class="font-weight-bold mb-1">'+username +'</div> '+ message+ '</div></div>');
        }

        //append the message to UI
        $('#parentmessages').append(newMessageFromHere);
    });

});


    

