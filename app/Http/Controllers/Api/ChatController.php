<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewChatNotification;

class ChatController extends Controller
{
    public function startChat(Request $request)
    {
        $request->validate([
            'participant_two_id' => 'required|exists:users,id',
            'company_id' => 'required|exists:users,id',
        ]);
    
        $chat = Chat::create([
            'company_id' => $request->company_id,
            'participant_one_id' => Auth::id(),
            'participant_two_id' => $request->participant_two_id,
        ]);
    
        // Send a notification to the second participant
        $chat->participantTwo->notify(new NewChatNotification($chat));
    
        return response()->json([
            'status' => 'Chat Started',
            'chat' => $chat
        ], 201);
    }
    


    

    public function sendMessage(Request $request, $chat_id)
{
    $request->validate([
        'message' => 'required|string',
    ]);

    $chat = Chat::findOrFail($chat_id);

    $message = Message::create([
        'chat_id' => $chat->id,
        'sender_id' => Auth::id(),
        'receiver_id' => $chat->participant_one_id == Auth::id() ? $chat->participant_two_id : $chat->participant_one_id,
        'message' => $request->message,
        'is_read' => false, // Ensure this is explicitly set if needed
    ]);

    return response()->json([
        'status' => 'Message Sent',
        'message' => [
            'id' => $message->id,
            'chat_id' => $message->chat_id,
            'sender_id' => $message->sender_id,
            'receiver_id' => $message->receiver_id,
            'message' => $message->message,
            'is_read' => $message->is_read,
            'created_at' => $message->created_at->diffForHumans(), // Formatted time
            'updated_at' => $message->updated_at,
            'sender_image' => $message->sender->image // Fetch the sender's image
        ]
    ], 201);
}


public function getMessages($chat_id)
{
    $chat = Chat::findOrFail($chat_id);
    $messages = Message::where('chat_id', $chat->id)
        ->with('sender') // Include sender data
        ->get()
        ->map(function ($message) {
            return [
                'id' => $message->id,
                'chat_id' => $message->chat_id,
                'sender_id' => $message->sender_id,
                'receiver_id' => $message->receiver_id,
                'message' => $message->message,
                'is_read' => $message->is_read,
                'created_at' => $message->created_at->diffForHumans(), // Formatted time
                'updated_at' => $message->updated_at,
                'sender_image' => $message->sender->image // Fetch the sender's image
            ];
        });

    return response()->json([
        'status' => 'Messages Retrieved',
        'messages' => $messages
    ], 200);
}


public function getChats()
{
    $chats = Chat::where('participant_one_id', Auth::id())
                 ->orWhere('participant_two_id', Auth::id())
                 ->get();

    return response()->json([
        'status' => 'Chats Retrieved',
        'chats' => $chats
    ], 200);
}

public function markAsRead($message_id)
{
    $message = Message::findOrFail($message_id);

    // Ensure that the current user is either the sender or receiver
    if ($message->receiver_id != Auth::id()) {
        return response()->json(['status' => 'Unauthorized'], 403);
    }

    $message->is_read = true;
    $message->save();

    return response()->json([
        'status' => 'Message Marked as Read',
        'message' => [
            'id' => $message->id,
            'chat_id' => $message->chat_id,
            'sender_id' => $message->sender_id,
            'receiver_id' => $message->receiver_id,
            'message' => $message->message,
            'is_read' => $message->is_read,
            'created_at' => $message->created_at->diffForHumans(),
            'updated_at' => $message->updated_at,
            'sender_image' => $message->sender->image
        ]
    ], 200);
}

public function getNotifications()
{
    $notifications = Auth::user()->notifications;

    return response()->json([
        'status' => 'Notifications Retrieved',
        'notifications' => $notifications
    ], 200);
}


}
