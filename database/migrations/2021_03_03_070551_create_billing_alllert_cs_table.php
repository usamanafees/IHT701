<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingAlllertCsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_alllert_cs', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('uid')->nullable();

            $table->string('sms_message_before')->nullable();
            $table->string('email_message_before')->nullable();
            $table->string('email_subject_before')->nullable();
            $table->boolean('send_me_email_before')->nullable();
            $table->integer('days_before')->nullable();
            $table->boolean('sms_before')->nullable();
            $table->boolean('email_before')->nullable();

            $table->string('sms_message_after')->nullable();
            $table->string('email_message_after')->nullable();
            $table->string('email_subject_after')->nullable();
            $table->boolean('send_me_email_after')->nullable();
            $table->integer('days_after')->nullable();
            $table->boolean('sms_after')->nullable();
            $table->boolean('email_after')->nullable();
            $table->string('is_before')->nullable();  
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billing_alllert_cs');
    }
}
