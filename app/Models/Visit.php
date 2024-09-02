<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;
    protected $fillable = [
        'postulant_type',
        'name',
        'purpose_of_visit',
        'number_of_individuals',
        'visit_time_from',
        'visit_time_to',
        'duration_of_visit',
        'pets',
        'pet_type',
        'entry_by_vehicle',
        'vehicle_type',
        'accompanying_individuals',
    ];
}
