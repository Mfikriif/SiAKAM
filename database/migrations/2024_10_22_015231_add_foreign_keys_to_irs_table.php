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
        Schema::table('irs', function (Blueprint $table) {
            $table->foreign(['mahasiswa_id'], 'irs_ibfk_1')->references(['id'])->on('mahasiswa')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['id_jadwal'], 'irs_ibfk_2')->references(['kode_mk'])->on('jadwal_mk')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('irs', function (Blueprint $table) {
            $table->dropForeign('irs_ibfk_1');
            $table->dropForeign('irs_ibfk_2');
        });
    }
};
