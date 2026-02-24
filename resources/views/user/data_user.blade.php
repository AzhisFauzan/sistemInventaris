@extends('layout.page')

@section('content')
<div class="row">
    <div class="col-12">

        <h1 class="h3 mb-2 text-gray-800">Data User</h1>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalUser">
            Add User
        </button>

        <table class="table table-bordered" id="userTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data_user as $user)
                <tr id="row-{{ $user->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <a href=""><span class="badge bg-success"><i class="fas fa-pencil-alt"></i></span></a>
                        <a href="#" class="btn-delete" data-id="{{ $user->id }}">
                            <span class="badge bg-danger"><i class="fas fa-trash"></i></span>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

<div class="modal fade" id="modalUser">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form id="formUser">
                @csrf
                <div class="modal-body">

                    <div id="alertError" class="alert alert-danger d-none"></div>

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" name="password" id="password" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" id="role" class="form-control">
                            <option value="">Pilih Role</option>
                            <option value="admin">Admin</option>
                            <option value="teknisi">Teknisi</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="button" id="saveUser">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){

    $('#saveUser').click(function(){

        if($('#name').val() == '' || $('#password').val() == '' || $('#role').val() == ''){
            $('#alertError').removeClass('d-none').text('Semua field wajib diisi');
            return;
        }

        $('#alertError').addClass('d-none');

        $.ajax({
            url: "{{ url('/user/data_user') }}",
            type: "POST",
            data: {
                _token: $('input[name=_token]').val(),
                name: $('#name').val(),
                password: $('#password').val(),
                role: $('#role').val()
            },
            success: function(response){
                if(response.status == 'success'){
                    let rowCount = $('#userTable tbody tr').length + 1;
                    $('#userTable tbody').append(`
                        <tr id="row-${response.id}">
                            <td>${rowCount}</td>
                            <td>${response.name}</td>
                            <td>${response.role}</td>
                            <td>
                                <a href="#"><span class="badge bg-success"><i class="fas fa-pencil-alt"></i></span></a>
                                <a href="#" class="btn-delete" data-id="${response.id}">
                                    <span class="badge bg-danger"><i class="fas fa-trash"></i></span>
                                </a>
                            </td>
                        </tr>
                    `);

                    $('#formUser')[0].reset();
                    $('#modalUser').modal('hide');
                    alert('Data berhasil disimpan');
                }
            },
            error: function(xhr){
                if(xhr.status == 422){
                    let errors = xhr.responseJSON.errors;
                    let msg = '';
                    $.each(errors, function(key, val){
                        msg += val[0] + '\n';
                    });
                    $('#alertError').removeClass('d-none').text(msg);
                } else {
                    alert('Terjadi kesalahan, silakan coba lagi');
                }
            }
        });
    });

    $(document).on('click', '.btn-delete', function(e){
        e.preventDefault();

        let id = $(this).data('id');

        if(!confirm('Yakin ingin menghapus user ini?')){
            return;
        }

        $.ajax({
            url: "{{ url('/user/data_user') }}/" + id + "/delete",
            type: "GET",
            success: function(response){
                if(response.status == 'success'){
                    $('#row-' + id).remove();

                    $('#userTable tbody tr').each(function(index){
                        $(this).find('td:first').text(index + 1);
                    });
                    alert('Data berhasil dihapus');
                }
            },
            error: function(xhr){
                alert('Gagal menghapus data, silakan coba lagi');
            }
        });
    });

    $('#modalUser').on('hidden.bs.modal', function(){
        $('#alertError').addClass('d-none').text('');
        $('#formUser')[0].reset();
    });

});
</script>
@endsection
