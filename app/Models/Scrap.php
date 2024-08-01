<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scrap extends Model
{
    use HasFactory;

    protected $fillable = ['desc_ar', 'desc_en', 'image'];

    public function getDescAttribute()
    {
        return $this->{'desc_' . app()->getLocale()};
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }
}
