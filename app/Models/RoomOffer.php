<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomOffer extends Model
{
    use HasFactory;
    protected $fillable = [
        'room_id',
        'offer_name', 
        'start_date',       // Add this line
        'end_date',         // Add this line       
        'price_before_offer',
        'price_after_offer',
        'discount',
    ];


    protected $dates = [
        'start_date',
        'end_date',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

}
