<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

protected $table = 'restaurants';

protected $fillable = [
    'name', 'location', 'lat', 'lng', 'opening_time_from', 'opening_time_to','image_url'
   
];
}
   