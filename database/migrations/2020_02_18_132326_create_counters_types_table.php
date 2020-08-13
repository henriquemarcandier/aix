<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountersTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counters_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tipo');
            $table->unsignedBigInteger('idTipo');
            $table->date('data');
            $table->integer('acessos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counters_types');
    }
}
