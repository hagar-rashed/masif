<?php

namespace App\Models;
use App\Models\villageImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class village extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
        'desc_ar',
        'desc_en',
        'location_ar',
        'location_en',
        'lat',
        'lng',
        'services_ar',
        'services_en',
        'owner_name_ar',
        'owner_name_en'
    ];
    public function images(){
        return $this->hasMany(villageImages::class , 'village_id' , 'id');
    }
    // public function getNameAttribute()
    // {
    //     return $this->{'name_' . app()->getLocale()};
    // }

    // public function getDescAttribute()
    // {
    //     return $this->{'desc_' . app()->getLocale()};
    // }
    // public function getLocationAttribute()
    // {
    //     return $this->{'location_' . app()->getLocale()};
    // }

    public function __get($key)
    {
        // Check if the requested attribute has an '_ar' and '_en' version
        if (in_array($key, ['name', 'desc', 'location', 'services', 'owner_name'])) {
            // Return the attribute based on the current locale
            return $this->{$key . '_' . app()->getLocale()};
        }

        // Fallback to the parent __get method for other attributes
        return parent::__get($key);
    }

}
