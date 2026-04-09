<style>
    .sidebar.toggled {
        width: 65px !important;
    }

    #accordionSidebar.toggled {
        overflow-x: hidden;
    }

    .sidebar.toggled .nav-item {
        width: 65px;
        text-align: center;
    }

    .sidebar.toggled .nav-item .nav-link {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        padding: 10px 0 !important;
        width: 65px;
    }

    .sidebar.toggled .nav-item .nav-link i {
        font-size: 1rem;
        width: auto;
        margin: 0 !important;
        float: none !important;
    }

    .sidebar.toggled .nav-item .nav-link span,
    .sidebar.toggled .sidebar-heading,
    .sidebar.toggled .sidebar-brand-text {
        display: none !important;
    }

    .sidebar.toggled .sidebar-brand {
        justify-content: center !important;
        padding: 10px 0 !important;
    }

    .sidebar.toggled .sidebar-brand-icon {
        margin: 0 !important;
        font-size: 1.2rem;
    }

    .sidebar.toggled hr.sidebar-divider {
        margin: 4px 10px !important;
    }

    .sidebar {
        position: fixed !important;
        top: 0;
        left: 0;
        height: 100vh;
        width: 224px !important; /* Full width */
        z-index: 1000;
        transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        overflow-x: hidden;
    }

    .sidebar .nav-link span,
    .sidebar .sidebar-heading,
    .sidebar .sidebar-brand-text {
        transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .pin-sidebar{
        background: transparent;
        border: none;
        color: rgba(255,255,255,0.5);
        font-size: 0.8rem;
        cursor: pointer;
        padding: 0 4px;
        margin-left: auto;
        line-height: 1;
    }

    .sidebar.toggled #btn-pin-sidebar {
        display: none !important;
    }

    #btn-pin-sidebar.pinned {
        color: #fff !important;
    }

    #btn-pin-sidebar {
        transition: color 0.2s ease, transform 0.2s ease;
    }

    .sidebar-brand-small {
        display: none;
        color: #fff;
    }

    .sidebar-brand-full {
        display: flex;
    }

    .sidebar.toggled .sidebar-brand-small {
        display: block !important;
    }

    .sidebar.toggled .sidebar-brand-full {
        display: none !important;
    }
    .navbar-nav{
        background-color: #5b3cc4
    }
</style>
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard') }}">
        <div class="sidebar-brand-small">
            <i class="fas fa-bars" style="font-size:1.2rem;"></i>
        </div>

        <div class="sidebar-brand-full d-flex align-items-center w-100">
            <div class="sidebar-brand-icon">
                <img src="/img/logo.png" style="width:50px; height:50px; object-fit:contain;">
            </div>
            <div class="sidebar-brand-text mx-3">SIMANTIS</div>
            <button id="btn-pin-sidebar" title="Tahan Sidebar" class="pin-sidebar ml-auto">
                <i class="fas fa-bars"></i>
            </button>
        </div>
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

        <li class="nav-item {{ request()->is('ruangan/data_ruangan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/ruangan/data_ruangan') }}">
                <i class="fas fa-fw fa-building"></i>
                <span>Ruangan</span>
            </a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            INVENTARIS & MAINTENANCE
        </div>

        <li class="nav-item {{ request()->is('ruangan/ruangan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/ruangan/ruangan') }}">
                <i class="fas fa-fw fa-desktop"></i>
                <span>Inventaris IT</span>
            </a>
        </li>

        <li class="nav-item {{ request()->is('maintenance/maintenance*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/maintenance/maintenance') }}"">
                <i class="fas fa-fw fa-calendar-alt"></i>
                <span>Jadwal Maintenance</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLaporan"
                aria-expanded="false" aria-controls="collapseLaporan">
                <i class="fas fa-fw fa-file-alt"></i>
                <span>Laporan</span>
            </a>
            <div id="collapseLaporan" class="collapse" aria-labelledby="headingLaporan"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Pilih Laporan:</h6>
                    <a class="collapse-item {{ request()->is('laporan/inventaris*') ? 'active' : '' }}"
                        href="{{ url('/laporan/inventaris') }}">
                        <i class="fas fa-desktop fa-sm mr-2"></i> Inventaris
                    </a>
                    {{-- <a class="collapse-item {{ request()->is('laporan/maintenance*') ? 'active' : '' }}"
                        href="{{ url('/laporan/maintenance') }}">
                        <i class="fas fa-calendar-alt fa-sm mr-2"></i> Data Maintenance
                    </a> --}}
                </div>
            </div>
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

</ul>
<script>
    var sidebarPinned = false;

    $(document).ready(function () {
        $("body").addClass("sidebar-toggled");
        $(".sidebar").addClass("toggled");
    });

    $(".sidebar").on("mouseenter", function () {
        $("body").removeClass("sidebar-toggled");
        $(".sidebar").removeClass("toggled");
    });

    $(".sidebar").on("mouseleave", function () {
        if (!sidebarPinned) {
            $("body").addClass("sidebar-toggled");
            $(".sidebar").addClass("toggled");
            $('.sidebar .collapse').collapse('hide');
        }
    });

    $("#btn-pin-sidebar").on("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        sidebarPinned = !sidebarPinned;

        if (sidebarPinned) {
            $(this).addClass("pinned");
            $(this).attr("title", "Lepas Tahan");
        } else {
            $(this).removeClass("pinned");
            $(this).attr("title", "Tahan Sidebar");
            $("body").addClass("sidebar-toggled");
            $(".sidebar").addClass("toggled");
            $('.sidebar .collapse').collapse('hide');
        }
    });

    function saveSidebarState(isToggled) {
    localStorage.setItem('sidebarToggled', isToggled);
    localStorage.setItem('sidebarPinned', sidebarPinned);
}

// Load state sidebar dari localStorage
function loadSidebarState() {
    const savedToggled = localStorage.getItem('sidebarToggled') === 'true';
    const savedPinned = localStorage.getItem('sidebarPinned') === 'true';

    sidebarPinned = savedPinned;

    if (savedToggled) {
        $("body").addClass("sidebar-toggled");
        $(".sidebar").addClass("toggled");
    } else {
        $("body").removeClass("sidebar-toggled");
        $(".sidebar").removeClass("toggled");
    }

    // Update pin button
    if (sidebarPinned) {
        $("#btn-pin-sidebar").addClass("pinned").attr("title", "Lepas Tahan");
    }
}

// Update script sidebar yang ada
$(document).ready(function () {
    loadSidebarState(); // Load state instead of always toggled
});

// Update mouse events
$(".sidebar").on("mouseenter", function () {
    if (!sidebarPinned) {
        $("body").removeClass("sidebar-toggled");
        $(".sidebar").removeClass("toggled");
        saveSidebarState(false);
    }
});

$(".sidebar").on("mouseleave", function () {
    if (!sidebarPinned) {
        $("body").addClass("sidebar-toggled");
        $(".sidebar").addClass("toggled");
        saveSidebarState(true);
        $('.sidebar .collapse').collapse('hide');
    }
});

// Update pin button
$("#btn-pin-sidebar").on("click", function (e) {
    e.preventDefault();
    e.stopPropagation();
    sidebarPinned = !sidebarPinned;

    saveSidebarState(!sidebarPinned); // Save opposite state

    if (sidebarPinned) {
        $(this).addClass("pinned").attr("title", "Lepas Tahan");
        $("body").removeClass("sidebar-toggled");
        $(".sidebar").removeClass("toggled");
    } else {
        $(this).removeClass("pinned").attr("title", "Tahan Sidebar");
        $("body").addClass("sidebar-toggled");
        $(".sidebar").addClass("toggled");
        $('.sidebar .collapse').collapse('hide');
    }
});
</script>
