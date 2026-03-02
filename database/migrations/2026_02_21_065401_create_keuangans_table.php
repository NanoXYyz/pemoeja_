<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('keterangan');
            // Dulu enum, sekarang string — opsi dikontrol oleh settings (category: keuangan)
            $table->string('input');          // setting: keuangan > input
            $table->bigInteger('saldo');      // nominal transaksi
            $table->string('bukti')->nullable(); // path gambar bukti
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keuangans');
    }
};