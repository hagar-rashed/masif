<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'unit_type', 
        'unit_area', 
        'location', 
        'number_of_rooms', 
        'contact_number', 
        'available_entertainment', 
        'number_of_beds', 
        'price', 
        'details', 
        'payment_methods', 
        'pets_available', 
        'add_code_to_telephone',
    ];

    protected $casts = [
        'pets_available' => 'boolean',
        'add_code_to_telephone' => 'boolean',
    ];


    public function images()
    {
        return $this->hasMany(OwnerUnitImage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}