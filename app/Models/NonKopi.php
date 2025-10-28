<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NonKopi extends Model
{
    protected $table = 'nonkopi';
    protected $fillable = ['produk_id', 'rasa'];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
