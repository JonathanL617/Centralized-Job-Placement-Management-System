<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    protected $table = 'jobs';
    protected $primaryKey = 'job_id';
    protected $fillable = ['employer_id', 'title', 'technical_requirements', 'pipeline_type', 'admin_approval', 'status', 'open_date', 'close_date'];

    public function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id', 'employer_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'job_id', 'job_id');
    }
}
