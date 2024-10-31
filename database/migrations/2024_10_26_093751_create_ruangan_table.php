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
        Schema::create('ruangan', function (Blueprint $table) {
            $table->id()->primary();
            $table->timestamps();
            $table->integer('kapasitas');
            $table->string('jurusan');
            $table->string('kode_ruangan', 255);
            $table->enum('status', ['Disetujui', 'Tidak Disetujui'])->default('Tidak Disetujui');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangan');
    }
};
