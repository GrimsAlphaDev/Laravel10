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
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang', 100);
            $table->integer('id_jenis')->unsigned();
            $table->integer('jumlah_stok');
            $table->decimal('harga_satuan', 10, 2);
            $table->string('status')->default('aktif');
            $table->timestamps();
            $table->foreign('id_jenis')->references('id')->on('jenis_barang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
