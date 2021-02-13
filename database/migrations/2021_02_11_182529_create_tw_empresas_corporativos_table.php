<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwEmpresasCorporativosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tw_empresas_corporativos', function (Blueprint $table) {
            $table->id();
            $table->string('S_RazonSocial', 150);
            $table->string('S_RFC', 13);
            $table->string('S_Pais', 75);
            $table->string('S_Estado', 75);
            $table->string('S_Municipio',75);
            $table->string('S_ColoniaLocalidad', 75);
            $table->string('S_Domicilio', 100);
            $table->string('S_CodigoPostal', 5);
            $table->string('S_UsoCFDI', 45);
            $table->string('S_UrlRFC', 255);
            $table->string('S_UrlActaConstitutiva', 255);
            $table->tinyInteger('S_Activo')->length(1);
            $table->string('S_Comentarios', 255);
            $table->foreignId('tw_corporativos_id')->constrained('tw_corporativos')->onUpdate('cascade')->onDelete('cascade')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tw_empresas_corporativos');
    }
}
