<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'employer_id';
    protected $fillable = ['user_id', 'company_name', 'registration_number', 'verification_status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function jobPostings()
    {
        return $this->hasMany(JobPosting::class, 'employer_id', 'employer_id');
    }
}
