<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;
    
    protected $fillable = ['screen_id', 'seat_number', 'row_number', 'status'];

        // Relationship with Screening
       
    
        public function screen()
        {
            return $this->belongsTo(Screen::class);
        }
        
   
}




