<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kopi extends Model
{
    protected $table = 'kopi';
    protected $fillable = ['produk_id', 'jenis_biji'];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
