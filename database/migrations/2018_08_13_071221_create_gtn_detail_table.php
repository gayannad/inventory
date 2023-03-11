<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGtnDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gtn_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('gtn_no')->unsigned();
            $table->foreign('gtn_no')->references('id')->on('gtn_header');
            $table->integer('product')->unsigned();
            $table->foreign('product')->references('id')->on('products');
            $table->integer('qty');
            $table->double('price_cost_with_tax');
            $table->double('price_cost_without_tax');
            $table->double('price_selling_with_tax');
            $table->double('price_selling_without_tax');
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
        Schema::dropIfExists('gtn_detail');
    }
}
