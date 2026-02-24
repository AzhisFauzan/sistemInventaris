@extends('layout.page')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1 class="h3 mb-2 text-gray-800">Master Kategori Perangkat</h1>

        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalKategori">
            Add Kategori
        </button>

        <table class="table table-bordered" id="kategoriTable">
            <thead>
                <tr>
                    <th width="10%">No</th>
                    <th>Nama Kategori</th>
                    <th width="20%">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data_kategori as $kategori)
                <tr id="row-{{ $kategori->id_kategori }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kategori->nama_kategori }}</td>
                    <td>
                        <a href="#" class="btn-delete" data-id="{{ $kategori->id_kategori }}">
                            <span class="badge bg-danger"><i class="fas fa-trash"></i> Hapus</span>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalKategori">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="formKategori">
                @csrf
                <div class="modal-body">
                    <div id="alertErrorKat" class="alert alert-danger d-none"></div>
                    <div class="form-group">
                        <label>Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" placeholder="Contoh: PC, Laptop, Printer...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="button" id="saveKategori">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#saveKategori').click(function(){
        if($('#nama_kategori').val() == ''){
            $('#alertErrorKat').removeClass('d-none').text('Nama Kategori wajib diisi!');
            return;
        }
        $('#alertErrorKat').addClass('d-none');

        $.ajax({
            url: "{{ url('/kategori/store') }}",
            type: "POST",
            data: {
                _token: $('input[name=_token]').val(),
                nama_kategori: $('#nama_kategori').val()
            },
            success: function(response){
                if(response.status == 'success'){
                    let rowCount = $('#kategoriTable tbody tr').length + 1;
                    $('#kategoriTable tbody').append(`
                        <tr id="row-${response.id_kategori}">
                            <td>${rowCount}</td>
                            <td>${response.nama_kategori}</td>
                            <td>
                                <a href="#" class="btn-delete" data-id="${response.id_kategori}">
                                    <span class="badge bg-danger"><i class="fas fa-trash"></i> Hapus</span>
                                </a>
                            </td>
                        </tr>
                    `);
                    $('#formKategori')[0].reset();
                    $('#modalKategori').modal('hide');
                }
            }
        });
    });

    $(document).on('click', '.btn-delete', function(e){
        e.preventDefault();
        let id = $(this).data('id');
        if(!confirm('Yakin hapus kategori ini?')) return;

        $.ajax({
            url: "{{ url('/kategori') }}/" + id + "/delete",
            type: "GET",
            success: function(response){
                if(response.status == 'success'){
                    $('#row-' + id).remove();
                    $('#kategoriTable tbody tr').each(function(index){
                        $(this).find('td:first').text(index + 1);
                    });
                }
            }
        });
    });

    $('#modalKategori').on('hidden.bs.modal', function(){
        $('#alertErrorKat').addClass('d-none').text('');
        $('#formKategori')[0].reset();
    });
});
</script>
@endsection
