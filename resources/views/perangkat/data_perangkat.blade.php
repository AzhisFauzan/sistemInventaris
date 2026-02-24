@extends('layout.page')

@section('content')
<div class="row">
    <div class="col-12">

        <h1 class="h3 mb-2 text-gray-800">Data Perangkat IT</h1>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalPerangkat">
            Add Perangkat
        </button>

        <table class="table table-bordered" id="perangkatTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Inventaris</th>
                    <th>Nama Perangkat</th>
                    <th>Kategori</th>
                    <th>Merk</th>
                    <th>Ruangan</th>
                    <th>Kondisi</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data_perangkat as $perangkat)
                <tr id="row-{{ $perangkat->id_perangkat }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $perangkat->kode_inventaris }}</td>
                    <td>{{ $perangkat->nama_perangkat }}</td>
                    <td>{{ $perangkat->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $perangkat->merk }}</td>
                    <td>{{ $perangkat->ruangan->nama_ruangan ?? '-' }}</td>
                    <td>
                        @if($perangkat->kondisi == 'Baik')
                            <span class="badge bg-success">Baik</span>
                        @elseif($perangkat->kondisi == 'Rusak')
                            <span class="badge bg-danger">Rusak</span>
                        @else
                            <span class="badge bg-warning text-dark">Maintenance</span>
                        @endif
                    </td>
                    <td>
                        <a href="#"><span class="badge bg-success"><i class="fas fa-pencil-alt"></i></span></a>
                        <a href="#" class="btn-delete" data-id="{{ $perangkat->id_perangkat }}">
                            <span class="badge bg-danger"><i class="fas fa-trash"></i></span>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

<div class="modal fade" id="modalPerangkat">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Tambah Perangkat IT</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form id="formPerangkat">
                @csrf
                <div class="modal-body">

                    <div id="alertError" class="alert alert-danger d-none"></div>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Kode Inventaris</label>
                            <input type="text" name="kode_inventaris" id="kode_inventaris" class="form-control" placeholder="Contoh: INV-PC-001">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Nama Perangkat</label>
                            <input type="text" name="nama_perangkat" id="nama_perangkat" class="form-control" placeholder="Contoh: PC Admin">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Kategori</label>
                            <select name="id_kategori" id="id_kategori" class="form-control">
                                <option value="">Pilih Kategori...</option>
                                @foreach($data_kategori as $kategori)
                                    <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Merk</label>
                            <input type="text" name="merk" id="merk" class="form-control" placeholder="Contoh: Dell / HP / Lenovo">
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Ruangan</label>
                            <select name="id_ruangan" id="id_ruangan" class="form-control">
                                <option value="">Pilih Ruangan...</option>
                                @foreach($data_ruangan as $ruangan)
                                    <option value="{{ $ruangan->id_ruangan }}">{{ $ruangan->nama_ruangan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Kondisi</label>
                            <select name="kondisi" id="kondisi" class="form-control">
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>

                        <div class="col-md-12 form-group">
                            <label>Spesifikasi</label>
                            <textarea name="spesifikasi" id="spesifikasi" class="form-control" rows="3" placeholder="Contoh: Core i5, RAM 8GB, SSD 256GB"></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="button" id="savePerangkat">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){

    // ==========================================
    // PROSES SIMPAN DATA (AJAX POST)
    // ==========================================
    $('#savePerangkat').click(function(){

        // Validasi Sederhana Form Kosong
        if($('#kode_inventaris').val() == '' || $('#nama_perangkat').val() == '' || $('#id_kategori').val() == '' || $('#id_ruangan').val() == ''){
            $('#alertError').removeClass('d-none').text('Pastikan Kode, Nama, Kategori, dan Ruangan terisi!');
            return;
        }

        $('#alertError').addClass('d-none');

        $.ajax({
            url: "{{ url('/perangkat/store') }}", // Ngarah ke route post di web.php
            type: "POST",
            data: {
                _token: $('input[name=_token]').val(),
                kode_inventaris: $('#kode_inventaris').val(),
                nama_perangkat: $('#nama_perangkat').val(),
                id_kategori: $('#id_kategori').val(),
                merk: $('#merk').val(),
                spesifikasi: $('#spesifikasi').val(),
                id_ruangan: $('#id_ruangan').val(),
                kondisi: $('#kondisi').val()
            },
            success: function(response){
                if(response.status == 'success'){
                    // Hitung jumlah baris buat nomer urut otomatis
                    let rowCount = $('#perangkatTable tbody tr').length + 1;

                    // Bikin badge kondisi sesuai balikan dari server
                    let badgeKondisi = '';
                    if(response.kondisi == 'Baik') badgeKondisi = '<span class="badge bg-success">Baik</span>';
                    else if(response.kondisi == 'Rusak') badgeKondisi = '<span class="badge bg-danger">Rusak</span>';
                    else badgeKondisi = '<span class="badge bg-warning text-dark">Maintenance</span>';

                    // Tambahin baris baru ke tabel secara live (tanpa reload)
                    $('#perangkatTable tbody').append(`
                        <tr id="row-${response.id_perangkat}">
                            <td>${rowCount}</td>
                            <td>${response.kode_inventaris}</td>
                            <td>${response.nama_perangkat}</td>
                            <td>${response.nama_kategori}</td>
                            <td>${response.merk}</td>
                            <td>${response.nama_ruangan}</td>
                            <td>${badgeKondisi}</td>
                            <td>
                                <a href="#"><span class="badge bg-success"><i class="fas fa-pencil-alt"></i></span></a>
                                <a href="#" class="btn-delete" data-id="${response.id_perangkat}">
                                    <span class="badge bg-danger"><i class="fas fa-trash"></i></span>
                                </a>
                            </td>
                        </tr>
                    `);

                    // Bersihin form dan tutup modal
                    $('#formPerangkat')[0].reset();
                    $('#modalPerangkat').modal('hide');
                    alert('Data perangkat berhasil disimpan');
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

    // ==========================================
    // PROSES HAPUS DATA (AJAX GET)
    // ==========================================
    $(document).on('click', '.btn-delete', function(e){
        e.preventDefault();

        let id = $(this).data('id');

        if(!confirm('Yakin bro ingin menghapus perangkat ini?')){
            return;
        }

        $.ajax({
            url: "{{ url('/perangkat') }}/" + id + "/delete",
            type: "GET",
            success: function(response){
                if(response.status == 'success'){
                    // Hapus baris dari tabel
                    $('#row-' + id).remove();

                    // Bikin ulang nomer urutnya biar rapi lagi
                    $('#perangkatTable tbody tr').each(function(index){
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

    // ==========================================
    // RESET MODAL PAS DITUTUP
    // ==========================================
    $('#modalPerangkat').on('hidden.bs.modal', function(){
        $('#alertError').addClass('d-none').text('');
        $('#formPerangkat')[0].reset();
    });

});
</script>
@endsection
