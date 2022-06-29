<?php

namespace App\Http\Controllers\Api\Notifications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;

class NotificationsController extends Controller
{
    /**
     * Get all user notifications
     */
    public function fetchAllUserNotifications(Request $request, User $user)
    {
        $notifications = $user->unreadNotifications;

        return response()->json([
            'success' => true,
            'message' => 'All current user notificastions',
            'data' => $notifications
        ], 200);
    }

    /**
     * Delete notification record
     */
    public function deleteNotification(Request $request, Notification $notification)
    {

        $user = User::where('id', $notification->notifiable_id)->first();

        $notification->delete();

        $notifications = $user->unreadNotifications;

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted',
            'data' => $notifications
        ]);
    }
}
