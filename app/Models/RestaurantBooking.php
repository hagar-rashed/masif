<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantBooking extends Model
{
    use HasFactory;
// The table associated with the model
protected $table = 'restaurant_bookings';

// The attributes that are mass assignable
protected $fillable = [
    'full_name',
    'mobile_number',
    'appointment_time',
    'number_of_individuals',
    'payment_method',
    'qr_code_path',
];
}