@extends('layouts.app')
@section('title', 'Employer Dashboard')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
@endpush
@section('content')
<div class="container mt-4">
    <h2>Employer Dashboard</h2>
    <p>Welcome, {{ auth()->user()->email }}</p>
</div>
@endsection
