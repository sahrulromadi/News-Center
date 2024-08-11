<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function fetchNotifications()
    {
        try {
            $notifications = auth()->user()->notifications;
            $notifications = $notifications->sortByDesc('created_at')->values()->take(5);
            
            return response()->json(['notifications' => $notifications]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch notifications'], 500);
        }
    }

    public function unreadNotificationsCount()
    {
        $unreadCount = Notification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->count();

        return response()->json(['unreadCount' => $unreadCount]);
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($notification) {
            $notification->update(['read_at' => now()]);

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Notification not found or does not belong to the current user.'], 404);
    }
}
