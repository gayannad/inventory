<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrnHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grn_header', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('location')->unsigned();
            $table->foreign('location')->references('id')->on('locations');
            $table->integer('supplier')->unsigned()->nullable();
            $table->foreign('supplier')->references('id')->on('suppliers');
            $table->string('invoice')->nullable();
            $table->double('total_net_with_tax')->nullable();
            $table->double('total_net_without_tax')->nullable();
            $table->double('total_discount')->nullable();
            $table->integer('status');
            $table->integer('grn_type');
            $table->integer('tax_status')->nullable();
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
        Schema::dropIfExists('grn_header');
    }
}
