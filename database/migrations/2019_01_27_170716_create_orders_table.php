<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('stat_id')->nullable();
            $table->date('date_delivery')->nullable();
            $table->date('date_pay')->nullable();
            $table->string('cost')->nullable();
            $table->string('type_pay')->nullable();
            $table->text('observations')->nullable();
            $table->string('advance')->nullable();
            $table->string('due')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('orders');
    }
}
