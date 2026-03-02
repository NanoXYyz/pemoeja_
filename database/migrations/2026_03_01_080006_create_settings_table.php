<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('category');       // nama model/modul: anggota, keuangan, lagu, jadwal, arsip
            $table->string('sub_content');    // nama field yang dikontrol: gender, jabatan, input, key, dst
            $table->string('type_data')->default('string'); // string, text, enum, integer, date
            $table->string('keterangan')->default('nullable'); // nullable, required, unique
            $table->string('default_value')->nullable();
            $table->timestamps();

            // Satu category+sub_content harus unik
            $table->unique(['category', 'sub_content']);
        });

        Schema::create('setting_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('setting_id')->constrained('settings')->onDelete('cascade');
            $table->string('option_name');  // nilai tersimpan (lowercase-dash)
            $table->string('label')->nullable(); // label tampil di UI
            $table->integer('urutan')->default(0); // urutan tampil
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('setting_options');
        Schema::dropIfExists('settings');
    }
};