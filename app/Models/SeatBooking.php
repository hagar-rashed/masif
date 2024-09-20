<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeatBooking extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'seat_id', 'seat_numbers', 'payment_method',
        'number_of_adult_tickets', 'number_of_child_tickets', 'total_price', 'qr_code'
    ];



    public function seat()
{
    return $this->belongsTo(Seat::class);
}


public function user()
{
    return $this->belongsTo(User::class);
}

}
