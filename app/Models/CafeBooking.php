<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CafeBooking extends Model
{
    use HasFactory;
   // The table associated with the model
protected $table = 'cafe_bookings';

// The attributes that are mass assignable
protected $fillable = [
    'cafe_id',
    'user_id',
    'full_name',
    'mobile_number',
    'appointment_time',
    'number_of_individuals',
    'payment_method',
    'qr_code_path',
];

   // Relationship with cafe
   public function cafe()
   {
       return $this->belongsTo(Cafe::class);
   }  
}