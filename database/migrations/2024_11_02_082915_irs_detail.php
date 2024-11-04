<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('irs_detail', function (Blueprint $table) {
            $table->id('pengambilan_id');
            $table->unsignedBigInteger('irs_id');
            $table->string('kode_mk');
            $table->char('nilai',2)->nullable();
            
            $table->foreign('irs_id')->references('irs_id')->on('irs')->onDelete('cascade');

            $table->foreign('kode_mk')->references('kode_mk')->on('mata_kuliah')->onDelete('cascade');          
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('irs_detail');
    }
};