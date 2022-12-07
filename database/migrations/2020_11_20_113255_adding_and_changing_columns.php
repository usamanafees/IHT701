<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddingAndChangingColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apilogs', function (Blueprint $table) {
            //$table->renameColumn('sms_id', 'module_id');
            $table->unsignedBigInteger('module_id')->nullable()->after('sms_id');
            $table->string('action')->nullable()->after('module_id');
            $table->unsignedBigInteger('record_id')->nullable()->after('action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apilogs', function (Blueprint $table) {
            //$table->renameColumn('module_id', 'sms_id');
            $table->dropColumn('module_id');
            $table->dropColumn('action');
            $table->dropColumn('record_id');
        });
    }
}
