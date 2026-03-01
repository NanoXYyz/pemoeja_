<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_create_settings_table.php
public function up() {
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->string('category'); 
        $table->string('sub_content');
        $table->string('type_data')->default('string'); // string, text, enum, integer, date
        $table->string('keterangan')->default('nullable'); // nullable, unique, default
        $table->string('default_value')->nullable();
        $table->timestamps();
    });

    Schema::create('setting_options', function (Blueprint $table) {
        $table->id();
        $table->foreignId('setting_id')->constrained()->onDelete('cascade');
        $table->string('option_name');
        $table->timestamps();
    });
}
};
