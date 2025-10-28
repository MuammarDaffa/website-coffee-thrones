<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{
    // ======================
    // 🔹 INDEX UMUM
    // ======================
    public function index()
    {
        $produks = Produk::all();
        return view('admin.produk.kopi', compact('produks'));
    }

    // ======================
    // 🔹 TAMBAH PRODUK
    // ======================
    public function create()
    {
        return view('admin.produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori' => 'required|string',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        Produk::create($request->all());
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    // ======================
    // 🔹 EDIT & UPDATE
    // ======================
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('admin.produk.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->update([
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diperbarui.'
        ]);
    }

    // ======================
    // 🔹 HAPUS PRODUK
    // ======================
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = $produk->kategori;
        $produk->delete();

        if ($kategori === 'kopi') {
            return redirect()->route('produk.kopi')->with('success', 'Produk kopi berhasil dihapus.');
        } elseif ($kategori === 'nonkopi') {
            return redirect()->route('produk.nonkopi')->with('success', 'Produk non-kopi berhasil dihapus.');
        } elseif ($kategori === 'makanan') {
            return redirect()->route('produk.makanan')->with('success', 'Produk makanan berhasil dihapus.');
        }

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }

    // ======================
    // 🔹 FILTER PER KATEGORI + SEARCH
    // ======================

    public function kopi(Request $request)
    {
        $search = $request->input('search');

        $produks = Produk::where('kategori', 'kopi')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_produk', 'LIKE', "%{$search}%")
                      ->orWhere('deskripsi', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.produk.kopi', compact('produks'));
    }

    public function nonkopi(Request $request)
    {
        $search = $request->input('search');

        $produks = Produk::where('kategori', 'nonkopi')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_produk', 'LIKE', "%{$search}%")
                      ->orWhere('deskripsi', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.produk.nonkopi', compact('produks'));
    }

    public function makanan(Request $request)
    {
        $search = $request->input('search');

        $produks = Produk::where('kategori', 'makanan')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_produk', 'LIKE', "%{$search}%")
                      ->orWhere('deskripsi', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.produk.makanan', compact('produks'));
    }

 public function search(Request $request)
{
    $keyword = $request->get('q');
    $kategori = $request->get('kategori'); // kalau mau filter per kategori

    $query = Produk::query();

    if ($kategori) {
        $query->where('kategori', $kategori);
    }

    if ($keyword) {
        $query->where('nama_produk', 'like', "%{$keyword}%")
              ->orWhere('deskripsi', 'like', "%{$keyword}%");
    }

    $produks = $query->limit(10)->get();

    return response()->json($produks);
}


}
