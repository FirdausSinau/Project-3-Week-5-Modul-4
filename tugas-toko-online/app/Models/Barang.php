<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('products', key: 'id_barang', keyType: 'string', incrementing: false)]
#[WithoutTimestamps]
#[Fillable(['id_barang', 'nama_barang', 'deskripsi', 'harga', 'stok', 'gambar'])]
class Barang extends Model
{
    // satu barang bisa muncul di banyak baris detail pesanan
    public function details(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'id_barang', 'id_barang');
    }
}
