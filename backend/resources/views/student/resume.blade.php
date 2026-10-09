@extends('layouts.app')
@section('title', 'My Resume')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/resume.css') }}">
@endpush
@section('content')
<div class="container mt-4">
    <h2>Resume Builder</h2>
    <!-- Resume form -->
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white fw-bold">Upload New Resume</div>
                <div class="card-body">
                    <!-- IMPORTANT: enctype="multipart/form-data" is required for files! -->
                    <form action="{{ route('student.resume.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Select PDF File</label>
                            <input type="file" name="resume" class="form-control" accept="application/pdf" required>
                            @error('resume')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Upload & Extract Skills</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
