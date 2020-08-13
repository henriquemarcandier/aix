<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashierSystemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashier_system', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("razao_social");
            $table->string("nome_fantasia");
            $table->string("cnpj");
            $table->string("cep");
            $table->string("logradouro");
            $table->string("numero");
            $table->string("complemento");
            $table->string("bairro");
            $table->string("cidade");
            $table->string("estado");
            $table->unsignedBigInteger('tipoEstabelecimento');
            $table->unsignedBigInteger('quantidade');
            $table->unsignedBigInteger('numeroPessoasPorMesa');
            $table->unsignedBigInteger('percentual');
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
        Schema::dropIfExists('cashier_system');
    }
}
