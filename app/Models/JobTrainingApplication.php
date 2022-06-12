<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class JobTrainingApplication extends Model
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

    public function getMotivationLetterAttribute($motivation_letter)
    {
        $motivation_letter_path = Storage::url('job_training_application/motivation_letter/');
        return url('/').$motivation_letter_path.$motivation_letter;
    }

    public function getCvAttribute($cv)
    {
        $cv_path = Storage::url('job_training_application/cv/');
        return url('/').$cv_path.$cv;
    }

    public function getPortfolioAttribute($portfolio)
    {
        $portfolio_path = Storage::url('job_training_application/portfolio/');
        return url('/').$portfolio_path.$portfolio;
    }
}
