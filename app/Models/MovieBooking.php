<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'movie_id',
        'payment_method',
        'booking_date_time',
        'hall',
        'seats',
        'adult_tickets',
        'child_tickets',
        'adult_price',
        'child_price',
        'total_price',
        'qr_code_path',
    ];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

}
