<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewChatNotification;
use Illuminate\Support\Facades\App;

class ChatController extends Controller
{
    public function searchParticipants(Request $request)
    {
        // Extract the 'query' parameter from the request
        $searchQuery = $request->input('query'); // or $request->get('query')
    
        // Validate that the search query is a string and not empty
        $request->validate([
            'query' => 'required|string|max:255',
        ]);
    
        // Search users by name or email
        $users = User::where('name', 'like', '%' . $searchQuery . '%')
                     ->orWhere('email', 'like', '%' . $searchQuery . '%')
                     ->get(['id', 'name', 'email', 'image']); // Only return essential fields
    
        return response()->json([
            'status' => 'Participants Found',
            'users' => $users
        ], 200);
    }
    

 
    // Start a chat between two participants, preventing duplicate chats
    public function startChat(Request $request)
    {
        $request->validate([
            'participant_two_id' => 'required|exists:users,id',
        ]);

        $authUserId = Auth::id();
        $participantTwoId = $request->participant_two_id;

        if ($authUserId === $participantTwoId) {
            return response()->json(['status' => 'Error', 'message' => 'Cannot start a chat with yourself'], 400);
        }

        try {
            $existingChat = Chat::where(function ($query) use ($authUserId, $participantTwoId) {
                $query->where('participant_one_id', $authUserId)
                      ->where('participant_two_id', $participantTwoId);
            })->orWhere(function ($query) use ($authUserId, $participantTwoId) {
                $query->where('participant_one_id', $participantTwoId)
                      ->where('participant_two_id', $authUserId);
            })->first();

            if ($existingChat) {
                return response()->json([
                    'status' => 'Chat already exists',
                    'chat' => $existingChat
                ], 200);
            }

            $chat = Chat::create([
                'participant_one_id' => $authUserId,
                'participant_two_id' => $participantTwoId,
            ]);

            $chat->participantTwo->notify(new NewChatNotification($chat));

            return response()->json([
                'status' => 'Chat Started',
                'chat' => $chat
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error starting chat: ' . $e->getMessage());
            return response()->json(['status' => 'Error', 'message' => 'Failed to start chat'], 500);
        }
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
    try {
        $chat = Chat::findOrFail($chat_id);
        $authUserId = Auth::id();

        // Temporarily set the locale to English
        App::setLocale('en');

        $messages = Message::where('chat_id', $chat->id)
            ->with('sender')
            ->get()
            ->map(function ($message) use ($authUserId) {
                $isSent = $message->sender_id == $authUserId;
                return [
                    'id' => $message->id,
                    'chat_id' => $message->chat_id,
                    'sender_id' => $message->sender_id,
                    'receiver_id' => $message->receiver_id,
                    'message' => $message->message,
                    'is_sent' => $isSent,
                    'is_read' => $message->is_read,
                    'created_at' => $message->created_at,
                    'updated_at' => $message->updated_at,
                    'sender_name' => $message->sender->name,
                    'sender_image' => $message->sender->image,
                ];
            });

        return response()->json([
            'status' => 'Messages Retrieved',
            'messages' => $messages
        ], 200);
    } catch (\Exception $e) {
        Log::error('Error retrieving messages: ' . $e->getMessage());
        return response()->json(['status' => 'Error', 'message' => 'Failed to retrieve messages'], 500);
    }
}


public function getChats()
    {
        try {
            $authUserId = Auth::id();

            // Temporarily set the locale to English
            App::setLocale('en');

            $chats = Chat::where('participant_one_id', $authUserId)
                         ->orWhere('participant_two_id', $authUserId)
                         ->with(['participantOne', 'participantTwo', 'messages' => function ($query) {
                             $query->orderBy('created_at', 'desc');
                         }])
                         ->get()
                         ->map(function ($chat) use ($authUserId) {
                             $receiver = $chat->participant_one_id == $authUserId 
                                 ? $chat->participantTwo 
                                 : $chat->participantOne;

                             $unreadMessagesCount = $chat->messages
                                 ->where('receiver_id', $authUserId)
                                 ->where('is_read', false)
                                 ->count();

                             $lastMessage = $chat->messages->first();

                             return [
                                 'chat_id' => $chat->id,
                                 'receiver' => [
                                     'id' => $receiver->id,
                                     'name' => $receiver->name,
                                     'image' => $receiver->image
                                 ],
                                 'unread_messages_count' => $unreadMessagesCount,
                                 'last_message' => $lastMessage ? [
                                     'id' => $lastMessage->id,
                                     'message' => $lastMessage->message,
                                     'sender_id' => $lastMessage->sender_id,
                                     'is_read' => $lastMessage->is_read,
                                     'created_at' => $lastMessage->created_at->diffForHumans(),
                                 ] : null,
                                 'created_at' => $chat->created_at,
                                 'updated_at' => $chat->updated_at,
                             ];
                         });

            return response()->json([
                'status' => 'Chats Retrieved',
                'chats' => $chats
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error retrieving chats: ' . $e->getMessage());
            return response()->json(['status' => 'Error', 'message' => 'Failed to retrieve chats'], 500);
        }
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
