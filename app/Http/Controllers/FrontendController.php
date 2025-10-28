<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class FrontendController extends Controller
{
    // Halaman utama
    public function index()
    {
        // Ambil data berdasarkan kategori
        $kopi = Produk::where('kategori', 'kopi')->get();
        $nonkopi = Produk::where('kategori', 'nonkopi')->get();
        $makanan = Produk::where('kategori', 'makanan')->get();

        return view('frontend.index', compact('kopi', 'nonkopi', 'makanan'));
    }

    // Halaman detail produk
    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('frontend.detail', compact('produk'));
    }
}
