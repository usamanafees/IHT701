<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVbStatementTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vb_statement', function(Blueprint $table)
		{
			$table->increments('vbsid');
			$table->integer('vbid')->unsigned();
			$table->timestamp('entry_date')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->char('pm', 2)->nullable()->default('TB');
			$table->string('pm_reference', 50)->nullable();
			$table->string('pm_comment', 100)->nullable();
			$table->enum('currency', array('€','£','$'))->default('€');
			$table->decimal('value', 7)->default(0.00);
			$table->decimal('value_euro', 7);
			$table->decimal('balance', 9)->default(0.00);
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
		Schema::drop('vb_statement');
	}

}
