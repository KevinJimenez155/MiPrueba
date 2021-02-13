<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwDocumentosCorporativosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tw_documentos_corporativos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tw_corporativos_id')->constrained('tw_corporativos')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->foreignId('tw_documentos_id')->constrained('tw_documentos')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->string('S_ArchivoUrl', 255);
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
        Schema::dropIfExists('tw_documentos_corporativos');
    }
}
