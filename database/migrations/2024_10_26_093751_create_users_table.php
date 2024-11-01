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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            // Tambahkan kolom peran dengan nilai default false
            $table->boolean('mahasiswa')->nullable()->default(false);
            $table->boolean('dekan')->nullable()->default(false);
            $table->boolean('kaprodi')->nullable()->default(false);
            $table->boolean('dosenwali')->nullable()->default(false);
            $table->boolean('akademik')->nullable()->default(false);
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