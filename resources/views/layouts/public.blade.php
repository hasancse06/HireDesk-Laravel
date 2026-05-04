<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>@yield('title', 'HireDesk Laravel')</title>

    <meta name="description"
          content="@yield('meta_description', 'HireDesk Laravel is a free open-source Laravel job board starter for building custom job portals and recruitment platforms.')">

    <link rel="stylesheet" href="{{ asset('assets/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/adminlte/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/public.css') }}">

    @stack('styles')
</head>

<body class="hiredesk-public-body">

<header class="public-navbar">
    <div class="public-container">
        <div class="public-nav-inner">
            <a href="{{ route('jobs.index') }}" class="public-brand">
                <span class="public-brand-icon">
                    <i class="fas fa-briefcase"></i>
                </span>
                <span>HireDesk</span>
            </a>

            <nav class="public-nav-links">
                <a href="{{ route('jobs.index') }}">Browse Jobs</a>

                @auth
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}" class="public-nav-button">Post / Apply</a>
                @endauth
            </nav>
        </div>
    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="public-footer">
    <div class="public-container">
        <div class="public-footer-inner">
            <p class="mb-0">
                &copy; {{ date('Y') }} HireDesk Laravel. Free open-source job board starter.
            </p>

            <p class="mb-0">
                Built with Laravel 12 and AdminLTE 3.2.0
            </p>
        </div>
    </div>
</footer>

<script src="{{ asset('assets/adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/adminlte/js/adminlte.min.js') }}"></script>

@stack('scripts')
</body>
</html>