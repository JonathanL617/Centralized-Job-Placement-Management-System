<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INTI Job Portal - @yield('title')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Shared Layout CSS (navbar, hero, global) -->
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">

    <!-- Page-specific CSS injected by each child view -->
    @stack('styles')
</head>
<body data-user-role="{{ auth()->check() ? auth()->user()->role : '' }}">

    {{-- Navbar: only shown when a user is logged in --}}
    @auth
    <header>
        <div class="container">
            <div class="header-content">
                <a href="{{ route('dashboard') }}" class="logo">INTI Job Portal</a>
                <nav>
                    <ul>
                        {{-- Student Navigation --}}
                        @if(auth()->user()->role === 'student')
                            <li><a href="{{ route('jobs.index') }}" class="tab-link">Jobs</a></li>
                            <li><a href="{{ route('applications.index') }}" class="tab-link">My Applications</a></li>
                            <li><a href="{{ route('resume.index') }}" class="tab-link">Resume</a></li>
                        @endif

                        {{-- Employer Navigation --}}
                        @if(auth()->user()->role === 'employer')
                            <li><a href="{{ route('employer.jobs.index') }}" class="tab-link">Manage Jobs</a></li>
                            <li><a href="{{ route('employer.applications.index') }}" class="tab-link">Job Applications</a></li>
                        @endif

                        {{-- Admin Navigation --}}
                        @if(auth()->user()->role === 'admin')
                            <li><a href="{{ route('admin.dashboard') }}" class="tab-link">Dashboard</a></li>
                            <li><a href="{{ route('admin.users.index') }}" class="tab-link">Users</a></li>
                            <li><a href="{{ route('admin.jobs.index') }}" class="tab-link">Jobs</a></li>
                        @endif

                        <li>
                            <a href="#" id="logoutBtn"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Log Out
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    @endauth

    {{-- Main page content injected by each child view --}}
    <main>
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Page-specific JS injected by each child view -->
    @stack('scripts')
</body>
</html>
