<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReferencesTypeClientToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Clients', function (Blueprint $table) {
            $table->boolean('is_active')->nullable();
            $table->string('type_sale')->nullable();
           $table->unsignedInteger('type_client_id')->nullable();
           $table->foreign('type_client_id')->references('id')->on('type_clients')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Clients', function (Blueprint $table) {
            $table->dropForeign('clients_type_client_id_foreign');
             $table->dropColumn('type_client_id');
             $table->dropColumn('type_sale');
             $table->dropColumn('is_active');
        });
    }
}
