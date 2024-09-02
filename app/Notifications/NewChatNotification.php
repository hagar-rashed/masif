<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewChatNotification extends Notification
{
    use Queueable;

    protected $chat;

    public function __construct($chat)
    {
        $this->chat = $chat;
    }

    public function via($notifiable)
    {
        return ['database']; // You can also use 'mail', 'broadcast', etc.
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'You have a new chat request.',
            'chat_id' => $this->chat->id,
            'company_id' => $this->chat->company_id,
            'participant_one_id' => $this->chat->participant_one_id,
            'participant_two_id' => $this->chat->participant_two_id,
        ];
    }
}