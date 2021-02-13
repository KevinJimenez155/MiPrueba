<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwContratosCorporativosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tw_contratos_corporativos', function (Blueprint $table) {
            $table->id();
            $table->timestamp('D_FechaInicio')->nullable()->default(null);
            $table->timestamp('D_FechaFin')->nullable()->default(null);
            $table->string('S_URLContrato', 255);
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
        Schema::dropIfExists('tw_contratos_corporativos');
    }
}
