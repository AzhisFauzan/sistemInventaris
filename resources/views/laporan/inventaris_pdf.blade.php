<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; margin: 20px; }
        .header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #4E73DF; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #4E73DF; font-size: 15px; }
        .header p  { margin: 3px 0; color: #555; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #4E73DF; color: white; padding: 7px 8px; font-size: 10px; text-align: left; }
        td { padding: 5px 8px; border-bottom: 1px solid #ddd; font-size: 10px; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .footer { margin-top: 10px; font-size: 9px; color: #aaa; text-align: right; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Inventaris Perangkat IT</h2>
        <p>Ruangan : <strong>{{ $namaRuangan }}</strong></p>
        <p>Dicetak pada : {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY HH:mm') }} WIB</p>
        <p>Total : {{ $perangkat->count() }} perangkat</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Inventaris</th>
                <th>Kategori</th>
                <th>Ruangan</th>
                <th>Alamat IP</th>
                <th>Spesifikasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perangkat as $i => $p)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $p->kode_inventaris ?? '-' }}</td>
                <td>{{ $p->nama_kategori   ?? '-' }}</td>
                <td>{{ $p->nama_ruangan    ?? '-' }}</td>
                <td>{{ $p->alamat_ip       ?? '-' }}</td>
                <td>{{ $p->spesifikasi     ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center; color:#999; padding:15px;">
                    Tidak ada data perangkat
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Laporan Inventaris IT &nbsp;|&nbsp; {{ now()->format('d/m/Y') }}
    </div>

</body>
</html>
