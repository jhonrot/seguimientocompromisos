<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableObjetivos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objetivos', function (Blueprint $table) {
            $table->id();
            $table->string('objetivo');
            $table->unsignedBigInteger('proceso_id');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->timestamp('deleted_at')->nullable();
            $table->foreign('proceso_id')->references('id')->on('procesos');
        });

        Schema::create('objetivo_user', function (Blueprint $table) {
            $table->unsignedBigInteger('objetivo_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('objetivo_id')->references('id')->on('objetivos')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');

            $table->primary(['objetivo_id', 'user_id'], 'objetivos_users_user_id_objetivo_id_primary');
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('objetivos');
        Schema::dropIfExists('user_objetivo');
    }
}
