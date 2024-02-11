<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    

    public function index ()
    {
        $notifications = auth()->user()->unreadNotifications()->paginate(15);

        return view('admin.notifications.index', [
            'notifications' => $notifications,
        ]);
    }

    public function markNotification()
    {
        auth()->user()
            ->unreadNotifications
            ->when(request('notificationId'), function ($query) {
                return $query->where('id', request('notificationId'));
            })
            ->markAsRead();

        return response()->noContent();
    }
}
