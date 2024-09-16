<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Room extends Model
{
    protected $fillable = [
        'hotel_id', 'room_type', 'number_of_beds', 'service', 'night_price','image_path','space',
        'description', 'facilities', 'payment_method', 'discount'
    ];

    protected $casts = [
        'facilities' => 'array', // Assuming facilities is stored as JSON
    ];

    public function availability()
    {
        return $this->hasMany(RoomAvailability::class);
    }
    
       
        // A room belongs to a hotel
        public function hotel()
        {
            return $this->belongsTo(Hotel::class);
        }
    
        public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    
   
        
        
    }

