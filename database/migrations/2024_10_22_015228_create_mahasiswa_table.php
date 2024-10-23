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
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->char('nim', 14)->unique();
            $table->string('email')->unique();
            $table->string('jurusan');
            $table->year('angkatan');
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->boolean('status')->default(true);
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('email')->references('email')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
