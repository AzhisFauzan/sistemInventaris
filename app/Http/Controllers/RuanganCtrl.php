<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganCtrl extends Controller
{
    public function data_ruangan()
    {
        $data_ruangan = Ruangan::all();
        return view("ruangan.data_ruangan", compact('data_ruangan'));
    }

    public function store_ruangan(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required'
        ]);

        $ruangan = Ruangan::create([
            'nama_ruangan' => $request->nama_ruangan,
        ]);

        return response()->json([
            'status'       => 'success',
            'id_ruangan'   => $ruangan->id_ruangan,
            'nama_ruangan' => $ruangan->nama_ruangan,
        ]);
    }

    public function delete_ruangan($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->delete();

        return response()->json([
            'status' => 'success',
            'id'     => $id
        ]);
    }
}
