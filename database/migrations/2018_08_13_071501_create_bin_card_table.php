<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBinCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bin_card', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location');
            $table->integer('type');
            $table->integer('reference');
            $table->integer('product')->unsigned();
            $table->foreign('product')->references('id')->on('products');
            $table->integer('qty');
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
        Schema::dropIfExists('bin_card');
    }
}
