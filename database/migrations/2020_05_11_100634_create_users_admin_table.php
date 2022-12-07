<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersAdminTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users_admin', function(Blueprint $table)
		{
			$table->integer('uid', true);
			$table->string('username', 50)->default('');
			$table->string('password', 100)->default('');
			$table->string('name', 200)->default('');
			$table->string('email', 50)->default('');
			$table->timestamp('entry_date')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->text('description', 65535);
			$table->char('language', 2)->default('EN');
			$table->enum('active', array('Y','N'))->default('Y');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users_admin');
	}

}
