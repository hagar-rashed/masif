<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id','name', 'description', 'price_before_discount','price_after_discount', 'calories', 'image', 'rating', 'purchase_rate', 'preparation_time'
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    protected $attributes = [
        'image' => 'default-image.png',
    ];
}
