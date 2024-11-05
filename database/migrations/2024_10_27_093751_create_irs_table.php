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
            $table->unsignedBigInteger('id');
            $table->integer('semester');
            $table->string('status')->default('Belum disetujui');
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_persetujuan')->nullable();

            $table->foreign('id')->references('id')->on('mahasiswa')->onDelete('cascade');
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
