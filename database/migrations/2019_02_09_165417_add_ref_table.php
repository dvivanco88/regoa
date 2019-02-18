<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRefTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_clients', function (Blueprint $table) {
              $table->unsignedInteger('client_id')->change();
              $table->unsignedInteger('order_id')->change();
              $table->unsignedInteger('product_id')->change();
          
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');   
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
            $table->dropForeign('order_clients_client_id_foreign');
            $table->dropForeign('order_clients_order_id_foreign');
            $table->dropForeign('order_clients_product_id_foreign');

            $table->integer('client_id')->change();
              $table->integer('order_id')->change();
              $table->integer('product_id')->change();
              
        });
    }
}
