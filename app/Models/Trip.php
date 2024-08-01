<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
        'location_ar',
        'location_en',
        'desc_ar',
        'desc_en',
        'price',
        'start_date',
        'end_date',
        'duration',
    ];



    public function __get($key)
    {
        // Check if the requested attribute has an '_ar' and '_en' version
        if (in_array($key, ['name', 'location', 'desc'])) {
            // Return the attribute based on the current locale
            return $this->{$key . '_' . app()->getLocale()};
        }

        // Fallback to the parent __get method for other attributes
        return parent::__get($key);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }
}