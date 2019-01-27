<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('name')->nullable();
            $table->string('contact')->nullable();
            $table->string('adress')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone1')->nullable();
            $table->string('ext1')->nullable();
            $table->string('telephone2')->nullable();
            $table->string('type_business')->nullable();
            $table->string('rfc')->nullable();
            $table->string('email2')->nullable();
            $table->string('contact_position')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clients');
    }
}
