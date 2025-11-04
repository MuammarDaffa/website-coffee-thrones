<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Galeri;

class FrontendController extends Controller
{
    // Halaman utama
    public function index()
    {
        // Ambil 6 data terbaru per kategori
        $kopi = Produk::where('kategori', 'kopi')
                    ->orderByDesc('created_at')
                    ->take(6)
                    ->get();

        $nonkopi = Produk::where('kategori', 'nonkopi')
                    ->orderByDesc('created_at')
                    ->take(6)
                    ->get();

        $makanan = Produk::where('kategori', 'makanan')
                    ->orderByDesc('created_at')
                    ->take(6)
                    ->get();

        // Ambil galeri terbaru (9 foto)
        $galeri = Galeri::latest('created_at')->take(9)->get();
        $total = Galeri::count();

        // Kirim data ke view
        return view('frontend.index', compact('kopi', 'nonkopi', 'makanan', 'galeri'));
    }

    // Halaman detail produk
    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('frontend.detail', compact('produk'));
    }
}

