<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMInvoicesDocumentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_invoices_documents', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('fac_id');
			$table->char('fac_tipo', 1);
			$table->string('serie', 20)->default('INF');
			$table->string('entidade', 10)->default('INF');
			$table->enum('tipo', array('Venda a Dinheiro','Factura','Factura/Recibo','Fatura','Fatura/Recibo'))->default('Factura/Recibo');
			$table->integer('eid')->unsigned()->default(0)->index('eid');
			$table->timestamp('entry_date')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->integer('uid')->default(-1);
			$table->text('documento', 65535)->nullable();
			$table->smallInteger('iva')->nullable();
			$table->decimal('iva_valor', 7);
			$table->string('vat', 15);
			$table->decimal('value')->default(0.00);
			$table->decimal('valor_cambio', 5)->default(1.00);
			$table->string('texto_livre')->nullable();
			$table->string('AT_InvoiceNo', 50);
			$table->char('AT_InvoiceStatus', 1)->default('N');
			$table->string('AT_Reason', 50)->nullable()->default('');
			$table->char('AT_TaxExemptionReason', 3)->nullable();
			$table->string('AT_Hash', 172);
			$table->string('AT_HashControl', 200);
			$table->string('observacao', 250)->nullable();
			$table->unique(['fac_id','serie','entidade'], 'semDuplicados');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('m_invoices_documents');
	}

}
