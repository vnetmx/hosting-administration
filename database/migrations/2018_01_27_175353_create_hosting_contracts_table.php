<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHostingContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('hosting_contracts', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('hosting_plan_contracted_id')->unsigned();
        $table->integer('cpanel_account_id')->unsigned();
        $table->integer('customer_id')->unsigned();
        $table->date('start_date');
        $table->date('finish_date');
        $table->decimal('total_price');
        $table->enum('status', 
          ['active', 'pending', 'canceled', 'finished', 'suspended']);
        $table->boolean('active')->comment('Last contract of the client');
        $table->integer('user_id')->unsigned()->nullable();
        $table->timestamps();

        $table->foreign('hosting_plan_contracted_id')
              ->references('id')->on('hosting_plans_contracted')
              ->onUpdate('cascade')->onDelete('cascade');

        $table->foreign('customer_id')
              ->references('id')->on('customers')
              ->onUpdate('cascade')->onDelete('cascade');

        $table->foreign('cpanel_account_id')
              ->references('id')->on('cpanel_accounts')
              ->onUpdate('cascade')->onDelete('cascade');

        $table->foreign('user_id')
              ->references('id')->on('users')
              ->onUpdate('cascade')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hosting_contracts');
    }
}