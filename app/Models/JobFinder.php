<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobFinder extends Model
{
    use HasFactory;
    protected $table = 'job_finders';
    protected $fillable = ['full_name', 'birth_date', 'address'];
}
