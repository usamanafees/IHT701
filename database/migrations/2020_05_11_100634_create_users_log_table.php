<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_log', function(Blueprint $table)
		{
			$table->integer('logid', true);
			$table->integer('cuid')->default(0);
			$table->enum('user_type', array('ADMIN','CLIENT'));
			$table->string('ip', 55)->nullable();
			$table->string('action', 250)->default('');
			$table->text('description', 65535);
			$table->timestamp('entry_date')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->text('file', 65535)->nullable();
			$table->text('GET', 65535);
			$table->text('POST', 65535);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users_log');
	}

}
