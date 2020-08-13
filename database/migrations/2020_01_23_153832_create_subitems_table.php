<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subitems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('page');
            $table->string('name');
            $table->string('slug');
            $table->string('subname');
            $table->text('description');
            $table->string('img');
            $table->string('status');
            $table->timestamps();
            $table->foreign("page")->references('id')->on("pages")->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subitems');
    }
}
