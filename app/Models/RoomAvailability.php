<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomAvailability extends Model
{
    use HasFactory;

    protected $fillable = ['room_id', 'start_date', 'end_date'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}