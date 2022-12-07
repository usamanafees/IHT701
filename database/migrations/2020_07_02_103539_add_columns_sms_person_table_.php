<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsSmsPersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_person',function(Blueprint $table){
			$table->string('client');
			$table->string('provider');
			$table->string('channel');
			$table->string('state');
			$table->dateTime('date')->nullable();
			$table->string('cost_charged');
			$table->string('cost_commission');
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
