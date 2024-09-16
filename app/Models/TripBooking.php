<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripBooking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'trip_offer_id',
        'individuals_count',
        'total_cost',
        'qr_code_path'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tripOffer()
    {
        return $this->belongsTo(OfferTrip::class, 'trip_offer_id');
    }

}
