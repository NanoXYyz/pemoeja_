<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan kolom role setelah kolom email
            // Kita beri default 'user' karena user umum tidak perlu login/readonly
            $table->string('role')->default('user')->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Untuk menghapus kolom jika migration di-rollback
            $table->dropColumn('role');
        });
    }
};