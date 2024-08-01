<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    use HasFactory;

    protected $fillable = ['desc_ar', 'desc_en', 'seoable_id', 'seoable_type'];

    public function getDescAttribute()
    {
        return $this->{'desc_' . app()->getLocale()};
    }

    public function seoable()
    {
        return $this->morphTo();
    }
}
