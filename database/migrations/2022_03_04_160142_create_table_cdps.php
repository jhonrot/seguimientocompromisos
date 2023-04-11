<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableCdps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cdps', function (Blueprint $table) {
            $table->id();
            $table->string('cdp_asignado');
            $table->string('cdp_numero');
            $table->date('fecha_expedicion');
            $table->unsignedBigInteger('proyecto_id');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('proyecto_id')->references('id')->on('proyectos');

            $table->unique(['proyecto_id'], 'cdps_proyecto_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cdps');
    }
}
