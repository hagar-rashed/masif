<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;
    protected $fillable = [
        'cinema_id',
        'name',
        'image_url',
        'genre',
        'rating',
        'description',
        'certificate',
        'runtime',
        'release_year',
        'director',
        'cast',
        'adult_price',
        'child_price',
    ];
    
    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }
}
