<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class
ChangeColumnToSmsRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_rates', function (Blueprint $table) {
            $table->dropForeign(['sms_provider_id']);
            $table->dropForeign(['country_id']);
            $table->foreign('sms_provider_id')->references('id')->on('sms_provider')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sms_rates', function (Blueprint $table) {
            //
        });
    }
}
