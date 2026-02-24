<?php

namespace App\Http\Controllers;

use App\Models\Perangkat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerangkatCtrl extends Controller
{
    public function data_perangkat()
    {
        // Mengambil data perangkat beserta relasinya (Kategori & Ruangan)
        $data_perangkat = Perangkat::with(['kategori', 'ruangan'])->get();

        // Mengambil data master untuk dropdown di Modal
        $data_kategori = DB::table('kategori_perangkat')->get();
        $data_ruangan = DB::table('ruangan')->get();

        return view("perangkat.data_perangkat", compact('data_perangkat', 'data_kategori', 'data_ruangan'));
    }

    public function store_perangkat(Request $request)
    {
        // Validasi input
        $request->validate([
            'kode_inventaris' => 'required',
            'nama_perangkat'  => 'required',
            'id_kategori'     => 'required',
            'id_ruangan'      => 'required',
            'kondisi'         => 'required'
        ]);

        // Simpan data perangkat
        $perangkat = Perangkat::create([
            'kode_inventaris' => $request->kode_inventaris,
            'nama_perangkat'  => $request->nama_perangkat,
            'id_kategori'     => $request->id_kategori,
            'merk'            => $request->merk,
            'spesifikasi'     => $request->spesifikasi,
            'id_ruangan'      => $request->id_ruangan,
            'kondisi'         => $request->kondisi,
        ]);

        // Ambil nama kategori & ruangan untuk di-return sebagai JSON (kebutuhan append baris AJAX)
        $kategori = DB::table('kategori_perangkat')->where('id_kategori', $perangkat->id_kategori)->first();
        $ruangan = DB::table('ruangan')->where('id_ruangan', $perangkat->id_ruangan)->first();

        return response()->json([
            'status'          => 'success',
            'id_perangkat'    => $perangkat->id_perangkat,
            'kode_inventaris' => $perangkat->kode_inventaris,
            'nama_perangkat'  => $perangkat->nama_perangkat,
            'nama_kategori'   => $kategori ? $kategori->nama_kategori : '-',
            'merk'            => $perangkat->merk,
            'nama_ruangan'    => $ruangan ? $ruangan->nama_ruangan : '-',
            'kondisi'         => $perangkat->kondisi,
        ]);
    }

    public function delete_perangkat($id)
    {
        // Cari perangkat berdasarkan id_perangkat lalu hapus
        $perangkat = Perangkat::findOrFail($id);
        $perangkat->delete();

        return response()->json([
            'status' => 'success',
            'id'     => $id
        ]);
    }
}
