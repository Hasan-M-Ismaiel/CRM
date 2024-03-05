import './bootstrap';

//for the notifications
Echo.private(`App.Models.User.`+window.userID)
    .notification((notification) => {
    if(notification['notification_type'] == 'TaskAssigned'){
        $("#toast_link_to_notification_target").attr("href",notification['link_to_task']+'?notificationId='+notification['notification_id']);
        $("#toast_image").attr("src",notification['project_manager_image']);
        $("#toast_project_manager_name").html(notification['project_manager_name']);
        $("#toast_content").html("finish this new task "+notification['task_title']);
        $(".toast").toast('show');
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

        //update the number of notification on the screen
        $("#num_of_notification").html(window.NumberOfNotifications + 1);
        window.NumberOfNotifications = window.NumberOfNotifications + 1 ;

        $("#headerTasksDropdown").html($("#headerTasksDropdown").val() + 1);

        //update the number of tasks on the screen
        $("#num_of_tasks").html(window.NumberOfTasks + 1);
        window.NumberOfTasks = window.NumberOfTasks + 1 ;

    } else if (notification['notification_type'] == 'TaskUnAssigned'){
        $("#toast_link_to_notification_target").attr("href",notification['link_to_project']+'?notificationId='+notification['notification_id']);
        $("#toast_image").attr("src",notification['project_manager_image']);
        $("#toast_project_manager_name").html(notification['project_manager_name']);
        $("#toast_content").html("the task "+notification['task_title']+" is unassigned from you ");
        $(".toast").toast('show');

        $("#num_of_notification").html(window.NumberOfNotifications + 1);
        window.NumberOfNotifications = window.NumberOfNotifications + 1 ;

        $("#headerTasksDropdown").html($("#headerTasksDropdown").val() - 1);

        //update the number of tasks on the screen
        $("#num_of_tasks").html(window.NumberOfTasks - 1);
        window.NumberOfTasks = window.NumberOfTasks - 1 ;

    } else if (notification['notification_type'] == 'ProjectAssigned'){
        $("#toast_link_to_notification_target").attr("href",notification['link_to_project']+'?notificationId='+notification['notification_id']);
        $("#toast_image").attr("src",notification['project_manager_image']);
        $("#toast_project_manager_name").html(notification['project_manager_name']);
        $("#toast_content").html(" you are now one of team member for this project "+ notification['project_title']);
        $(".toast").toast('show');
        //update the number of notification on the screen
        $("#num_of_notification").html(window.NumberOfNotifications + 1);
        window.NumberOfNotifications = window.NumberOfNotifications + 1 ;

        $("#headerProjectsDropdown").html($("#headerProjectsDropdown").val() + 1);

    } else if (notification['notification_type'] == 'ProjectUnAssigned'){
        $("#toast_image").attr("src",notification['project_manager_image']);
        $("#toast_project_manager_name").html(notification['project_manager_name']);
        $("#toast_content").html(" you are now not one of team member for this project "+ notification['project_title']);
        $(".toast").toast('show');

        $("#num_of_notification").html(window.NumberOfNotifications + 1);
        window.NumberOfNotifications = window.NumberOfNotifications +1 ;

        $("#headerProjectsDropdown").html($("#headerProjectsDropdown").val() - 1);

    } else if (notification['notification_type'] == 'TaskWaitingNotification'){
        $("#toast_link_to_notification_target").attr("href",notification['link_to_task']+'?notificationId='+notification['notification_id']);
        $("#toast_image").attr("src",notification['project_manager_image']);    // add logo image here
        $("#toast_project_manager_name").html(notification['project_manager_name']);
        $("#toast_content").html("There is a task pending and waiting to be closed from project " + notification['project_title']);
        $(".toast").toast('show');

        $("#num_of_notification").html(window.NumberOfNotifications + 1);
        window.NumberOfNotifications = window.NumberOfNotifications +1 ;
    } else if (notification['notification_type'] == 'TeamleaderRoleAssigned'){
        $("#toast_link_to_notification_target").attr("href",notification['link_to_project']+'?notificationId='+notification['notification_id']);
        $("#toast_image").attr("src",notification['project_manager_image']);
        $("#toast_project_manager_name").html(notification['project_manager_name']);
        $("#toast_content").html("You are now the teamleader of this project "+ notification['project_title']);
        $(".toast").toast('show');

        $("#num_of_notification").html(window.NumberOfNotifications + 1);
        window.NumberOfNotifications = window.NumberOfNotifications +1 ;

    } else if (notification['notification_type'] == 'TeamleaderRoleUnAssigned'){
        $("#toast_link_to_notification_target").attr("href",notification['link_to_project']+'?notificationId='+notification['notification_id']);
        $("#toast_image").attr("src",notification['project_manager_image']);
        $("#toast_project_manager_name").html(notification['project_manager_name']);
        $("#toast_title").html(" you are now not the teamleader of this project "+notification['project_title']);
        $(".toast").toast('show');

        $("#num_of_notification").html(window.NumberOfNotifications + 1);
        window.NumberOfNotifications = window.NumberOfNotifications +1 ;

    } else if (notification['notification_type'] == 'ProjectDeleted'){
        $("#toast_image").attr("src",notification['project_manager_image']);
        $("#toast_project_manager_name").html(notification['project_manager_name']);
        $("#toast_content").html("The project " + notification['project_title']+ " has been deleted");
        $(".toast").toast('show');

        $("#num_of_notification").html(window.NumberOfNotifications + 1);
        window.NumberOfNotifications = window.NumberOfNotifications + 1 ;
        
        $("#headerProjectsDropdown").html($("#headerProjectsDropdown").val() - 1);

    } else if (notification['notification_type'] == 'TaskDeleted'){
        $("#toast_link_to_notification_target").attr("href",notification['link_to_task']+'?notificationId='+notification['notification_id']);
        $("#toast_image").attr("src",notification['project_manager_image']);
        $("#toast_project_manager_name").html(notification['project_manager_name']);
        $("#toast_content").html("this task: " + notification['task_title'] +' has been deleted' +" from this project: " + notification['project_title']);
        $(".toast").toast('show');

        $("#num_of_notification").html(window.NumberOfNotifications + 1);
        window.NumberOfNotifications = window.NumberOfNotifications + 1 ;

        $("#headerTasksDropdown").html($("#headerTasksDropdown").val() - 1);

        if(window.NumberOfTasks > 0){
            //update the number of tasks on the screen
            $("#num_of_tasks").html(window.NumberOfTasks - 1);
            window.NumberOfTasks = window.NumberOfTasks - 1 ;
        }else{
            //update the number of tasks on the screen
            $("#num_of_tasks").html(window.NumberOfTasks);
            window.NumberOfTasks = window.NumberOfTasks ;
        }
    } else if (notification['notification_type'] == 'TaskMissed'){
        $("#toast_link_to_notification_target").attr("href",notification['link_to_task']+'?notificationId='+notification['notification_id']);
        $("#toast_image").hide();   // add logo image here 
        $("#toast_project_manager_name").hide();
        $("#toast_title").html("Task missed");
        $("#toast_content").html('you have missed this task '.notification['task_title'] + 'from project '.notification['project_title']);
        $(".toast").toast('show');

        $("#num_of_notification").html(window.NumberOfNotifications + 1);
        window.NumberOfNotifications = window.NumberOfNotifications + 1 ;

        //update the number of tasks on the screen
        $("#num_of_tasks").html(window.NumberOfTasks - 1);
        window.NumberOfTasks = window.NumberOfTasks - 1 ;

    }
});

//for the team channel messages
window.projectIds.forEach(element => {
    Echo.private(`teams.`+element)
        .listen('MessageSent', (e) => {
        var searchString = 'admin/teams/'+element;
        var userimage = e.user_image_url;
        var message = e.message;
        var username = e.user_name;
        var teamId = e.team_id;
        var userId = e.user_id;
        var message_id = e.message_id;
        // alert(e.message_id);
        var userprofile = e.user_profile_url;
        var numberOfSingle;

        // if the user is open this conversation then do not increase the number of unreaded messages on the screen and send ajax request to the back end to make the messages readed in the database and you should send (message readed) event in the server for the sender to know that
        if (window.location.href.indexOf(searchString) > -1) {
            axios.post("markMessagesAsReaded", {
                teamId: teamId,
                authUserId: window.userID,
              })
              .then((response) => {
                alert('success');
                alert('done');
                console.log(response);
              }, (error) => {
                console.log(error);
              });

        } else {
            //if the auth is the same as the person who send the message then ignore
            if(window.userID != userId){
                $("#num_of_total_messages_notifications").html(window.NumberOfTotalMessageNotifications + 1);
                window.window.NumberOfTotalMessageNotifications = window.window.NumberOfTotalMessageNotifications + 1 ;

                $("#num_of_team_messages_notifications").html(window.NumberOfTeamMessageNotifications + 1);
                window.NumberOfTeamMessageNotifications = window.NumberOfTeamMessageNotifications + 1 ;

                if(window.NumberOfTaskMessageNotifications==0){
                    $('#num_of_single_team_notifications-'+teamId).html("new messages");
                }else{
                    $('#num_of_single_team_notifications-'+teamId).html(window.NumberOfTaskMessageNotifications + "+");
                }
            }
        }

        //current time for the message received
        var time1= new Date();
        var currentTime = time1.toLocaleTimeString().replace(/(.*)\D\d+/, '$1');

        if(e.user_id == window.userID){ // is the auth // for user experince you can comment this first line and add the message from the sender side that is faster to render the sender message
            var newMessageFromHere = $('<div class="chat-message-right pb-4"> <div class="ms-2"> <img src="'+userimage+'" class="rounded-circle mr-1 border border-success" width="40" height="40" /> <div class="text-white small text-nowrap mt-2">'+currentTime+'</div> </div><div> <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3"> <div class="font-weight-bold mb-1">'+username +'</div><div> '+ message+ '</div></div><div id="'+message_id+'"></div></div></div>');
        }else{
            var newMessageFromHere = $('<div class="chat-message-left pb-4"> <div> <img src="'+userimage+'" class="rounded-circle mr-1 border border-success" width="40" height="40" /> <div class="text-white small text-nowrap mt-2">'+currentTime+'</div> </div><div> <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3"> <div class="font-weight-bold mb-1">'+username +'</div><div> '+ message+ '</div></div><div id="'+message_id+'"></div></div></div>');
        }

        //append the message to UI
        $('#parentmessages').append(newMessageFromHere);

        // for the scroll bar to be down
        var messageBodyT = document.querySelector('#parentmessages');
        messageBodyT.scrollTop = messageBodyT.scrollHeight - messageBodyT.clientHeight;
    })
    // listen if the users read the messages of this conversation
    .listen('MessageReaded',(e)=>{
        var fromUser = e.user_id;
        var userimage = e.user_image_url;
        var messagesId = e.messages_id;
        var teamId = e.team_id;

        // add the pictures of the users who readed the message
        messagesId.forEach(myFunction);

        function myFunction(value, index, array) {
            var message_id_team = '#'+value;
            var child = '#image-'+fromUser;
            if ($(message_id_team).children(child).length > 0) {
                // do something
            }else{
               var newUserImage = '<img id="image-'+fromUser+'" src="'+userimage+'" class="rounded-circle mr-1 border border-success" width="15" height="15" />';
               $(message_id_team).append(newUserImage);
           }
         }
    })
});

//for the task channel messages
window.taskIds.forEach(element => {
    Echo.private(`tasks.`+element)                                      // element is the item ( task id ) who the user own - the admin get all of them - see the app layout js section 
    .listen('TaskMessageSent', (e) => {
        var searchString_task = 'admin/tasks/showTaskChat/'+element;    // to check if the chat is opened in the reciver section 
        var userimage_task = e.user_image_url;                          // the url for the person how send the message
        var message_task = e.message;                                   // the sended message
        var username_task = e.user_name;                                // the name for the sender
        var taskId_task = e.task_id;                                    // the conversation chat - here is the task id 
        var userId_task = e.user_id;                                    // the user id who send the message ( the sender )
        var taskmessage_id = e.taskmessage_id;                          // id for the created task message (the new added task message id)
        var userprofile = e.user_profile_url;                           // the url for going to profile for the user 

        // alert(e.taskmessage_id);                // this should be 109 

        // if the user is open this conversation then do not increase the number of unreaded messages on the screen and send ajax request to the back end to make the messages readed in the database and you should send (message readed) event in the server for the sender to know that
        if (window.location.href.indexOf(searchString_task) > -1) {
            axios.post("../markTaskMessagesAsReaded", {
                taskId: taskId_task,
                authUserId: window.userID,
              })
              .then((response) => { 
                // the event message readed in catched down listener
                // alert('the markTaskMessagesAsReaded is fired');
              });
              
        } else {
            //if the logedin user is the same as the person who send the message then ignore [dont update the number of notifications]
            if(window.userID != userId_task){
                // main fab button
                $("#num_of_total_messages_notifications").html(window.NumberOfTotalMessageNotifications + 1);
                window.window.NumberOfTotalMessageNotifications = window.window.NumberOfTotalMessageNotifications + 1 ;
                // task fab button  
                $("#num_of_task_messages_notifications").html(window.NumberOfTaskMessageNotifications + 1);
                window.NumberOfTaskMessageNotifications = window.NumberOfTaskMessageNotifications + 1 ;

                // var spotlight= '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fe0131" class="bi bi-circle-fill" viewBox="0 0 16 16"> <circle cx="8" cy="8" r="8"/></svg>';
                // numberOfSingle = $('#num_of_single_team_notifications-'+teamId).html() + (int) 1;
                if(window.NumberOfTaskMessageNotifications==0){
                    $('#num_of_single_task_notifications-'+taskId_task).html("new messages");
                }else{
                    $('#num_of_single_task_notifications-'+taskId_task).html(window.NumberOfTaskMessageNotifications + "+");
                }
            }
        }
        //current time for the message received
        var time2= new Date();
        var currentTime2 = time2.toLocaleTimeString().replace(/(.*)\D\d+/, '$1');

        // if the sender was the same as the loged in user - add the added message on the right
        if(e.user_id == window.userID){ // is the auth // for user experince you can comment this first line and add the message from the sender side that is faster to render the sender message
            var newMessageFromHereTask = $('<div class="chat-message-right pb-4"> <div class="ms-2"> <img src="'+userimage_task+'" class="rounded-circle mr-1 border border-success" width="40" height="40" /> <div class="text-white small text-nowrap mt-2">'+currentTime2+'</div> </div> <div> <div class="flex-shrink-1  bg-primary text-white rounded py-2 px-3 ml-3"> <div class="font-weight-bold mb-1">'+username_task +'</div><div>'+ message_task+ '</div></div><div id="taskmessage-'+taskmessage_id+'"></div></div></div>');
        }else{
            var newMessageFromHereTask = $('<div class="chat-message-left pb-4"> <div> <img src="'+userimage_task+'" class="rounded-circle mr-1 border border-success" width="40" height="40" /> <div class="text-white small text-nowrap mt-2">'+currentTime2+'</div> </div> <div> <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3"> <div class="font-weight-bold mb-1">'+username_task +'</div><div>'+ message_task+ '</div></div><div id="taskmessage-'+taskmessage_id+'"></div></div></div>');
        }

        //append the message to UI
        $('#parenttaskmessages').append(newMessageFromHereTask);

        // for the scroll bar to be down
        var messageBody = document.querySelector('#parenttaskmessages');
        messageBody.scrollTop = messageBody.scrollHeight - messageBody.clientHeight;
    })

    // listen if the users read the messages of this conversation
    .listen('TaskMessageReaded',(e)=>{
        var fromUser_task = e.user_id;                  // the user id who see the messages
        var userimage_task = e.user_image_url;          // the user image who see the messages
        var taskmessagesId = e.taskmessages_id;         // the ids of the readed messages in the task
        var taskId = e.task_id;                         // task id that contain the messages that have been seen by the user 
        
        // alert(taskmessagesId);                          //'
        // alert('readed');                       // you can add condition here to check if the sender is the same as the reciver 
        
        // add the pictures of the users who readed the message
        taskmessagesId.forEach(myFunctiontask);

        function myFunctiontask(value, index, array) {
            var taskmessage_id_task = '#taskmessage-'+value;
            var child = '#image-'+fromUser_task;
            if ($(taskmessage_id_task).children(child).length > 0) {
                // do something
                // if the picture is already exist
            }else{
               var newUserImage_task = '<img id="image-'+fromUser_task+'" src="'+userimage_task+'" class="rounded-circle mr-1 border border-success" width="15" height="15" />';
               $(taskmessage_id_task).append(newUserImage_task);
           }
         }
    })

});

