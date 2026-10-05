<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';
    protected $primaryKey = 'application_id';
    protected $fillable = ['job_id', 'student_id', 'match_score', 'skill_gap_report', 'tracking_status'];
    protected $casts = ['skill_gap_report' => 'array'];

    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class, 'job_id', 'job_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'application_id', 'application_id');
    }
}
