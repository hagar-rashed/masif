<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Other extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'image',
        'phone',
        'location',
        'latitude',
        'longitude',
        'description',
        'opening_time_from',
        'opening_time_to',
        'delivery_time',
        'rating'
    ];

}
