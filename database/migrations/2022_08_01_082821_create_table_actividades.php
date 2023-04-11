<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableActividades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->string('actividad');
            $table->unsignedBigInteger('estado_id');
            $table->date('fecha');
            $table->longText('acciones_adelantadas');
            $table->longText('acciones_pendientes');
            $table->longText('dificultades');
            $table->longText('alternativas');
            $table->string('evidencia')->nullable();
            $table->unsignedBigInteger('seguimiento_id');

            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('estado_id')->references('id')->on('estado_seguimientos');
            $table->foreign('seguimiento_id')->references('id')->on('seguimientos');
        });

        Schema::create('actividad_archivos', function (Blueprint $table) {
            $table->unsignedBigInteger('actividad_id');
            $table->string('evidencia');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('actividades');
    }
}
