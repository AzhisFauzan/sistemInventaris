<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaintenanceCtrl extends Controller
{
    public function maintenance(){
        $maintenances = DB::table('maintenance as a')->join('kategori_perangkat as b','a.id_kategori','b.id_kategori')->join('ruangan as c','a.id_ruangan','c.id_ruangan')->select('a.*','c.nama_ruangan')->get();
        $kategoriPerangkat = DB::table('kategori_perangkat')->select('id_kategori','nama_kategori')->orderBy('nama_kategori')->get()->unique('id_kategori')->groupBy('nama_kategori');
        $ruangan = DB::table('ruangan')->get();
        return view('maintenance.maintenance',compact('maintenances','kategoriPerangkat','ruangan'));
    }

    public function detail_maintenance($id){
        $maintenance = DB::table('maintenance as a')->join('ruangan as b', 'a.id_ruangan', 'b.id_ruangan')->select('a.*', 'b.nama_ruangan')->where('a.id_maintenance', $id)->first();

        $kategoris = DB::table('maintenance as a')->join('kategori_perangkat as k', 'a.id_kategori', 'k.id_kategori')->select('k.id_kategori', 'k.nama_kategori')->where('a.id_ruangan', $maintenance->id_ruangan)->distinct()->get();

        $maintenance->kategoris = $kategoris;

        return response()->json($maintenance);
    }

    public function kategoriRuangan(){
        $data = DB::table('maintenance')->select('id_ruangan', 'id_kategori')->distinct()->get();

        $mapping = [];
        foreach($data as $row){
            $mapping[$row->id_ruangan][] = $row->id_kategori;
        }

        return response()->json($mapping);
    }

    public function store_maintenance(Request $request) {
        $tanggal = $request->tanggal . ' ' . $request->jam . ':00';

        // Cek jika tidak ada kategori yang dipilih
        if (!$request->id_kategori || count($request->id_kategori) == 0) {
            return redirect()->back()->with('error', 'Pilih minimal satu kategori perangkat.');
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

        return redirect()->back()->with('success', 'Jadwal maintenance berhasil ditambahkan.');
    }

    public function destroy_maintenance(Request $request) {
        $ids = $request->ids;

        if (!$ids || count($ids) == 0) {
            return response()->json(['message' => 'Tidak ada data yang dipilih.'], 400);
        }

        $count = DB::table('maintenance')->whereIn('id_maintenance', $ids)->count();
        DB::table('maintenance')->whereIn('id_maintenance', $ids)->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus.',
            'count'   => $count
        ]);
    }

    public function riwayat_maintenance(){
        $riwayat = DB::table('maintenance as a')->join('kategori_perangkat as b','a.id_kategori','b.id_kategori')->join('ruangan as c','a.id_ruangan','c.id_ruangan')->select('a.*','c.nama_ruangan','b.nama_kategori')->orderByDesc('a.tanggal')->get();

        $kategoriPerangkat = DB::table('kategori_perangkat')->select('id_kategori','nama_kategori')->orderBy('nama_kategori')->get()->unique('id_kategori')->groupBy('nama_kategori');

        return view('maintenance.riwayat_maintenance', compact('riwayat','kategoriPerangkat'));
    }
}
