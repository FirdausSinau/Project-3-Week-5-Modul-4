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
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id_order', 15)->primary();    // mis. ORD-XXXXXX
            $table->string('id_user', 15);
            $table->dateTime('tanggal_order');
            $table->decimal('total_harga', 12, 2);
            $table->text('alamat_pengiriman');

            // foreign key: id_user menunjuk ke users.id_user
            $table->foreign('id_user')->references('id_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
