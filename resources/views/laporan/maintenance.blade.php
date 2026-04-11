@extends('layout.page')

@section('content')
<style>
    * { box-sizing: border-box; }

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
    .btn-print {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #111827;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 9px 16px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: opacity .15s;
    }
    .btn-print:hover { opacity: .85; color: #fff; }

    /* ── Filter Card ── */
    .filter-card {
        background: #fff;
        border: 0.5px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 16px;
        overflow: hidden;
    }
    .filter-card-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 14px 20px;
        border-bottom: 0.5px solid #f3f4f6;
        background: #f9fafb;
    }
    .filter-card-title {
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: .5px;
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
        font-weight: 600;
        color: #9ca3af;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .form-control-custom {
        width: 100%;
        padding: 8px 11px;
        border: 0.5px solid #d1d5db;
        border-radius: 8px;
        font-size: 13px;
        color: #111827;
        background: #fff;
        outline: none;
        transition: border-color .15s, box-shadow .15s;
        appearance: none;
        -webkit-appearance: none;
    }
    .form-control-custom:focus {
        border-color: #6b7280;
        box-shadow: 0 0 0 3px rgba(0,0,0,.06);
    }
    select.form-control-custom {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 16 16' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round'%3E%3Cpath d='M4 6l4 4 4-4'/%3E%3C/svg%3E");
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
        background: #111827;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        white-space: nowrap;
        transition: opacity .15s;
    }
    .btn-filter:hover { opacity: .85; }
    .btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: transparent;
        color: #6b7280;
        border: 0.5px solid #d1d5db;
        border-radius: 8px;
        padding: 8px 14px;
        font-size: 13px;
        text-decoration: none;
        white-space: nowrap;
        transition: background .15s;
    }
    .btn-reset:hover { background: #f9fafb; color: #374151; }

    /* Active filter pills */
    .active-filters {
        display: flex;
        gap: 6px;
        flex-wrap: wrap;
        align-items: center;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 0.5px solid #f3f4f6;
    }
    .active-filters-label {
        font-size: 11px;
        color: #9ca3af;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .filter-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f3f4f6;
        color: #374151;
        border-radius: 20px;
        padding: 3px 10px;
        font-size: 12px;
        font-weight: 500;
    }
    .filter-pill-key { color: #9ca3af; }

    /* ── Table Card ── */
    .table-card {
        background: #fff;
        border: 0.5px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 80px;
    }
    .table-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 20px;
        border-bottom: 0.5px solid #e5e7eb;
        background: #f9fafb;
    }
    .table-card-title {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
    }
    .total-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #dbeafe;
        color: #1d4ed8;
        border-radius: 20px;
        padding: 3px 10px;
        font-size: 12px;
        font-weight: 500;
    }

    /* ── Summary Stats ── */
    .stats-strip {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        border-bottom: 0.5px solid #e5e7eb;
    }
    .stat-cell {
        padding: 14px 20px;
        border-right: 0.5px solid #e5e7eb;
    }
    .stat-cell:last-child { border-right: none; }
    .stat-cell-label {
        font-size: 11px;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 2px;
    }
    .stat-cell-value {
        font-size: 20px;
        font-weight: 600;
        color: #111827;
    }

    /* ── Table ── */
    .table-wrap { overflow-x: auto; }
    table#tabelMaintenance {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    table#tabelMaintenance thead th {
        padding: 10px 16px;
        text-align: left;
        font-size: 11px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: .5px;
        background: #f9fafb;
        border-bottom: 0.5px solid #e5e7eb;
        white-space: nowrap;
    }
    table#tabelMaintenance tbody tr {
        border-bottom: 0.5px solid #f3f4f6;
        transition: background .1s;
    }
    table#tabelMaintenance tbody tr:last-child { border-bottom: none; }
    table#tabelMaintenance tbody tr:hover { background: #f9fafb; }
    table#tabelMaintenance td {
        padding: 11px 16px;
        vertical-align: middle;
        color: #374151;
    }
    .td-no {
        color: #9ca3af;
        font-size: 12px;
        width: 40px;
    }
    .td-id {
        font-family: 'Courier New', monospace;
        font-size: 11px;
        color: #6b7280;
        background: #f3f4f6;
        border-radius: 4px;
        padding: 2px 7px;
        display: inline-block;
    }
    .td-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 3px 9px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 500;
        background: #f0fdf4;
        color: #15803d;
    }
    .td-room {
        font-weight: 500;
        color: #111827;
    }
    .td-date {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #eff6ff;
        color: #1d4ed8;
        border-radius: 6px;
        padding: 3px 9px;
        font-size: 11px;
        font-weight: 500;
        white-space: nowrap;
    }
    .td-desc {
        color: #6b7280;
        max-width: 240px;
    }

    .empty-row td {
        text-align: center;
        padding: 48px 20px;
        color: #9ca3af;
        font-size: 13px;
    }
</style>

<div class="container-fluid" style="padding-bottom: 40px;">

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan Maintenance</h1>
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
            <i class="fas fa-sliders-h" style="font-size:12px;color:#9ca3af"></i>
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
                            <i class="fas fa-filter" style="font-size:11px"></i>
                            Filter
                        </button>
                        <a href="{{ url('/laporan/maintenance') }}" class="btn-reset">
                            Reset
                        </a>
                    </div>
                </div>

                {{-- Active filter pills --}}
                @if(request('id_ruangan') || request('id_kategori') || request('dari') || request('sampai'))
                <div class="active-filters">
                    <span class="active-filters-label">Aktif:</span>
                    @if(request('id_ruangan'))
                        @php $rNama = $ruangans->firstWhere('id', request('id_ruangan'))?->nama_ruangan ?? request('id_ruangan'); @endphp
                        <span class="filter-pill"><span class="filter-pill-key">Ruangan</span> {{ $rNama }}</span>
                    @endif
                    @if(request('id_kategori'))
                        @php $kNama = $kategoris->firstWhere('id', request('id_kategori'))?->nama_kategori ?? request('id_kategori'); @endphp
                        <span class="filter-pill"><span class="filter-pill-key">Kategori</span> {{ $kNama }}</span>
                    @endif
                    @if(request('dari'))
                        <span class="filter-pill"><span class="filter-pill-key">Dari</span> {{ \Carbon\Carbon::parse(request('dari'))->format('d/m/Y') }}</span>
                    @endif
                    @if(request('sampai'))
                        <span class="filter-pill"><span class="filter-pill-key">Sampai</span> {{ \Carbon\Carbon::parse(request('sampai'))->format('d/m/Y') }}</span>
                    @endif
                </div>
                @endif
            </form>
        </div>
    </div>

    {{-- ── Table Card ── --}}
    <div class="table-card">
        <div class="table-card-header">
            <span class="table-card-title">Data Jadwal &amp; Riwayat Maintenance</span>
            <span class="total-badge">
                <i class="fas fa-database" style="font-size:10px"></i>
                {{ $maintenances->count() }} data
            </span>
        </div>

        {{-- Stats strip --}}
        @if($maintenances->count() > 0)
        <div class="stats-strip">
            <div class="stat-cell">
                <div class="stat-cell-label">Total Data</div>
                <div class="stat-cell-value">{{ $maintenances->count() }}</div>
            </div>
            <div class="stat-cell">
                <div class="stat-cell-label">Teknisi Terlibat</div>
                <div class="stat-cell-value">{{ $maintenances->unique('nama_teknisi')->count() }}</div>
            </div>
            <div class="stat-cell">
                <div class="stat-cell-label">Ruangan</div>
                <div class="stat-cell-value">{{ $maintenances->unique('nama_ruangan')->count() }}</div>
            </div>
        </div>
        @endif

        <div class="table-wrap">
            <table id="tabelMaintenance" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
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
                        <td><span class="td-id">{{ $m->id_maintenance }}</span></td>
                        <td>
                            <span class="td-badge">
                                {{ $m->nama_kategori ?? '-' }}
                            </span>
                        </td>
                        <td class="td-room">{{ $m->nama_ruangan ?? '-' }}</td>
                        <td style="color:#374151">{{ $m->nama_teknisi }}</td>
                        <td>
                            <span class="td-date">
                                <i class="far fa-calendar-alt" style="font-size:10px"></i>
                                {{ $m->tanggal ? \Carbon\Carbon::parse($m->tanggal)->format('d/m/Y') : '-' }}
                            </span>
                        </td>
                        <td class="td-desc">{{ $m->deskripsi }}</td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="7">Tidak ada data maintenance untuk filter yang dipilih.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
