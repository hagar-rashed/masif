<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'author_ar',
        'author_en',
        'publisher_ar',
        'publisher_en',
        'edition_ar',
        'edition_en',
        'physical_desc_ar',
        'physical_desc_en',
        'desc_ar',
        'desc_en',
        'image',
        'file',
        'type',
    ];

    public function getTitleAttribute()
    {
        return $this->{'title_' . app()->getLocale()};
    }

    public function getAuthorAttribute()
    {
        return $this->{'author_' . app()->getLocale()};
    }

    public function getPublisherAttribute()
    {
        return $this->{'publisher_' . app()->getLocale()};
    }

    public function getEditionAttribute()
    {
        return $this->{'edition_' . app()->getLocale()};
    }

    public function getPhysicalDescAttribute()
    {
        return $this->{'physical_desc_' . app()->getLocale()};
    }

    public function getDescAttribute()
    {
        return $this->{'desc_' . app()->getLocale()};
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }
}
