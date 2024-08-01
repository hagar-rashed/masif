<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = [

        'desc_ar',
        'desc_en',
       
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function unit(){
        return $this->belongsTo(unit::class);
    }
}