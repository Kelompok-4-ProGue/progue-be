<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    use HasFactory;
    protected $table = 'job_vacancies';
    protected $fillable = ['user_skill_id', 'company_id', 'position', 'city', 'salary'];
}
