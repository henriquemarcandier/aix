<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBugTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bug_trackings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('typeService');
            $table->unsignedBigInteger('typeVersion');
            $table->unsignedBigInteger('priority');
            $table->unsignedBigInteger('category');
            $table->string('name');
            $table->string('email');
            $table->string('title');
            $table->text('message');
            $table->timestamps();
            $table->foreign("typeService")->references('id')->on("types_services")->onDelete('CASCADE');
            $table->foreign("typeVersion")->references('id')->on("type_versions")->onDelete('CASCADE');
            $table->foreign("priority")->references('id')->on("priorities")->onDelete('CASCADE');
            $table->foreign("category")->references('id')->on("categories")->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bug_trackings');
    }
}
