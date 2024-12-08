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
            $table->unsignedBigInteger('tahun_ajaran_id');
            $table->string('kode_mk', 10);
            $table->string('hari', 50);
            $table->string('ruangan', 5)->nullable()->index('kode_ruangan');
            $table->integer('kuota_kelas');
            $table->string('nama', 50);
            $table->integer('sks');
            $table->string('sifat', 15);
            $table->char('kelas', 1);
            $table->integer('semester');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('koordinator_mk', 50);
            $table->string('pengampu_1', 50);
            $table->string('pengampu_2', 50)->nullable();
            $table->string('pengampu_3', 50)->nullable();
            $table->boolean('persetujuan')->default(false);
            $table->text('reason_for_rejection')->nullable();
            $table->unique(['kode_mk', 'kelas']);
            $table->timestamps();

            $table->foreign('kode_mk')
                ->references('kode_mk')
                ->on('mata_kuliah')
                ->onDelete('cascade');

            $table->foreign('tahun_ajaran_id')
                ->references('id')
                ->on('tahun_ajaran')
                ->onDelete('cascade');
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