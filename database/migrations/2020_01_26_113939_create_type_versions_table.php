<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_versions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('typeService');
            $table->string('name');
            $table->string('status');
            $table->timestamps();
            $table->foreign("typeService")->references('id')->on("types_services")->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_versions');
    }
}
