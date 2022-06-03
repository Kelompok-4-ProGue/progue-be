<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class JobVacancy extends Model
{
    use HasFactory, Uuids;
    protected $table = 'job_vacancies';
    protected $fillable = ['company_id', 'position', 'description', 'requirement', 'additional_requirement', 'city', 'salary', 'category'];

    public function Company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
