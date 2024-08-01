<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\unit;
class UnitImage extends Model
{
    use HasFactory;

    protected $table = 'units_images';
    
    protected $fillable = [
        'path',
        'unit_id'
    ];


    public function units(){
        return $this->belongsTo(unit::class , 'unit_id' , 'id');
    }
}
