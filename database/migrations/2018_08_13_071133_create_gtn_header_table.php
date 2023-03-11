<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGtnHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gtn_header', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('source_location')->unsigned();
            $table->foreign('source_location')->references('id')->on('locations');
            $table->integer('destination_location')->unsigned();
            $table->foreign('destination_location')->references('id')->on('locations');
            $table->integer('status');
            $table->integer('status_received')->nullable();
            $table->integer('authorized_or_reject_by')->nullable()->unsigned();
            $table->foreign('authorized_or_reject_by')->references('id')->on('users');
            $table->timestamp('authorized_or_reject_timestamp')->nullable();
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('gtn_header');
    }
}
