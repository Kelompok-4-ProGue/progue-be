<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Company extends Model
{
    use HasFactory, Uuids;

    protected $fillable = ['user_id', 'company_name', 'company_address', 'company_letter'];
}
