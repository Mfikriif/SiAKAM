<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('daftar_ruangan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_ruangan', 4)->unique(); // Menyimpan kode ruangan
            $table->string('keterangan')->nullable(); // Menyimpan keterangan
        });
    }    
};
