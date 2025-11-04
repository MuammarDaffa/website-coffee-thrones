<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JamOperasional;

class JamOperasionalController extends Controller
{
    public function index()
    {
        $jam = JamOperasional::orderBy('id')->get();
        return view('admin.jam.index', compact('jam'));
    }

    public function update(Request $request, $id)
    {
        $jam = JamOperasional::findOrFail($id);

        // Ambil hanya field yang diisi
        $data = $request->only(['open_time', 'close_time']);

        // Hapus key yang nilainya kosong agar tidak overwrite null
        $data = array_filter($data, function ($value) {
            return !is_null($value) && $value !== '';
        });

        $jam->update($data);

        return redirect()->back()->with('success', 'Jam operasional berhasil diperbarui');
    }
}
