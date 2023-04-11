<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePlanActividades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_actividades', function (Blueprint $table) {
            $table->id();
            $table->string('actividad');
            $table->string('meta');
            $table->string('indicador');
            $table->string('unidad');
            $table->string('cantidad');
            $table->unsignedBigInteger('obligacion_id');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('obligacion_id')->references('id')->on('obligaciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plan_actividades');
    }
}
