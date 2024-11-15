<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel `users`.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
            $table->integer('role')->default(1);
            $table->string('profile_photo')->nullable();
        });
    }

    /**
     * Kembalikan migrasi jika dihapus.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};