<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTemas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temas', function (Blueprint $table) {
            $table->id();
            $table->string('tema');
            $table->string('description')->nullable();
            $table->date('fecha_cumplimiento');
            $table->unsignedBigInteger('estado_id');
            $table->unsignedBigInteger('subclasificacion_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('estado_id')->references('id')->on('estado_seguimientos');
            $table->foreign('subclasificacion_id')->references('id')->on('sub_clasificaciones');
        });

        Schema::create('tema_user', function (Blueprint $table) {
            $table->unsignedBigInteger('tema_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('tema_id')->references('id')->on('temas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');

            $table->primary(['tema_id', 'user_id'], 'temas_users_user_id_tema_id_primary');
        });

        Schema::create('tema_archivos', function (Blueprint $table) {
            $table->unsignedBigInteger('tema_id');
            $table->string('evidencia');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->foreign('tema_id')->references('id')->on('temas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temas');
        Schema::dropIfExists('user_tema');
        Schema::dropIfExists('tema_archivos');
    }
}
