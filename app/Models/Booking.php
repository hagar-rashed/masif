<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Units;

class Booking extends Model
{
    use HasFactory;
    protected $fillable = ['check_in', 'check_out', 'price', 'status', 'user_id', 'unit_id', 'trip_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function unit(){
        return $this->belongsTo(unit::class);
    }
    
    public function trip(){
        return $this->belongsTo(Trip::class);
    }
}
