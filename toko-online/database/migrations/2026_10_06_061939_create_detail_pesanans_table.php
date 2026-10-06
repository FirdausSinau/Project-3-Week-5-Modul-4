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
        Schema::create('order_details', function (Blueprint $table) {
            $table->string('id_order', 15);
            $table->string('id_barang', 10);
            $table->decimal('harga_satuan', 12, 2);   // ARSIP harga saat dibeli
            $table->integer('jumlah_beli');

            // PK gabungan: satu barang hanya boleh muncul sekali per pesanan
            $table->primary(['id_order', 'id_barang']);

            // dua kabel foreign key
            $table->foreign('id_order')->references('id_order')->on('orders');
            $table->foreign('id_barang')->references('id_barang')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
