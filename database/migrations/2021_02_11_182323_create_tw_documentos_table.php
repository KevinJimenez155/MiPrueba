<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tw_documentos', function (Blueprint $table) {
            $table->id();
            $table->string('S_Nombre', 45);
            $table->tinyInteger('N_Obligatorio')->length(1);
            $table->string('S_Descripcion', 255);
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
        Schema::dropIfExists('tw_documentos');
    }
}
