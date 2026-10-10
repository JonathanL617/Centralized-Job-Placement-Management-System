<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Centralized Job Placement Management System')</title>
    
    <!-- Bootstrap 5 CSS (Modern & Efficient) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
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

    <!-- Global Bootstrap Modal -->
    <div class="modal fade" id="globalModal" tabindex="-1" aria-labelledby="globalModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="globalModalLabel">Title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="globalModalContent">
                    <!-- Content injected here via JS -->
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Global Modal Helper
        function openModal(title, contentHtml) {
            document.getElementById('globalModalLabel').innerText = title;
            document.getElementById('globalModalContent').innerHTML = contentHtml;
            const modalElement = document.getElementById('globalModal');
            const modalInstance = new bootstrap.Modal(modalElement);
            modalInstance.show();
        }
        
        function closeModal() {
            const modalElement = document.getElementById('globalModal');
            const modalInstance = bootstrap.Modal.getInstance(modalElement);
            if(modalInstance) {
                modalInstance.hide();
            }
        }
    </script>

    <!-- Inject Page-Specific JS Here -->
    @stack('scripts')
</body>
</html>
