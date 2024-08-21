<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cafe extends Model
{
    protected $fillable = [
        'name', 'location', 'latitude', 'longitude', 'opening_time_from', 'opening_time_to','image_url','description',
        'phone','rating','delivery_time','busy_rate','menu_qr_code'
       
    ];
    
    protected $casts = [
        'busy_rate' => 'array', 
    ];
    
    public function cafeItems()
    {
            return $this->hasMany(CafeItem::class);
    }
}
