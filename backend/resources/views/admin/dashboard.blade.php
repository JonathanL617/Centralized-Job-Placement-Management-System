@extends('layouts.app')
@section('title', 'Admin Dashboard')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
@endpush
@section('content')
<div class="container mt-4">
    <h2>Admin Dashboard</h2>
    <p>Welcome, {{ auth()->user()->email }}</p>
</div>
@endsection
