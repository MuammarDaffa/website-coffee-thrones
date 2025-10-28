<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    protected $table = 'makanan';
    protected $fillable = ['produk_id', 'tipe'];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
