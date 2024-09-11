<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


    class Hotel extends Model
    {
        protected $fillable = [
            'user_id',
            'name',
            'image_path',
            'qr_code',
            'phone',
            'location',
            'star_rating',
            'services',
        ];
    
        // A hotel has many rooms
        public function rooms()
        {
            return $this->hasMany(Room::class);
        }
    
        // Cast services as an array
        protected $casts = [
            'services' => 'array',
        ];

        public function images()
        {
            return $this->hasMany(HotelImage::class);
        }
    
        
    }