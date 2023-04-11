<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEjecuciones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ejecuciones', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_suscripcion_contrato');
            $table->date('fecha_socializacion_contratista');
            $table->integer('tiempo_ejecucion');
            $table->date('fecha_cierre_proyecto');
            $table->integer('tiempo_etapa_contractual');

            $table->boolean('prorroga')->nullable();
            $table->integer('tiempo_prorroga')->nullable();
            $table->date('fecha_prorroga')->nullable();

            $table->unsignedBigInteger('precontractual_id');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('precontractual_id')->references('id')->on('precontractuales');

            $table->unique(['precontractual_id'], 'ejecuciones_precontractual_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ejecuciones');
    }
}
