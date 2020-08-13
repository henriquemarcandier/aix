<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product');
            $table->unsignedBigInteger('product_type');
            $table->string('code');
            $table->string('name');
            $table->string('value');
            $table->string('promotion');
            $table->date('validity_promotion');
            $table->string('status');
            $table->timestamps();
            $table->foreign("product")->references('id')->on("products")->onDelete('CASCADE');
            $table->foreign("product_type")->references('id')->on("types_products")->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_items');
    }
}
