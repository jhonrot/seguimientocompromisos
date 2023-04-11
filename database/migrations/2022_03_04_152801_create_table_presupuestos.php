<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePresupuestos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->id();
            $table->double('presupuesto_proyecto', 15, 0);
            $table->integer('cantidad');
            $table->unsignedBigInteger('proyecto_id');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('proyecto_id')->references('id')->on('proyectos');

            $table->unique(['proyecto_id'], 'presupuestos_proyecto_id_unique');
        });

        Schema::create('modalidad_presupuesto', function (Blueprint $table) {
            $table->unsignedBigInteger('modalidad_id');
            $table->unsignedBigInteger('presupuesto_id');
            $table->double('presupuesto_modalidad', 15, 0);
            $table->foreign('modalidad_id')->references('id')->on('modalidades');
            $table->foreign('presupuesto_id')->references('id')->on('presupuestos')->onDelete('cascade');

            $table->primary(['modalidad_id','presupuesto_id'], 'presupuestos_modalidades_presupuesto_id_modalidad_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presupuestos');
        Schema::dropIfExists('modalidad_presupuesto');
    }
}
