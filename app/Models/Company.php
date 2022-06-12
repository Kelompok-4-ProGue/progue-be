<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Storage;

class Company extends Model
{
    use HasFactory, Uuids;

    protected $fillable = ['user_id', 'name', 'address', 'letter', 'company_logo_small', 'company_logo_big', 'phone', 'city', 'postal_code', 'linkedin', 'website'];

    public function getLetterAttribute($letter)
    {
        $company_letter_path = Storage::url('company/letter/');
        return url('/').$company_letter_path.$letter;
    }
    
    public function getCompanyLogoBigAttribute($big_logo)
    {
        $big_logo_path = Storage::url('company/logo/big_logo/');
        return url('/').$big_logo_path.$big_logo;
    }

    public function getCompanyLogoSmallAttribute($small_logo)
    {
        $small_logo_path = Storage::url('company/logo/small_logo/');
        return url('/').$small_logo_path.$small_logo;
    }
}
