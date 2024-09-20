<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
        
    use HasFactory;

    protected $fillable = ['cinema_id', 'movie_id', 'screening_date', 'screening_time', 'name','adult_price','child_price'];


    // Relationship with Cinema
    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    // Relationship with Movie
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    // Relationship with Seats
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
}

