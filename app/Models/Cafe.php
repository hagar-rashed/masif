<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cafe extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'location', 'latitude', 'longitude', 'opening_time_from', 'opening_time_to','image_url'
       
    ];
}
