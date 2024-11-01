<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('jadwal_mk', function (Blueprint $table) {
            $table->id();
            $table->string('kode_mk', 10);
            $table->string('hari', 50);
            $table->string('ruangan', 5)->nullable()->index('kode_ruangan');
            $table->string('nama', 50);
            $table->integer('sks');
            $table->string('sifat', 15);
            $table->string('pengampu', 255);
            $table->char('kelas', 1);
            $table->integer('semester');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->boolean('persetujuan')->default(false);
            $table->unique(['kode_mk', 'kelas']);
            $table->timestamps();
        });
    }

    /**
     * Balikkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_mk');
    }
};