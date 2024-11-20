<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGlobalConfigurationsTable extends Migration
{
    public function up()
    {
        Schema::create('global_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('background_color')->default('#ffffff'); // A cor do fundo
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('global_configurations');
    }
}
