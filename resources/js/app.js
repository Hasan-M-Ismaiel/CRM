import './bootstrap';

Echo.private(`App.Models.User.`+userID)
    .notification((notification) => {
    $("#toast_link_to_task").attr("href",notification['link_to_task']+'?notificationId='+notification['notification_id']);
    
    // $("#toast_link_to_task").on('click', function(){
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
    $("#toast_content").html(notification['project_name']);
    $(".toast").toast('show');
    //update the number of notification on the screen 
    $("#num_of_notification").html(window.NumberOfNotifications + 1);
});


$(document).ready(function() {
});
