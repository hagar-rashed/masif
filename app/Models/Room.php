<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Room extends Model
{
    protected $fillable = [
        'hotel_id',
        'room_type',
        'from_date',
        'to_date',
        'number_of_rooms',
        'price_per_night',
        'number_of_nights',
        'original_price',
        'discount',
        'total_price',
        'payment_method',
        'description',
        'facilities',
    ];

    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date',
        'facilities' => 'array',
    ];

    public function getAvailabilityAttribute()
    {
        // Ensure 'from_date' and 'to_date' are Carbon instances before using them
        $fromDate = $this->from_date instanceof Carbon ? $this->from_date : Carbon::parse($this->from_date);
        $toDate = $this->to_date instanceof Carbon ? $this->to_date : Carbon::parse($this->to_date);

        return [
            'from_date' => $fromDate->toDateString(),
            'to_date' => $toDate->toDateString(),
        ];
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

