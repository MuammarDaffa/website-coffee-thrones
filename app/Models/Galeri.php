<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use HasFactory;

    protected $table = 'galeris'; // pastikan sesuai dengan nama tabel

    protected $fillable = [
        'gambar',
        'deskripsi',
    ];
}
