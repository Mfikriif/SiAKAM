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
        Schema::table('pembimbing_akademik', function (Blueprint $table) {
            $table->foreign(['id'], 'pembimbing_akademik_ibfk_1')->references(['id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pembimbing_akademik', function (Blueprint $table) {
            $table->dropForeign('pembimbing_akademik_ibfk_1');
        });
    }
};
