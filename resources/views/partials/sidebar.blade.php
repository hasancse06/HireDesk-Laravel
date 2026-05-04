<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('assets/adminlte/img/AdminLTELogo.png') }}"
             alt="HireDesk Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">

        <span class="brand-text font-weight-light">HireDesk</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/adminlte/img/user2-160x160.jpg') }}"
                     class="img-circle elevation-2"
                     alt="User Image">
            </div>

            <div class="info">
                <a href="#" class="d-block">
                    {{ auth()->user()->name ?? 'User' }}
                </a>

                <small class="text-muted text-capitalize">
                    {{ str_replace('_', ' ', auth()->user()?->primaryRoleName() ?? 'guest') }}
                </small>
            </div>
        </div>

        <div class="form-inline mb-3">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar"
                       type="search"
                       placeholder="Search"
                       aria-label="Search">

                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">JOB BOARD</li>

                <li class="nav-item">
                    <a href="#"
                       class="nav-link">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>Jobs</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#"
                       class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Applications</p>
                    </a>
                </li>

                @role('super_admin|admin')
                    <li class="nav-header">ADMINISTRATION</li>

                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}"
                           class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.roles.index') }}"
                           class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>Roles</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.permissions.index') }}"
                           class="nav-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-key"></i>
                            <p>Permissions</p>
                        </a>
                    </li>
                @endrole

                <li class="nav-header">SYSTEM</li>

                <li class="nav-item">
                    <a href="#"
                       class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Settings</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>