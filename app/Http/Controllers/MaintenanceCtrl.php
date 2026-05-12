<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceCtrl extends Controller
{
    public function maintenance()
    {
        $maintenances = DB::table('maintenance as a')
            ->leftJoin('kategori_perangkat as b', 'a.id_kategori', 'b.id_kategori')
            ->leftJoin('ruangan as c', 'a.id_ruangan', 'c.id_ruangan')
            ->select('a.*', 'c.nama_ruangan')
            ->distinct()
            ->get();

        $kategoriPerangkat = DB::table('kategori_perangkat')
            ->select('id_kategori', 'nama_kategori')
            ->orderBy('nama_kategori')
            ->get()
            ->unique('id_kategori')
            ->groupBy('nama_kategori');

        $ruangan = DB::table('ruangan')->get();

        return view('maintenance.maintenance', compact('maintenances', 'kategoriPerangkat', 'ruangan'));
    }

    public function detail_maintenance($id)
    {
        $maintenance = DB::table('maintenance as a')
            ->join('ruangan as b', 'a.id_ruangan', 'b.id_ruangan')
            ->select('a.*', 'b.nama_ruangan')
            ->where('a.id_maintenance', $id)
            ->first();

        $kategoris = DB::table('maintenance as a')
            ->join('kategori_perangkat as k', 'a.id_kategori', 'k.id_kategori')
            ->select('k.id_kategori', 'k.nama_kategori')
            ->where('a.id_ruangan', $maintenance->id_ruangan)
            ->distinct()
            ->get();

        $maintenance->kategoris = $kategoris;

        return response()->json($maintenance);
    }

    public function kategoriRuangan()
    {
        $data = DB::table('maintenance')->select('id_ruangan', 'id_kategori')->distinct()->get();
        $mapping = [];
        foreach ($data as $row) {
            $mapping[$row->id_ruangan][] = $row->id_kategori;
        }
        return response()->json($mapping);
    }

    public function store_maintenance(Request $request)
    {
        $tanggal = $request->tanggal . ' ' . $request->jam . ':00';

        if (!$request->id_kategori || count($request->id_kategori) == 0) {
            return redirect()->back()->with('error', 'Pilih minimal satu kategori perangkat.');
        }
        if (!$request->id_ruangan) {
            return redirect()->back()->with('error', 'Silakan pilih ruangan.');
        }

        foreach ($request->id_kategori as $id_kategori) {
            DB::table('maintenance')->insert([
                'id_kategori'  => $id_kategori,
                'id_ruangan'   => $request->id_ruangan,
                'tanggal'      => $tanggal,
                'nama_teknisi' => $request->nama_teknisi,
                'deskripsi'    => $request->deskripsi,
            ]);
        }

        return redirect()->back()->with('success', 'Data maintenance berhasil disimpan.');
    }

    public function destroy_maintenance(Request $request)
    {
        $ids = $request->ids;

        if (!$ids || count($ids) == 0) {
            return response()->json(['message' => 'Tidak ada data dipilih'], 400);
        }

        $deleted = DB::table('maintenance')->whereIn('id_ruangan', $ids)->delete();

        return response()->json([
            'message' => 'Terhapus permanen',
            'count'   => $deleted
        ]);
    }

    public function riwayat_maintenance()
    {
        $riwayat = DB::table('maintenance as a')
            ->join('kategori_perangkat as b', 'a.id_kategori', 'b.id_kategori')
            ->join('ruangan as c', 'a.id_ruangan', 'c.id_ruangan')
            ->select('a.*', 'c.nama_ruangan', 'b.nama_kategori')
            ->orderByDesc('a.tanggal')
            ->get();

        $kategoriPerangkat = DB::table('kategori_perangkat')
            ->select('id_kategori', 'nama_kategori')
            ->orderBy('nama_kategori')
            ->get()
            ->unique('id_kategori')
            ->groupBy('nama_kategori');

        return view('maintenance.riwayat_maintenance', compact('riwayat', 'kategoriPerangkat'));
    }

    public function api_terima_pengaduan(Request $request)
    {
        $request->validate([
            'id_ruangan' => 'required|integer',
            'tanggal'    => 'required|date',
            'deskripsi'  => 'required|string',
        ]);

        try {
            DB::table('maintenance')->insert([
                'id_kategori'  => $request->id_kategori ?? 3,
                'id_ruangan'   => $request->id_ruangan,
                'tanggal'      => $request->tanggal,
                'nama_teknisi' => 'Menunggu Teknisi',
                'deskripsi'    => $request->deskripsi,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tiket maintenance berhasil dibuat dari pengaduan.'
            ], 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses pengaduan: ' . $e->getMessage()
            ], 500);
        }
    }
}