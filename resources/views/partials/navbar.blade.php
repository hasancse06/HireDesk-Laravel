<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Jobs</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <span class="nav-link">
                <i class="far fa-user-circle"></i>
                <span class="ml-1 d-none d-md-inline">
                    {{ auth()->user()->name ?? 'User' }}
                </span>
            </span>
        </li>

        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf

                <button type="submit" class="btn btn-link nav-link text-danger">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="ml-1 d-none d-md-inline">Logout</span>
                </button>
            </form>
        </li>
    </ul>
</nav>