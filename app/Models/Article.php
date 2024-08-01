<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar',
        'title_en',
        'desc_ar',
        'desc_en',
        'image',
        'images',
        'category_id',
    ];

    protected $dates = [
        'publish_date',
    ];

    public function getTitleAttribute()
    {
        return $this->{'title_' . app()->getLocale()};
    }

    public function getDescAttribute()
    {
        return $this->{'desc_' . app()->getLocale()};
    }

    public function getDayAttribute()
    {
        $dateFromat = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at']);

        // Get the current app locale
        $locale = app()->getLocale();

        // Tell Carbon to use the current app locale
        Carbon::setlocale($locale);

        $format = $locale === 'ar' ? 'd' : 'd';

        // Use `translatedFormat()` to get a translated date string
        return $dateFromat->translatedFormat($format);
    }

    public function getMonthAttribute()
    {
        $dateFromat = Carbon::createFromFormat('Y-m-d H:i:s', $this->attributes['created_at']);

        // Get the current app locale
        $locale = app()->getLocale();

        // Tell Carbon to use the current app locale
        Carbon::setlocale($locale);

        $format = $locale === 'ar' ? 'M' : 'M';

        // Use `translatedFormat()` to get a translated date string
        return $dateFromat->translatedFormat($format);
    }

    public function getFirstImageAttribute()
    {
        $images = json_decode($this->images, true);

        if (!empty($images)) {
            $firstImage = reset($images);
            return $firstImage;
        }

        return null;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
