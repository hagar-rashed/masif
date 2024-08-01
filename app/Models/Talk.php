<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
    use HasFactory;

    protected $fillable = ['desc_ar', 'desc_en', 'name_ar', 'name_en', 'job_title_ar', 'job_title_en'];

    public function getDescAttribute()
    {
        return $this->{'desc_' . app()->getLocale()};
    }
    public function getNameAttribute()
    {
        return $this->{'name_' . app()->getLocale()};
    }
    public function getJobTitleAttribute()
    {
        return $this->{'job_title_' . app()->getLocale()};
    }
}
