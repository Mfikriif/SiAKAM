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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID auto-increment
            $table->string('name'); // Nama pengguna
            $table->string('email')->unique(); // Email unik
            $table->string('password'); // Password
            $table->timestamp('email_verified_at')->nullable(); // Verifikasi email nullable
            $table->rememberToken(); // Token ingat (remember me)
            $table->timestamps(); // Kolom created_at dan updated_at

            // Tambahkan kolom role berdasarkan kebutuhan
            $table->tinyInteger('mahasiswa')->default(0);
            $table->tinyInteger('dekan')->default(0);
            $table->tinyInteger('kaprodi')->default(0);
            $table->tinyInteger('dosenwali')->default(0);
            $table->tinyInteger('akademik')->default(0);
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Email sebagai primary key
            $table->string('token'); // Token reset password
            $table->timestamp('created_at')->nullable(); // Timestamp pembuatan token
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID sesi sebagai primary key
            $table->foreignId('user_id')->nullable()->index(); // ID user sebagai foreign key
            $table->string('ip_address', 45)->nullable(); // IP address pengguna (maksimal 45 karakter)
            $table->text('user_agent')->nullable(); // Informasi user agent
            $table->longText('payload'); // Payload sesi
            $table->integer('last_activity')->index(); // Aktivitas terakhir
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
?>