<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tourism extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image_url',
        'phone',
        'location',
        'description',
        'facilities',
        'rating'
    ];

    protected $casts = [        
        'facilities' => 'array',
    ];

    public function offerTrips()
    {
        return $this->hasMany(OfferTrip::class);
    }

}


