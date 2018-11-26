<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitaUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cita_usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->date('Fecha');
            $table->string('Nombre');
            $table->string('Apellido');
            $table->string('DNI');
            $table->unsignedInteger('Especialidad_Id');
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
        Schema::dropIfExists('cita_usuarios');
    }
}
