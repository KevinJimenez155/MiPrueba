<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTwUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tw_usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('username', 45)->unique();
            $table->string('email', 45)->unique();
            $table->string('S_Nombre', 45);
            $table->string('S_Apellidos', 45);
            $table->string('S_FotoPerfilUrl', 255);
            $table->tinyInteger('S_Activo')->length(1);
            $table->string('password', 100);
            $table->string('verification_token',191)->nullable()->default(null);
            $table->string('verified', 191)->nullable()->default(null);
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
        Schema::dropIfExists('tw_usuarios');
    }
}
