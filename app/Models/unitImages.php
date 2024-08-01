<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\unit;
class unitImages extends Model
{
    use HasFactory;
    public function units(){
        return $this->belongsTo(unit::class , 'unit_id' , 'id');
    }
}
