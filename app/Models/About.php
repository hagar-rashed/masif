<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'desc_ar', 'desc_en'];

    public function getDescAttribute()
    {
        return $this->{'desc_' . app()->getLocale()};
    }
}
