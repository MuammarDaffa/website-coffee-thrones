<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Galeri; // ✅ tambahkan ini

class FrontendController extends Controller
{
    // Halaman utama
    public function index()
    {
        // Ambil data berdasarkan kategori
        $kopi = Produk::where('kategori', 'kopi')->get();
        $nonkopi = Produk::where('kategori', 'nonkopi')->get();
        $makanan = Produk::where('kategori', 'makanan')->get();

        // ✅ Ambil semua galeri juga
        $galeri = Galeri::latest('created_at')->take(9)->get();
        $total = Galeri::count();

        // ✅ Kirim semua variabel ke view
        return view('frontend.index', compact('kopi', 'nonkopi', 'makanan', 'galeri'));
    }

    // Halaman detail produk
    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('frontend.detail', compact('produk'));
    }
}
