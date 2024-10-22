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
            $table->integer('id_irs', true);
            $table->integer('semester');
            $table->string('status', 10);
            $table->unsignedBigInteger('mahasiswa_id')->nullable()->index('mahasiswa_id');
            $table->string('id_jadwal', 10)->nullable()->index('id_jadwal');
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
