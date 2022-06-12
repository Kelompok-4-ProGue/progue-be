<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class JobVacancyApplication extends Model
{
    use HasFactory, Uuids;
    protected $fillable = ['job_vacancy_id', 'job_finder_id', 'motivation_letter', 'cv', 'portfolio', 'status'];

    public function JobVacancy()
    {
        return $this->belongsTo('App\Models\JobVacancy');
    }

    public function JobFinder()
    {
        return $this->belongsTo('App\Models\JobFinder');
    }
}
