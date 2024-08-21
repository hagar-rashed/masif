<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CafeItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cafe_id','name', 'description', 'price_before_discount','price_after_discount', 'calories', 'image', 'rating', 'purchase_rate', 'preparation_time'
    ];

    public function cafe()
    {
        return $this->belongsTo(Cafe::class);
    }

    protected $attributes = [
        'image' => 'default-image.png',
    ];
}


