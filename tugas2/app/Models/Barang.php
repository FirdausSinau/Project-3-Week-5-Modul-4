<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;

#[Table('barang')]                        // beri tahu Laravel: tabelnya "barang", bukan "barangs"
#[WithoutTimestamps]                      // tabel kita tidak punya created_at/updated_at
#[Fillable(['nama', 'harga', 'stok'])]    // kolom yang boleh diisi massal
class Barang extends Model
{
    //
}
