<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLogWorkFlowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_work_flows', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('controller_name')->nullable();            
            $table->string('action')->nullable();
            $table->string('page')->nullable();
            $table->integer('register_id')->nullable();
            $table->text('info1')->nullable();
            $table->text('info2')->nullable();
            $table->text('info3')->nullable();
            $table->text('info4')->nullable();
            $table->text('info5')->nullable();            
            $table->timestamps();
            $table->softDeletes();

            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_work_flows', function (Blueprint $table) {
            $table->dropForeign('log_work_flows_user_id_foreign');                          
        });
        
        Schema::drop('log_work_flows');
    }
}
