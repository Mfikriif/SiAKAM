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
        Schema::create('khs', function (Blueprint $table) {
            $table->integer('id_khs', true);
            $table->char('nim');
            $table->char('nama');
            $table->char('program_studi');
            $table->integer('semester');
            $table->string('kode_mk',10);
            $table->string('nama_mk');
            $table->integer('sks');
            $table->integer('nilai_angka')->nullable();
            $table->char('nilai_huruf', 2)->nullable();

            $table->foreign('nim')->references('nim')->on('mahasiswa')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khs');
    }
};
