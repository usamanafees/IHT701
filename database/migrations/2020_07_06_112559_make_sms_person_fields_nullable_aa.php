<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeSmsPersonFieldsNullableAa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_person', function(Blueprint $table){
			$table->string('client')->nullable()->change();
			$table->string('provider')->nullable()->change();
			$table->string('channel')->nullable()->change();
			$table->string('state')->nullable()->change();
			$table->string('cost_charged')->nullable()->change();
			$table->string('cost_commission')->nullable()->change();
			$table->string('sender')->nullable()->change();
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
