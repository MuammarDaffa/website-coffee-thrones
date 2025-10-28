<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $fillable = [
        'nama_produk', 'kategori', 'harga', 'deskripsi'
    ];

    public function kopi()
    {
        return $this->hasOne(Kopi::class);
    }

    public function nonkopi()
    {
        return $this->hasOne(NonKopi::class);
    }

    public function makanan()
    {
        return $this->hasOne(Makanan::class);
    }
}
