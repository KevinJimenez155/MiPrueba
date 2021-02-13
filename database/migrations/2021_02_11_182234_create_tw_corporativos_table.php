<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwCorporativosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tw_corporativos', function (Blueprint $table) {
            $table->id();
            $table->string('S_NombreCorto',45);
            $table->string('S_nombreCompleto', 75);
            $table->string('S_LogoURL', 255);
            $table->string('S_DBName', 45);
            $table->string('S_DBPassword', 150);
            $table->string('S_SystemUrl', 255);
            $table->tinyInteger('S_Activo')->length(1);
            $table->timestamp('D_FechaIncorporacion');
            $table->foreignId('tw_usuarios_id')->constrained('tw_usuarios')->onUpdate('cascade')->onDelete('cascade')->nullable();
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
        Schema::dropIfExists('tw_corporativos');
    }
}
