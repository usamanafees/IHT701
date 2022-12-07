<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVbAccountTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vb_account', function(Blueprint $table)
		{
			$table->increments('vbid');
			$table->integer('cid')->unsigned();
			$table->char('default_pm', 2)->nullable()->default('TB');
			$table->enum('default_currency', array('€','£','$'))->default('€');
			$table->text('description', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('vb_account');
	}

}
