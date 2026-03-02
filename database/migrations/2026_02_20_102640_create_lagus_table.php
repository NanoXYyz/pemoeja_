<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lagus', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            // Dulu enum chromatic scale, sekarang string — opsi dikontrol oleh settings (category: lagu)
            $table->string('key');  // setting: lagu > key
            $table->text('lirik');
            $table->text('reff')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lagus');
    }
};