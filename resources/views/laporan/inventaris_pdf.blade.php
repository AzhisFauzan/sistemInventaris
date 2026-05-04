<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        /* Pengaturan Kertas A4 Portrait */
        @page {
            size: A4 portrait;
            margin: 1.5cm;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            margin: 0;
            color: #333;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #16a34a; /* Hijau Utama */
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            color: #16a34a;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header p {
            margin: 4px 0;
            color: #555;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th {
            background-color: #16a34a; /* Hijau Utama */
            color: white;
            padding: 8px 5px;
            font-size: 10px;
            text-align: left;
            border: 1px solid #16a34a;
        }

        td {
            padding: 6px 5px;
            border: 1px solid #e2e8f0;
            font-size: 9px;
            word-wrap: break-word;
            vertical-align: top;
        }

        tr:nth-child(even) { background-color: #f0fdf4; } /* Hijau sangat muda */

        /* Pengaturan Lebar Kolom */
        .col-no { width: 20px; text-align: center; } /* Nomor dipersempit */
        .col-kode { width: 85px; }
        .col-kat { width: 70px; }
        .col-ruang { width: 80px; }
        .col-ip { width: 75px; }
        .col-spek { width: auto; }

        .footer {
            margin-top: 20px;
            font-size: 8px;
            color: #94a3b8;
            text-align: right;
            border-top: 1px solid #f1f5f9;
            padding-top: 5px;
        }

        .text-bold { font-weight: bold; }
        .text-center { text-align: center; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Inventaris Perangkat IT</h2>
        <p>Dicetak pada : {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY HH:mm') }} WIB</p>
        <p>Total Perangkat : <span class="text-bold">{{ $perangkat->count() }}</span></p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="col-no text-center">No</th>
                <th class="col-kode">Kode Inventaris</th>
                <th class="col-kat">Kategori</th>
                <th class="col-ruang">Ruangan</th>
                <th class="col-ip">Alamat IP</th>
                <th class="col-spek">Spesifikasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perangkat as $i => $p)
            <tr>
                <td class="text-center">{{ $i + 1 }}</td>
                <td>{{ $p->kode_inventaris ?? '-' }}</td>
                <td>{{ $p->nama_kategori ?? '-' }}</td>
                <td>{{ $p->nama_ruangan ?? '-' }}</td>
                <td>{{ $p->alamat_ip ?? '-' }}</td>
                <td>{{ $p->spesifikasi ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="color:#94a3b8; padding:30px;">
                    Data perangkat tidak tersedia.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        RS Darmayu Madiun — Sistem Inventaris IT &nbsp;|&nbsp; {{ date('d/m/Y') }}
    </div>
</body>
</html>
