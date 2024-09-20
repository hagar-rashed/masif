<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Room extends Model
{
    protected $fillable = [
        'hotel_id', 'room_type', 'number_of_beds', 'service', 'night_price','space',
        'description', 'facilities', 'payment_method', 'discount'
    ];

    protected $casts = [
        'facilities' => 'array', // Assuming facilities is stored as JSON
    ];

    public function availability()
    {
        return $this->hasMany(RoomAvailability::class);
    }
    
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public function images()
    {
        return $this->hasMany(RoomImage::class);
    }
    
    public function offers()
    {
        return $this->hasMany(RoomOffer::class);
    }
        
 }

