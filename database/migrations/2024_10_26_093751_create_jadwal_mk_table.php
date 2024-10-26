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
        Schema::create('jadwal_mk', function (Blueprint $table) {
            $table->string('kode_mk', 10)->primary();
            $table->string('hari', 50);
            $table->time('jam');
            $table->string('kode_ruangan', 5)->nullable()->index('kode_ruangan');
            $table->string('nama_mk', 50);
            $table->integer('sks');
            $table->string('sifat', 15);
            $table->string('pengampu', 50);
            $table->char('kelas', 1);
            $table->integer('semester');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_mk');
    }
};
