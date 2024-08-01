<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'desc_ar',
        'desc_en',
        'price',
        'village_id',
    ];

    // Define the relationship with the Village model
    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}
