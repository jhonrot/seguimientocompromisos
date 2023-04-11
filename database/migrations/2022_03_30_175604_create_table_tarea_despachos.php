<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTareaDespachos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarea_despachos', function (Blueprint $table) {
            $table->id();

            $table->longText('descripcion');
            $table->longText('responsable');
            $table->date('fecha_inicio');
            $table->date('fecha_final');

            $table->unsignedBigInteger('tema_despacho_id');
            
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('tema_despacho_id')->references('id')->on('tema_despachos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarea_despachos');
    }
}
