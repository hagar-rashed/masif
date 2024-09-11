<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelImage extends Model
{
    protected $fillable = [
        'hotel_id',
        'image_path',
    ];

    // Each image belongs to a hotel
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}