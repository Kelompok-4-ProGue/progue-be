<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class JobTraining extends Model
{
    use HasFactory, Uuids;
    protected $fillable = ['company_id', 'title', 'description', 'requirement', 'additional_requirement', 'city', 'price', 'is_online'];

    public function Company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
