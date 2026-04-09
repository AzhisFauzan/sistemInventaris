@extends('layout.page')
@section("judul","Data Kategori")
@section('content')
<style>
    #thead-table{
        background-color: purple;
    }
    #tr-no-action{
        color: white
    }
     #tbody-user{
        color:black
     }
     .badge-delete{
        color:red;
    }
    </style>
<div class="row">
    <div class="col-md-12">

<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 mb-2 text-gray-800">Master Kategori Perangkat</h1>
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalKategori">
            Add Kategori
            </button>
        </div>
        <div class="card" style="width: 100%;margin-bottom:100px">
            <div class="card-body">
                <table class="table table-striped table-sm" id="kategoriTable">
                    <thead id="thead-table">
                        <tr id="tr-no-action">
                            <th class="text-center" width="0.5%">No</th>
                            <th class="text-center" width="15%">Nama Kategori</th>
                            <th class="text-center" width="1%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-user">
                        @foreach ($data_kategori as $kategori)
                        <tr id="row-{{ $kategori->id_kategori }}">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $kategori->nama_kategori }}</td>
                            {{-- <td class="text-center">
                                <a href="#" class="btn-delete" data-id="{{ $kategori->id_kategori }}">
                                    <span class="badge bg-danger"><i class="fas fa-trash"></i></span>
                                </a>
                            </td> --}}
                            <td class="text-center">
                            <button class="btn-delete border-0 bg-transparent p-0"
                                    data-id="{{ $kategori->id_kategori }}"
                                    type="button">
                                <span class="badge-delete"><i class="fas fa-trash"></i></span>
                            </button>
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
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
