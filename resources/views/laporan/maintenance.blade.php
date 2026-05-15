@extends('layout.page')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap');

    :root {
        /* Warna Khas RS Darmayu */
        --rs-purple:       #6b21a8; /* Ungu Utama */
        --rs-purple-hover: #581c87;
        --rs-purple-soft:  #f3e8ff;
        --rs-purple-mid:   #d8b4fe;

        --rs-green:        #16a34a; /* Hijau Utama */
        --rs-green-hover:  #15803d;
        --rs-green-soft:   #dcfce7;

        --slate:     #f8fafc;
        --border:    #e2e8f0;
        --text-main: #0f172a;
        --text-sub:  #64748b;
        --radius:    10px;
    }

    * { box-sizing: border-box; font-family: 'DM Sans', sans-serif; }

    /* ── Page Header ── */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-main);
        letter-spacing: -0.3px;
        margin: 0;
    }
    .page-subtitle {
        font-size: 12px;
        color: var(--text-sub);
        margin-top: 3px;
    }
    .btn-print {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--rs-green);
        color: #fff;
        border: none;
        border-radius: var(--radius);
        padding: 9px 18px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: background .15s;
        box-shadow: 0 4px 12px rgba(22, 163, 74, .25);
    }
    .btn-print:hover { background: var(--rs-green-hover); color: #fff; text-decoration: none; }

    /* ── Filter Card ── */
    .filter-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 12px;
        margin-bottom: 16px;
        overflow: hidden;
        box-shadow: 0 1px 8px rgba(0,0,0,.02);
    }
    .filter-card-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        border-bottom: 0.5px solid var(--border);
        background: linear-gradient(135deg, var(--rs-purple), var(--rs-purple-hover));
    }
    .filter-card-title {
        font-size: 12px;
        font-weight: 700;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: .6px;
    }
    .filter-card-body { padding: 20px; }

    .filter-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr auto;
        gap: 14px;
        align-items: end;
    }
    @media (max-width: 1024px) {
        .filter-grid { grid-template-columns: 1fr 1fr; }
    }

    .form-label-custom {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: var(--text-sub);
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .form-control-custom {
        width: 100%;
        padding: 8px 11px;
        border: 1.5px solid var(--border);
        border-radius: 8px;
        font-size: 13px;
        color: var(--text-main);
        background: var(--slate);
        outline: none;
        transition: border-color .15s, box-shadow .15s;
        appearance: none;
        -webkit-appearance: none;
    }
    .form-control-custom:focus {
        border-color: var(--rs-purple);
        box-shadow: 0 0 0 3px rgba(107, 33, 168, 0.1);
    }
    select.form-control-custom {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 16 16' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round'%3E%3Cpath d='M4 6l4 4 4-4'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        padding-right: 30px;
    }

    .filter-actions {
        display: flex;
        gap: 8px;
    }
    .btn-filter {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--rs-green);
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        white-space: nowrap;
        transition: background .15s;
    }
    .btn-filter:hover { background: var(--rs-green-hover); }
    .btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: transparent;
        color: var(--text-sub);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        white-space: nowrap;
        transition: background .15s;
    }
    .btn-reset:hover { background: var(--slate); color: var(--text-main); text-decoration: none; }

    /* Active filter pills */
    .active-filters {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        align-items: center;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 0.5px solid var(--border);
    }
    .active-filters-label {
        font-size: 11px;
        color: var(--text-sub);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .filter-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: var(--rs-purple-soft);
        color: var(--rs-purple);
        border: 1px solid var(--rs-purple-mid);
        border-radius: 20px;
        padding: 3px 12px;
        font-size: 12px;
        font-weight: 600;
    }
    .filter-pill-key { color: var(--text-sub); font-weight: 500; }

    /* ── Table Card ── */
    .table-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 14px;
        overflow: hidden;
        margin-bottom: 80px;
        box-shadow: 0 1px 8px rgba(0,0,0,.03);
    }
    .table-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        background: linear-gradient(135deg, var(--rs-purple), var(--rs-purple-hover));
    }
    .table-card-title {
        font-size: 14px;
        font-weight: 600;
        color: #fff;
    }
    .total-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 12px;
        font-weight: 600;
    }

    /* ── Summary Stats ── */
    .stats-strip {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        border-bottom: 1px solid var(--border);
    }
    .stat-cell {
        padding: 16px 20px;
        border-right: 1px solid var(--border);
    }
    .stat-cell:last-child { border-right: none; }
    .stat-cell-label {
        font-size: 11px;
        color: var(--text-sub);
        text-transform: uppercase;
        letter-spacing: .5px;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .stat-cell-value {
        font-size: 24px;
        font-weight: 700;
        color: var(--rs-purple);
    }

    /* ── Table ── */
    .table-wrap { overflow-x: auto; }
    table#tabelMaintenance {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    table#tabelMaintenance thead th {
        padding: 12px 16px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: var(--text-sub);
        text-transform: uppercase;
        letter-spacing: .5px;
        background: var(--slate);
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }
    table#tabelMaintenance tbody tr {
        border-bottom: 1px solid var(--border);
        transition: background .1s;
    }
    table#tabelMaintenance tbody tr:last-child { border-bottom: none; }
    table#tabelMaintenance tbody tr:hover { background: var(--rs-purple-soft); }
    table#tabelMaintenance td {
        padding: 12px 16px;
        vertical-align: middle;
        color: var(--text-main);
    }
    .td-no {
        color: var(--text-sub);
        font-size: 12px;
        width: 40px;
        text-align: center;
    }
    .td-id {
        font-family: 'Courier New', monospace;
        font-size: 11px;
        color: var(--rs-purple);
        background: var(--rs-purple-soft);
        border: 1px solid var(--rs-purple-mid);
        border-radius: 6px;
        padding: 3px 8px;
        display: inline-block;
        font-weight: 600;
    }
    .td-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 600;
        background: var(--rs-green-soft);
        color: var(--rs-green-hover);
    }
    .td-room {
        font-weight: 600;
        color: var(--text-main);
    }
    .td-date {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: var(--slate);
        color: var(--text-sub);
        border: 1px solid var(--border);
        border-radius: 6px;
        padding: 4px 10px;
        font-size: 11.5px;
        font-weight: 600;
        white-space: nowrap;
    }
    .td-desc {
        color: var(--text-sub);
        max-width: 240px;
        font-size: 12px;
        line-height: 1.5;
    }

    .empty-row td {
        text-align: center;
        padding: 48px 20px;
        color: var(--text-sub);
        font-size: 13px;
        font-weight: 500;
    }
</style>

<div class="container-fluid" style="padding-bottom: 40px;">

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fas fa-file-contract mr-2" style="color: var(--rs-purple);"></i>Laporan Maintenance</h1>
            <p class="page-subtitle">Data jadwal dan riwayat perawatan perangkat IT</p>
        </div>
        <a href="{{ url('/laporan/maintenance/print') }}?{{ http_build_query(request()->all()) }}"
           target="_blank" class="btn-print">
            <i class="fas fa-print" style="font-size:12px"></i>
            Cetak Laporan
        </a>
    </div>

    {{-- ── Filter Card ── --}}
    <div class="filter-card">
        <div class="filter-card-header">
            <i class="fas fa-sliders-h" style="font-size:12px; color:#fff"></i>
            <span class="filter-card-title">Filter Laporan</span>
        </div>
        <div class="filter-card-body">
            <form method="GET" action="{{ url('/laporan/maintenance') }}">
                <div class="filter-grid">
                    <div>
                        <label class="form-label-custom">Ruangan</label>
                        <select name="id_ruangan" class="form-control-custom">
                            <option value="">Semua Ruangan</option>
                            @foreach($ruangans as $r)
                                <option value="{{ $r->id_ruangan }}" {{ request('id_ruangan') == $r->id_ruangan ? 'selected' : '' }}>
                                    {{ $r->nama_ruangan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label-custom">Kategori</label>
                        <select name="id_kategori" class="form-control-custom">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoris as $k)
                                <option value="{{ $k->id_kategori }}" {{ request('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label-custom">Dari Tanggal</label>
                        <input type="date" name="dari" class="form-control-custom" value="{{ request('dari') }}">
                    </div>
                    <div>
                        <label class="form-label-custom">Sampai Tanggal</label>
                        <input type="date" name="sampai" class="form-control-custom" value="{{ request('sampai') }}">
                    </div>
                    <div class="filter-actions">
                        <button type="submit" class="btn-filter">
                            <i class="fas fa-search" style="font-size:11px"></i> Filter
                        </button>
                        <a href="{{ url('/laporan/maintenance') }}" class="btn-reset">
                            <i class="fas fa-undo" style="font-size:11px"></i> Reset
                        </a>
                    </div>
                </div>

                {{-- Active filter pills --}}
                @if(request('id_ruangan') || request('id_kategori') || request('dari') || request('sampai'))
                <div class="active-filters">
                    <span class="active-filters-label">Filter Aktif:</span>
                    @if(request('id_ruangan'))
                        @php $rNama = $ruangans->firstWhere('id', request('id_ruangan'))?->nama_ruangan ?? request('id_ruangan'); @endphp
                        <span class="filter-pill"><span class="filter-pill-key">Ruangan:</span> {{ $rNama }}</span>
                    @endif
                    @if(request('id_kategori'))
                        @php $kNama = $kategoris->firstWhere('id', request('id_kategori'))?->nama_kategori ?? request('id_kategori'); @endphp
                        <span class="filter-pill"><span class="filter-pill-key">Kategori:</span> {{ $kNama }}</span>
                    @endif
                    @if(request('dari'))
                        <span class="filter-pill"><span class="filter-pill-key">Dari:</span> {{ \Carbon\Carbon::parse(request('dari'))->format('d/m/Y') }}</span>
                    @endif
                    @if(request('sampai'))
                        <span class="filter-pill"><span class="filter-pill-key">Sampai:</span> {{ \Carbon\Carbon::parse(request('sampai'))->format('d/m/Y') }}</span>
                    @endif
                </div>
                @endif
            </form>
        </div>
    </div>

    {{-- ── Table Card ── --}}
    <div class="table-card">
        <div class="table-card-header">
            <span class="table-card-title"><i class="fas fa-list-ul mr-2"></i>Data Jadwal &amp; Riwayat Maintenance</span>
            <span class="total-badge">
                <i class="fas fa-database" style="font-size:10px"></i>
                {{ $maintenances->count() }} data
            </span>
        </div>

        {{-- Stats strip --}}
        @if($maintenances->count() > 0)
        <div class="stats-strip">
            <div class="stat-cell">
                <div class="stat-cell-label">Total Laporan</div>
                <div class="stat-cell-value">{{ $maintenances->count() }}</div>
            </div>
            <div class="stat-cell">
                <div class="stat-cell-label">Teknisi Terlibat</div>
                <div class="stat-cell-value">{{ $maintenances->unique('nama_teknisi')->count() }}</div>
            </div>
            <div class="stat-cell">
                <div class="stat-cell-label">Ruangan Termaintenance</div>
                <div class="stat-cell-value">{{ $maintenances->unique('nama_ruangan')->count() }}</div>
            </div>
        </div>
        @endif

        <div class="table-wrap">
            <table id="tabelMaintenance">
                <thead>
                    <tr>
                        <th style="text-align: center;">No</th>
                        <th>Kode Inventaris</th>
                        <th>Kategori</th>
                        <th>Ruangan</th>
                        <th>Teknisi</th>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($maintenances as $i => $m)
                    <tr>
                        <td class="td-no">{{ $i + 1 }}</td>
                        <td><span class="td-id">{{ $m->kode_inventaris ?? '-' }}</span></td>
                        <td>
                            <span class="td-badge">
                                {{ $m->nama_kategori ?? '-' }}
                            </span>
                        </td>
                        <td class="td-room">{{ $m->nama_ruangan ?? '-' }}</td>
                        <td style="font-weight: 500; color: var(--text-main);">{{ $m->nama_teknisi }}</td>
                        <td>
                            <span class="td-date">
                                <i class="far fa-calendar-alt"></i>
                                {{ $m->tanggal ? \Carbon\Carbon::parse($m->tanggal)->format('d M Y') : '-' }}
                            </span>
                        </td>
                        <td class="td-desc">{{ $m->deskripsi }}</td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="7">
                            <i class="fas fa-search fa-2x mb-2 d-block" style="color: var(--border);"></i>
                            Tidak ada data maintenance untuk filter yang dipilih.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
