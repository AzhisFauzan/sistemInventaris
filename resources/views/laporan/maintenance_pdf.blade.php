<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #111827;
            background: #fff;
            padding: 28px 32px;
        }

        /* ── Header ── */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 14px;
            border-bottom: 2px solid #111827;
            margin-bottom: 18px;
        }
        .header-left h2 {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            letter-spacing: -0.3px;
            margin-bottom: 3px;
        }
        .header-left p {
            font-size: 10px;
            color: #6b7280;
            margin-bottom: 2px;
        }
        .header-right {
            text-align: right;
        }
        .header-right .doc-label {
            font-size: 9px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: 3px;
        }
        .header-right .doc-date {
            font-size: 10px;
            color: #374151;
        }

        /* ── Summary Strip ── */
        .summary-strip {
            display: table;
            width: 100%;
            margin-bottom: 18px;
            border: 0.5px solid #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
        }
        .summary-cell {
            display: table-cell;
            width: 33.33%;
            padding: 10px 14px;
            border-right: 0.5px solid #e5e7eb;
            background: #f9fafb;
            vertical-align: middle;
        }
        .summary-cell:last-child { border-right: none; }
        .summary-label {
            font-size: 9px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 2px;
        }
        .summary-value {
            font-size: 17px;
            font-weight: 700;
            color: #111827;
        }

        /* ── Active Filters ── */
        .filters-row {
            margin-bottom: 16px;
            font-size: 10px;
            color: #6b7280;
        }
        .filters-row strong { color: #374151; }
        .filter-pill {
            display: inline-block;
            background: #f3f4f6;
            border: 0.5px solid #e5e7eb;
            border-radius: 20px;
            padding: 2px 8px;
            font-size: 9px;
            color: #374151;
            margin-left: 4px;
        }
        .filter-pill span { color: #9ca3af; }

        /* ── Table ── */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        thead th {
            background: #111827;
            color: #fff;
            padding: 8px 10px;
            font-size: 9px;
            font-weight: 700;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        thead th:first-child { border-radius: 0; width: 4%; }

        tbody tr:nth-child(even) { background: #f9fafb; }
        tbody tr:nth-child(odd)  { background: #fff; }

        tbody td {
            padding: 7px 10px;
            border-bottom: 0.5px solid #e5e7eb;
            font-size: 10px;
            color: #374151;
            vertical-align: top;
        }

        .td-no    { color: #9ca3af; font-size: 9px; text-align: center; }
        .td-id    { font-family: Courier, monospace; font-size: 9px; color: #6b7280; background: #f3f4f6; padding: 1px 5px; border-radius: 3px; display: inline-block; }
        .td-badge { display: inline-block; background: #f0fdf4; color: #15803d; border-radius: 4px; padding: 1px 6px; font-size: 9px; font-weight: 700; }
        .td-room  { font-weight: 700; color: #111827; }
        .td-date  { display: inline-block; background: #eff6ff; color: #1d4ed8; border-radius: 4px; padding: 1px 6px; font-size: 9px; font-weight: 700; white-space: nowrap; }
        .td-desc  { color: #6b7280; max-width: 180px; }

        .empty-row td {
            text-align: center;
            padding: 28px;
            color: #9ca3af;
            font-size: 11px;
        }

        /* ── Footer ── */
        .footer {
            display: table;
            width: 100%;
            border-top: 0.5px solid #e5e7eb;
            padding-top: 10px;
            margin-top: 4px;
        }
        .footer-left {
            display: table-cell;
            font-size: 9px;
            color: #9ca3af;
        }
        .footer-right {
            display: table-cell;
            text-align: right;
            font-size: 9px;
            color: #9ca3af;
        }
        .footer-right strong { color: #374151; }
    </style>
</head>
<body>

    {{-- ── Header ── --}}
    <div class="header">
        <div class="header-left">
            <h2>Laporan Data Maintenance</h2>
            <p>Jadwal dan riwayat perawatan perangkat IT</p>
        </div>
        <div class="header-right">
            <div class="doc-label">Dicetak pada</div>
            <div class="doc-date">{{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY HH:mm') }} WIB</div>
        </div>
    </div>

    {{-- ── Summary Strip ── --}}
    <div class="summary-strip">
        <div class="summary-cell">
            <div class="summary-label">Total Data</div>
            <div class="summary-value">{{ $maintenances->count() }}</div>
        </div>
        <div class="summary-cell">
            <div class="summary-label">Teknisi Terlibat</div>
            <div class="summary-value">{{ $maintenances->unique('nama_teknisi')->count() }}</div>
        </div>
        <div class="summary-cell">
            <div class="summary-label">Ruangan</div>
            <div class="summary-value">{{ $maintenances->unique('nama_ruangan')->count() }}</div>
        </div>
    </div>

    {{-- ── Table ── --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
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
                <td><span class="td-id">{{ $m->id ?? $m->id_maintenance ?? '-' }}</span></td>
                <td><span class="td-badge">{{ $m->nama_kategori ?? '-' }}</span></td>
                <td class="td-room">{{ $m->nama_ruangan ?? '-' }}</td>
                <td>{{ $m->nama_teknisi ?? '-' }}</td>
                <td><span class="td-date">{{ \Carbon\Carbon::parse($m->tanggal)->format('d/m/Y') }}</span></td>
                <td class="td-desc">{{ $m->deskripsi ?? '-' }}</td>
            </tr>
            @empty
            <tr class="empty-row">
                <td colspan="7">Tidak ada data maintenance.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ── Footer ── --}}
    <div class="footer">
        <div class="footer-left">Laporan Maintenance IT &nbsp;|&nbsp; {{ now()->format('d/m/Y') }}</div>
        <div class="footer-right">Total: <strong>{{ $maintenances->count() }} data</strong></div>
    </div>

</body>
</html>
