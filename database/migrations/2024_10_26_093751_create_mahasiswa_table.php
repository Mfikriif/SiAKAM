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
            $table->bigIncrements('id'); // Primary key as unsignedBigInteger
            $table->string('nama');
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
            $table->unsignedBigInteger('pembimbing_akademik_id')->nullable(); // Foreign key as unsignedBigInteger
            $table->timestamps();

            // Define the foreign key constraint
            $table->foreign('pembimbing_akademik_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null'); // Ensure users table exists first
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