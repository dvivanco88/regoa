<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderToOrderClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_clients', function (Blueprint $table) {
            $table->unsignedInteger('order_id')->nullable();
           $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_clients', function (Blueprint $table) {
            $table->dropForeign('order_clients_order_id_foreign');
             $table->dropColumn('order_id');
        });
    }
}
