@extends('layout.page')
@section("judul","Data Perangkat")
@section('content')
<style>
    #thead-perangkat {
        background-color: purple;
    }
    #tr-perangkat {
        color: rgb(255, 255, 255)
    }

    #modalDetailperangkat .modal-header {
        background: linear-gradient(135deg, #6f00b3, #9b00ff);
        color: white;
    }
    #modalDetailperangkat .modal-header .close {
        color: white;
        opacity: 1;
    }
    #modalDetailperangkat .detail-section-title {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #7c3aed;
        font-weight: 700;
        margin-bottom: 10px;
        border-bottom: 2px solid #ede9fe;
        padding-bottom: 4px;
    }
    #modalDetailperangkat .detail-card {
        background: #f8f5ff;
        border: 1px solid #e0d0ff;
        border-radius: 8px;
        padding: 14px 16px;
        margin-bottom: 14px;
    }
    #modalDetailperangkat .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 6px 0;
        border-bottom: 1px solid #ede9fe;
    }
    #modalDetailperangkat .detail-row:last-child {
        border-bottom: none;
    }
    #modalDetailperangkat .detail-key {
        font-size: 0.8rem;
        color: #888;
        min-width: 120px;
    }
    #modalDetailperangkat .detail-val {
        font-size: 0.88rem;
        font-weight: 600;
        color: #222;
        text-align: right;
    }
    #modalDetailperangkat .spec-card {
        background: white;
        border: 1px solid #e8e8e8;
        border-radius: 8px;
        padding: 12px 16px;
    }
    #modalDetailperangkat .spec-value {
        font-size: 0.95rem;
        color: #333;
        line-height: 1.6;
        white-space: pre-wrap;
        word-break: break-word;
    }

    /* ===== Modal Move ===== */
    #modalMoveperangkat .modal-header {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        color: white;
    }
    #modalMoveperangkat .modal-header .close {
        color: white;
        opacity: 1;
    }
    #modalMoveperangkat .move-info-card {
        background: #f0f4ff;
        border: 1px solid #c7d7fd;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 16px;
    }
    #modalMoveperangkat .move-info-card .move-label {
        font-size: 0.75rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }
    #modalMoveperangkat .move-info-card .move-value {
        font-size: 0.95rem;
        font-weight: 700;
        color: #1a3a6e;
    }
    #modalMoveperangkat .arrow-icon {
        text-align: center;
        font-size: 1.5rem;
        color: #0d6efd;
        margin: 8px 0;
    }

    .badge-detail{
        color: lightgreen
    }

    .badge-edit{
        color:orange;
    }

    .badge-move{
        color:blue;
    }

    .badge-delete{
        color:red;
    }

    h5{
        color: black
    }
</style>

<div class="row">
    <div class="col-md-12 mb-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 mb-2 text-gray-800">Data Perangkat IT</h1>
            <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalPerangkat">
                Add Perangkat
            </button>
        </div>

        <h5><b>Ruangan : {{ $data_ruangan->nama_ruangan }}</b></h5>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-sm" id="perangkatTable">
                    <thead id="thead-perangkat">
                        <tr class="text-center" id="tr-perangkat">
                            <th>No</th>
                            <th>Kode Inventaris</th>
                            <th>Alamat IP</th>
                            <th>Kategori</th>
                            <th>Merek</th>
                            <th>Kondisi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_perangkat as $perangkat)
                        <tr class="text-center" id="row-{{ $perangkat->id_perangkat }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $perangkat->kode_inventaris }}</td>
                            <td>{{ $perangkat->alamat_ip }}</td>
                            <td>{{ $perangkat->nama_kategori }}</td>
                            <td>{{ $perangkat->merek }}</td>
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
                                <button type="button"
                                    class="btn btn-sm"
                                    data-toggle="modal"
                                    data-target="#modalDetailperangkat"
                                    data-kode_inventaris="{{ $perangkat->kode_inventaris }}"
                                    data-alamat_ip="{{ $perangkat->alamat_ip }}"
                                    data-nama_kategori="{{ $perangkat->nama_kategori }}"
                                    data-merek="{{ $perangkat->merek }}"
                                    data-kondisi="{{ $perangkat->kondisi }}"
                                    data-tipe="{{ $perangkat->tipe }}"
                                    data-spesifikasi="{{ $perangkat->spesifikasi }}"
                                    data-dipindahkan_oleh="{{ $perangkat->dipindahkan_oleh }}"
                                    data-role_pemindah="{{ $perangkat->role_pemindah }}">
                                    <span class="badge-detail"><i class="fas fa-eye"></i></span>
                                </button>

                                {{-- Tombol Edit --}}
                                <button type="button"
                                    class="btn btn-sm btn-edit"
                                    data-toggle="modal"
                                    data-target="#modalEditperangkat"
                                    data-id_perangkat="{{ $perangkat->id_perangkat }}"
                                    data-kode_inventaris="{{ $perangkat->kode_inventaris }}"
                                    data-alamat_ip="{{ $perangkat->alamat_ip }}"
                                    data-id_kategori="{{ $perangkat->id_kategori }}"
                                    data-merek="{{ $perangkat->merek }}"
                                    data-kondisi="{{ $perangkat->kondisi }}"
                                    data-tipe="{{ $perangkat->tipe }}"
                                    data-spesifikasi="{{ $perangkat->spesifikasi }}">
                                    <span class="badge-edit"><i class="fas fa-pencil-alt"></i></span>
                                </button>

                                <button type="button"
                                    class="btn btn-sm"
                                    data-toggle="modal"
                                    data-target="#modalMoveperangkat"
                                    data-username="{{ Auth::user()->name }}"
                                    data-role="{{ Auth::user()->role }}"
                                    data-id_perangkat="{{ $perangkat->id_perangkat }}"
                                    data-kode_inventaris="{{ $perangkat->kode_inventaris }}"
                                    data-alamat_ip="{{ $perangkat->alamat_ip }}">
                                    <span class="badge-move"><i class="fas fa-exchange-alt"></i></span>
                                </button>

                                <button type="button"
                                    class="btn btn-sm"
                                    data-toggle="modal"
                                    data-target="#modalHapusperangkat"
                                    data-id_perangkat="{{ $perangkat->id_perangkat }}"
                                    data-alamat_ip="{{ $perangkat->alamat_ip }}">
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

<div class="modal fade" id="modalPerangkat">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Perangkat IT</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ url('perangkat/data_perangkat') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div id="alertError" class="alert alert-danger d-none"></div>
                    <div class="row">
                        <input type="hidden" name="id_ruangan" value="{{ $data_ruangan->id_ruangan }}">
                        <div class="col-md-6 form-group">
                            <label>Kode Inventaris</label>
                            <input type="text" name="kode_inventaris" class="form-control" placeholder="Contoh: INV-PC-001">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Alamat IP</label>
                            <input type="text" name="alamat_ip" class="form-control" placeholder="Contoh: 192.168...">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Kategori</label>
                            <select name="id_kategori" class="form-control">
                                <option value="">Pilih Kategori...</option>
                                @foreach($data_kategori as $kategori)
                                    <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Merek</label>
                            <input type="text" name="merek" class="form-control" placeholder="Contoh: Dell / HP / Lenovo">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Kondisi</label>
                            <select name="kondisi" class="form-control">
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Tipe</label>
                            <input type="text" name="tipe" value="-" class="form-control">
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Spesifikasi</label>
                            <textarea name="spesifikasi" class="form-control" rows="3" placeholder="Contoh: Core i5, RAM 8GB, SSD 256GB"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDetailperangkat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-desktop mr-2"></i> Detail Perangkat
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="detail-section-title"><i class="fas fa-info-circle mr-1"></i> Informasi Umum</div>
                <div class="detail-card">
                    <div class="detail-row">
                        <span class="detail-key">Kode Inventaris</span>
                        <span class="detail-val" id="detail_kode_inventaris">-</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-key">Alamat IP</span>
                        <span class="detail-val" id="detail_alamat_ip">-</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-key">Kategori</span>
                        <span class="detail-val" id="detail_nama_kategori">-</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-key">Merek</span>
                        <span class="detail-val" id="detail_merek">-</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-key">Tipe</span>
                        <span class="detail-val" id="detail_tipe">-</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-key">Kondisi</span>
                        <span class="detail-val" id="detail_kondisi_badge">-</span>
                    </div>
                    <div id="section_dipindahkan" style="display:none;">
                        <div class="detail-section-title">Dipindahkan Oleh</div>
                        <div class="detail-card">
                            <div class="detail-row">
                                <span class="detail-key">Username</span>
                                <span class="detail-val" id="detail_dipindahkan_oleh">-</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-key">Role</span>
                                <span class="detail-val" id="detail_role_pemindah">-</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="detail-section-title"><i class="fas fa-microchip mr-1"></i> Spesifikasi</div>
                <div class="spec-card">
                    <div class="spec-value" id="detail_spesifikasi">-</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditperangkat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formEditperangkat" method="POST">
                @csrf
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Edit Perangkat</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="id_ruangan" id="edit_id_ruangan" value="{{ $data_ruangan->id_ruangan }}">
                        <div class="col-md-6 form-group">
                            <label>Kode Inventaris</label>
                            <input type="text" name="kode_inventaris" id="edit_kode_inventaris" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Alamat IP</label>
                            <input type="text" name="alamat_ip" id="edit_alamat_ip" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Kategori</label>
                            <select name="id_kategori" id="edit_id_kategori" class="form-control">
                                <option value="">Pilih Kategori...</option>
                                @foreach($data_kategori as $kategori)
                                    <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Merek</label>
                            <input type="text" name="merek" id="edit_merek" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Kondisi</label>
                            <select name="kondisi" id="edit_kondisi" class="form-control">
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Tipe</label>
                            <input type="text" name="tipe" id="edit_tipe" class="form-control">
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Spesifikasi</label>
                            <textarea name="spesifikasi" id="edit_spesifikasi" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalMoveperangkat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form id="formMoveperangkat" method="POST">
                @csrf
                <div class="modal-header" id="modalMoveperangkat" style="background: linear-gradient(135deg, #0d6efd, #0a58ca);">
                    <h5 class="modal-title text-white">
                        <i class="fas fa-exchange-alt mr-2"></i> Pindah Perangkat ke Ruangan Lain
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    {{-- Info perangkat yang akan dipindah --}}
                    <div style="background:#f0f4ff; border:1px solid #c7d7fd; border-radius:8px; padding:12px 16px; margin-bottom:16px;">
                        <div style="font-size:0.75rem; color:#6c757d; text-transform:uppercase; letter-spacing:0.06em;">Perangkat yang Dipindah</div>
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <div>
                                <div style="font-size:0.95rem; font-weight:700; color:#1a3a6e;" id="move_kategori_perangkat">-</div>
                                <div style="font-size:0.8rem; color:#6c757d;" id="move_kode_inventaris_display">-</div>
                            </div>
                            <span class="badge badge-primary px-2 py-1">
                                <i class="fas fa-barcode mr-1"></i>
                                <span id="move_kode_badge">-</span>
                            </span>
                        </div>
                    </div>

                    <div class="text-center mb-3" style="font-size:1.4rem; color:#0d6efd;">
                        <i class="fas fa-arrow-down"></i>
                    </div>

                    {{-- Pilih Ruangan Tujuan --}}
                    <div class="form-group">
                        <label style="font-size:0.8rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:#0d6efd;">
                            <i class="fas fa-door-open mr-1"></i> Ruangan Tujuan
                        </label>
                        <select name="id_ruangan_tujuan" id="move_id_ruangan_tujuan" class="form-control" required>
                            <option value="">-- Pilih Ruangan Tujuan --</option>
                            @foreach($data_semua_ruangan as $ruangan)
                                @if($ruangan->id_ruangan != $data_ruangan->id_ruangan)
                                    <option value="{{ $ruangan->id_ruangan }}">{{ $ruangan->nama_ruangan }}</option>
                                @endif
                            @endforeach
                        </select>
                        <small class="text-muted">Ruangan saat ini tidak ditampilkan sebagai pilihan tujuan.</small>
                    </div>
                    <div style="background:#fff3cd; border:1px solid #ffc107; border-radius:8px; padding:12px 16px; margin-bottom:16px;">
                        <div style="font-size:0.75rem; color:#6c757d; text-transform:uppercase;">Dipindahkan Oleh</div>
                        <div style="font-weight:700; color:#856404;" id="move_username_display">-</div>
                        <div style="font-size:0.8rem; color:#6c757d;" id="move_role_display">-</div>
                    </div>
                    {{-- Catatan opsional --}}
                    <div class="form-group mb-0">
                        <label style="font-size:0.8rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:#6c757d;">
                            <i class="fas fa-sticky-note mr-1"></i> Catatan <span class="text-muted font-weight-normal">(opsional)</span>
                        </label>
                        <textarea name="catatan_pindah" class="form-control" rows="2" placeholder="Contoh: Dipindah karena kebutuhan ruang server..."></textarea>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-exchange-alt mr-1"></i> Pindahkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalHapusperangkat" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Hapus Perangkat</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-exclamation-triangle text-danger" style="font-size: 2rem;"></i>
                <p class="mt-2">Apakah Anda yakin ingin menghapus perangkat <strong id="hapus_kategori_perangkat"></strong>?</p>
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

    $('#modalDetailperangkat').on('show.bs.modal', function(e) {
        const btn   = $(e.relatedTarget);
        const modal = $(this);

        modal.find('#detail_kode_inventaris').text(btn.data('kode_inventaris') || '-');
        modal.find('#detail_alamat_ip').text(btn.data('alamat_ip') || '-');
        modal.find('#detail_nama_kategori').text(btn.data('nama_kategori') || '-');
        modal.find('#detail_merek').text(btn.data('merek') || '-');
        modal.find('#detail_tipe').text(btn.data('tipe') || '-');

        const kondisi = btn.data('kondisi') || '-';
        const badgeMap = {
            'Baik':        'badge badge-success',
            'Rusak':       'badge badge-danger',
            'Maintenance': 'badge badge-warning text-dark',
        };
        const cls = badgeMap[kondisi] || 'badge badge-secondary';
        modal.find('#detail_kondisi_badge').html('<span class="' + cls + '">' + kondisi + '</span>');
        modal.find('#detail_spesifikasi').text(btn.data('spesifikasi') || '-');

        // Tampilkan "Dipindahkan Oleh" hanya jika ada datanya
        const dipindahkanOleh = btn.data('dipindahkan_oleh') || '';
        const rolePemindah    = btn.data('role_pemindah')    || '';

        if (dipindahkanOleh) {
            modal.find('#detail_dipindahkan_oleh').text(dipindahkanOleh);
            modal.find('#detail_role_pemindah').text(rolePemindah);
            modal.find('#section_dipindahkan').show();
        } else {
            modal.find('#section_dipindahkan').hide();
        }
    });

    $('#modalEditperangkat').on('show.bs.modal', function(e) {
        const btn   = $(e.relatedTarget);
        const modal = $(this);

        modal.find('#edit_kode_inventaris').val(btn.data('kode_inventaris') || '');
        modal.find('#edit_alamat_ip').val(btn.data('alamat_ip')   || '');
        modal.find('#edit_id_kategori').val(btn.data('id_kategori')         || '');
        modal.find('#edit_merek').val(btn.data('merek')                       || '');
        modal.find('#edit_kondisi').val(btn.data('kondisi')                 || '');
        modal.find('#edit_tipe').val(btn.data('tipe')                       || '');
        modal.find('#edit_spesifikasi').val(btn.data('spesifikasi')         || '');

        $('#formEditperangkat').attr(
            'action',
            baseUrl + '/perangkat/data_perangkat/' + btn.data('id_perangkat') + '/update'
        );
    });

    $('#modalMoveperangkat').on('show.bs.modal', function(e) {
        const btn   = $(e.relatedTarget);
        const modal = $(this);

        const idPerangkat    = btn.data('id_perangkat')    || '';
        const kodeInventaris = btn.data('kode_inventaris') || '-';
        const namaPerangkat  = btn.data('kategori_perangkat')  || '-';

        modal.find('#move_kode_perangkat').text(namaPerangkat);
        modal.find('#move_kode_inventaris_display').text('Kode: ' + kodeInventaris);
        modal.find('#move_kode_badge').text(kodeInventaris);
        modal.find('#move_username_display').text(btn.data('username') || '-');
        modal.find('#move_role_display').text('Role: ' + (btn.data('role') || '-'));

        // Reset pilihan ruangan & catatan
        modal.find('#move_id_ruangan_tujuan').val('');
        modal.find('textarea[name="catatan_pindah"]').val('');

        // Set action form dengan id_perangkat dan kode_inventaris sebagai parameter
        $('#formMoveperangkat').attr(
            'action',
            baseUrl + '/perangkat/data_perangkat/' + idPerangkat + '/move'
        );
    });

    $('#modalHapusperangkat').on('show.bs.modal', function(e) {
        const btn = $(e.relatedTarget);
        $(this).find('#hapus_kategori_perangkat').text(btn.data('kategori_perangkat') || '');
        $('#formHapus').attr(
            'action',
            baseUrl + '/perangkat/data_perangkat/' + btn.data('id_perangkat') + '/delete'
        );
    });

    const inputSearch = document.getElementById('inputSearch');
    if (inputSearch) {
        let debounceTimer;
        inputSearch.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () {
                document.getElementById('formSearch').submit();
            }, 500);
        });
    }

    document.documentElement.style.setProperty('--sidebar-transition', 'none');
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.sidebar').style.transition = 'none';
        document.body.classList.add('sidebar-toggled');
        document.querySelector('.sidebar').classList.add('toggled');
        setTimeout(function() {
            document.querySelector('.sidebar').style.transition = '';
        }, 100);
    });
</script>
@endsection
