<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tourism extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'image_url',
        'qr_code',
        'phone',
        'location',
        'description',
        'facilities',
        'rating',
        'latitude',
        'longitude'
    ];

    protected $casts = [        
        'facilities' => 'array',
    ];

    public function offerTrips()
    {
        return $this->hasMany(OfferTrip::class);
    }

}


