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

    public function getMotivationLetterAttribute($motivation_letter)
    {
        $motivation_letter_path = Storage::url('job_vacancy_application/motivation_letter/');
        return url('/').$motivation_letter_path.$motivation_letter;
    }

    public function getCvAttribute($cv)
    {
        $cv_path = Storage::url('job_vacancy_application/cv/');
        return url('/').$cv_path.$cv;
    }

    public function getPortfolioAttribute($portfolio)
    {
        $portfolio_path = Storage::url('job_vacancy_application/portfolio/');
        return url('/').$portfolio_path.$portfolio;
    }
}
