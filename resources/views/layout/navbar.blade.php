<nav class="navbar navbar-expand navbar-light bg-white topbar shadow"
    style="position: sticky; top: 0; z-index: 999; min-height: 40px; padding: 0 1rem;">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <div style="line-height: 2.0;">
        <span class="d-block font-weight-bold" style="font-size: 0.85rem; font-family: 'Poppins', 'Segoe UI', sans-serif; color: #1a1a1a; letter-spacing: 0.2px;">Selamat Datang,
        </span>
        <span class="d-block font-weight-bold" style="font-size: 0.70rem; font-family: 'Poppins', 'Segoe UI', sans-serif; color: #1a1a1a; letter-spacing: 0.2px;">{{ ucfirst(Auth::user()->name) }}</span>
    </div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Lonceng Notifikasi -->
        <li class="nav-item mx-2" style="display: flex; align-items: center;">
            <a class="nav-link py-1" href="#" id="alertsDropdownBtn" style="position: relative; display: flex; align-items: center;">
                <i class="fas fa-bell fa-lg" style="color: gray;"></i>
                <!-- Badge Notifikasi Angka -->
                <span class="badge badge-danger" style="position: absolute; top: 18px; right: 5px; font-size: 0.65rem; border-radius: 50%; padding: 3px 5px;">3</span>
            </a>

            <!-- Dropdown Custom Notifikasi -->
            <div id="alertsDropdownMenu" class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                style="display:none; position:absolute; right:0; top:100%; width: 250px;">
                <h6 class="dropdown-header" style="background-color: #f8f9fa; border-bottom: 1px solid #ddd; padding: 10px 15px; margin-top: 0; font-weight: bold; color: #333;">
                    Pusat Notifikasi
                </h6>

                <!-- Item Notifikasi (Bisa di-looping pakai framework mu) -->
                <a class="dropdown-item d-flex align-items-center" href="#" style="padding: 10px 15px; border-bottom: 1px solid #ff0000; white-space: normal;">
                    <div style="line-height: 1.2;">
                        <div class="small text-muted" style="font-size: 0.75rem;">11 Mei 2026</div>
                        <span style="font-size: 0.85rem; font-weight: 500;">Pesan baru dari Admin telah diterima.</span>
                    </div>
                </a>

                <a class="dropdown-item text-center small text-muted py-2" href="#">Lihat Semua Notifikasi</a>
            </div>
        </li>

        <!-- Nav Item - User Information -->
        <li class="nav-item">
           <a class="nav-link py-1" href="#" id="userDropdownBtn" style="display: flex; align-items: center; background-color: white;">
                <i class="fas fa-user-circle fa-2x" style="margin-right: 10px; color: gray;"></i>
                <div class="d-none d-lg-block text-left" style="line-height: 1.2;">
                    <span class="d-block font-weight-bold" style="font-size: 0.85rem; font-family: 'Poppins', 'Segoe UI', sans-serif; color: #1a1a1a; letter-spacing: 0.2px;">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
            </a>

            <!-- Dropdown Custom User -->
            <div id="userDropdownMenu" class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                style="display:none; position:absolute; right:0; top:100%;">
                <a class="dropdown-item" href="#" id="logoutBtn">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h6 class="modal-title">
                    <i class="fas fa-sign-out-alt mr-2 text-danger"></i>Konfirmasi Logout
                </h6>
                <button class="close" type="button" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body py-2 small">Apakah Anda yakin ingin logout?</div>
            <div class="modal-footer py-2">
                <button class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Batal</button>
                <a href="{{ url('/logout') }}" class="btn btn-danger btn-sm">
                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle untuk Dropdown User
    document.getElementById('userDropdownBtn').addEventListener('click', function (e) {
        e.preventDefault();
        var userMenu = document.getElementById('userDropdownMenu');
        var alertsMenu = document.getElementById('alertsDropdownMenu');

        alertsMenu.style.display = 'none'; // Tutup notifikasi kalau user diklik
        userMenu.style.display = userMenu.style.display === 'none' ? 'block' : 'none';
    });

    // Toggle untuk Dropdown Notifikasi
    document.getElementById('alertsDropdownBtn').addEventListener('click', function (e) {
        e.preventDefault();
        var alertsMenu = document.getElementById('alertsDropdownMenu');
        var userMenu = document.getElementById('userDropdownMenu');

        userMenu.style.display = 'none'; // Tutup user menu kalau notifikasi diklik
        alertsMenu.style.display = alertsMenu.style.display === 'none' ? 'block' : 'none';
    });

    // Menutup dropdown jika klik di luar area
    document.addEventListener('click', function (e) {
        var userMenu = document.getElementById('userDropdownMenu');
        var userBtn = document.getElementById('userDropdownBtn');
        var alertsMenu = document.getElementById('alertsDropdownMenu');
        var alertsBtn = document.getElementById('alertsDropdownBtn');

        if (!userBtn.contains(e.target) && !userMenu.contains(e.target)) {
            userMenu.style.display = 'none';
        }

        if (!alertsBtn.contains(e.target) && !alertsMenu.contains(e.target)) {
            alertsMenu.style.display = 'none';
        }
    });

    // Trigger Modal Logout
    document.getElementById('logoutBtn').addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('userDropdownMenu').style.display = 'none';
        $('#logoutModal').modal('show');
    });
</script>
