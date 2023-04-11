<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePaas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paas', function (Blueprint $table) {
            $table->id();
            $table->date('socializacion');
            $table->double('plazo', 4, 2);
            $table->date('publicacion');
            $table->longText('id_paa');
            $table->unsignedBigInteger('presupuesto_id');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('presupuesto_id')->references('id')->on('presupuestos');

            $table->unique(['presupuesto_id'], 'paas_presupuesto_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paas');
    }
}
