<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Galeri;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    /**
     * Tampilkan semua galeri
     */
    public function index()
    {
        $galeri = Galeri::orderByDesc('created_at')->get();
        return view('admin.galeri.galeri', compact('galeri'));
    }

    /**
     * Form tambah galeri baru
     */
    public function create()
    {
        return view('admin.galeri.create');
    }

    /**
     * Simpan galeri baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $path = $request->file('gambar')->store('galeri', 'public');

        Galeri::create([
            'gambar' => $path,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('galeri.index')->with('success', 'Gambar berhasil ditambahkan!');
    }

    /**
     * Form edit galeri
     */
    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('admin.galeri.edit', compact('galeri'));
    }

    /**
     * Update galeri
     */
    public function update(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        $request->validate([
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $data = [
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('gambar')) {
            // hapus file lama
            if ($galeri->gambar && Storage::disk('public')->exists($galeri->gambar)) {
                Storage::disk('public')->delete($galeri->gambar);
            }

            // upload file baru
            $data['gambar'] = $request->file('gambar')->store('galeri', 'public');
        }

        $galeri->update($data);

        return redirect()->route('galeri.index')->with('success', 'Gambar berhasil diperbarui!');
    }

    /**
     * Hapus galeri
     */
    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);

        if ($galeri->gambar && Storage::disk('public')->exists($galeri->gambar)) {
            Storage::disk('public')->delete($galeri->gambar);
        }

        $galeri->delete();

        return redirect()->route('galeri.index')->with('success', 'Gambar berhasil dihapus!');
    }
}
