<html>
<head>
    <meta charset="UTF-8">
    <style>
        th { background-color: #4E73DF; color: white; font-weight: bold; padding: 6px 10px; }
        td { padding: 5px 10px; border: 1px solid #ccc; }
        table { border-collapse: collapse; width: 100%; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        h2 { font-family: Arial, sans-serif; }
        p  { font-family: Arial, sans-serif; font-size: 12px; color: #555; }
    </style>
</head>
<body>
    <h2>Laporan Inventaris Perangkat IT</h2>
    <p>Dicetak pada : {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY HH:mm') }} WIB</p>
    <p>Total : {{ $perangkat->count() }} perangkat</p>

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
                <td colspan="6" style="text-align:center; color:#999;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
