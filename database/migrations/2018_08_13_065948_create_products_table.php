<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('barcode')->nullable();
            $table->string('sku')->nullable();
            $table->string('description');
            $table->string('img_url')->nullable();
            $table->integer('category')->unsigned();
            $table->foreign('category')->references('id')->on('categories');
            $table->integer('brand')->unsigned();
            $table->foreign('brand')->references('id')->on('brands');
            $table->integer('supplier')->unsigned();
            $table->foreign('supplier')->references('id')->on('suppliers');
            $table->double('selling_price');
            $table->double('selling_without_tax');
            $table->double('cost_price');
            $table->double('cost_without_tax');
            $table->integer('user_created')->unsigned();
            $table->foreign('user_created')->references('id')->on('users');
            $table->integer('user_modified')->unsigned()->nullable();
            $table->foreign('user_modified')->references('id')->on('users');
            $table->integer('status');
            $table->integer('status_tax')->nullable();
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
        Schema::dropIfExists('products');
    }
}
