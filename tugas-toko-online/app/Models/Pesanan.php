<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('orders', key: 'id_order', keyType: 'string', incrementing: false)]
#[WithoutTimestamps]
#[Fillable(['id_order', 'id_user', 'tanggal_order', 'total_harga', 'alamat_pengiriman'])]
class Pesanan extends Model
{
    // pesanan ini milik siapa?
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // pesanan ini berisi baris-baris item apa saja?
    public function details(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'id_order', 'id_order');
    }
}
