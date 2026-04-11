@extends('layout.page')
@section("judul","Jadwal Maintenance")
@section('content')

<style>
    * { box-sizing: border-box; }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-title {
        font-size: 20px;
        font-weight: 600;
        color: #111827;
        letter-spacing: -0.3px;
        margin: 0;
    }
    .page-subtitle {
        font-size: 13px;
        color: #6b7280;
        margin-top: 2px;
    }
    .btn-row {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn-solid {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #111827;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        transition: opacity .15s;
    }
    .btn-solid:hover { opacity: .85; color: #fff; }

    .btn-outline-sm {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: transparent;
        color: #6b7280;
        border: 0.5px solid #d1d5db;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 13px;
        cursor: pointer;
        text-decoration: none;
        transition: background .15s;
    }
    .btn-outline-sm:hover { background: #f9fafb; color: #374151; }

    .btn-danger-sm {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: transparent;
        color: #dc2626;
        border: 0.5px solid #fca5a5;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 13px;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-danger-sm:hover { background: #fee2e2; }

    .sel-badge {
        background: #fee2e2;
        color: #b91c1c;
        border-radius: 20px;
        padding: 1px 7px;
        font-size: 11px;
        font-weight: 500;
    }

    /* ── Filter Tanggal Toolbar ── */
    .toolbar-card {
        background: #fff;
        border: 0.5px solid #e5e7eb;
        border-radius: 12px;
        padding: 14px 20px;
        margin-bottom: 14px;
    }
    .toolbar-row {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }
    .toolbar-label {
        font-size: 11px;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: .5px;
        white-space: nowrap;
    }
    .date-input {
        padding: 7px 10px;
        border: 0.5px solid #d1d5db;
        border-radius: 8px;
        font-size: 13px;
        color: #111827;
        background: #fff;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
    }
    .date-input:focus {
        border-color: #6b7280;
        box-shadow: 0 0 0 3px rgba(0,0,0,.06);
    }
    .date-sep { font-size: 12px; color: #9ca3af; }
    .divider-v { width: 1px; height: 28px; background: #e5e7eb; }

    .quick-pills { display: flex; gap: 6px; flex-wrap: wrap; }
    .quick-pill {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        border: 0.5px solid #e5e7eb;
        background: transparent;
        color: #6b7280;
        cursor: pointer;
        transition: all .15s;
    }
    .quick-pill:hover, .quick-pill.active {
        background: #111827;
        color: #fff;
        border-color: #111827;
    }
    .btn-reset {
        margin-left: auto;
        padding: 6px 12px;
        font-size: 12px;
        border: 0.5px solid #e5e7eb;
        border-radius: 8px;
        background: transparent;
        color: #6b7280;
        cursor: pointer;
        transition: background .15s;
    }
    .btn-reset:hover { background: #f9fafb; }

    /* ── Filter Kategori Chips ── */
    .filter-row {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
        margin-bottom: 14px;
    }
    .filter-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        border: 0.5px solid #e5e7eb;
        background: transparent;
        color: #6b7280;
        cursor: pointer;
        transition: all .15s;
        text-decoration: none;
    }
    .filter-chip:hover { background: #f3f4f6; }
    .filter-chip.active {
        background: #111827;
        color: #fff;
        border-color: #111827;
    }
    .chip-count {
        font-size: 10px;
        padding: 1px 6px;
        border-radius: 20px;
        background: rgba(255,255,255,.22);
    }
    .filter-chip:not(.active) .chip-count {
        background: #f3f4f6;
        color: #6b7280;
    }

    /* ── Result info ── */
    .result-info {
        font-size: 12px;
        color: #9ca3af;
        margin-bottom: 14px;
    }

    /* ── Maintenance Cards ── */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        margin-bottom: 80px;
    }
    @media (max-width: 900px) { .cards-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 580px) { .cards-grid { grid-template-columns: 1fr; } }

    .maintenance-card {
        background: #fff;
        border: 0.5px solid #e5e7eb;
        border-radius: 12px;
        padding: 16px;
        position: relative;
        display: flex;
        flex-direction: column;
        transition: border-color .15s;
        cursor: pointer;
    }
    .maintenance-card:hover { border-color: #d1d5db; }
    .maintenance-card.selected {
        border-color: #1d4ed8;
        box-shadow: 0 0 0 2px rgba(29,78,216,.12);
    }

    .card-checkbox {
        position: absolute;
        top: 12px;
        right: 12px;
        width: 16px;
        height: 16px;
        cursor: pointer;
        accent-color: #1d4ed8;
        z-index: 10;
    }

    .mcard-room {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 10px;
        padding-right: 26px;
    }
    .mcard-date-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #dbeafe;
        color: #1d4ed8;
        border-radius: 6px;
        padding: 3px 9px;
        font-size: 11px;
        font-weight: 500;
        margin-bottom: 8px;
    }
    .mcard-meta {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 6px;
    }
    .mcard-desc {
        font-size: 12px;
        color: #9ca3af;
        line-height: 1.5;
        margin-bottom: 12px;
        flex: 1;
    }
    .btn-detail-card {
        width: 100%;
        padding: 7px;
        border: 0.5px solid #e5e7eb;
        border-radius: 8px;
        background: transparent;
        font-size: 12px;
        color: #6b7280;
        cursor: pointer;
        transition: background .15s, color .15s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
    }
    .btn-detail-card:hover { background: #f9fafb; color: #111827; }

    .empty-state {
        text-align: center;
        padding: 48px 20px;
        color: #9ca3af;
        font-size: 13px;
        display: none;
        grid-column: 1 / -1;
    }

    /* ── Modals ── */
    .modal-content { border-radius: 12px; border: 0.5px solid #e5e7eb; }
    .modal-header { border-bottom: 0.5px solid #f3f4f6; padding: 18px 24px 14px; }
    .modal-body   { padding: 20px 24px; }
    .modal-footer { border-top: 0.5px solid #f3f4f6; padding: 14px 24px; }
    .modal-title  { font-size: 15px; font-weight: 600; color: #111827; }

    .form-label-sm {
        display: block;
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: .4px;
    }
    .form-control-sm-custom {
        width: 100%;
        padding: 8px 11px;
        border: 0.5px solid #d1d5db;
        border-radius: 8px;
        font-size: 13px;
        color: #111827;
        background: #fff;
        outline: none;
        transition: border-color .15s;
    }
    .form-control-sm-custom:focus {
        border-color: #6b7280;
        box-shadow: 0 0 0 3px rgba(0,0,0,.06);
    }

    .btn-modal-cancel {
        padding: 8px 16px;
        font-size: 13px;
        border: 0.5px solid #d1d5db;
        border-radius: 8px;
        background: transparent;
        color: #6b7280;
        cursor: pointer;
    }
    .btn-modal-save {
        padding: 8px 20px;
        font-size: 13px;
        font-weight: 500;
        border: none;
        border-radius: 8px;
        background: #111827;
        color: #fff;
        cursor: pointer;
        transition: opacity .15s;
    }
    .btn-modal-save:hover { opacity: .85; }
</style>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
</div>
@endif

<div class="row">
<div class="col-md-12 mb-3">

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Jadwal Maintenance</h1>
            <p class="page-subtitle">Kelola dan pantau jadwal perawatan perangkat IT</p>
        </div>
        <div class="btn-row">
            <button class="btn-solid" data-toggle="modal" data-target="#modalMaintenance">
                <i class="fas fa-plus" style="font-size:12px"></i>
                Tambah Jadwal
            </button>
            <a href="{{ url('maintenance/riwayat_maintenance') }}" class="btn-outline-sm">
                <i class="fas fa-history" style="font-size:12px"></i>
                Riwayat
            </a>
            <button id="btn-hapus-terpilih" class="btn-danger-sm">
                <i class="fas fa-trash" style="font-size:12px"></i>
                Hapus Terpilih
                <span id="jumlah-dipilih" class="sel-badge" style="display:none">0</span>
            </button>
        </div>
    </div>

    {{-- ── Filter Tanggal ── --}}
    <div class="toolbar-card">
        <div class="toolbar-row">
            <span class="toolbar-label">Filter Tanggal</span>
            <div style="display:flex;align-items:center;gap:8px;">
                <input type="date" class="date-input" id="filterDateFrom" placeholder="Dari">
                <span class="date-sep">—</span>
                <input type="date" class="date-input" id="filterDateTo" placeholder="Sampai">
            </div>
            <div class="divider-v"></div>
            <div class="quick-pills">
                <button class="quick-pill" id="pill-today"  onclick="setQuick('today',this)">Hari ini</button>
                <button class="quick-pill" id="pill-week"   onclick="setQuick('week',this)">Minggu ini</button>
                <button class="quick-pill" id="pill-month"  onclick="setQuick('month',this)">Bulan ini</button>
                <button class="quick-pill active" id="pill-all" onclick="setQuick('all',this)">Semua</button>
            </div>
            <button class="btn-reset" onclick="resetDateFilter()">Reset</button>
        </div>
    </div>

    {{-- ── Filter Kategori ── --}}
    <div class="filter-row" id="filterKategori">
        <a class="filter-chip active" href="#" data-kategori="all">
            <i class="fas fa-th-large" style="font-size:11px"></i>
            Semua
            <span class="chip-count">{{ $maintenances->count() }}</span>
        </a>
        @foreach($kategoriPerangkat as $namaKategori => $items)
            @php $kat = $items->first(); @endphp
            <a class="filter-chip" href="#" data-kategori="{{ $kat->id_kategori }}">
                {{ $namaKategori }}
                <span class="chip-count">{{ $maintenances->where('id_kategori', $kat->id_kategori)->count() }}</span>
            </a>
        @endforeach
    </div>

    {{-- ── Result info ── --}}
    <div class="result-info" id="resultInfo">
        Menampilkan {{ $maintenances->unique('id_ruangan')->count() }} jadwal
    </div>

    {{-- ── Cards Grid ── --}}
    <div class="cards-grid" id="containerMaintenance">
        @php $tampilRuangan = []; @endphp
        @foreach($maintenances as $item)
            @php
                if(in_array($item->id_ruangan, $tampilRuangan)) continue;
                $tampilRuangan[] = $item->id_ruangan;
            @endphp
            <div class="maintenance-card"
                data-kategori="{{ $item->id_kategori }}"
                data-ruangan="{{ $item->id_ruangan }}"
                data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') }}">

                <input type="checkbox" class="card-checkbox maintenance-check" data-id="{{ $item->id_maintenance }}" title="Pilih untuk dihapus">

                <div class="mcard-room">{{ $item->nama_ruangan }}</div>

                <div class="mcard-date-badge">
                    <i class="far fa-calendar-alt" style="font-size:10px"></i>
                    {{ \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d') }}
                </div>

                <div class="mcard-meta">
                    <i class="fas fa-user" style="font-size:11px;opacity:.6"></i>
                    {{ $item->nama_teknisi ?? '-' }}
                </div>

                <div class="mcard-desc">{{ Str::limit($item->deskripsi, 60) }}</div>

                <button class="btn-detail-card btn-detail"
                    data-id="{{ $item->id_maintenance }}"
                    data-toggle="modal"
                    data-target="#modalDetail">
                    <i class="fas fa-eye" style="font-size:11px"></i>
                    Detail
                </button>
            </div>
        @endforeach

        <div class="empty-state" id="pesanKosong">
            Tidak ada jadwal maintenance untuk filter yang dipilih.
        </div>

        @if($maintenances->isEmpty())
        <div style="grid-column:1/-1;text-align:center;padding:48px 20px;color:#9ca3af;font-size:13px;">
            Tidak ada jadwal maintenance.
        </div>
        @endif
    </div>

</div>
</div>

{{-- ── Modal Tambah Maintenance ── --}}
<div class="modal fade" id="modalMaintenance">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Jadwal Maintenance</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="{{ url('maintenance/maintenance') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div id="alertError" class="alert alert-danger d-none"></div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="form-label-sm">Kategori Perangkat <span style="font-weight:400;text-transform:none;font-size:11px;color:#9ca3af">(bisa pilih lebih dari satu)</span></label>
                            <input type="text" id="searchPerangkat" class="form-control-sm-custom mb-2" placeholder="Cari nama kategori...">
                            <div id="listPerangkat" style="max-height:200px;overflow-y:auto;border:0.5px solid #e5e7eb;border-radius:8px;padding:10px;">
                                @foreach($kategoriPerangkat as $namaKategori => $items)
                                <div class="kategori-group mb-1" data-nama="{{ strtolower($namaKategori) }}">
                                    @foreach($items as $kat)
                                    <div class="form-check perangkat-item" style="margin-bottom:4px;">
                                        <input class="form-check-input" type="checkbox" name="id_kategori[]" value="{{ $kat->id_kategori }}" id="kat_{{ $kat->id_kategori }}">
                                        <label class="form-check-label" for="kat_{{ $kat->id_kategori }}" style="font-size:13px;">{{ $namaKategori }}</label>
                                    </div>
                                    @endforeach
                                </div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-1">
                                <small style="color:#1d4ed8;font-size:11px;" id="countPilihan">0 kategori dipilih</small>
                                <small>
                                    <a href="#" id="pilihSemua" style="color:#1d4ed8;font-size:11px;">Pilih Semua</a> |
                                    <a href="#" id="hapusSemua" style="color:#dc2626;font-size:11px;">Hapus Semua</a>
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="form-label-sm">Ruangan</label>
                            <select name="id_ruangan" class="form-control-sm-custom">
                                <option value="">Pilih Ruangan...</option>
                                @foreach($ruangan as $ruang)
                                    <option value="{{ $ruang->id_ruangan }}">{{ $ruang->nama_ruangan }} || {{ $ruang->lokasi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label-sm">Tanggal</label>
                            <input type="date" name="tanggal" id="inputTanggal" class="form-control-sm-custom">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label-sm">Jam</label>
                            <input type="time" name="jam" id="inputJam" class="form-control-sm-custom">
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="form-label-sm">Nama Teknisi</label>
                            @if(Auth::user()->role == "teknisi")
                                <input type="text" name="nama_teknisi" value="{{ Auth::user()->name }}" class="form-control-sm-custom" readonly>
                            @else
                                <input type="text" name="nama_teknisi" value="{{ Auth::user()->name }}" class="form-control-sm-custom">
                            @endif
                        </div>
                        <div class="col-md-12 form-group">
                            <label class="form-label-sm">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control-sm-custom" rows="3" placeholder="Deskripsi pekerjaan maintenance..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-end" style="gap:8px">
                    <button type="button" class="btn-modal-cancel" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn-modal-save">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ── Modal Detail ── --}}
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Jadwal Maintenance</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div id="detail-loading" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>
                    <p class="mt-2" style="color:#9ca3af;font-size:13px;">Memuat data...</p>
                </div>
                <div id="detail-content" style="display:none;">
                    <table class="table table-borderless mb-0" style="font-size:13px;">
                        <tbody>
                            <tr>
                                <th width="38%" style="color:#9ca3af;font-weight:500;">Ruangan</th>
                                <td>: <span id="d-ruangan">-</span></td>
                            </tr>
                            <tr>
                                <th style="color:#9ca3af;font-weight:500;">Perangkat</th>
                                <td>: <span id="d-kategori">-</span></td>
                            </tr>
                            <tr>
                                <th style="color:#9ca3af;font-weight:500;">Tanggal</th>
                                <td>: <span id="d-tanggal">-</span></td>
                            </tr>
                            <tr>
                                <th style="color:#9ca3af;font-weight:500;">Teknisi</th>
                                <td>: <span id="d-teknisi">-</span></td>
                            </tr>
                            <tr>
                                <th style="color:#9ca3af;font-weight:500;">Deskripsi</th>
                                <td>: <span id="d-deskripsi">-</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="detail-error" class="alert alert-danger d-none">
                    Gagal memuat data. Silakan coba lagi.
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-end">
                <button type="button" class="btn-modal-cancel" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
/* ─────────────────────────────────────────
   FILTER TANGGAL
───────────────────────────────────────── */
function fmtDate(d) {
    return d.getFullYear() + '-' +
        String(d.getMonth() + 1).padStart(2, '0') + '-' +
        String(d.getDate()).padStart(2, '0');
}

function setQuick(type, el) {
    document.querySelectorAll('.quick-pill').forEach(function(p) { p.classList.remove('active'); });
    el.classList.add('active');
    var now = new Date();
    var from, to;
    if (type === 'today') {
        from = to = fmtDate(now);
    } else if (type === 'week') {
        var d = new Date(now);
        d.setDate(d.getDate() - d.getDay());
        from = fmtDate(d);
        var d2 = new Date(d); d2.setDate(d2.getDate() + 6);
        to = fmtDate(d2);
    } else if (type === 'month') {
        from = fmtDate(new Date(now.getFullYear(), now.getMonth(), 1));
        to   = fmtDate(new Date(now.getFullYear(), now.getMonth() + 1, 0));
    } else {
        from = ''; to = '';
    }
    $('#filterDateFrom').val(from);
    $('#filterDateTo').val(to);
    applyAllFilters();
}

function resetDateFilter() {
    $('#filterDateFrom').val('');
    $('#filterDateTo').val('');
    document.querySelectorAll('.quick-pill').forEach(function(p) { p.classList.remove('active'); });
    document.getElementById('pill-all').classList.add('active');
    applyAllFilters();
}

$('#filterDateFrom, #filterDateTo').on('change', function () {
    document.querySelectorAll('.quick-pill').forEach(function(p) { p.classList.remove('active'); });
    applyAllFilters();
});

/* ─────────────────────────────────────────
   FILTER KATEGORI (original algo intact)
───────────────────────────────────────── */
var mappingKategori = {};

$.ajax({
    url: "{{ url('maintenance/kategori-ruangan') }}",
    method: 'GET',
    success: function (data) { mappingKategori = data; }
});

$(document).on('click', '#filterKategori .filter-chip', function (e) {
    e.preventDefault();
    $('#filterKategori .filter-chip').removeClass('active');
    $(this).addClass('active');
    applyAllFilters();
});

/* ─────────────────────────────────────────
   COMBINED FILTER (kategori + tanggal)
───────────────────────────────────────── */
function applyAllFilters() {
    var kategori = $('#filterKategori .filter-chip.active').data('kategori');
    var dateFrom = $('#filterDateFrom').val();
    var dateTo   = $('#filterDateTo').val();
    var visible  = 0;

    $('.maintenance-card').each(function () {
        var cardKategori = parseInt($(this).data('kategori'));
        var cardRuangan  = parseInt($(this).data('ruangan'));
        var cardDate     = $(this).data('tanggal');

        // kategori filter (original logic)
        var katOk = false;
        if (kategori === 'all') {
            katOk = true;
        } else {
            var allowedKategoris = mappingKategori[cardRuangan] || null;
            if (allowedKategoris) {
                katOk = allowedKategoris.includes(parseInt(kategori))
                     && allowedKategoris.includes(cardKategori);
            } else {
                katOk = (cardKategori === parseInt(kategori));
            }
        }

        // date filter
        var dateOk = true;
        if (dateFrom) dateOk = dateOk && (cardDate >= dateFrom);
        if (dateTo)   dateOk = dateOk && (cardDate <= dateTo);

        if (katOk && dateOk) {
            $(this).show();
            visible++;
        } else {
            $(this).hide();
        }
    });

    $('#resultInfo').text('Menampilkan ' + visible + ' jadwal');
    var adaCard = visible > 0;
    $('#pesanKosong').css('display', adaCard ? 'none' : 'block');
}

/* ─────────────────────────────────────────
   CHECKBOX & HAPUS TERPILIH (original)
───────────────────────────────────────── */
$(document).on('change', '.maintenance-check', function () {
    $(this).closest('.maintenance-card').toggleClass('selected', $(this).is(':checked'));
    updateJumlahDipilih();
});

$(document).on('click', '.maintenance-card', function (e) {
    if ($(e.target).hasClass('btn-detail-card') || $(e.target).closest('.btn-detail-card').length) return;
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
    $('.maintenance-check:checked').each(function () { ids.push($(this).data('id')); });
    if (ids.length === 0) { alert('Pilih minimal satu data untuk dihapus.'); return; }
    if (!confirm('Hapus ' + ids.length + ' jadwal maintenance yang dipilih?')) return;

    $.ajax({
        url: "{{ url('maintenance/destroy') }}",
        method: 'POST',
        data: { _token: '{{ csrf_token() }}', ids: ids },
        success: function (res) {
            $('.maintenance-check:checked').each(function () {
                $(this).closest('.maintenance-card').fadeOut(300, function () { $(this).remove(); applyAllFilters(); });
            });
            updateJumlahDipilih();
            var alertHtml = '<div class="alert alert-success alert-dismissible fade show" role="alert">'
                + '<i class="fas fa-check-circle mr-1"></i> ' + res.count + ' data berhasil dihapus.'
                + '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button></div>';
            $('.col-md-12').prepend(alertHtml);
        },
        error: function () { alert('Gagal menghapus data. Silakan coba lagi.'); }
    });
});

/* ─────────────────────────────────────────
   DETAIL MODAL (original)
───────────────────────────────────────── */
$(document).on('click', '.btn-detail', function () {
    var id = $(this).data('id');
    $('#detail-loading').show();
    $('#detail-content').hide();
    $('#detail-error').addClass('d-none');

    $.ajax({
        url: "{{ url('maintenance/detail') }}/" + id,
        method: 'GET',
        success: function (data) {
            $('#d-ruangan').text(data.nama_ruangan ?? '-');
            $('#d-tanggal').text(data.tanggal      ?? '-');
            $('#d-teknisi').text(data.nama_teknisi  ?? '-');
            $('#d-deskripsi').text(data.deskripsi   ?? '-');
            var kategoriHtml = '';
            if (data.kategoris && data.kategoris.length > 0) {
                $.each(data.kategoris, function (i, kat) {
                    kategoriHtml += '<span class="badge badge-primary mr-1 mb-1">' + kat.nama_kategori + '</span>';
                });
            } else { kategoriHtml = '-'; }
            $('#d-kategori').html(kategoriHtml);
            $('#detail-loading').hide();
            $('#detail-content').show();
        },
        error: function () {
            $('#detail-loading').hide();
            $('#detail-error').removeClass('d-none');
        }
    });
});

/* ─────────────────────────────────────────
   MODAL TAMBAH — search & checkbox (original)
───────────────────────────────────────── */
$('#searchPerangkat').on('input', function () {
    var keyword = $(this).val().toLowerCase().trim();
    $('.kategori-group').each(function () {
        var namaKategori = $(this).data('nama') || '';
        if (keyword === '') { $(this).show(); }
        else { $(this).toggle(namaKategori.includes(keyword)); }
    });
    var tampil = $('.kategori-group:visible').length;
    if (keyword !== '') {
        $('#countPilihan').text(tampil + ' hasil ditemukan');
    } else {
        $('#countPilihan').text($('input[name="id_kategori[]"]:checked').length + ' kategori dipilih');
    }
});

$(document).on('change', 'input[name="id_kategori[]"]', function () {
    $('#countPilihan').text($('input[name="id_kategori[]"]:checked').length + ' kategori dipilih');
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
    var now    = new Date();
    var tanggal = fmtDate(now);
    var jam    = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
    $('#inputTanggal').val(tanggal);
    $('#inputJam').val(jam);
});
</script>

@endsection
