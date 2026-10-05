@extends('layouts.app')

@section('title', 'Login')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endpush

@section('content')
<div class="layout">
    <div class="login-side">

        {{-- Login Card --}}
        <div class="login-card" id="loginCard">
            <img src="{{ asset('images/inti_logo.jpeg') }}" alt="INTI Job Portal">
            <h3>INTI Job Portal</h3>
            <h5>Login</h5>

            {{-- Error Message --}}
            @if ($errors->any())
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif

            {{-- Session Status (e.g. after password reset) --}}
            @if (session('status'))
                <div class="alert-success">{{ session('status') }}</div>
            @endif

            <form action="{{ route('login') }}" method="POST" style="width: 100%;">
                @csrf
                <input type="email" name="email" placeholder="Email"
                       value="{{ old('email') }}" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="btn-main">Log In</button>
            </form>

            <div class="links">
                <a href="#" onclick="showCard('forgotCard'); return false;">Forgot password?</a>
            </div>
        </div>

        {{-- Forgot Password Card --}}
        <div class="reset-password-card" id="forgotCard" style="display: none;">
            <button class="back-button" onclick="showCard('loginCard')">&#60; Back</button>
            <img src="{{ asset('images/inti_logo.jpeg') }}" alt="Logo">
            <h4>Reset Password</h4>

            @if (session('reset_status'))
                <div class="alert-success">{{ session('reset_status') }}</div>
            @endif

            <form action="#" method="POST" style="width: 100%;">
                @csrf
                <input type="email" name="email" placeholder="Enter your email" required>
                <button type="submit" class="btn-main">Send Reset Link</button>
            </form>
        </div>

    </div>
    <div></div>{{-- Right side (background image shows through) --}}
</div>
@endsection

@push('scripts')
<script>
    function showCard(cardId) {
        document.getElementById('loginCard').style.display = 'none';
        document.getElementById('forgotCard').style.display = 'none';
        document.getElementById(cardId).style.display = 'flex';
    }

    // If there were validation errors on the forgot form, re-show it
    @if(session('reset_status'))
        showCard('loginCard');
    @endif
</script>
@endpush
