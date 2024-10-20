<?php  
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bagian_akademik', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('nip', 20)->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bagian_akademik');
    }
};
?>