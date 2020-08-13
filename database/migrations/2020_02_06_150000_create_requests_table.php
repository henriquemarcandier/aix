<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client');
            $table->unsignedBigInteger('paymentMethod');
            $table->unsignedBigInteger('status');
            $table->text('msInterna');
            $table->text('msExterna');
            $table->timestamps();
            $table->foreign("client")->references('id')->on("clients")->onDelete('CASCADE');
            $table->foreign("status")->references('id')->on("requests_status")->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
