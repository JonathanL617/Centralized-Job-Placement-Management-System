@extends('layouts.app')

@section('title', 'Student Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/student-dashboard.css') }}">
@endpush

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold text-dark">Welcome back, {{ auth()->user()->name }}</h2>
        <p class="text-muted">Here is your internship placement overview.</p>
    </div>
</div>

<!-- Quick Stats Row -->
<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-primary text-white h-100">
            <div class="card-body d-flex flex-column justify-content-center">
                <h6 class="card-title text-uppercase fw-semibold mb-1">Total Applications</h6>
                <h2 class="display-5 fw-bold mb-0">{{ $stats['total_applications'] ?? 0 }}</h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-white text-dark h-100">
            <div class="card-body d-flex flex-column justify-content-center">
                <h6 class="card-title text-uppercase fw-semibold text-muted mb-1">Interviews Scheduled</h6>
                <h2 class="display-5 fw-bold text-primary mb-0">{{ $stats['interviewing_applications'] ?? 0 }}</h2>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 bg-dark text-white h-100">
            <div class="card-body d-flex flex-column justify-content-center">
                <h6 class="card-title text-uppercase fw-semibold mb-1">Offers Received</h6>
                <h2 class="display-5 fw-bold mb-0">{{ $stats['offered_applications'] ?? 0 }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Recommended Jobs Section -->
<div class="row">
    <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
        <h4 class="fw-bold mb-0">Recommended Roles</h4>
        <a href="{{ route('student.jobs.index') }}" class="btn btn-outline-primary btn-sm">View All Jobs</a>
    </div>

    @forelse($recommendedJobs ?? [] as $job)
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="badge bg-primary text-white">{{ $job->match_score ?? 'N/A' }}% Match</span>
                        <small class="text-muted">Posted {{ $job->job->created_at ? $job->job->created_at->diffForHumans() : 'recently' }}</small>
                    </div>
                    <h5 class="card-title fw-bold">{{ $job->job->title ?? 'Unknown Job' }}</h5>
                    <h6 class="card-subtitle mb-3 text-muted"><i class="bi bi-building me-1"></i>{{ $job->job->employer->company_name ?? 'Unknown Company' }}</h6>
                    <p class="card-text text-secondary mb-4">
                        {{ Str::limit($job->job->technical_requirements ?? '', 100) }}
                    </p>
                    <a href="#" class="btn btn-dark w-100">View Details</a>
                </div>
            </div>
        </div>
    @empty
        <!-- Empty State UI -->
        <div class="col-12">
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-body text-center py-5">
                    <i class="bi bi-file-earmark-person display-4 text-muted mb-3 d-block"></i>
                    <h5 class="fw-bold">No recommendations yet</h5>
                    <p class="text-muted mb-0">Upload your resume so our NLP system can match you with the perfect roles.</p>
                    <a href="{{ route('student.resume.index') }}" class="btn btn-primary mt-3">Upload Resume Now</a>
                </div>
            </div>
        </div>
    @endforelse
</div>
@endsection
