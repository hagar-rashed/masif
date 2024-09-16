<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;
    protected $table = 'menu_items';


    protected $fillable = [
        'category_id','name', 'description', 'price_before_discount','price_after_discount', 'calories', 'image', 'rating', 'purchase_rate', 'preparation_time'
    ];

   
    public function category()
    {
       
       return $this->belongsTo(RestaurantCategory::class, 'category_id');
    }


    protected $attributes = [
        'image' => 'default-image.png',
    ];
}
