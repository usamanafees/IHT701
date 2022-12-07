<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('duration')->nullable()->comments('3 Months, 6 Months, 12 Months duration');
            $table->string('amount')->nullable()->comments('Amount for plan');
            $table->string('balance')->nullable()->comments('Balance with days left in trial and in expiring th e plan');
            $table->string('expires_on')->nullable();
            $table->string('total_documents')->nullable();
            $table->string('used_documents')->nullable();
            $table->string('total_users')->nullable();
            $table->string('used_users')->nullable();

            $table->string('free_sms_total')->nullable();
            $table->string('free_sms_used')->nullable();

            $table->string('bought_sms_total')->nullable();
            $table->string('bought_sms_used')->nullable();
            
            $table->string('user_id');

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
        Schema::dropIfExists('account_settings');
    }
}
