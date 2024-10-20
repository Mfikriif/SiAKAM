<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('irs', function (Blueprint $table) {
            $table->increments('id_irs');
            $table->integer('semester');
            $table->string('status', 10);
            $table->unsignedBigInteger('mahasiswa_id')->nullable();
            $table->string('id_jadwal', 10)->nullable();
            $table->timestamps();

            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswa');
        });
    }

    public function down()
    {
        Schema::dropIfExists('irs');
    }
};

