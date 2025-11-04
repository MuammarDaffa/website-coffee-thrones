<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JamOperasional;
use Carbon\Carbon;

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

    // Ambil field yang diisi
    $data = $request->only(['open_time', 'close_time']);
    $data = array_filter($data, fn($value) => !is_null($value) && $value !== '');

    // Ambil nilai lama jika tidak diisi
    $open_time = $data['open_time'] ?? $jam->open_time;
    $close_time = $data['close_time'] ?? $jam->close_time;

    // Parsing jam dengan Carbon
    $open = Carbon::parse($open_time);
    $close = Carbon::parse($close_time);

    // Cek jika jam buka sama dengan jam tutup
    if ($open->equalTo($close)) {
        return redirect()->back()->with('error', 'Jam buka dan jam tutup tidak boleh sama.');
    }

    // Jika jam tutup <= jam buka, anggap jam tutup di hari berikutnya
    if ($close->lessThan($open)) {
        $close->addDay();
    }

    // Hitung durasi dalam detik
    $durationSeconds = $close->diffInSeconds($open);

    // Validasi durasi maksimal 24 jam
    if ($durationSeconds >= 86400) { // 24 jam
        return redirect()->back()->with('error', 'Jam operasional tidak boleh 24 jam atau lebih.');
    }

    // Update data
    $jam->update($data);

    return redirect()->back()->with('success', 'Jam operasional berhasil diperbarui.');
}

}
