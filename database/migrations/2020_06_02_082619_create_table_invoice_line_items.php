<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInvoiceLineItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invl_items', function (Blueprint $table) {
           $table->increments('id');
           $table->string('code')->nullable();
           $table->longText('description')->nullable();
           $table->float('unit_price', 8, 2);
           $table->float('qty', 8, 2);
           $table->float('vat', 8, 2)->nullable();
           $table->float('discount', 8, 2)->nullable();
           $table->bigInteger('total');

           $table->integer('invid')->unsigned();
           $table->foreign('invid')->references('id')->on('invoices');
           
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
        Schema::dropIfExists('invl_items');
    }
}
