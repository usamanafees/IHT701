<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsInAppTransactionsToSaveThreeDecimal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('in_app_transactions',function(Blueprint $table){
			$table->decimal('debited_amount',8,3)->change();
			$table->decimal('credited_amount',8,3)->change();
			$table->decimal('balance',8,3)->change();
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
