<nav class="navbar navbar-expand navbar-light bg-white topbar shadow"
    style="position: sticky; top: 0; z-index: 999; min-height: 40px; padding: 0 1rem;">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
        <div style="line-height: 2.0;">
        <span class="d-block font-weight-bold" style="font-size: 0.85rem; font-family: 'Poppins', 'Segoe UI', sans-serif; color: #1a1a1a; letter-spacing: 0.2px;">Selamat Datang,
        </span>
        <span class="d-block" style="font-size: 0.70rem; font-family: 'Poppins', 'Segoe UI', sans-serif; color: #1a1a1a; letter-spacing: 0.2px; text-decoration: underline;">{{ ucfirst(Auth::user()->role) }}</span>
    </div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
           <a class="nav-link py-1" href="#" id="userDropdownBtn" style="display: flex; align-items: center; background-color: white;">
                <i class="fas fa-user-circle fa-2x" style="margin-right: 10px; color: gray;"></i>
                <div class="d-none d-lg-block text-left" style="line-height: 1.2;">
                    <span class="d-block font-weight-bold" style="font-size: 0.85rem; font-family: 'Poppins', 'Segoe UI', sans-serif; color: #1a1a1a; letter-spacing: 0.2px;">{{ Auth::user()->name }}</span>
                </div>
            </a>

            <!-- Dropdown Custom -->
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
    document.getElementById('userDropdownBtn').addEventListener('click', function (e) {
        e.preventDefault();
        var menu = document.getElementById('userDropdownMenu');
        menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
    });

    document.addEventListener('click', function (e) {
        var menu = document.getElementById('userDropdownMenu');
        var btn = document.getElementById('userDropdownBtn');
        if (!btn.contains(e.target) && !menu.contains(e.target)) {
            menu.style.display = 'none';
        }
    });

    document.getElementById('logoutBtn').addEventListener('click', function (e) {
        e.preventDefault();
        document.getElementById('userDropdownMenu').style.display = 'none';
        $('#logoutModal').modal('show');
    });
</script>
