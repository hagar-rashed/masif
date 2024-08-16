<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

protected $table = 'restaurants';

protected $fillable = [
    'name', 'location', 'latitude', 'longitude', 'opening_time_from', 'opening_time_to','image_url','description',
    'phone','rating','delivery_time','busy_rate','menu_qr_code'
   
];

protected $casts = [
    'busy_rate' => 'array', 
];

public function menuItems()
{
        return $this->hasMany(MenuItem::class);
}
}
   