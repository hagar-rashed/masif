<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CafeCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'image_url',
        'cafe_id',
       
    ];

    public function cafe()
    {
        return $this->belongsTo(Cafe::class);
    }

    public function items()
    {
       // return $this->hasMany(CafeItem::class);
       return $this->hasMany(CafeItem::class, 'category_id');
    }
}
