<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Company extends Model
{
    use HasFactory, Uuids;

    protected $fillable = ['user_id', 'name', 'address', 'letter', 'company_logo_small', 'company_logo_big', 'phone', 'ciry', 'postal_code', 'linkedin', 'website'];
}
