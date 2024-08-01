<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'link', 'type', 'name_ar', 'name_en', 'desc_ar', 'desc_en', 'media'];

    public function getNameAttribute()
    {
        return $this->{'name_' . app()->getLocale()};
    }

    public function getDescAttribute()
    {
        return $this->{'desc_' . app()->getLocale()};
    }

    public function getExtAttribute()
    {
        $ext = explode('.', $this->media);

        return end($ext);
    }
}
