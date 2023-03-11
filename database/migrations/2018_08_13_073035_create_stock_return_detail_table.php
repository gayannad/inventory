<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockReturnDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_return_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('srn_no')->unsigned();
            $table->foreign('srn_no')->references('id')->on('stock_return');
            $table->integer('product')->unsigned();
            $table->foreign('product')->references('id')->on('products');
            $table->integer('qty');
            $table->double('selling_price');
            $table->double('cost_price');
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
        Schema::dropIfExists('stock_return_detail');
    }
}
