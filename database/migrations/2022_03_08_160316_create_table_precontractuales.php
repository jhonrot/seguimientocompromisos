<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePrecontractuales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('precontractuales', function (Blueprint $table) {
            $table->id();

            $table->integer('paac');
            $table->unsignedBigInteger('cdp_id');

            $table->date('fecha_convocatoria')->nullable();
            $table->date('fecha_aprobacion_asp')->nullable();
            $table->date('fecha_aprobacion_edp')->nullable();
            $table->date('fecha_publicacion_contratacion')->nullable();
            $table->integer('plazo_adjudicacion')->nullable();
            $table->date('fecha_adjudicacion')->nullable();
            
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('cdp_id')->references('id')->on('cdps');

            $table->unique(['cdp_id'], 'precontractuales_cdp_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('precontractuales');
    }
}
