<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSmsProviderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_provider', function (Blueprint $table) {
            $table->string('ez4u_url')->nullable();
            $table->text('mobile_prefix')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sms_provider', function (Blueprint $table) {
            $table->dropColumn(['ez4u_url']);
            $table->dropColumn(['mobile_prefix']);
        });
    }
}
