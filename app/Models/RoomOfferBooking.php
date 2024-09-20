<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomOfferBooking extends Model
{
    use HasFactory;
    protected $fillable = ['room_id', 'offer_id', 'user_id'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function offer()
    {
        return $this->belongsTo(RoomOffer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}