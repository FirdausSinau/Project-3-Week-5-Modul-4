<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            // Primary key berupa teks, contoh: BRG-001.
            $table->string('id_barang', 10)->primary();
            $table->string('nama_barang', 50);
            $table->text('deskripsi');
            $table->decimal('harga', 12, 2);
            // Stok tidak boleh bernilai negatif.
            $table->unsignedInteger('stok');
            // Menyimpan nama file gambar.
            $table->string('gambar', 255);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
