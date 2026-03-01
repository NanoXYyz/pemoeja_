<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('keuangans', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('keterangan');
            $table->enum('input', ['pemasukan', 'pengeluaran']);
            $table->bigInteger('saldo'); // Nominal transaksi
            $table->string('bukti')->nullable(); // Path gambar bukti
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('keuangans');
    }
};