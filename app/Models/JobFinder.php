<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;


class JobFinder extends Model
{
    use HasFactory, Uuids;

    protected $table = 'job_finders';
    protected $fillable = ['user_id', 'name', 'birth_date', 'photo', 'phone', 'address', 'city', 'postal_code', 'birth_place', 'linkedin', 'website'];

    public function getPhotoAttribute($job_finder_photo)
    {
        $job_finder_photo_path = Storage::url('job_finder/profile_image/');
        return url('/').$job_finder_photo_path.$job_finder_photo;
    }
}
