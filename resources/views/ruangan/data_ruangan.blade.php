@extends('layout.page')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1 class="h3 mb-2 text-gray-800">Master Ruangan</h1>

        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalRuangan">
            Add Ruangan
        </button>

        <table class="table table-bordered" id="ruanganTable">
            <thead>
                <tr>
                    <th width="10%">No</th>
                    <th>Nama Ruangan</th>
                    <th width="20%">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data_ruangan as $ruangan)
                <tr id="row-{{ $ruangan->id_ruangan }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ruangan->nama_ruangan }}</td>
                    <td>
                        <a href="#" class="btn-delete" data-id="{{ $ruangan->id_ruangan }}">
                            <span class="badge bg-danger"><i class="fas fa-trash"></i> Hapus</span>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="modalRuangan">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Ruangan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form id="formRuangan">
                @csrf
                <div class="modal-body">
                    <div id="alertErrorRua" class="alert alert-danger d-none"></div>
                    <div class="form-group">
                        <label>Nama Ruangan</label>
                        <input type="text" name="nama_ruangan" id="nama_ruangan" class="form-control" placeholder="Contoh: Lab Komputer, Ruang Admin...">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="button" id="saveRuangan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#saveRuangan').click(function(){
        if($('#nama_ruangan').val() == ''){
            $('#alertErrorRua').removeClass('d-none').text('Nama Ruangan wajib diisi!');
            return;
        }
        $('#alertErrorRua').addClass('d-none');

        $.ajax({
            url: "{{ url('/ruangan/store') }}",
            type: "POST",
            data: {
                _token: $('input[name=_token]').val(),
                nama_ruangan: $('#nama_ruangan').val()
            },
            success: function(response){
                if(response.status == 'success'){
                    let rowCount = $('#ruanganTable tbody tr').length + 1;
                    $('#ruanganTable tbody').append(`
                        <tr id="row-${response.id_ruangan}">
                            <td>${rowCount}</td>
                            <td>${response.nama_ruangan}</td>
                            <td>
                                <a href="#" class="btn-delete" data-id="${response.id_ruangan}">
                                    <span class="badge bg-danger"><i class="fas fa-trash"></i> Hapus</span>
                                </a>
                            </td>
                        </tr>
                    `);
                    $('#formRuangan')[0].reset();
                    $('#modalRuangan').modal('hide');
                }
            }
        });
    });

    $(document).on('click', '.btn-delete', function(e){
        e.preventDefault();
        let id = $(this).data('id');
        if(!confirm('Yakin hapus ruangan ini?')) return;

        $.ajax({
            url: "{{ url('/ruangan') }}/" + id + "/delete",
            type: "GET",
            success: function(response){
                if(response.status == 'success'){
                    $('#row-' + id).remove();
                    $('#ruanganTable tbody tr').each(function(index){
                        $(this).find('td:first').text(index + 1);
                    });
                }
            }
        });
    });

    $('#modalRuangan').on('hidden.bs.modal', function(){
        $('#alertErrorRua').addClass('d-none').text('');
        $('#formRuangan')[0].reset();
    });
});
</script>
@endsection
