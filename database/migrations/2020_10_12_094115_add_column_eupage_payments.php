<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnEupagePayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eupago_payments',function(Blueprint $table){
			$table->increments('id');
			$table->string('user_id');
			$table->integer('eupago_id')->nullable();
			$table->string('phone')->nullable();
			$table->decimal('amount',8,3);
			$table->decimal('tax',8,3);
			$table->enum('approved', array('Yes','No'))->default('No');
			$table->softDeletes();
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
        //
    }
}
