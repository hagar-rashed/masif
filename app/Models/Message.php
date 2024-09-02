<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'chat_id',    // ID of the chat this message belongs to
        'sender_id',  // ID of the user who sent the message
        'receiver_id', // ID of the user who receives the message
        'message',    // The content of the message
        'is_read',    // Whether the message has been read
    ];

    /**
     * Define the relationship between Message and Chat.
     * A message belongs to a chat.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    /**
     * Define the relationship between Message and User (Sender).
     * A message has a sender, who is a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Define the relationship between Message and User (Receiver).
     * A message has a receiver, who is a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Accessor for 'is_read' attribute.
     * This can help ensure a boolean value is always returned.
     *
     * @return bool
     */
    public function getIsReadAttribute($value)
    {
        return (bool) $value;
    }
}
