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
            $table->char('nama');
            $table->char('program_studi');
            $table->integer('semester');
            $table->string('kode_mk',10);
            $table->string('nama_mk');
            $table->integer('sks');
            $table->integer('nilai_angka')->nullable();
            $table->char('nilai_huruf', 2)->nullable();
            $table->decimal('ip_semester', 3, 2)->nullable();
            $table->decimal('ip_kumulatif', 3, 2)->nullable();

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
