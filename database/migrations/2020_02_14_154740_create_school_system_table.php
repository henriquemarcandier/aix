<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_system', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("nome");
            $table->string("email");
            $table->string("cep");
            $table->string("logradouro");
            $table->string("numero");
            $table->string("complemento");
            $table->string("bairro");
            $table->string("cidade");
            $table->string("estado");
            $table->unsignedBigInteger('tipoNota');
            $table->unsignedBigInteger('turno');
            $table->string("letra");
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
        Schema::dropIfExists('school_system');
    }
}
