<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_penjualan');
            $table->decimal('total_harga',10,2);
            $table->foreignId('pelanggan_id')->constrained('pelanggan')->onDelete('cascade');
            $table->enum('status_pembelian', ['sudah', 'belum'])->default('belum');
            // $table->decimal('uang',10.2);
            // $table->decimal('kembalian',10.2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan');
    }
};
