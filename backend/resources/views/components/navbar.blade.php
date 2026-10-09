<nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #004080;"> <!-- Professional Deep Blue -->
    <div class="container">
        <!-- Logo / Brand -->
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            <i class="bi bi-briefcase-fill me-2"></i>Job Placement & Management System
        </a>
        
        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <!-- Left Side: Role-Based Navigation -->
            <ul class="navbar-nav me-auto">
                @auth
                    @if(auth()->user()->role === 'student')
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('student.dashboard') ? 'active fw-bold' : '' }}" href="{{ route('student.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('student.jobs.index') ? 'active fw-bold' : '' }}" href="{{ route('student.jobs.index') }}">Browse Jobs</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('student.applications.index') ? 'active fw-bold' : '' }}" href="{{ route('student.applications.index') }}">My Applications</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('student.resume.index') ? 'active fw-bold' : '' }}" href="{{ route('student.resume.index') }}">Resume Builder</a></li>
                    
                    @elseif(auth()->user()->role === 'employer')
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('employer.dashboard') ? 'active fw-bold' : '' }}" href="{{ route('employer.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('employer.jobs.index') ? 'active fw-bold' : '' }}" href="{{ route('employer.jobs.index') }}">Manage Jobs</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('employer.applications.index') ? 'active fw-bold' : '' }}" href="{{ route('employer.applications.index') }}">Applicants</a></li>
                    
                    @elseif(auth()->user()->role === 'admin')
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active fw-bold' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.jobs.index') ? 'active fw-bold' : '' }}" href="{{ route('admin.jobs.index') }}">Job Approvals</a></li>
                        <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.users.index') ? 'active fw-bold' : '' }}" href="{{ route('admin.users.index') }}">Manage Users</a></li>
                    @endif
                @endauth
            </ul>

            <!-- Right Side: Auth / Profile Dropdown -->
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
                            {{ auth()->user()->email }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        Log Out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Log In</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
