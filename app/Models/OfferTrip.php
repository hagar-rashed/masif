<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferTrip extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',  
        'tourism_id',
        'name',
        'description',
        'image_path',  
        'rating',
        'reviews_count',
        'start_time',
        'end_time',
        'destination',
        'places',
        'trip_schedule',
        'transportation',
        'hotel_name',
        'hotel_address',
        'hotel_phone', 
        'trip_cost',
        'tax',
        'total_cost',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tourism()
    {
        return $this->belongsTo(Tourism::class);
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

  
    


}
