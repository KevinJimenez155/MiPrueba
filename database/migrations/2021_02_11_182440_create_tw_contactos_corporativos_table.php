<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwContactosCorporativosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tw_contactos_corporativos', function (Blueprint $table) {
            $table->id();
            $table->string('S_Nombre', 45);
            $table->string('S_Puesto', 45);
            $table->string('S_Comentarios', 255);
            $table->bigInteger('N_TelefonoFijo')->length(12);
            $table->bigInteger('N_TelefonoMovil')->length(12);
            $table->string('S_Email', 45);
            $table->foreignId('tw_corporativos_id')->constrained('tw_corporativos')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tw_contactos_corporativos');
    }
}
