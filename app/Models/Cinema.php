<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'location',
        'latitude',
        'longitude',
        'details',
        'image_url',
        'rating',
    ];

    public function movies()
    {
        return $this->hasMany(Movie::class);
    }

    public function screenings()
    {
        return $this->hasMany(Screening::class);
    }
}
