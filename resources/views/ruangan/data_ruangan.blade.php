@extends('layout.page')
@section("judul","Data Ruangan")
@section('content')
<style>
    .badge-delete{
        color:red;
    }
    .badge-edit{
        color:orange;
    }
    #table-thead {
        background-color:purple;
    }
    #ruanganTable tbody tr td {
        vertical-align: middle;
    }
    #tr-no-action{
        color: white
    }
    #search_ruangan{
        width: 30%
    }
    #tbody-user{
        color:black;
        float: center;
        justify-content: center
     }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 mb-0 text-gray-800">Master Ruangan</h1>
            <button class="btn btn-primary" data-toggle="modal" data-target="#modalTambahruangan">
                <i class="fas fa-plus mr-1"></i> Add Ruangan
            </button>
        </div>

        <form method="GET" action="{{ url('ruangan/data_ruangan') }}" class="d-flex" id="formSearch" style="gap: 6px;">
            <div class="input-group mb-1" id="search_ruangan">
                <input type="hidden" name="lokasi" value="{{ $lokasi }}">
                <div class="position-relative w-100">
                    <i class="fas fa-search position-absolute" style="left: 10px; top: 50%; transform: translateY(-50%); color: #aaa; z-index: 10;"></i>
                    <input type="text" name="search" id="inputSearch" class="form-control form-control-sm" style="padding-left: 30px;" placeholder="Cari nama ruangan..." value="{{ $search }}">
                </div>
            </div>
            @if($search)
                <a href="{{ url('ruangan/data_ruangan') }}?lokasi={{ $lokasi }}"
                    class="btn btn-sm btn-secondary d-flex align-items-center justify-content-center"
                    style="height: calc(1.5em + .5rem + 2px); width: calc(1.5em + .5rem + 2px); padding: 0;">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </form>
        <br>
        <div class="card" style="width: 100%;">
            <div class="card-body">
                <table class="table table-striped table-sm" id="ruanganTable">
                    <thead id="table-thead">
                        <tr id="tr-no-action">
                            <th width="0.5%" class="text-center">No</th>
                            <th class="text-center" width="5%">Nama Ruangan</th>
                            <th class="text-center" width="1%">Lokasi</th>
                            <th width="1%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-user" class="table-light">
                        @foreach ($data_ruangan as $index => $ruangan)
                        <tr id="row-{{ $ruangan->id_ruangan }}">
                            <td class="text-center">{{ $data_ruangan->firstItem() + $index }}</td>
                            <td class="text-left">{{ $ruangan->nama_ruangan }}</td>
                            <td class="text-center">{{ $ruangan->lokasi }}</td>
                            <td class="text-center">
                            <button class="btn-edit border-0 bg-transparent p-0"
                                    data-id_ruangan="{{ $ruangan->id_ruangan }}"
                                    data-nama_ruangan="{{ $ruangan->nama_ruangan }}"
                                    data-lokasi="{{ $ruangan->lokasi }}"
                                    type="button">
                                <span class="badge-edit"><i class="fas fa-edit"></i></span>
                            </button>
                            <button class="btn-hapus border-0 bg-transparent p-0"
                                    data-id_ruangan="{{ $ruangan->id_ruangan }}"
                                    data-nama_ruangan="{{ $ruangan->nama_ruangan }}"
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

        <div class="d-flex justify-content-between align-items-center mt-2">
            <small class="text-gray-500">
                Menampilkan {{ $data_ruangan->firstItem() }} - {{ $data_ruangan->lastItem() }}
                dari {{ $data_ruangan->total() }} data
            </small>
            {{ $data_ruangan->appends(['lokasi' => $lokasi])->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modalTambahruangan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('ruangan/data_ruangan') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Tambah Ruangan</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Ruangan</label>
                        <input type="text" class="form-control" name="nama_ruangan" placeholder="Masukkan nama ruangan" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lokasi</label>
                        <select class="form-control" name="lokasi" required>
                            <option value="" disabled selected>&lt;---- Pilih Lokasi ----&gt;</option>
                            <option value="Lt. 1">Lantai 1</option>
                            <option value="Lt. 2">Lantai 2</option>
                            <option value="Lt. 3">Lantai 3</option>
                        </select>
                        {{-- <input type="number" class="form-control" name="lokasi" placeholder="Masukkan lokasi" required> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade" id="modalEditruangan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEditruangan" method="POST">
                @csrf
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Edit Ruangan</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Ruangan</label>
                        <input type="text" class="form-control" id="edit_ruangan" name="nama_ruangan" required>
                    </div>
                    <div <label class="form-label">Lokasi</label>
                        <select class="form-control" name="lokasi" id="edit_lokasi" required>
                            <option value="" disabled selected>&lt;---- Pilih Lokasi ----&gt;</option>
                            <option value="Lt. 1">Lantai 1</option>
                            <option value="Lt. 2">Lantai 2</option>
                            <option value="Lt. 3">Lantai 3</option>
                        </select>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="submit" form="formEditruangan" class="btn btn-warning">Update</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Hapus --}}
<div class="modal fade" id="modalHapusruangan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Hapus Ruangan</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="bi bi-exclamation-triangle-fill text-danger" style="font-size: 2rem;"></i>
                <p class="mt-2">Apakah Anda yakin ingin menghapus ruangan <strong id="hapus_nama_ruangan"></strong>?</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="formHapus" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const baseUrl = "{{ url('') }}";

    const inputSearch = document.getElementById('inputSearch');
    let debounceTimer;

    inputSearch.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function() {
            document.getElementById('formSearch').submit();
        }, 500);
    });

    document.getElementById('modalTambahruangan').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            document.querySelector('#modalTambahruangan button[type="submit"]').click();
        }
    });

    document.querySelectorAll('.btn-edit').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('edit_ruangan').value = this.dataset.nama_ruangan;
            document.getElementById('edit_lokasi').value  = this.dataset.lokasi;
            document.getElementById('formEditruangan').action = baseUrl + '/ruangan/data_ruangan/' + this.dataset.id_ruangan + '/update';
            $('#modalEditruangan').modal('show');
        });
    });

    document.querySelectorAll('.btn-hapus').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.getElementById('hapus_nama_ruangan').textContent = this.dataset.nama_ruangan;
            document.getElementById('formHapus').action = baseUrl + '/ruangan/data_ruangan/' + this.dataset.id_ruangan + '/delete';
            $('#modalHapusruangan').modal('show');
        });
    });
</script>
@endsection
