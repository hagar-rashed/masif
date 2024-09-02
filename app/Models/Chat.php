<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', // Company involved in the chat
        'participant_one_id', // The first participant (could be owner or client)
        'participant_two_id'  // The second participant (could be owner or client)
    ];

    // Define relationships

    // A chat has many messages
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Optionally, you can define relationships to the User model
    public function participantOne()
    {
        return $this->belongsTo(User::class, 'participant_one_id');
    }

    public function participantTwo()
    {
        return $this->belongsTo(User::class, 'participant_two_id');
    }
}
