<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'desc_ar',
        'desc_en',
        'requirements_ar',
        'requirements_en',
    ];

    public function getNameAttribute()
    {
        return $this->{'name_' . app()->getLocale()};
    }

    public function getDescAttribute()
    {
        return $this->{'desc_' . app()->getLocale()};
    }

    public function getRequirementsAttribute()
    {
        return $this->{'requirements_' . app()->getLocale()};
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
