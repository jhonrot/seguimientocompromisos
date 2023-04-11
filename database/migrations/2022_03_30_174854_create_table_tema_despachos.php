<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTemaDespachos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tema_despachos', function (Blueprint $table) {
            $table->id();

            $table->longText('descripcion');
            $table->date('fecha_reunion');
            $table->longText('objetivo');
            $table->longText('asistentes');
            $table->longText('orden');
            $table->longText('desarrollo');

            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tema_despachos');
    }
}
