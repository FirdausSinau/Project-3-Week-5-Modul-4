<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Catatan: PK aslinya gabungan (id_order + id_barang). Eloquent tidak mendukung
// composite key, jadi kita deklarasikan satu kunci "wakil" — model ini diakses
// lewat relasi & create(), bukan lewat find() pada kombinasi PK.
#[Table('order_details', key: 'id_order', keyType: 'string', incrementing: false)]
#[WithoutTimestamps]
#[Fillable(['id_order', 'id_barang', 'harga_satuan', 'jumlah_beli'])]
class DetailPesanan extends Model
{
    // baris ini milik pesanan mana?
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'id_order', 'id_order');
    }

    // baris ini menunjuk barang apa?
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
