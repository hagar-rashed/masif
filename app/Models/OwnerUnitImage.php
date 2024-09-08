<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OwnerUnitImage extends Model
{
    use HasFactory;
    protected $fillable = ['owner_unit_id', 'image_path'];

    public function ownerUnit()
    {
        return $this->belongsTo(OwnerUnit::class);
    }

}
