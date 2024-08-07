<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRCode extends Model
{
    use HasFactory;
    protected $table = 'qrcodes';

    protected $fillable = [
        'name',        
        'email',      
        'village_name',
        'starting_date',
        'expiration_date',
        'duration',
        'code_type',
        'code',
        'qr_code', // Include this column
    ];

}
