<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanCtrl extends Controller
{
    public function inventaris(Request $request)
    {
        $ruangan = DB::table('ruangan as c')
            ->join('perangkat as a', 'c.id_ruangan', '=', 'a.id_ruangan')
            ->select('c.id_ruangan', 'c.nama_ruangan', DB::raw('COUNT(a.id_perangkat) as jumlah_perangkat'))
            ->groupBy('c.id_ruangan', 'c.nama_ruangan')
            ->having('jumlah_perangkat', '>', 1)
            ->orderBy('c.nama_ruangan')
            ->get();

        $data_perangkat = DB::table('perangkat as a')
            ->join('kategori_perangkat as b', 'a.id_kategori', '=', 'b.id_kategori')
            ->join('ruangan as c', 'a.id_ruangan', '=', 'c.id_ruangan')
            ->leftJoin(DB::raw('(SELECT id_ruangan, MAX(dicetak_pada) as terakhir_cetak FROM riwayat_cetak GROUP BY id_ruangan) as rc'), 'a.id_ruangan', '=', 'rc.id_ruangan')
            ->select('a.*', 'b.nama_kategori', 'c.nama_ruangan', DB::raw('DATE_FORMAT(rc.terakhir_cetak, "%d %M %Y %H:%i") as terakhir_cetak'))
            ->orderBy('a.id_perangkat');

        // whereIn karena checkbox array
        if ($request->filled('id_ruangan')) {
            $data_perangkat->whereIn('a.id_ruangan', (array) $request->id_ruangan);
        }

        $perangkat = $data_perangkat->get();

        return view('laporan.inventaris', compact('perangkat', 'ruangan'));
    }

    public function inventarisPrint(Request $request)
    {
        $data_perangkat = DB::table('perangkat as a')
            ->join('kategori_perangkat as b', 'a.id_kategori', '=', 'b.id_kategori')
            ->join('ruangan as c', 'a.id_ruangan', '=', 'c.id_ruangan')
            ->select('a.*', 'b.nama_kategori', 'c.nama_ruangan')
            ->orderBy('a.id_perangkat');

        if ($request->filled('id_ruangan')) {
            $data_perangkat->whereIn('a.id_ruangan', (array) $request->id_ruangan);
        }

        $perangkat = $data_perangkat->get();

        // Simpan riwayat cetak 1 baris per ruangan yang dipilih
        $ruanganDipilih = $request->filled('id_ruangan') ? (array) $request->id_ruangan : [null];
        foreach ($ruanganDipilih as $idRuangan) {
            DB::table('riwayat_cetak')->insert([
                'id_ruangan'   => $idRuangan ?: null,
                'jenis'        => 'pdf',
                'dicetak_pada' => now(),
            ]);
        }

        // Nama ruangan untuk header PDF
        $namaRuangan = $request->filled('id_ruangan')
            ? DB::table('ruangan')
                ->whereIn('id_ruangan', (array) $request->id_ruangan)
                ->pluck('nama_ruangan')
                ->join(', ')
            : 'Semua Ruangan';

        $pdf = Pdf::loadView('laporan.inventaris_pdf', compact('perangkat', 'namaRuangan'))
                  ->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-inventaris-' . now()->format('Ymd') . '.pdf');
    }

    public function inventarisExcel(Request $request)
    {
        $data_perangkat = DB::table('perangkat as a')
            ->join('kategori_perangkat as b', 'a.id_kategori', '=', 'b.id_kategori')
            ->join('ruangan as c', 'a.id_ruangan', '=', 'c.id_ruangan')
            ->select('a.*', 'b.nama_kategori', 'c.nama_ruangan')
            ->orderBy('a.id_perangkat');

        if ($request->filled('id_ruangan')) {
            $data_perangkat->whereIn('a.id_ruangan', (array) $request->id_ruangan);
        }

        $perangkat = $data_perangkat->get();

        $ruanganDipilih = $request->filled('id_ruangan') ? (array) $request->id_ruangan : [null];
        foreach ($ruanganDipilih as $idRuangan) {
            DB::table('riwayat_cetak')->insert([
                'id_ruangan'   => $idRuangan ?: null,
                'jenis'        => 'excel',
                'dicetak_pada' => now(),
            ]);
        }

        $namaFile = 'laporan-inventaris-' . now()->format('Ymd') . '.xls';
        $html     = view('laporan.inventaris_excel', compact('perangkat'))->render();

        return response($html, 200, [
            'Content-Type'        => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename=\"$namaFile\"",
        ]);
    }
}
