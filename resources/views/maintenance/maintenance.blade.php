@extends('layout.page')
@section("judul","Data Kategori")
@section('content')
<style>
.card-checkbox {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 18px;
    height: 18px;
    cursor: pointer;
    accent-color: #e74c3c;
    z-index: 10;
}
.maintenance-card .border {
    position: relative;
    transition: box-shadow 0.2s, border-color 0.2s;
}
.maintenance-card.selected .border {
    border-color: #e74c3c !important;
    box-shadow: 0 0 0 2px rgba(231,76,60,0.18);
}

.filter-btn {
    transition: all 0.2s ease;
    font-size: 0.8rem;
    font-weight: 500;
}
.filter-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(78,115,223,0.25);
}
.filter-btn.active {
    box-shadow: 0 3px 8px rgba(78,115,223,0.3);
}
</style>
<div class="row">
    <div class="col-md-12 mb-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3 mb-2 text-gray-800">Jadwal Maintenance</h1>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalMaintenance">
                    <i class="fas fa-plus mr-1"></i> Add Jadwal Maintenance
                </button>
                <a href="{{ url('maintenance/riwayat_maintenance') }}" class="btn btn-sm btn-outline-secondary mr-2" style="margin-left:10px">
                    <i class="fas fa-history mr-1"></i> Riwayat
                </a>
                <button id="btn-hapus-terpilih" class="btn btn-sm btn-danger">
                    <i class="fas fa-trash mr-1"></i> Hapus Terpilih
                    <span id="jumlah-dipilih" class="badge badge-light ml-1" style="display:none;">0</span>
                </button>
            </div>
        </div>
         @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="card">
            <div class="card-header">
                <i class="far fa-calendar-alt"></i> Jadwal Maintenance
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center mb-3" id="filterKategori" style="gap: 8px;">

                    <a class="btn btn-sm btn-primary rounded-pill px-3 filter-btn active"
                    href="#" data-kategori="all">
                        <i class="fas fa-th-large mr-1"></i> Semua
                    </a>

                    @foreach($kategoriPerangkat as $namaKategori => $items)
                        @php $kat = $items->first(); @endphp
                        <a class="btn btn-sm btn-outline-primary rounded-pill px-3 filter-btn"
                        href="#" data-kategori="{{ $kat->id_kategori }}">
                            {{ $namaKategori }}
                            <span class="badge badge-primary ml-1">
                                {{ $maintenances->where('id_kategori', $kat->id_kategori)->count() }}
                            </span>
                        </a>
                    @endforeach
                </div>

                <div class="row g-3" id="containerMaintenance">
                    @php $tampilRuangan = []; @endphp

                    @foreach($maintenances as $item)

                    @php
                        if(in_array($item->id_ruangan, $tampilRuangan)) continue;
                        $tampilRuangan[] = $item->id_ruangan;
                    @endphp

                    <div class="col-md-4 mb-4 maintenance-card"
                        data-kategori="{{ $item->id_kategori }}"
                        data-ruangan="{{ $item->id_ruangan }}">
                        <div class="border rounded-3 p-3 h-100 d-flex flex-column" style="background:#fff;">
                            <input type="checkbox" class="card-checkbox maintenance-check" data-id="{{ $item->id_maintenance }}" title="Pilih untuk dihapus">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $item->nama_ruangan }}</h6>
                                </div>
                            </div>

                            <div class="d-flex align-items-center text-muted mb-1" style="font-size:0.875rem;">
                                <i class="far fa-calendar-alt me-2"></i> &nbsp;
                                {{ \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') }}
                            </div>

                            <div class="text-muted mb-1" style="font-size:0.875rem;">
                                Teknisi: {{ $item->nama_teknisi ?? '-' }}
                            </div>

                            <div class="text-muted mb-2" style="font-size:0.875rem;">
                                {{ Str::limit($item->deskripsi, 60) }}
                            </div>

                            <div class="mt-auto pt-2">
                                <button
                                    class="btn btn-outline-primary btn-sm w-100 btn-detail"
                                    data-id="{{ $item->id_maintenance }}"
                                    data-toggle="modal"
                                    data-target="#modalDetail">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </button>
                            </div>
                        </div>
                    </div>

                    @endforeach

                    <div class="col-12 text-center text-muted py-4 d-none" id="pesanKosong">
                        Tidak ada jadwal maintenance untuk kategori ini.
                    </div>

                    @if($maintenances->isEmpty())
                    <div class="col-12 text-center text-muted py-4">
                        Tidak ada jadwal maintenance.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalMaintenance">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Perangkat IT</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ url('maintenance/maintenance') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div id="alertError" class="alert alert-danger d-none"></div>
                    <div class="row">
                        {{-- <div class="col-md-6 form-group">
                            <label>Kode Inventaris</label>
                            <input type="text" name="kode_inventaris" class="form-control" placeholder="Contoh: INV-PC-001">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Nama Perangkat</label>
                            <input type="text" name="nama_perangkat" class="form-control" placeholder="Contoh: PC Admin">
                        </div> --}}
                        <div class="col-md-6 form-group">
                            <label>Kategori Perangkat <small class="text-muted">(bisa pilih lebih dari satu)</small></label>

                            <input type="text" id="searchPerangkat" class="form-control form-control-sm mb-2" placeholder="Cari nama kategori...">

                            <div id="listPerangkat" style="max-height: 220px; overflow-y: auto; border: 1px solid #ced4da; border-radius: 4px; padding: 8px;">

                                @foreach($kategoriPerangkat as $namaKategori => $items)
                                <div class="kategori-group mb-1" data-nama="{{ strtolower($namaKategori) }}">

                                    @foreach($items as $kat)
                                    <div class="form-check perangkat-item">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="id_kategori[]"
                                            value="{{ $kat->id_kategori }}"
                                            id="kat_{{ $kat->id_kategori }}"
                                        >
                                        <label class="form-check-label" for="kat_{{ $kat->id_kategori }}" style="font-size:0.875rem;">
                                            {{ $namaKategori }}
                                        </label>
                                    </div>
                                    @endforeach

                                </div>
                                @endforeach

                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <small class="text-primary" id="countPilihan">0 kategori dipilih</small>
                                <small>
                                    <a href="#" id="pilihSemua" class="text-primary mr-2">Pilih Semua</a> |
                                    <a href="#" id="hapusSemua" class="text-danger ml-2">Hapus Semua</a>
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Ruangan</label>
                            <select name="id_ruangan" class="form-control">
                                <option value="">Pilih Ruangan...</option>
                                @foreach($ruangan as $ruang)
                                    <option value="{{ $ruang->id_ruangan }}">{{ $ruang->nama_ruangan }} || {{ $ruang->lokasi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control">
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Jam</label>
                            <input type="time" name="jam" class="form-control" id="inputJam">
                        </div>
                        {{-- <div class="col-md-6 form-group">
                            <label>Kondisi</label>
                            <select name="kondisi" class="form-control">
                                <option value="Baik">Baik</option>
                                <option value="Rusak">Rusak</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div> --}}
                        <div class="col-md-6 form-group">
                            <label>Nama Teknisi</label>
                            @if(Auth::user()->role=="teknisi")
                            <input type="text" name="nama_teknisi" value="{{Auth::user()->name}}" class="form-control" readonly>
                            @else
                            <input type="text" name="nama_teknisi" value="{{Auth::user()->name}}" class="form-control">
                            @endif
                        </div>
                        <div class="col-md-12 form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Contoh: Core i5, RAM 8GB, SSD 256GB"></textarea>
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
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-info-circle me-2"></i>Detail Jadwal Maintenance
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="detail-loading" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Memuat data...</p>
                </div>

                {{-- Content --}}
                <div id="detail-content" style="display:none;">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <th width="38%" class="text-muted">Ruangan</th>
                                <td>: <span id="d-ruangan">-</span></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Perangkat</th>
                                <td>: <span id="d-kategori">-</span></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Tanggal</th>
                                <td>: <span id="d-tanggal">-</span></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Teknisi</th>
                                <td>: <span id="d-teknisi">-</span></td>
                            </tr>
                            <tr>
                                <th class="text-muted">Deskripsi</th>
                                <td>: <span id="d-deskripsi">-</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Error --}}
                <div id="detail-error" class="alert alert-danger d-none">
                    Gagal memuat data. Silakan coba lagi.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>

$('#searchPerangkat').on('input', function () {
    var keyword = $(this).val().toLowerCase().trim();

    $('.kategori-group').each(function () {
        var namaKategori = $(this).data('nama') || '';
        if (keyword === '') {
            $(this).show();
        } else {
            $(this).toggle(namaKategori.includes(keyword));
        }
    });

    var tampil = $('.kategori-group:visible').length;
    if (keyword !== '') {
        $('#countPilihan').text(tampil + ' hasil ditemukan');
    } else {
        var checked = $('input[name="id_kategori[]"]:checked').length;
        $('#countPilihan').text(checked + ' kategori dipilih');
    }
});


$(document).on('change', 'input[name="id_kategori[]"]', function () {
    var count = $('input[name="id_kategori[]"]:checked').length;
    $('#countPilihan').text(count + ' kategori dipilih');
});

$('#pilihSemua').on('click', function (e) {
    e.preventDefault();
    $('input[name="id_kategori[]"]:visible').prop('checked', true);
    $('#countPilihan').text($('input[name="id_kategori[]"]:checked').length + ' kategori dipilih');
});

$('#hapusSemua').on('click', function (e) {
    e.preventDefault();
    $('input[name="id_kategori[]"]').prop('checked', false);
    $('#countPilihan').text('0 kategori dipilih');
});

$('#modalMaintenance').on('hidden.bs.modal', function () {
    $('input[name="id_kategori[]"]').prop('checked', false);
    $('#countPilihan').text('0 kategori dipilih');
    $('#searchPerangkat').val('');
    $('.perangkat-item, .kategori-group').show();
});

$('#modalMaintenance').on('show.bs.modal', function () {
    var now = new Date();
    var tanggal = now.getFullYear() + '-' +
        String(now.getMonth() + 1).padStart(2, '0') + '-' +
        String(now.getDate()).padStart(2, '0');
    var jam = String(now.getHours()).padStart(2, '0') + ':' +
              String(now.getMinutes()).padStart(2, '0');
    $('#inputTanggal').val(tanggal);
    $('#inputJam').val(jam);
});

$(document).on('click', '.btn-detail', function () {
    var id = $(this).data('id');
    $('#detail-loading').show();
    $('#detail-content').hide();
    $('#detail-error').addClass('d-none');

    $.ajax({
        url: "{{ url('maintenance/detail') }}/" + id,
        method: 'GET',
        success: function(data) {
            $('#d-ruangan').text(data.nama_ruangan ?? '-');
            $('#d-tanggal').text(data.tanggal      ?? '-');
            $('#d-teknisi').text(data.nama_teknisi  ?? '-');
            $('#d-deskripsi').text(data.deskripsi   ?? '-');

            // Tampilkan semua kategori sebagai badge
            var kategoriHtml = '';
            if(data.kategoris && data.kategoris.length > 0){
                $.each(data.kategoris, function(i, kat){
                    kategoriHtml += '<span class="badge badge-primary mr-1 mb-1">' + kat.nama_kategori +'</span>';
                });
            } else {
                kategoriHtml = '-';
            }
            $('#d-kategori').html(kategoriHtml);

            $('#detail-loading').hide();
            $('#detail-content').show();
        },
        error: function() {
            $('#detail-loading').hide();
            $('#detail-error').removeClass('d-none');
        }
    });
});
var mappingKategori = {};

$.ajax({
    url: "{{ url('maintenance/kategori-ruangan') }}",
    method: 'GET',
    success: function(data) {
        mappingKategori = data;
    }
});

$(document).on('click', '#filterKategori .filter-btn', function (e) {
    e.preventDefault();

    $('#filterKategori .filter-btn')
        .removeClass('btn-primary active')
        .addClass('btn-outline-primary');

    $(this)
        .removeClass('btn-outline-primary')
        .addClass('btn-primary active');

    var kategori = $(this).data('kategori');

    if (kategori === 'all') {
        $('.maintenance-card').show();
    } else {
        $('.maintenance-card').each(function () {
            var cardKategori = parseInt($(this).data('kategori'));
            var cardRuangan  = parseInt($(this).data('ruangan'));
            var allowedKategoris = mappingKategori[cardRuangan] || null;
            var tampil = false;

            if (allowedKategoris) {
                tampil = allowedKategoris.includes(parseInt(kategori))
                      && allowedKategoris.includes(cardKategori);
            } else {
                tampil = (cardKategori === parseInt(kategori));
            }

            $(this).toggle(tampil);
        });
    }

    var adaCard = $('.maintenance-card:visible').length > 0;
    $('#pesanKosong').toggleClass('d-none', adaCard);
});

$(document).on('change', '.maintenance-check', function () {
    $(this).closest('.maintenance-card').toggleClass('selected', $(this).is(':checked'));
    updateJumlahDipilih();
});

$(document).on('click', '.maintenance-card .border', function (e) {
    if ($(e.target).hasClass('btn-detail') || $(e.target).closest('.btn-detail').length) return;
    if ($(e.target).hasClass('maintenance-check')) return;
    var checkbox = $(this).find('.maintenance-check');
    checkbox.prop('checked', !checkbox.prop('checked')).trigger('change');
});

function updateJumlahDipilih() {
    var count = $('.maintenance-check:checked').length;
    if (count > 0) {
        $('#jumlah-dipilih').text(count).show();
    } else {
        $('#jumlah-dipilih').hide();
    }
}

$('#btn-hapus-terpilih').on('click', function () {
    var ids = [];
    $('.maintenance-check:checked').each(function () {
        ids.push($(this).data('id'));
    });

    if (ids.length === 0) {
        alert('Pilih minimal satu data untuk dihapus.');
        return;
    }

    if (!confirm('Hapus ' + ids.length + ' jadwal maintenance yang dipilih?')) return;

    $.ajax({
        url: "{{ url('maintenance/destroy') }}",
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            ids: ids
        },
        success: function (res) {
            $('.maintenance-check:checked').each(function () {
                $(this).closest('.maintenance-card').fadeOut(300, function () {
                    $(this).remove();
                });
            });
            updateJumlahDipilih();

            var alertHtml = '<div class="alert alert-success alert-dismissible fade show" role="alert">'
                + '<i class="fas fa-check-circle mr-1"></i> ' + res.count + ' data berhasil dihapus.'
                + '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>'
                + '</div>';
            $('.card-body').prepend(alertHtml);
        },
        error: function () {
            alert('Gagal menghapus data. Silakan coba lagi.');
        }
    });
});

</script>
@endsection
