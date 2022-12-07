<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clients', function(Blueprint $table)
		{
		   $table->increments('id');
		   $table->string('name')->nullable();
		   $table->string('vat_number')->nullable();
		   $table->string('country')->nullable();
		   $table->string('main_url')->nullable();
		   $table->string('email')->nullable();
           $table->string('code')->nullable();
           $table->string('postal_code')->nullable();
           $table->longText('address')->nullable();
           $table->string('city')->nullable();
           $table->string('telephone')->nullable();
           $table->string('mobile')->nullable();
           $table->string('primary_name')->nullable();
           $table->string('primary_email')->nullable();
           $table->string('primary_mobile')->nullable();
           $table->string('primary_telephone')->nullable();
		   
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
		Schema::drop('clients');
	}

}
