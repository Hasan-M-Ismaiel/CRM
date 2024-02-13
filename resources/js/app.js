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


