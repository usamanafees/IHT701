<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_alerts', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('uid')->unsigned()->nullable();
            $table->foreign('uid')->references('id')->on('users');

            $table->string('sms_message_before')->default("Dear %preferred_contact_name%,&#013;The following documents will expire whitin %invoice_days_left% day(s):&#013;%invoice_list%");
            $table->string('email_message_before')->default("Dear %preferred_contact_name%,&#013;The following documents will expire whitin %invoice_days_left% day(s):&#013;%invoice_list%");
            $table->string('email_subject_before')->default("%preferred_contact_name%, have documents to expire within %invoice_days_expire% day(s)");
            $table->boolean('send_me_email_before')->default('0');
            $table->integer('days_before')->default('3');
            $table->boolean('sms_before')->default('0');
            $table->boolean('email_before')->default('0');

            $table->string('sms_message_after')->default("Dear %preferred_contact_name%,&#013;The following documents have expired %invoice_days_left% day(s):&#013;%invoice_list%");
            $table->string('email_message_after')->default("Dear %preferred_contact_name%,&#013;The following documents have expired %invoice_days_left% day(s):&#013;%invoice_list%");
            $table->string('email_subject_after')->default("%preferred_contact_name%, has overdue and unpaid documents");
            $table->boolean('send_me_email_after')->default('0');
            $table->integer('days_after')->default('3');
            $table->boolean('sms_after')->default('0');
            $table->boolean('email_after')->default('0');

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
        Schema::dropIfExists('billing_alerts');
    }
}
