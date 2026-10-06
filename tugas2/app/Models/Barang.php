<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;

// Tabelnya bernama "barang", bukan tebakan "barangs".
#[Table('barang')]
// Tabel ini tidak punya created_at/updated_at.
#[WithoutTimestamps]
// Kolom yang boleh diisi massal.
#[Fillable(['nama', 'harga', 'stok'])]
class Barang extends Model
{
    //
}
