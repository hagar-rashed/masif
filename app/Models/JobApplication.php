<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'file',
        'job_vacancy_id'
    ];

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }
}
