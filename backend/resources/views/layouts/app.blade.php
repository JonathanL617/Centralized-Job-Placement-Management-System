<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Centralized Job Placement Management System')</title>
    
    <!-- Bootstrap 5 CSS (Modern & Efficient) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts (Montserrat) -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Global Shared Styles -->
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    
    <!-- Inject Page-Specific CSS Here -->
    @stack('styles')
</head>
<body class="bg-light" style="font-family: 'Montserrat', sans-serif;">

    <!-- Navbar Component -->
    <x-navbar />

    <!-- Main Content Injection Slot -->
    <main class="container py-5">
        @yield('content')
    </main>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Inject Page-Specific JS Here -->
    @stack('scripts')
</body>
</html>
