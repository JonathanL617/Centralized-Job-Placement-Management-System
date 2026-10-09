<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function index(){
        //return student info from session
        $studentId = auth()->user()->student->student_id;

        //count total + by status (pending, interviewing, offered)
        // into array and return
        $total_applications = \App\Models\Application::where('student_id', $studentId)->count();
        $pending_applications = \App\Models\Application::where('student_id', $studentId)->where('tracking_status', 'pending')->count();
        $interviewing_applications = \App\Models\Application::where('student_id', $studentId)->where('tracking_status', 'interviewing')->count();
        $offered_applications = \App\Models\Application::where('student_id', $studentId)->where('tracking_status', 'offered')->count();
        $accepted_applications = \App\Models\Application::where('student_id', $studentId)->where('tracking_status', 'accepted')->count();
        $rejected_applications = \App\Models\Application::where('student_id', $studentId)->where('tracking_status', 'rejected')->count();

        $stats = [
            'total_applications' => $total_applications,
            'pending_applications' => $pending_applications,
            'interviewing_applications' => $interviewing_applications,
            'offered_applications' => $offered_applications,
            'accepted_applications' => $accepted_applications,
            'rejected_applications' => $rejected_applications
        ];

        //fetch top 3 jobs from job posting based on highest match score
        $recommendedJobs = \App\Models\Application::with(['job', 'job.employer'])
            ->where('student_id', $studentId)
            ->orderBy('match_score', 'desc')
            ->take(3)
            ->get();

        return view('student.dashboard', compact('stats', 'recommendedJobs'));
    }
}
