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
        Schema::create('irs', function (Blueprint $table) {
            $table->id('irs_id');
            $table->unsignedBigInteger('mahasiswa_id');
            $table->string('nama');
            $table->string('program_studi');
            $table->integer('semester');            
            $table->string('tahun_akademik')->default('2024/2025');
            $table->string('kode_mk');
            $table->string('nama_mk');
            $table->integer('sks');
            $table->boolean('status')->default(false);
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_persetujuan')->nullable();

            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('irs');
    }
};
