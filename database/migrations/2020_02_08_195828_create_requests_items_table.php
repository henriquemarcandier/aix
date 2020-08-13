<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('request');
            $table->unsignedBigInteger('product');
            $table->unsignedBigInteger('product_item');
            $table->unsignedBigInteger('school_system');
            $table->unsignedBigInteger('cashier_system');
            $table->string('name');
            $table->string('quantity');
            $table->string('value');
            $table->string('its_already_gone');
            $table->timestamps();
            $table->foreign("request")->references('id')->on("requests")->onDelete('CASCADE');
            $table->foreign("product")->references('id')->on("products")->onDelete('CASCADE');
            $table->foreign("product_item")->references('id')->on("products_items")->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests_items');
    }
}
