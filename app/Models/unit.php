<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\unitImage;
class unit extends Model
{
    use HasFactory;

    protected $table = 'units';

    protected $fillable = [
        'location_en',
        'location_ar',
        'lat',
        'lng',
        'name_en',
        'name_ar',
        'price',
        'owner_name_en',
        'owner_name_ar',
        'desc_en',
        'desc_ar',
        'booked',
        'avilable_from',
        'avilable_to',
        'village_id',
    ];
    
    public function images(){
        return $this->hasMany(UnitImage::class , 'unit_id' , 'id');
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function bookings(){
        return $this->hasMany(Booking::class);
    }
}
