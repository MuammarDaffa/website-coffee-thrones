<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Galeri;
use App\Models\JamOperasional; // 🟢 Tambahkan ini

class FrontendController extends Controller
{
    // Halaman utama
    public function index()
    {
        // Ambil produk per kategori
        $kopi = Produk::where('kategori', 'kopi')->orderByDesc('created_at')->take(6)->get();
        $nonkopi = Produk::where('kategori', 'nonkopi')->orderByDesc('created_at')->take(6)->get();
        $makanan = Produk::where('kategori', 'makanan')->orderByDesc('created_at')->take(6)->get();

        // Ambil galeri terbaru
        $galeri = Galeri::latest('created_at')->take(9)->get();
        $total = Galeri::count();

        // 🟢 Ambil semua jam operasional
        $jam_operasional = JamOperasional::orderBy('id')->get();

        // Kirim data ke view
        return view('frontend.index', compact('kopi', 'nonkopi', 'makanan', 'galeri', 'jam_operasional'));
    }

    // Halaman detail produk
    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('frontend.detail', compact('produk'));
    }
}
