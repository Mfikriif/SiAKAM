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
        Schema::create('civitas_akademik', function (Blueprint $table) {
            // Make 'id' also a foreign key that references 'id' in 'users'
            $table->unsignedBigInteger('id')->primary();
            $table->char('nama');
            $table->char('nip', 20)->unique();
            $table->string('email')->unique();
            $table->string('jurusan')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->text('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            // Define the foreign key relationship on 'id'
            $table->foreign('id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('civitas_akademik');
    }
};