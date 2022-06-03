<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;


class JobFinder extends Model
{
    use HasFactory, Uuids;

    protected $table = 'job_finders';
    protected $fillable = ['user_id', 'full_name', 'birth_date'];
}
