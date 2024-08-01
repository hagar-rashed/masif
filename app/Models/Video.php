<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'desc_ar',
        'desc_en',
        'url',
        'type',
    ];

    public function getTitleAttribute()
    {
        return $this->{'title_' . app()->getLocale()};
    }

    public function getDescAttribute()
    {
        return $this->{'desc_' . app()->getLocale()};
    }

    public function getThumbnailAttribute()
    {
        $url = $this->attributes['url'];
        $url_components = parse_url($url);
        if (array_key_exists('query', $url_components)) {
            parse_str($url_components['query'], $params);
            $key = $params['v'];
        } else {
            $key = str_replace('/', '', $url_components['path']);
        }

        return 'http://img.youtube.com/vi/' . $key . '/mqdefault.jpg';
    }

    public function getLinkAttribute()
    {
        $url = $this->attributes['url'];

        $url_components = parse_url($url);
        if (array_key_exists('query', $url_components)) {
            parse_str($url_components['query'], $params);
            $key = $params['v'];
        } else {
            $key = str_replace('/', '', $url_components['path']);
        }

        return 'https://www.youtube.com/embed/' . $key;
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }
}
