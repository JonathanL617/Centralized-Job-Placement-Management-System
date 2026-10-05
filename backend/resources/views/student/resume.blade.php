@extends('layouts.app')
@section('title', 'My Resume')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/resume.css') }}">
@endpush
@section('content')
<div class="container mt-4">
    <h2>Resume Builder</h2>
</div>
@endsection
