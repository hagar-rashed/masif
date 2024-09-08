<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Fetch all notifications for the authenticated user
    public function getNotifications(Request $request)
    {
        $user = Auth::user();
        return response()->json($user->notifications);
    }

    // Mark a specific notification as read
    public function markAsRead(Request $request, $id)
    {
        $user = Auth::user();
        $notification = $user->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['message' => 'Notification marked as read.']);
        }

        return response()->json(['error' => 'Notification not found.'], 404);
    }
}
