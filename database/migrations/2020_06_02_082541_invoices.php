<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Invoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
           $table->increments('id');
           $table->dateTime('inv_date')->nullable();
           $table->longText('remarks')->nullable();
           $table->string('due',20)->nullable();
           $table->string('po',20)->nullable();
           $table->string('sequence', 10)->nullable();
           $table->float('retention', 8, 2)->nullable();
           
           $table->float('inv_retention', 8, 2)->nullable();
           $table->float('inv_subtotal', 8, 2)->nullable();
           $table->float('inv_vat', 8, 2)->nullable();
           $table->float('inv_discount', 8, 2)->nullable();
           
           $table->string('currency', 10)->nullable();
           $table->text('tax_exemption_reason')->nullable();
           $table->string('total_invoice_value')->nullable();

           $table->integer('uid')->unsigned()->nullable();
           $table->foreign('uid')->references('id')->on('users');

           $table->integer('cid')->unsigned()->nullable();
           $table->foreign('cid')->references('id')->on('clients');

           $table->integer('brand_templates_id')->unsigned()->nullable();
           $table->foreign('brand_templates_id')->references('id')->on('brand_templates');

           $table->integer('brands_id')->unsigned()->nullable();
           $table->foreign('brands_id')->references('id')->on('brands');

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
        Schema::dropIfExists('invoices');
    }
}
