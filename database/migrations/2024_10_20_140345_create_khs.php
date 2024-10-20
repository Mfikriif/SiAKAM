<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('khs', function (Blueprint $table) {
            $table->increments('id_khs');
            $table->integer('semester');
            $table->integer('nilai_angka');
            $table->char('nilai_huruf', 1);
            $table->unsignedBigInteger('mahasiswa_id')->nullable();
            $table->timestamps();

            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa');
        });
    }

    public function down()
    {
        Schema::dropIfExists('khs');
    }
};
