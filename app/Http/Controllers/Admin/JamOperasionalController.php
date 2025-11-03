<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JamOperasional;

class JamOperasionalController extends Controller
{
    public function index()
    {
        // ambil semua hari, urut berdasarkan id
        $jam = JamOperasional::orderBy('id')->get();
        return view('admin.jam.index', compact('jam'));
    }

   public function update(Request $request, $id)
{
    $jam = JamOperasional::findOrFail($id);

    // Validasi format jam jika ada (boleh kosong)
    $request->validate([
        'open_time' => 'nullable|date_format:H:i',
        'close_time' => 'nullable|date_format:H:i',
    ]);

    // Ambil input langsung
    $open_time = $request->input('open_time');   // bisa '' atau '08:00' atau null
    $close_time = $request->input('close_time');

    // Bila input kosong string atau null, gunakan nilai lama
    if ($open_time === null || $open_time === '') {
        $open_time = $jam->open_time;
    }

    if ($close_time === null || $close_time === '') {
        $close_time = $jam->close_time;
    }

    // Validasi logika: apabila kedua ada, pastikan open < close
    if ($open_time && $close_time && $open_time >= $close_time) {
        return redirect()->back()->with('error', 'Jam tutup harus lebih besar dari jam buka!');
    }

    $jam->update([
        'open_time' => $open_time,
        'close_time' => $close_time,
    ]);

    return redirect()->route('jam.index')->with('success', 'Jam operasional berhasil diperbarui!');
}


}
