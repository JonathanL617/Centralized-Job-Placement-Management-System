@extends('layouts.app')

@section('title', 'Browse Jobs')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/jobs.css') }}">
@endpush

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold text-dark">Browse Jobs & Internships</h2>
        <p class="text-muted">Find roles matched to your skills using our NLP analysis.</p>
    </div>
</div>

<div class="row">
    <!-- Sidebar Filters -->
    <div class="col-lg-3 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Filters</h5>
                
                <form action="{{ route('student.jobs.index') }}" method="GET">
                    <!-- Search -->
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-semibold text-uppercase">Search Keyword</label>
                        <input type="text" name="search" class="form-control" placeholder="e.g. Developer, Data..." value="{{ request('search') }}">
                    </div>

                    <!-- Pipeline Type -->
                    <div class="mb-3">
                        <label class="form-label text-muted small fw-semibold text-uppercase">Pipeline</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="pipeline[]" value="academic" id="checkAcademic" {{ in_array('academic', request('pipeline', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="checkAcademic">Academic Internship</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="pipeline[]" value="direct-hire" id="checkDirect" {{ in_array('direct-hire', request('pipeline', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="checkDirect">Direct-Hire</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-2">Apply Filters</button>
                    @if(request()->hasAny(['search', 'pipeline']))
                        <a href="{{ route('student.jobs.index') }}" class="btn btn-outline-secondary w-100 mt-2 btn-sm">Clear Filters</a>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Job Listings (Right Column) -->
    <div class="col-lg-9">
        @forelse($jobs ?? [] as $job)
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge {{ ($job->match_score ?? 0) > 80 ? 'bg-primary' : 'bg-dark' }} text-white me-2">
                                    {{ $job->match_score ?? 'N/A' }}% Match
                                </span>
                                <span class="badge bg-light text-dark border me-2">{{ ucfirst($job->pipeline_type) }}</span>
                                <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $job->close_date ? 'Closes ' . \Carbon\Carbon::parse($job->close_date)->diffForHumans() : 'Open' }}</small>
                            </div>
                            <h4 class="fw-bold mb-1">{{ $job->title }}</h4>
                            <h6 class="text-primary mb-3"><i class="bi bi-building me-1"></i>{{ $job->employer->company_name ?? 'Unknown Company' }}</h6>
                            <p class="text-muted mb-0">
                                {{ Str::limit($job->technical_requirements, 150) }}
                            </p>
                        </div>
                        <div class="col-md-3 text-md-end mt-3 mt-md-0 border-start">
                            <a href="#" class="btn btn-dark w-100 mb-2">View Job</a>
                            <button class="btn btn-outline-secondary w-100 btn-sm">View Skill Gap</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- Empty State UI -->
            <div class="card shadow-sm border-0 bg-white">
                <div class="card-body text-center py-5">
                    <i class="bi bi-search display-4 text-muted mb-3 d-block"></i>
                    <h5 class="fw-bold">No jobs found</h5>
                    <p class="text-muted mb-0">There are currently no active job postings matching your criteria.</p>
                </div>
            </div>
        @endforelse

        <!-- Pagination -->
        @if(isset($jobs) && $jobs instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="mt-4 d-flex justify-content-center">
                {{ $jobs->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>
@endsection
