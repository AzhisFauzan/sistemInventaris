@extends('layout.page')
@section("judul","Data User")
@section('content')

<style>
    * { box-sizing: border-box; }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding: 4px 0;
    }
    .page-title {
        font-size: 20px;
        font-weight: 600;
        color: #1a1a1a;
        letter-spacing: -0.3px;
        margin: 0;
    }
    .page-subtitle {
        font-size: 13px;
        color: #6b7280;
        margin-top: 2px;
    }

    .btn-add-user {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #00b300;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        padding: 9px 16px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: opacity .15s;
        text-decoration: none;
    }
    .btn-add-user:hover { opacity: 0.85; color: #fff; }

    /* Stats */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: #f9fafb;
        border-radius: 8px;
        padding: 14px 16px;
        border: 0.5px solid #e5e7eb;
    }
    .stat-label {
        font-size: 11px;
        color: #6b7280;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .stat-value {
        font-size: 24px;
        font-weight: 600;
        color: #111827;
    }

    /* Table Card */
    .table-card {
        background: #ffffff;
        border: 0.5px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 100px;
    }
    .table-toolbar {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 14px 20px;
        border-bottom: 0.5px solid #e5e7eb;
    }
    .table-toolbar-title {
        font-size: 14px;
        font-weight: 700;
        color: #111827;
    }

    #userTable {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        margin: 0;
    }
    #userTable thead th {
        text-align: left;
        padding: 10px 20px;
        font-size: 11px;
        font-weight: 600;
        color: #ffffff;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        border-bottom: 0.5px solid #e5e7eb;
        background: #5b3cc4;
    }
    #userTable thead th:first-child { text-align: center; }
    #userTable thead th:last-child { text-align: center; }
    #userTable tbody tr {
        border-bottom: 0.5px solid #f3f4f6;
        transition: background .1s;
    }
    #userTable tbody tr:last-child { border-bottom: none; }
    #userTable tbody tr:hover { background: #f9fafb; }
    #userTable td {
        padding: 12px 20px;
        vertical-align: middle;
        color: #111827;
    }
    #userTable td:first-child { text-align: center; }
    #userTable td:last-child { text-align: center; }

    /* Avatar */
    .user-cell { display: flex; align-items: center; gap: 10px; }
    .avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 600;
        flex-shrink: 0;
    }
    .avatar-admin    { background: #dbeafe; color: #1d4ed8; }
    .avatar-teknisi  { background: #dcfce7; color: #16a34a; }
    .user-name  { font-weight: 500; font-size: 13px; color: #111827; }
    .user-meta  { font-size: 11px; color: #9ca3af; }

    /* Badge */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
    }
    .badge-admin   { background: #dbeafe; color: #1d4ed8; }
    .badge-teknisi { background: #dcfce7; color: #16a34a; }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; display: inline-block; }
    .badge-admin   .badge-dot { background: #1d4ed8; }
    .badge-teknisi .badge-dot { background: #16a34a; }

    /* Action buttons */
    .action-buttons { display: inline-flex; gap: 4px; justify-content: center; }
    .btn-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border: 0.5px solid #e5e7eb;
        border-radius: 6px;
        background: transparent;
        cursor: pointer;
        color: #6b7280;
        transition: all .15s;
        padding: 0;
    }
    .btn-icon:hover { background: #f3f4f6; color: #111827; }
    .btn-icon-danger:hover { background: #fee2e2; color: #dc2626; border-color: #fca5a5; }

    /* Modal */
    .modal-content { border-radius: 12px; border: 0.5px solid #e5e7eb; }
    .modal-header  { border-bottom: 0.5px solid #f3f4f6; padding: 20px 24px 16px; }
    .modal-body    { padding: 20px 24px; }
    .modal-footer  { border-top: 0.5px solid #f3f4f6; padding: 16px 24px; }
    .modal-title   { font-size: 15px; font-weight: 600; color: #111827; }

    .form-label-custom {
        display: block;
        font-size: 11px;
        font-weight: 500;
        color: #6b7280;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }
    .form-control-custom {
        width: 100%;
        padding: 9px 12px;
        border: 0.5px solid #d1d5db;
        border-radius: 8px;
        font-size: 13px;
        color: #111827;
        background: #ffffff;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .form-control-custom:focus {
        border-color: #6b7280;
        box-shadow: 0 0 0 3px rgba(0,0,0,0.06);
    }

    .btn-cancel {
        padding: 8px 16px;
        font-size: 13px;
        border: 0.5px solid #d1d5db;
        border-radius: 8px;
        background: transparent;
        color: #6b7280;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-cancel:hover { background: #f9fafb; }

    .btn-save-modal {
        padding: 8px 20px;
        font-size: 13px;
        font-weight: 500;
        border: none;
        border-radius: 8px;
        background: #111827;
        color: #ffffff;
        cursor: pointer;
        transition: opacity .15s;
    }
    .btn-save-modal:hover { opacity: 0.85; }

    .btn-update-modal {
        padding: 8px 20px;
        font-size: 13px;
        font-weight: 500;
        border: none;
        border-radius: 8px;
        background: #d97706;
        color: #ffffff;
        cursor: pointer;
        transition: opacity .15s;
    }
    .btn-update-modal:hover { opacity: 0.85; }

    .alert-custom-danger {
        background: #fee2e2;
        color: #b91c1c;
        border: 0.5px solid #fca5a5;
        border-radius: 8px;
        padding: 10px 12px;
        font-size: 12px;
        margin-bottom: 16px;
    }
</style>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif

<div class="row">
    <div class="col-md-12">

        <!-- Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Manajemen User</h1>
                <p class="page-subtitle">Kelola akun dan hak akses pengguna sistem</p>
            </div>
            <button class="btn-add-user" data-toggle="modal" data-target="#modalUser">
                <svg width="14" height="14" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <path d="M8 2v12M2 8h12"/>
                </svg>
                Tambah User
            </button>
        </div>

        <!-- Stats -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-label">Total User</div>
                <div class="stat-value" id="stat-total">{{ $data_user->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Admin</div>
                <div class="stat-value" id="stat-admin">{{ $data_user->where('role','admin')->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Teknisi</div>
                <div class="stat-value" id="stat-teknisi">{{ $data_user->where('role','teknisi')->count() }}</div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-card">
            <div class="table-toolbar">
                <span class="table-toolbar-title">Daftar Pengguna</span>
            </div>
            <table id="userTable">
                <thead>
                    <tr>
                        <th style="width:50px">NO</th>
                        <th>Pengguna</th>
                        <th>Role</th>
                        <th style="width:100px">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbody-user">
                    @foreach ($data_user as $user)
                    <tr id="row-{{ $user->id }}">
                        <td style="color:#9ca3af;font-size:12px">{{ $loop->iteration }}</td>
                        <td>
                            <div class="user-cell">
                                <div class="avatar avatar-{{ $user->role }}">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr(strstr($user->name, ' '), 1, 1)) }}
                                </div>
                                <div>
                                    <div class="user-name">{{ $user->name }}</div>
                                    <div class="user-meta">ID #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-{{ $user->role }}">
                                <span class="badge-dot"></span>
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="btn-icon btn-edit"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->name }}"
                                    data-role="{{ $user->role }}"
                                    title="Edit user"
                                    type="button">
                                    <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 2.5l2.5 2.5L4 14H1.5v-2.5L11 2.5z"/>
                                    </svg>
                                </button>
                                <button class="btn-icon btn-icon-danger btn-delete"
                                    data-id="{{ $user->id }}"
                                    title="Hapus user"
                                    type="button">
                                    <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 4h12M5 4V2h6v2M6 7v5M10 7v5M3 4l1 9h8l1-9"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- Modal Tambah User --}}
<div class="modal fade" id="modalUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah User Baru</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="formUser">
                @csrf
                <div class="modal-body">
                    <div id="alertError" class="alert-custom-danger" style="display:none"></div>
                    <div class="form-group">
                        <label class="form-label-custom">Nama</label>
                        <input type="text" name="name" id="name" class="form-control-custom" placeholder="Masukkan nama lengkap">
                    </div>
                    <div class="form-group">
                        <label class="form-label-custom">Password</label>
                        <input type="password" name="password" id="password" class="form-control-custom" placeholder="Masukkan password">
                    </div>
                    <div class="form-group">
                        <label class="form-label-custom">Role</label>
                        <select name="role" id="role" class="form-control-custom">
                            <option value="">Pilih role...</option>
                            <option value="admin">Admin</option>
                            <option value="teknisi">Teknisi</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end" style="gap:8px">
                    <button class="btn-cancel" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn-save-modal" type="button" id="saveUser">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit User --}}
<div class="modal fade" id="modalEditUser" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="formEditUser">
                @csrf
                <div class="modal-body">
                    <div id="alertErrorEdit" class="alert-custom-danger" style="display:none"></div>
                    <input type="hidden" id="edit_id">
                    <div class="form-group">
                        <label class="form-label-custom">Nama</label>
                        <input type="text" id="edit_name" class="form-control-custom" placeholder="Masukkan nama lengkap">
                    </div>
                    <div class="form-group">
                        <label class="form-label-custom">Password <span style="font-weight:400;color:#9ca3af">(kosongkan jika tidak diubah)</span></label>
                        <input type="password" id="edit_password" class="form-control-custom" placeholder="Password baru (opsional)">
                    </div>
                    <div class="form-group">
                        <label class="form-label-custom">Role</label>
                        <select id="edit_role" class="form-control-custom">
                            <option value="">Pilih role...</option>
                            <option value="admin">Admin</option>
                            <option value="teknisi">Teknisi</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end" style="gap:8px">
                    <button class="btn-cancel" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn-update-modal" type="button" id="updateUser">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function getInitials(name) {
    var parts = name.trim().split(' ');
    var init = parts[0][0] || '';
    if (parts.length > 1) init += parts[1][0];
    return init.toUpperCase();
}

function updateStats() {
    var rows = $('#userTable tbody tr');
    var total = rows.length;
    var admin = rows.filter(function() {
        return $(this).find('.badge-admin').length > 0;
    }).length;
    var teknisi = rows.filter(function() {
        return $(this).find('.badge-teknisi').length > 0;
    }).length;
    $('#stat-total').text(total);
    $('#stat-admin').text(admin);
    $('#stat-teknisi').text(teknisi);
}

$(document).ready(function(){

    // ===================== TAMBAH USER =====================
    $('#saveUser').click(function(){
        var name = $('#name').val().trim();
        var pass = $('#password').val().trim();
        var role = $('#role').val();

        if(name == '' || pass == '' || role == ''){
            $('#alertError').show().text('Semua field wajib diisi');
            return;
        }
        $('#alertError').hide();

        $.ajax({
            url: "{{ url('/user/data_user') }}",
            type: "POST",
            data: {
                _token: $('input[name=_token]').val(),
                name: name,
                password: pass,
                role: role
            },
            success: function(response){
                if(response.status == 'success'){
                    var rowCount = $('#userTable tbody tr').length + 1;
                    var idPad   = String(response.id).padStart(4, '0');
                    var initials = getInitials(response.name);
                    $('#userTable tbody').append(`
                        <tr id="row-${response.id}">
                            <td style="color:#9ca3af;font-size:12px">${rowCount}</td>
                            <td>
                                <div class="user-cell">
                                    <div class="avatar avatar-${response.role}">${initials}</div>
                                    <div>
                                        <div class="user-name">${response.name}</div>
                                        <div class="user-meta">ID #${idPad}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-${response.role}">
                                    <span class="badge-dot"></span>
                                    ${response.role.charAt(0).toUpperCase() + response.role.slice(1)}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-icon btn-edit"
                                        data-id="${response.id}"
                                        data-name="${response.name}"
                                        data-role="${response.role}"
                                        title="Edit user" type="button">
                                        <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 2.5l2.5 2.5L4 14H1.5v-2.5L11 2.5z"/>
                                        </svg>
                                    </button>
                                    <button class="btn-icon btn-icon-danger btn-delete"
                                        data-id="${response.id}"
                                        title="Hapus user" type="button">
                                        <svg width="13" height="13" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M2 4h12M5 4V2h6v2M6 7v5M10 7v5M3 4l1 9h8l1-9"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `);
                    $('#formUser')[0].reset();
                    $('#modalUser').modal('hide');
                    updateStats();
                    alert('Data berhasil disimpan');
                }
            },
            error: function(xhr){
                if(xhr.status == 422){
                    var errors = xhr.responseJSON.errors;
                    var msg = '';
                    $.each(errors, function(key, val){ msg += val[0] + '\n'; });
                    $('#alertError').show().text(msg);
                } else {
                    alert('Terjadi kesalahan, silakan coba lagi');
                }
            }
        });
    });

    // ===================== BUKA MODAL EDIT =====================
    $(document).on('click', '.btn-edit', function(e){
        e.preventDefault();
        var id   = $(this).data('id');
        var name = $(this).data('name');
        var role = $(this).data('role');

        $('#edit_id').val(id);
        $('#edit_name').val(name);
        $('#edit_role').val(role);
        $('#edit_password').val('');
        $('#alertErrorEdit').hide().text('');
        $('#modalEditUser').modal('show');
    });

    // ===================== UPDATE USER =====================
    $('#updateUser').click(function(){
        if($('#edit_name').val() == '' || $('#edit_role').val() == ''){
            $('#alertErrorEdit').show().text('Nama dan Role wajib diisi');
            return;
        }
        $('#alertErrorEdit').hide();

        var id = $('#edit_id').val();

        $.ajax({
            url: "{{ url('/user/data_user') }}/" + id + "/update",
            type: "POST",
            data: {
                _token: $('input[name=_token]').val(),
                name: $('#edit_name').val(),
                password: $('#edit_password').val(),
                role: $('#edit_role').val()
            },
            success: function(response){
                if(response.status == 'success'){
                    var row      = $('#row-' + id);
                    var initials = getInitials(response.name);
                    var idPad    = String(id).padStart(4, '0');

                    row.find('.user-cell').html(`
                        <div class="avatar avatar-${response.role}">${initials}</div>
                        <div>
                            <div class="user-name">${response.name}</div>
                            <div class="user-meta">ID #${idPad}</div>
                        </div>
                    `);
                    row.find('td:nth-child(3)').html(`
                        <span class="badge badge-${response.role}">
                            <span class="badge-dot"></span>
                            ${response.role.charAt(0).toUpperCase() + response.role.slice(1)}
                        </span>
                    `);
                    row.find('.btn-edit')
                        .data('name', response.name)
                        .data('role', response.role);

                    $('#modalEditUser').modal('hide');
                    updateStats();
                    alert('Data berhasil diupdate');
                }
            },
            error: function(xhr){
                if(xhr.status == 422){
                    var errors = xhr.responseJSON.errors;
                    var msg = '';
                    $.each(errors, function(key, val){ msg += val[0] + '\n'; });
                    $('#alertErrorEdit').show().text(msg);
                } else {
                    alert('Terjadi kesalahan, silakan coba lagi');
                }
            }
        });
    });

    // ===================== HAPUS USER =====================
    $(document).on('click', '.btn-delete', function(e){
        e.preventDefault();
        var id = $(this).data('id');

        if(!confirm('Yakin ingin menghapus user ini?')){ return; }

        $.ajax({
            url: "{{ url('/user/data_user') }}/" + id + "/delete",
            type: "GET",
            success: function(response){
                if(response.status == 'success'){
                    $('#row-' + id).remove();
                    $('#userTable tbody tr').each(function(index){
                        $(this).find('td:first').text(index + 1);
                    });
                    updateStats();
                    alert('Data berhasil dihapus');
                }
            },
            error: function(){
                alert('Gagal menghapus data, silakan coba lagi');
            }
        });
    });

    // ===================== RESET MODAL =====================
    $('#modalUser').on('hidden.bs.modal', function(){
        $('#alertError').hide().text('');
        $('#formUser')[0].reset();
    });
    $('#modalEditUser').on('hidden.bs.modal', function(){
        $('#alertErrorEdit').hide().text('');
        $('#formEditUser')[0].reset();
    });

});
</script>
@endsection
