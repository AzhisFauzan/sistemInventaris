<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laptop-code"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SIM IT <sup>v1</sup></div>
    </a>

    <hr class="sidebar-divider my-0">

    @if(Auth::user()->role == 'admin')
        <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            DATA MASTER
        </div>

        <li class="nav-item {{ request()->is('user/data_user') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/user/data_user') }}">
                <i class="fas fa-fw fa-users"></i>
                <span>Users</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('kategori*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/kategori') }}">
                <i class="fas fa-fw fa-tags"></i>
                <span>Kategori Perangkat</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('ruangan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/ruangan') }}">
                <i class="fas fa-fw fa-building"></i>
                <span>Ruangan</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            INVENTARIS & MAINTENANCE
        </div>

        <li class="nav-item {{ request()->is('perangkat*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/perangkat') }}">
                <i class="fas fa-fw fa-desktop"></i>
                <span>Data Perangkat IT</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-calendar-alt"></i>
                <span>Jadwal Maintenance</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-history"></i>
                <span>Riwayat Maintenance</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-file-alt"></i>
                <span>Laporan</span>
            </a>
        </li>

    @elseif(Auth::user()->role == 'teknisi')
        <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            INVENTARIS & MAINTENANCE
        </div>

        <li class="nav-item {{ request()->is('perangkat*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/perangkat') }}">
                <i class="fas fa-fw fa-desktop"></i>
                <span>Data Perangkat IT</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-calendar-alt"></i>
                <span>Jadwal Maintenance</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-history"></i>
                <span>Riwayat Maintenance</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-file-alt"></i>
                <span>Laporan</span>
            </a>
        </li>
    @endif

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
