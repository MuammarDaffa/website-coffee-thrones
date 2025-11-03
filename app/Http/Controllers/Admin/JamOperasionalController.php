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

    public function update(Request $request, JamOperasional $jamOperasional)
    {
        $request->validate([
            'open_time' => 'nullable|date_format:H:i',
            'close_time' => 'nullable|date_format:H:i',
        ]);

        $jamOperasional->update([
            'open_time' => $request->open_time,
            'close_time' => $request->close_time,
        ]);

        return redirect()->route('jam.index')->with('success', 'Jam operasional berhasil diperbarui!');
    }
}
