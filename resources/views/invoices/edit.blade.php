

@extends('partials.main')
@section('content')
	<script>

		var ArraysOfObjects = [];
		var ArrayOfTaxRates = [];
		var ArrayOfTaxNames= [];
		var SubTotal = 0;
		var Discount = 0;
		var Vat = 0;
		var WithoutVat = 0;
		var Total = 0;

		function Invoice(id)  {
			this.id =id;
			this.line_item_code =  '';
			this.line_item_description =  '';
			this.line_item_unit_price = 0;
			this.line_item_qty = 0;
			this.line_item_vat = 0;
			this.line_item_discount = 0;
			this.line_item_total = 0;
		}
		function preparedRows(id,line_item_code,line_item_description,line_item_unit_price,line_item_qty,line_item_vat,line_item_discount)
		{
			if(ArraysOfObjects.length == 0)
			{
				setTimeout(function(){
					var object = new Invoice(id) ;
					object.id = id;
					this.line_item_code =  line_item_code;
					this.line_item_description =  line_item_description;
					this.line_item_unit_price = line_item_unit_price;
					this.line_item_qty = line_item_qty;
					this.line_item_vat = line_item_vat;
					this.line_item_discount = line_item_discount;
					this.line_item_total = 0;
					ArraysOfObjects.push(object);
					recalculateLineItem(id);
				}, 2000);
			}
			else
			{
				var object = new Invoice(id) ;
				object.id = id;
				this.line_item_code =  line_item_code;
				this.line_item_description =  line_item_description;
				this.line_item_unit_price = line_item_unit_price;
				this.line_item_qty = line_item_qty;
				this.line_item_vat = line_item_vat;
				this.line_item_discount = line_item_discount;
				this.line_item_total = 0;
				ArraysOfObjects.push(object);
				recalculateLineItem(id);
			}


		}
		createObject = function (id , line_item_code, line_item_description ,line_item_unit_price ,line_item_qty ,line_item_vat ,line_item_discount){
			var object = new Invoice(id) ;
			object.id = id;
			this.line_item_code =  line_item_code;
			this.line_item_description =  line_item_description;
			this.line_item_unit_price = line_item_unit_price;
			this.line_item_qty = line_item_qty;
			this.line_item_vat = line_item_vat;
			this.line_item_discount = line_item_discount;
			this.line_item_total = 0;

			ArraysOfObjects.push(object);
			var subtotal = 0;
			var Discount = 0;
			var Vat = 0;
			$.each(ArraysOfObjects , function (key, value) {
				if(!isNaN(value.line_item_total))
				{
					subtotal = parseFloat(subtotal) + parseFloat(value.line_item_total);
				}
				if(!isNaN(value.line_item_discount) && !isNaN(value.line_item_total) )
				{
					Discount = parseFloat(Discount) + (parseFloat(parseFloat(value.line_item_discount) / 100 ) * parseFloat(value.line_item_total));
				}

			});
			$(document).ready(function () {
				if(!isNaN(subtotal))
				{
					$('#subTotal_Invoice').text(subtotal);
					$('#Total_Invoice').text(subtotal);
				}

			});
		}
		clearArraysOfObjects = function (){
			ArraysOfObjects = new Array();
		}


		addAnotherLine = function(event) {
			event.preventDefault();
			var id = Math.floor(Math.random() * Math.floor(100000));
			var object = new Invoice(id) ;
			object.id = id;
			ArraysOfObjects.push(object);
			var html = "<tr class='line_item_row' id='line_item_row_"+id+"'>"+
					"<td><input type='text' name='line_item_code[]' id='line_item_code_"+id+"' class='form-control' ></td>"+
					"<td><input type='text' name='line_item_description[]' id='line_item_description_"+id+"' class='form-control'></td>"+
					"<td><input type='number' name='line_item_unit_price[]' id='line_item_unit_price_"+id+"' class='form-control' onchange='recalculateLineItem("+id+")'></td>"+
					"<td><input type='number' name='line_item_qty[]' id='line_item_qty_"+id+"' class='form-control' value='1' onchange='recalculateLineItem("+id+")'></td>"+
					"<td>"+
					"<select  name='line_item_vat[]' id='line_item_vat_"+id+"' class='form-control' onchange='recalculateLineItem("+id+")'>"+
					"<option value='23' selected='selected'>23,0% - IVA23</option>"+
					"<option value='18'>18,0% - IVA18</option>"+
					"<option value='22'>22,0% - IVA22</option>"+
					"<option value='0'>0,0% - Isento</option"+
					"</select>"+
					"</td>"+
					"<td><input type='number' name='line_item_discount[]' id='line_item_discount_"+id+"' class='form-control' value='0' onchange='recalculateLineItem("+id+")'></td>"+
					"<td><a href='#'  onclick='deleteDynamicRow("+id+",event)'><i class='fa fa-trash' style='cursor: pointer;font-size: 22px'></i></a></td>"+
					"</tr>";
			$('#line_item_body').append(html);
		}

		deleteDynamicRow = function (id,event) {
			var keyToDelete = 0;
			SubTotal = 0;
			// Discount = parseFloat($('#adjustment_'+branch_id).val());
			$.each(ArraysOfObjects , function (key, value) {
				if(value.id == id)
				{
					keyToDelete = key;
				}
				// else if(value.branch_id == branch_id)
				// {
				// SubTotal = parseFloat(SubTotal) + parseFloat(value.amount) ;
				// }
			});
			// if(!isNaN(Discount))
			// {
			// Total = SubTotal + Discount;
			// }
			ArraysOfObjects.splice(keyToDelete,1);
			event.preventDefault();
			$('#line_item_row_'+id).remove();
			// $('#line_'+id).remove();
			// $('#subTotal_'+branch_id).text(SubTotal);
			// $('#Total_'+branch_id).text(Total);
		}
		//Separator for euro
		function thousands_separators(num)
		{
			var num_parts = num.toString().split(".");
			num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, " ");
			return num_parts.join(",");
		}

		recalculateLineItem = function (id) {
			SubTotal = 0; Discount = 0; Vat = 0; Total = 0; var line_item_discount_calc = 0;
			$.each(ArraysOfObjects,function (key, value) {
				if(parseFloat(value.id )== parseFloat(id))
				{
					value.line_item_unit_price = parseFloat($('#line_item_unit_price_'+id).val());
					value.line_item_qty = parseFloat($('#line_item_qty_' + id).val());
					value.line_item_vat = parseFloat($('#line_item_vat_' + id + ' :selected').val());
					value.line_item_discount = parseFloat($('#line_item_discount_' + id).val());
					value.line_item_total = value.line_item_qty * value.line_item_unit_price;
				}
				if(isNaN(value.line_item_total)){value.line_item_total = 0;}
				if(isNaN(value.line_item_discount)){value.line_item_discount = 0;}
				if(isNaN(value.line_item_vat)){value.line_item_vat = 0;}
				SubTotal = parseFloat(SubTotal) +  parseFloat(value.line_item_total);
				Discount = parseFloat(Discount) +  (value.line_item_total * (value.line_item_discount/100));
				line_item_discount_calc = (value.line_item_total * (value.line_item_discount/100));
				line_item_vat_calc = (value.line_item_total * (value.line_item_vat/100));

				Vat = parseFloat(Vat) +  ((value.line_item_total - line_item_discount_calc) * (value.line_item_vat/100));
				console.log([value,SubTotal,Discount,Vat]);

			});
			var str = $('#invoice_currency :selected').val();
			var res = str.split("_");
			Total = parseFloat(SubTotal) - parseFloat(Discount) + parseFloat(Vat);
			WithoutVat = parseFloat(SubTotal) - parseFloat(Discount);
			$('#sum_Invoice').text(thousands_separators(SubTotal.toFixed(2))+res[1]);
			$('#discount_Invoice').text(thousands_separators(Discount.toFixed(2))+res[1]);
			$('#retention_Invoice').text(thousands_separators('0.00')+res[1]);
			$('#w_o_vat_Invoice').text(thousands_separators(WithoutVat.toFixed(2))+res[1]);
			$('#vat_Invoice').text(thousands_separators(Vat.toFixed(2))+res[1]);
			$('#total_Invoice').text(thousands_separators(Total.toFixed(2))+res[1]);
	if(inv_type == "simplified")
		{
			if(Total > 1000)
			{
				$('#invoice-save').prop("disabled", true);
				$('#invoice-draft').prop("disabled", true);
				$('#alert_amount').show();
			}else{
				$('#alert_amount').hide();
				$('#invoice-draft').prop("disabled", false);
				$('#invoice-save').prop("disabled", false);
			}
		}
			$('input[name=total_invoice_value]').val(thousands_separators(Total.toFixed(2)));
		}
		saveInvoice = function (){
			var client_id = $('input[name=client_id]').val();
			if(client_id == ''){
				if(client_vat_number == '' || client_name == '')
				{
					$('.error_area').css('display','block');
					$('#client_error_top').css('display','block');
					$('.client_error').css('border','1px solid #ba4a48');
					$("html, body").animate({ scrollTop: 0 }, "slow");
				}
			}
			if(ArraysOfObjects.length == 0){
				$('.error_area').css('display','block');
				$('#item_error_top').css('display','block');
				$("html, body").animate({ scrollTop: 0 }, "slow");
			}
			if(client_id != '' && ArraysOfObjects.length != 0){
				$('.save_invoice').attr('type','submit');
			}

			$(".invoice-form").append("<input type='hidden' value='"+JSON.stringify(ArraysOfObjects)+"' name='ArraysOfObjects'>");

		}

		saveDraft = function (){
			var client_id = $('input[name=client_id]').val();
			if(client_id == ''){
				if(client_vat_number == '' || client_name == '')
				{
					$('.error_area').css('display','block');
					$('#client_error_top').css('display','block');
					$('.client_error').css('border','1px solid #ba4a48');
					$("html, body").animate({ scrollTop: 0 }, "slow");
				}
			}
			if(ArraysOfObjects.length == 0){
				$('.error_area').css('display','block');
				$('#item_error_top').css('display','block');
				$("html, body").animate({ scrollTop: 0 }, "slow");
			}
			if(client_id != '' && ArraysOfObjects.length != 0){
				$('.save_draft').attr('type','submit');
			}

			$(".invoice-form").append("<input type='hidden' value='"+JSON.stringify(ArraysOfObjects)+"' name='ArraysOfObjects'>");

		}

	</script>
	<div class="app-main__outer">
		<div class="app-main__inner">
			<div class="app-page-title">
				<div class="page-title-wrapper">
					<div class="page-title-heading">
						<div class="page-title-icon">
							<i class="fas fa-file icon-gradient bg-tempting-azure">
							</i>
						</div>
						@if ($inv_type == "receipt")
						<div>{{trans('invoices.add_invoices')}} {{ $inv_type == "receipt" ? 'Receipt' : '' }}
						</div>
						@elseif ($inv_type == "futura")	
							<div> Add Fautura simplificada</div>
						@else
						<div>{{trans('invoices.add_invoices')}}</div>
						@endif
					</div>
				<!--  <div class="page-title-actions">
                        <div class="d-inline-block dropdown">
                            <a href="{{route('clients.add')}}" class="btn-shadow btn btn-info" href="">Add Client</a>
                        </div>
                    </div>     -->
				</div>
			</div>
			<div class="main-card mb-3 card">

				<div class="main-card mb-3 card">
					<div class="card-body error_area" style="display:none; background-color: #f2dede">
						<div style="text-align: left;color: #ba4a48;">
							<h4>Warning!</h4>
							<ul>
								<li style="display: none;" id="client_error_top">
									<i class="fas fa-dot-circle 1x"></i>
									Document must have a client selected</li>
								<li style="display: none;" id="item_error_top">
									<i class="fas fa-dot-circle 1x"></i>
									Document should have at least one item</li>
							</ul>

						</div>
					</div>
					<div class="card-body" style="background-color: #f5f7f8;">
						<div class="row">
							<div class="col-6">
							<h2><b>
								@if($inv_type == "receipt")
								Edit Invoice Receipt
								@elseif($inv_type == "futura")
								Edit Fautura Simplificada
								@else
								{{trans('invoices.edit_invoice')}}
								@endif
							</b></h2>
							</div>
							<div class="col-6" style="text-align: right;">
								<form method="GET" action="{{route('Get.Invoice')}}">
									<input type="hidden" name="invoice_id" value="{{$invoices->id}}">
								<!-- <button type="submit" class="mb-2 mr-2 btn-icon btn btn-success"><i class="fa fa-print btn-icon-wrapper"> </i>{{trans('invoices.print_invoice')}}</button> -->
								</form>
							</div>
						</div>
						<div style="text-align: right;">
							<h8>{{trans('invoices.Required_Fields')}}<font color="red">*</font></h8>
						</div>
					</div>
					<div class="card-body client_area">
						<div class="col-md-12 ">
							<h3>{{trans('invoices.client_data')}}</h3>
							<hr>
							<div class="form-row">
								<div class="col-md-6">
									<div class="position-relative form-group">
										<label for="" class="">{{trans('invoices.name')}}</label>
										<input name="name" id="" placeholder="Name, Company name" type="text" class="form-control" value="{{$client->name}}" disabled required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="position-relative form-group">
										<label for="" class="">{{trans('invoices.Vat_Number')}}</label>
										<input name="vat_number" id="" placeholder="VAT number for invoices" type="text" class="form-control" value="{{$client->vat_number}}" disabled required>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-6">
									<div class="position-relative form-group">
										<label for="" class="">{{trans('invoices.country')}}</label>
										<input name="country" id="" placeholder="Country location of company" type="text" class="form-control" value="{{$client->country}}" disabled required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="position-relative form-group">
										<label for="" class="">{{trans('invoices.address')}}</label>
										<input name="address" id="address" placeholder="Main Url of the Business" value="{{$client->address}}" type="text" class="form-control" disabled required>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-6">
									<div class="position-relative form-group">
										<label for="" class="">{{trans('invoices.city')}}</label>
										<input name="city" id="city" placeholder="Country location of company" value="{{$client->city}}" type="text" class="form-control" disabled required>
									</div>
								</div>
								<div class="col-md-6">
									<div class="position-relative form-group">
										<label for="" class="">{{trans('invoices.postal-code')}}</label>
										<input name="postal_code" id="postal_code" placeholder="Main Url of the Business" value="{{$client->postal_code}}" type="text" class="form-control" disabled required>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<form class="invoice-form" method="POST" action="{{route('invoices.update',$invoices->id)}}">
				<!-- //Client Section -->
				{{csrf_field()}}
				<input type="hidden" name="client_id" value="{{$client->id}}">
	<input type="hidden" name="inv_type" value="{{ $inv_type }}">
				<div class="card-body">


					<h3>{{trans('invoices.Document_Details')}}</h3>
					<hr>
					<div class="form-row">
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-2">
									<div class="position-relative form-group"><label for="invoice_date" class="">{{  trans('invoices.Invoice_Date') }}</label></div>
								</div>
								<div class="col-md-10">
									<div class="input-group mb-3">
										<input type="text" class="form-control" data-toggle="datepicker-button" id="invoice_date"
											   name="invoice_date" value="{{$invoices->inv_date}}">
										<div class="input-group-append">
											<button class="btn btn-outline-primary datepicker-trigger-btn" type="button">
												<i class="fas fa-calendar-alt fa-lg"></i>
											</button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-2">
									<div class="position-relative form-group"><label for="invoice_remarks" class="">{{trans('invoices.Remarks')}}</label></div>
								</div>
								<div class="col-md-10">
									<div class="position-relative form-group"><textarea name="invoice_remarks" id="invoice_remarks"  class="form-control" >{{$invoices->remarks}}
								</textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-2">
									<div class="position-relative form-group"><label for="invoice_due" class="">{{trans('invoices.Due')}}</label></div>
								</div>
								<div class="col-md-10">
									<div class="input-group mb-3">
										<select class="form-control-sm form-control" id="invoice_due" name="invoice_due">
											<option value="Immediately" @if($invoices->due =="Immediately")selected @endif>Immediately</option>
											<option value="15" @if($invoices->due =="15")selected @endif>15</option>
											<option value="30" @if($invoices->due =="30")selected @endif>30</option>
											<option value="45" @if($invoices->due =="45")selected @endif>45</option>
											<option value="90" @if($invoices->due =="90")selected @endif>90</option>
											<option value="Other">Other</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-2">
									<div class="position-relative form-group"><label for="invoice_po" class="">{{trans('invoices.P_O')}}</label></div>
								</div>
								<div class="col-md-10">
									<div class="position-relative form-group"><input name="invoice_po" id="invoice_po"  class="form-control" type="text" value="{{$invoices->po}}">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-2">
									<div class="position-relative form-group"><label for="invoice_sequence" class="">{{trans('invoices.Sequence')}}</label></div>
								</div>
								<div class="col-md-10">
									<div class="input-group mb-3">
										<select class="form-control-sm form-control" id="invoice_sequence">
											<option value="A">A</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-2">
									<div class="position-relative form-group"><label for="invoice_retention" class="">{{trans('invoices.Retention_%')}}</label></div>
								</div>
								<div class="col-md-10">
									<div class="position-relative form-group"><input name="invoice_retention" id="invoice_retention"  class="form-control" type="text" value="{{$invoices->retention}}">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-2">
									<div class="position-relative form-group"><label for="invoice_currency" class="">{{trans('invoices.Currency')}}</label></div>
								</div>
								<div class="col-md-10">
									<div class="input-group mb-3">
										<select class="form-control-sm form-control currency" id="invoice_currency" name="invoice_currency">
											<option value="USD_$"    @if($invoices->currency=="USD_$"   )selected @endif        >U.S. dollar ($)</option>
											<option value="EUR_€" @if($invoices->currency=="EUR_€"   )selected @endif>
												Euro (€)</option>
											<option value="GBP_£"    @if($invoices->currency=="GBP_£"   )selected @endif        >Pound sterling (£)</option>
											<option value="CAD_C$"   @if($invoices->currency=="CAD_C$"  )selected @endif         >Canadian dollar (C$)</option>
											<option value="AUD_A$"   @if($invoices->currency=="AUD_A$"  )selected @endif         >Australian dollar (A$)</option>
											<option value="ZAR_R"    @if($invoices->currency=="ZAR_R"   )selected @endif        >South African rand (R)</option>
											<option value="AFN_؋"    @if($invoices->currency=="AFN_؋"   )selected @endif        >Afghan afghani (؋)</option>
											<option value="ALL_L"    @if($invoices->currency=="ALL_L"   )selected @endif        >Albanian lek (L)</option>
											<option value="DZD_د.ج"  @if($invoices->currency=="DZD_د.ج" )selected @endif          >Algerian dinar (د.ج)</option>
											<option value="AOA_Kz"   @if($invoices->currency=="AOA_Kz"  )selected @endif         >Angolan kwanza (Kz)</option>
											<option value="ARS_$"    @if($invoices->currency=="ARS_$"   )selected @endif        >Argentine peso ($)</option>
											<option value="AMD_դր."  @if($invoices->currency=="AMD_դր." )selected @endif          >Armenian dram (դր.)</option>
											<option value="AWG_ƒ"    @if($invoices->currency=="AWG_ƒ"   )selected @endif        >Aruban florin (ƒ)</option>
											<option value="AZN_¤"    @if($invoices->currency=="AZN_¤"   )selected @endif        >Azerbaijani manat (¤)</option>
											<option value="BSD_$"    @if($invoices->currency=="BSD_$"   )selected @endif        >Bahamian dollar ($)</option>
											<option value="BHD_ب.د"  @if($invoices->currency=="BHD_ب.د" )selected @endif          >Bahraini dinar (ب.د)</option>
											<option value="BDT_¤"    @if($invoices->currency=="BDT_¤"   )selected @endif        >Bangladeshi taka (¤)</option>
											<option value="BBD_$"    @if($invoices->currency=="BBD_$"   )selected @endif        >Barbadian dollar ($)</option>
											<option value="BYR_Br"   @if($invoices->currency=="BYR_Br"  )selected @endif         >Belarusian ruble (Br)</option>
											<option value="BZD_$"    @if($invoices->currency=="BZD_$"   )selected @endif        >Belize dollar ($)</option>
											<option value="BMD_$"    @if($invoices->currency=="BMD_$"   )selected @endif        >Bermudian dollar ($)</option>
											<option value="BTN_¤"    @if($invoices->currency=="BTN_¤"   )selected @endif        >Bhutanese ngultrum (¤)</option>
											<option value="BOB_Bs."  @if($invoices->currency=="BOB_Bs." )selected @endif          >Bolivian boliviano (Bs.)</option>
											<option value="BAM_KM"   @if($invoices->currency=="BAM_KM"  )selected @endif         >Bosnia &amp; Herzegovina mark (KM)</option>
											<option value="BWP_P"    @if($invoices->currency=="BWP_P"   )selected @endif        >Botswana pula (P)</option>
											<option value="BRL_R$"   @if($invoices->currency=="BRL_R$"  )selected @endif         >Brazilian real (R$)</option>
											<option value="BND_$"    @if($invoices->currency=="BND_$"   )selected @endif        >Brunei dollar ($)</option>
											<option value="BGN_лв"   @if($invoices->currency=="BGN_лв"  )selected @endif         >Bulgarian lev (лв)</option>
											<option value="BIF_Fr"   @if($invoices->currency=="BIF_Fr"  )selected @endif         >Burundian franc (Fr)</option>
											<option value="KHR_¤"    @if($invoices->currency=="KHR_¤"   )selected @endif        >Cambodian riel (¤)</option>
											<option value="CVE_Esc"  @if($invoices->currency=="CVE_Esc" )selected @endif          >Cape Verdean escudo (Esc)</option>
											<option value="KYD_$"    @if($invoices->currency=="KYD_$"   )selected @endif        >Cayman Islands dollar ($)</option>
											<option value="XAF_Fr"   @if($invoices->currency=="XAF_Fr"  )selected @endif         >Central African CFA franc (Fr)</option>
											<option value="XPF_Fr"   @if($invoices->currency=="XPF_Fr"  )selected @endif         >CFP franc (Fr)</option>
											<option value="CLP_$"    @if($invoices->currency=="CLP_$"   )selected @endif        >Chilean peso ($)</option>
											<option value="CNY_¥"    @if($invoices->currency=="CNY_¥"   )selected @endif        >Chinese yuan (¥)</option>
											<option value="COP_$"    @if($invoices->currency=="COP_$"   )selected @endif        >Colombian peso ($)</option>
											<option value="KMF_Fr"   @if($invoices->currency=="KMF_Fr"  )selected @endif         >Comorian franc (Fr)</option>
											<option value="CDF_Fr"   @if($invoices->currency=="CDF_Fr"  )selected @endif         >Congolese franc (Fr)</option>
											<option value="CRC_₡"    @if($invoices->currency=="CRC_₡"   )selected @endif        >Costa Rican colón (₡)</option>
											<option value="HRK_kn"   @if($invoices->currency=="HRK_kn"  )selected @endif         >Croatian kuna (kn)</option>
											<option value="CUC_$"    @if($invoices->currency=="CUC_$"   )selected @endif        >Cuban convertible peso ($)</option>
											<option value="CUP_$"    @if($invoices->currency=="CUP_$"   )selected @endif        >Cuban peso ($)</option>
											<option value="CZK_Kč"   @if($invoices->currency=="CZK_Kč"  )selected @endif         >Czech koruna (Kč)</option>
											<option value="DKK_kr."  @if($invoices->currency=="DKK_kr." )selected @endif          >Danish krone (kr.)</option>
											<option value="DJF_Fr"   @if($invoices->currency=="DJF_Fr"  )selected @endif         >Djiboutian franc (Fr)</option>
											<option value="DOP_$"    @if($invoices->currency=="DOP_$"   )selected @endif        >Dominican peso ($)</option>
											<option value="XCD_$"    @if($invoices->currency=="XCD_$"   )selected @endif        >East Caribbean dollar ($)</option>
											<option value="EGP_ج.م"  @if($invoices->currency=="EGP_ج.م" )selected @endif          >Egyptian pound (ج.م)</option>
											<option value="ERN_Nfk"  @if($invoices->currency=="ERN_Nfk" )selected @endif          >Eritrean nakfa (Nfk)</option>
											<option value="EEK_KR"   @if($invoices->currency=="EEK_KR"  )selected @endif         >Estonian kroon (KR)</option>
											<option value="ETB_¤"    @if($invoices->currency=="ETB_¤"   )selected @endif        >Ethiopian birr (¤)</option>
											<option value="FKP_£"    @if($invoices->currency=="FKP_£"   )selected @endif        >Falkland Islands pound (£)</option>
											<option value="FJD_$"    @if($invoices->currency=="FJD_$"   )selected @endif        >Fijian dollar ($)</option>
											<option value="GMD_D"    @if($invoices->currency=="GMD_D"   )selected @endif        >Gambian dalasi (D)</option>
											<option value="GEL_ლ"    @if($invoices->currency=="GEL_ლ"   )selected @endif        >Georgian lari (ლ)</option>
											<option value="GHS_₵"    @if($invoices->currency=="GHS_₵"   )selected @endif        >Ghanaian cedi (₵)</option>
											<option value="GIP_£"    @if($invoices->currency=="GIP_£"   )selected @endif        >Gibraltar pound (£)</option>
											<option value="GTQ_Q"    @if($invoices->currency=="GTQ_Q"   )selected @endif        >Guatemalan quetzal (Q)</option>
											<option value="GNF_Fr"   @if($invoices->currency=="GNF_Fr"  )selected @endif         >Guinean franc (Fr)</option>
											<option value="GYD_$"    @if($invoices->currency=="GYD_$"   )selected @endif        >Guyanese dollar ($)</option>
											<option value="HTG_G"    @if($invoices->currency=="HTG_G"   )selected @endif        >Haitian gourde (G)</option>
											<option value="HNL_L"    @if($invoices->currency=="HNL_L"   )selected @endif        >Honduran lempira (L)</option>
											<option value="HKD_$"    @if($invoices->currency=="HKD_$"   )selected @endif        >Hong Kong dollar ($)</option>
											<option value="HUF_Ft"   @if($invoices->currency=="HUF_Ft"  )selected @endif         >Hungarian forint (Ft)</option>
											<option value="ISK_kr"   @if($invoices->currency=="ISK_kr"  )selected @endif         >Icelandic króna (kr)</option>
											<option value="INR_Rs"   @if($invoices->currency=="INR_Rs"  )selected @endif         >Indian rupee (Rs)</option>
											<option value="IDR_Rp"   @if($invoices->currency=="IDR_Rp"  )selected @endif         >Indonesian rupiah (Rp)</option>
											<option value="IRR_﷼"    @if($invoices->currency=="IRR_﷼"   )selected @endif        >Iranian rial (﷼)</option>
											<option value="IQD_ع.د"  @if($invoices->currency=="IQD_ع.د" )selected @endif          >Iraqi dinar (ع.د)</option>
											<option value="ILS_₪"    @if($invoices->currency=="ILS_₪"   )selected @endif        >Israeli new sheqel (₪)</option>
											<option value="JMD_$"    @if($invoices->currency=="JMD_$"   )selected @endif        >Jamaican dollar ($)</option>
											<option value="JPY_¥"    @if($invoices->currency=="JPY_¥"   )selected @endif        >Japanese yen (¥)</option>
											<option value="JOD_د.ا"  @if($invoices->currency=="JOD_د.ا" )selected @endif          >Jordanian dinar (د.ا)</option>
											<option value="KZT_〒"    @if($invoices->currency=="KZT_〒"   )selected @endif        >Kazakhstani tenge (〒)</option>
											<option value="KES_Sh"   @if($invoices->currency=="KES_Sh"  )selected @endif         >Kenyan shilling (Sh)</option>
											<option value="KWD_د.ك"  @if($invoices->currency=="KWD_د.ك" )selected @endif          >Kuwaiti dinar (د.ك)</option>
											<option value="KGS_¤"    @if($invoices->currency=="KGS_¤"   )selected @endif        >Kyrgyzstani som (¤)</option>
											<option value="LAK_₭"    @if($invoices->currency=="LAK_₭"   )selected @endif        >Lao kip (₭)</option>
											<option value="LVL_Ls"   @if($invoices->currency=="LVL_Ls"  )selected @endif         >Latvian lats (Ls)</option>
											<option value="LBP_ل.ل"  @if($invoices->currency=="LBP_ل.ل" )selected @endif          >Lebanese pound (ل.ل)</option>
											<option value="LSL_L"    @if($invoices->currency=="LSL_L"   )selected @endif        >Lesotho loti (L)</option>
											<option value="LRD_$"    @if($invoices->currency=="LRD_$"   )selected @endif        >Liberian dollar ($)</option>
											<option value="LYD_ل.د"  @if($invoices->currency=="LYD_ل.د" )selected @endif          >Libyan dinar (ل.د)</option>
											<option value="LTL_Lt"   @if($invoices->currency=="LTL_Lt"  )selected @endif         >Lithuanian litas (Lt)</option>
											<option value="MOP_P"    @if($invoices->currency=="MOP_P"   )selected @endif        >Macanese pataca (P)</option>
											<option value="MKD_ден"  @if($invoices->currency=="MKD_ден" )selected @endif          >Macedonian denar (ден)</option>
											<option value="MGA_¤"    @if($invoices->currency=="MGA_¤"   )selected @endif        >Malagasy ariary (¤)</option>
											<option value="MWK_MK"   @if($invoices->currency=="MWK_MK"  )selected @endif         >Malawian kwacha (MK)</option>
											<option value="MYR_RM"   @if($invoices->currency=="MYR_RM"  )selected @endif         >Malaysian ringgit (RM)</option>
											<option value="MVR_Rf"   @if($invoices->currency=="MVR_Rf"  )selected @endif         >Maldivian rufiyaa (Rf)</option>
											<option value="MRO_UM"   @if($invoices->currency=="MRO_UM"  )selected @endif         >Mauritanian ouguiya (UM)</option>
											<option value="MUR_₨"    @if($invoices->currency=="MUR_₨"   )selected @endif        >Mauritian rupee (₨)</option>
											<option value="MXN_$"    @if($invoices->currency=="MXN_$"   )selected @endif        >Mexican peso ($)</option>
											<option value="MDL_L"    @if($invoices->currency=="MDL_L"   )selected @endif        >Moldovan leu (L)</option>
											<option value="MNT_₮"    @if($invoices->currency=="MNT_₮"   )selected @endif        >Mongolian tögrög (₮)</option>
											<option value="MAD_MAD"  @if($invoices->currency=="MAD_MAD" )selected @endif          >Moroccan dirham (MAD)</option>
											<option value="MZN_MZN"  @if($invoices->currency=="MZN_MZN" )selected @endif          >Mozambican metical (MZN)</option>
											<option value="MMK_K"    @if($invoices->currency=="MMK_K"   )selected @endif        >Myanma kyat (K)</option>
											<option value="NAD_$"    @if($invoices->currency=="NAD_$"   )selected @endif        >Namibian dollar ($)</option>
											<option value="NPR_₨"    @if($invoices->currency=="NPR_₨"   )selected @endif        >Nepalese rupee (₨)</option>
											<option value="ANG_ƒ"    @if($invoices->currency=="ANG_ƒ"   )selected @endif        >Netherlands Antillean guilder (ƒ)</option>
											<option value="TWD_$"    @if($invoices->currency=="TWD_$"   )selected @endif        >New Taiwan dollar ($)</option>
											<option value="NZD_$"    @if($invoices->currency=="NZD_$"   )selected @endif        >New Zealand dollar ($)</option>
											<option value="NIO_C$"   @if($invoices->currency=="NIO_C$"  )selected @endif         >Nicaraguan córdoba (C$)</option>
											<option value="NGN_₦"    @if($invoices->currency=="NGN_₦"   )selected @endif        >Nigerian naira (₦)</option>
											<option value="KPW_₩"    @if($invoices->currency=="KPW_₩"   )selected @endif        >North Korean won (₩)</option>
											<option value="NOK_kr"   @if($invoices->currency=="NOK_kr"  )selected @endif         >Norwegian krone (kr)</option>
											<option value="OMR_ر.ع." @if($invoices->currency=="OMR_ر.ع.")selected @endif           >Omani rial (ر.ع.)</option>
											<option value="PKR_₨"    @if($invoices->currency=="PKR_₨"   )selected @endif        >Pakistani rupee (₨)</option>
											<option value="PAB_B/."  @if($invoices->currency=="PAB_B/." )selected @endif          >Panamanian balboa (B/.)</option>
											<option value="PGK_K"    @if($invoices->currency=="PGK_K"   )selected @endif        >Papua New Guinean kina (K)</option>
											<option value="PYG_₲"    @if($invoices->currency=="PYG_₲"   )selected @endif        >Paraguayan guaraní (₲)</option>
											<option value="PEN_S/."  @if($invoices->currency=="PEN_S/." )selected @endif          >Peruvian nuevo sol (S/.)</option>
											<option value="PHP_₱"    @if($invoices->currency=="PHP_₱"   )selected @endif        >Philippine peso (₱)</option>
											<option value="PLN_zł"   @if($invoices->currency=="PLN_zł"  )selected @endif         >Polish złoty (zł)</option>
											<option value="QAR_ر.ق"  @if($invoices->currency=="QAR_ر.ق" )selected @endif          >Qatari riyal (ر.ق)</option>
											<option value="RON_L"    @if($invoices->currency=="RON_L"   )selected @endif        >Romanian leu (L)</option>
											<option value="RUB_р."   @if($invoices->currency=="RUB_р."  )selected @endif         >Russian ruble (р.)</option>
											<option value="RWF_Fr"   @if($invoices->currency=="RWF_Fr"  )selected @endif         >Rwandan franc (Fr)</option>
											<option value="SHP_£"    @if($invoices->currency=="SHP_£"   )selected @endif        >Saint Helena pound (£)</option>
											<option value="SVC_₡"    @if($invoices->currency=="SVC_₡"   )selected @endif        >Salvadoran colón (₡)</option>
											<option value="WST_T"    @if($invoices->currency=="WST_T"   )selected @endif        >Samoan tala (T)</option>
											<option value="STD_Db"   @if($invoices->currency=="STD_Db"  )selected @endif         >São Tomé and Príncipe dobra (Db)</option>
											<option value="SAR_ر.س"  @if($invoices->currency=="SAR_ر.س" )selected @endif          >Saudi riyal (ر.س)</option>
											<option value="RSD_дин." @if($invoices->currency=="RSD_дин.")selected @endif           >Serbian dinar (дин.)</option>
											<option value="SCR_₨"    @if($invoices->currency=="SCR_₨"   )selected @endif        >Seychellois rupee (₨)</option>
											<option value="SLL_Le"   @if($invoices->currency=="SLL_Le"  )selected @endif         >Sierra Leonean leone (Le)</option>
											<option value="SGD_$"    @if($invoices->currency=="SGD_$"   )selected @endif        >Singapore dollar ($)</option>
											<option value="SBD_$"    @if($invoices->currency=="SBD_$"   )selected @endif        >Solomon Islands dollar ($)</option>
											<option value="SOS_Sh"   @if($invoices->currency=="SOS_Sh"  )selected @endif         >Somali shilling (Sh)</option>
											<option value="KRW_₩"    @if($invoices->currency=="KRW_₩"   )selected @endif        >South Korean won (₩)</option>
											<option value="LKR_Rs"   @if($invoices->currency=="LKR_Rs"  )selected @endif         >Sri Lankan rupee (Rs)</option>
											<option value="SDG_£"    @if($invoices->currency=="SDG_£"   )selected @endif        >Sudanese pound (£)</option>
											<option value="SRD_$"    @if($invoices->currency=="SRD_$"   )selected @endif        >Surinamese dollar ($)</option>
											<option value="SZL_L"    @if($invoices->currency=="SZL_L"   )selected @endif        >Swazi lilangeni (L)</option>
											<option value="SEK_kr"   @if($invoices->currency=="SEK_kr"  )selected @endif         >Swedish krona (kr)</option>
											<option value="CHF_Fr"   @if($invoices->currency=="CHF_Fr"  )selected @endif         >Swiss franc (Fr)</option>
											<option value="SYP_ل.س"  @if($invoices->currency=="SYP_ل.س" )selected @endif          >Syrian pound (ل.س)</option>
											<option value="TJS_ЅМ"   @if($invoices->currency=="TJS_ЅМ"  )selected @endif         >Tajikistani somoni (ЅМ)</option>
											<option value="TZS_Sh"   @if($invoices->currency=="TZS_Sh"  )selected @endif         >Tanzanian shilling (Sh)</option>
											<option value="THB_฿"    @if($invoices->currency=="THB_฿"   )selected @endif        >Thai baht (฿)</option>
											<option value="TOP_T$"   @if($invoices->currency=="TOP_T$"  )selected @endif         >Tongan paʻanga (T$)</option>
											<option value="TTD_$"    @if($invoices->currency=="TTD_$"   )selected @endif        >Trinidad and Tobago dollar ($)</option>
											<option value="TND_د.ت"  @if($invoices->currency=="TND_د.ت" )selected @endif          >Tunisian dinar (د.ت)</option>
											<option value="TRY_TL"   @if($invoices->currency=="TRY_TL"  )selected @endif         >Turkish lira (TL)</option>
											<option value="TMM_m"    @if($invoices->currency=="TMM_m"   )selected @endif        >Turkmenistani manat (m)</option>
											<option value="UGX_Sh"   @if($invoices->currency=="UGX_Sh"  )selected @endif         >Ugandan shilling (Sh)</option>
											<option value="UAH_₴"    @if($invoices->currency=="UAH_₴"   )selected @endif        >Ukrainian hryvnia (₴)</option>
											<option value="AED_د.إ"  @if($invoices->currency=="AED_د.إ" )selected @endif          >United Arab Emirates dirham (د.إ)</option>
											<option value="UYU_$"    @if($invoices->currency=="UYU_$"   )selected @endif        >Uruguayan peso ($)</option>
											<option value="UZS_¤"    @if($invoices->currency=="UZS_¤"   )selected @endif        >Uzbekistani som (¤)</option>
											<option value="VUV_Vt"   @if($invoices->currency=="VUV_Vt"  )selected @endif         >Vanuatu vatu (Vt)</option>
											<option value="VEF_Bs F" @if($invoices->currency=="VEF_Bs F")selected @endif           >Venezuelan bolívar (Bs F)</option>
											<option value="VND_₫"    @if($invoices->currency=="VND_₫"   )selected @endif        >Vietnamese đồng (₫)</option>
											<option value="XOF_Fr"   @if($invoices->currency=="XOF_Fr"  )selected @endif         >West African CFA franc (Fr)</option>
											<option value="YER_﷼"    @if($invoices->currency=="YER_﷼"   )selected @endif        >Yemeni rial (﷼)</option>
											<option value="ZMK_ZK"   @if($invoices->currency=="ZMK_ZK"  )selected @endif         >Zambian kwacha (ZK)</option>
											<option value="ZWR_$"    @if($invoices->currency=="ZWR_$"   )selected @endif        >Zimbabwean dollar ($)</option>
											<option value="XDR_SDR"  @if($invoices->currency=="XDR_SDR" )selected @endif          >Special Drawing Rights (SDR)</option>
											<option value="TMT_m"    @if($invoices->currency=="TMT_m"   )selected @endif        >Turkmen manat (m)</option>
											<option value="VEB_Bs"   @if($invoices->currency=="VEB_Bs"  )selected @endif         >Venezuelan bolivar (Bs)</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-2">
									<div class="position-relative form-group"><label for="invoice_tax_exemption_reason" class="">{{trans('invoices.Tax_Exemption_Reason')}}</label></div>
								</div>
								<div class="col-md-10">
									<div class="input-group mb-3">
										<select name="invoice_tax_exemption_reason" class="form-control-sm form-control" id="invoice_tax_exemption_reason">
											<option value="M09"   @if($invoices->tax_exemption_reason == "M09") selected @endif >IVA ‐ não confere direito a dedução.</option>
											<option value="M08"   @if($invoices->tax_exemption_reason == "M08") selected @endif >IVA – autoliquidação.</option>
											<option value="M07"   @if($invoices->tax_exemption_reason == "M07") selected @endif >Isento Artigo 9º do CIVA.</option>
											<option value="M06"   @if($invoices->tax_exemption_reason == "M06") selected @endif >Isento Artigo 15º do CIVA.</option>
											<option value="M05"   @if($invoices->tax_exemption_reason == "M05") selected @endif >Isento Artigo 14º do CIVA.</option>
											<option value="M04"   @if($invoices->tax_exemption_reason == "M04") selected @endif >Isento Artigo 13º do CIVA.</option>
											<option value="M03"   @if($invoices->tax_exemption_reason == "M03") selected @endif >Exigibilidade de caixa.</option>
											<option value="M02"   @if($invoices->tax_exemption_reason == "M02") selected @endif >Artigo 6º do Decreto‐Lei nº 198/90, de 19 de Junho.</option>
											<option value="M01"   @if($invoices->tax_exemption_reason == "M01") selected @endif >Artigo 16º nº 6 do CIVA.</option>
											<option value="M16"   @if($invoices->tax_exemption_reason == "M16") selected @endif >Isento Artigo 14º do RITI.</option>
											<option value="M15"   @if($invoices->tax_exemption_reason == "M15") selected @endif >Regime da margem de lucro–Objetos de coleção e antiguidades.</option>
											<option value="M14"   @if($invoices->tax_exemption_reason == "M14") selected @endif >Regime da margem de lucro – Objetos de arte.</option>
											<option value="M13"   @if($invoices->tax_exemption_reason == "M13") selected @endif >Regime da margem de lucro – Bens em segunda mão.</option>
											<option value="M12"   @if($invoices->tax_exemption_reason == "M12") selected @endif >Regime da margem de lucro – Agências de viagens.</option>
											<option value="M11"   @if($invoices->tax_exemption_reason == "M11") selected @endif >Regime particular do tabaco.</option>
											<option value="M10"   @if($invoices->tax_exemption_reason == "M10") selected @endif >IVA – Regime de isenção.</option>
											<option value="M99"   @if($invoices->tax_exemption_reason == "M99") selected @endif >Não sujeito; não tributado (ou similar).</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-2">
									<div class="position-relative form-group"><label for="invoice_sequence" class="">{{trans('invoices.brands')}}</label></div>
								</div>
								<div class="col-md-10">
									<div class="input-group mb-3">
										<select class="form-control-sm form-control" id="brand" name="brands_id" required>
											<option value="" disabled selected>Select Brand</option>
											@foreach($brands as $brand)
												<option value="{{$brand->id}}"
														@if($brand->id == $invoices->brands_id) selected @endif>{{$brand->name}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-2">
									<div class="position-relative form-group"><label for="invoice_retention" class="">{{trans('invoices.brand_templates')}}</label></div>
								</div>
								<div class="col-md-10">
									<div class="position-relative form-group">
										<select class="form-control-sm form-control" name="brand_templates_id" id="brand_template" required>
											<option value="" disabled selected>Select Template</option>
											@foreach($templates as $template)
												<option value="{{$template->id}}"
														@if($template->id == $invoices->brand_templates_id) selected @endif>{{$template->name}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<h3>{{trans('invoices.Items')}}<span style="color:red;">*</span></h3>
					<hr>


					<table class="mb-0 table table-bordered">
						<thead>
						<tr>
							<th>{{trans('invoices.Code')}}</th>
							<th>{{trans('invoices.Description')}}</th>
							<th>{{trans('invoices.Unit_Price')}} </th>
							<th>{{trans('invoices.Qty')}}</th>
							<th>{{trans('invoices.Vat')}}</th>
							<th>{{trans('invoices.Disc_')}}</th>
							<th></th>
						</tr>
						</thead>
						<tbody class="line_item_body" id="line_item_body">
						@foreach($line_items as $line_item)
							<tr class="line_item_row" id="line_item_row_1">
								<td><input type="text" name="line_item_code[]" id="line_item_code_{{$line_item->id}}" class="form-control" value="{{$line_item->code}}" ></td>
								<td><input type="text" name="line_item_description[]" id="line_item_description_{{$line_item->id}}" class="form-control" value="{{$line_item->description}}"></td>
								<td><input type="number" name="line_item_unit_price[]" id="line_item_unit_price_{{$line_item->id}}" class="form-control" onchange='recalculateLineItem({{$line_item->id}})' value="{{$line_item->unit_price}}"></td>
								<td><input type="number" name="line_item_qty[]" id="line_item_qty_{{$line_item->id}}" class="form-control" onchange='recalculateLineItem({{$line_item->id}})' value="{{$line_item->qty}}"></td>
								<td>
									<select  name="line_item_vat[]" id="line_item_vat_{{$line_item->id}}" class="form-control" onchange='recalculateLineItem({{$line_item->id}})'>
										@if($fee_list != "")
											@if(isset($fee_list) && !empty($fee_list))
												@foreach ($fee_list as $fee)
													<option value={{ $fee[0] }}
														@if($line_item->vat == $fee[0])selected @endif >
														{{ $fee[0] }} - {{ $fee[1] }}
													</option>
												@endforeach
												{{-- <option value="23" @if($line_item->vat == "23")selected @endif >23,0% - IVA23</option>
												<option value="18" @if($line_item->vat == "18")selected @endif >18,0% - IVA18</option>
												<option value="22" @if($line_item->vat == "22")selected @endif >22,0% - IVA22</option>
												<option value="0" @if($line_item->vat == "0")selected @endif >0,0% - Isento</option --}}
										    @endif
										@else
											@if(isset($user_default_fee_list) && !empty($user_default_fee_list))
												@foreach ($user_default_fee_list as $fee)
													<option value={{ $fee[0] }}
														@if($line_item->vat == $fee[0])selected @endif >
														{{ $fee[0] }} - {{ $fee[1] }}
													</option>
												@endforeach
											{{-- <option value="23" @if($line_item->vat == "23")selected @endif >23,0% - IVA23</option>
											<option value="18" @if($line_item->vat == "18")selected @endif >18,0% - IVA18</option>
											<option value="22" @if($line_item->vat == "22")selected @endif >22,0% - IVA22</option>
											<option value="0" @if($line_item->vat == "0")selected @endif >0,0% - Isento</option --}}
											@endif
										@endif	
								</select>
								</td>
								<td>
									<input type="number" name="line_item_discount[]" id="line_item_discount_{{$line_item->id}}" class="form-control"  onchange='recalculateLineItem({{$line_item->id}})' value="{{$line_item->discount}}"></td>
								<td>
									<a href='#'  onclick='deleteDynamicRow("1",event)'><i class='fa fa-trash' style='cursor: pointer;font-size: 22px'></i></a>
								</td>
							</tr>
							<script>
								window.onload = preparedRows({{$line_item->id}},'{{$line_item->code}}','{{$line_item->description}}',{{$line_item->unit_price}},{{$line_item->qty}},{{$line_item->vat}},{{$line_item->discount}});

							</script>
						@endforeach
						</tbody>

					</table>
					<div class="add-another-text">
						<!-- <a id="addAnotherLine" onclick="addAnotherLine(event)" href="#"><i class="fa fa-plus"></i> Add line item</a> -->
					</div>
					<div class="main-card mb-3 card">
						<div class="card-body" style="background-color: #f5f7f8;">
							<div class="col-md-12 ">
								<div class="row">
									<div class="col-12 item_button" style="text-align: right;">
										{{trans('invoices.add_items')}}
										<a type="button" class="mt-2 btn btn-success item_selector" id="item_selector"><i class="fa fa-plus"></i></a>
									</div>
								</div>
							</div>
							<div class="col-md-12 open_item_selector" style=" display: none;">
								<div class="input-group">
									<input type="text" name="clients" id="items" class="search_items_live items form-control" placeholder="{{trans('invoices.Search_for_an_existing_items')}}" autocomplete="false">
									<div class="input-group-addon search_icon_item" style="margin-top: -1%;display: none;">
										<i class="fas fa-spinner fa-spin fa-2x"></i>
									</div>
								</div>

								<div id="ItemList" style="position: relative;">
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div style="clear: both;padding: 10px;border-radius: 10px;width: 500px;float: right;margin: 50px -22px 0px 0px;">
								<div class="sub-total-container">

									<div class="subtotal-left">
										<h5>{{trans('invoices.Summary')}}</h5>
										<hr>
									</div>
									<div class="row">
										<div class="col-md-6">
											<h7>{{trans('invoices.Sum')}}</h7>
										</div>
										<div class="col-md-6" style="text-align:right !important;">
											<h5 id="sum_Invoice">0.00</h5>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<h7>{{trans('invoices.Discount')}}</h7>
										</div>
										<div class="col-md-6" style="text-align:right !important;">
											<h5 id="discount_Invoice">0.00</h5>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<h7>{{trans('invoices.Retention')}}</h7>
										</div>
										<div class="col-md-6" style="text-align:right !important;">
											<h5 id="retention_Invoice">0.00</h5>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<h7>{{trans('invoices.w_o_VAT')}}</h7>
										</div>
										<div class="col-md-6" style="text-align:right !important;">
											<h5 id="w_o_vat_Invoice">0.00</h5>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<h7>{{trans('invoices.VAT')}}</h7>
										</div>
										<div class="col-md-6" style="text-align:right !important;">
											<h5 id="vat_Invoice">0.00</h5>
										</div>
									</div>
									<hr>
									<div class="row">
										<div class="col-md-6">
											<h7>{{trans('invoices.Total')}}</h7>
										</div>
										<div class="col-md-6" style="text-align:right !important;">
											<h5 id="total_Invoice">0.00</h5>
											<input type="hidden" name="total_invoice_value">
<span style="display:none;" class="text-danger" id="alert_amount">Amount Can not be graeter than 1000€</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div style="text-align: right;">
						<button type="button" name="invoicebtn" id="invoice-draft" onclick="saveDraft()" class="save_draft mt-2 btn btn-warning" value="saveDraft">{{trans('invoices.save_draft')}}</button>
						<button type="button" name="invoicebtn" id="invoice-save" onclick="saveInvoice()" class="save_invoice mt-2 btn btn-primary" value="saveInvoice">{{trans('invoices.save_final')}}</button>
					</div>
				</div>
			</form>
			<!-- <div style="text-align: right;">
                <button type="submit" id="invoice-save" onclick="saveInvoice()" class="mt-2 btn btn-primary">Save</button>
          </div>	 -->
		</div>
	</div>
	</div>



@endsection
@section('javascript')
	<script type="text/javascript">
	var inv_type = {!! json_encode($inv_type) !!};
		$(document).click(function() {
			$('#ItemList').hide();
		});
	var f_list     = {!! json_encode($fee_list) !!};
	var user_default_fee_list    = {!! json_encode($user_default_fee_list) !!};
	var client_fee = {!! json_encode($client->default_fee) !!} 
		//Items Section
		$('#item_selector').click(function(e){
			var currency_selected = $('.currency').children("option:selected").val();
			if(currency_selected.length == 0){
				swal("Error!","Please select currency before adding items", "error");
				return false;
			}
			$('.item_button').slideUp();
			$('.open_item_selector').slideDown();

			$('.search_icon_item').css('display','block');
			var token = "{{ csrf_token() }}";
			var url = "{{route('item_list')}}";
			$.ajax({
				type: "GET",
				url: url,
				data: {_token:token},
				success: function(data) {
					var items = JSON.parse(data);
					get_fetched_items(items);
				}

			});
		});
		$('#items').click(function(e) {
			var items_count = $('.items').val();
			$('#ItemList').empty();
			if(!items_count){

				$("#ClientList").html('<span>Searching...</span>');
				$('.search_icon_item').css('display','block');
				var token = "{{ csrf_token() }}";
				var url = "{{route('item_list')}}";
				$.ajax({
					type: "POST",
					url: url,
					data: {_token:token},
					success: function(data) {
						var items = JSON.parse(data);
						get_fetched_items(items);
					}

				});

			}
		});
		function get_fetched_items(items = ''){
			if(items.length > 0){
				$('.search_icon_item').css('display','none');

				var output = '<ul class="dropdown-menu" style="display:block;width: 100%;">';
				for( var i=0 ; i< items.length ; i++){
					output += '<li class="get_item"><a style="font-weight: 600;" href="javascript:void(0)" id="get_item" class"get_selected_item" data-id="'+items[i].id+'">&nbsp;'+items[i].code+'</a></li>';
				}

				output += '</ul>';
				$('#ItemList').fadeIn();
				$('#ItemList').html(output);

				$('.get_item').click(function(e) {
					var item_id = $(this).find('a').attr('data-id');

					for( var i=0 ; i< items.length ; i++){
						if(items[i].id == item_id){

							var id = Math.floor(Math.random() * Math.floor(100000));
							var object = new Invoice(id) ;
							object.id = id;
							ArraysOfObjects.push(object);
							if(items[i].description == null){
								items[i].description = '';
							}
	                        var options="";
							
							for (let key in f_list) {

								console.log(key, f_list[key][0]);
								if(f_list[key][0] == client_fee)
								{
									options +=	"<option value='"+f_list[key][0]+"' selected>"+f_list[key][0]+' - '+f_list[key][1] +"</option>";
								}
								else
								{
									options +=	"<option value='"+f_list[key][0]+"' >"+f_list[key][0]+' - '+f_list[key][1] +"</option>";
								}
							}
						
							if(options == "")
							{
								console.log("from second one its calling");
								if(user_default_fee_list != "")
								{
									for (let key in user_default_fee_list) 
									{
										//console.log(key, f_list[key][0]);
										if(user_default_fee_list[key][0] == client_fee)
										{
											options +=	"<option value='"+user_default_fee_list[key][0]+"' selected>"+user_default_fee_list[key][0]+' - '+user_default_fee_list[key][1] +"</option>";
										}
										else
										{
											options +=	"<option value='"+user_default_fee_list[key][0]+"' >"+user_default_fee_list[key][0]+' - '+user_default_fee_list[key][1] +"</option>";
										}
									}
								}
							}
						
							var html = "<p>Hello Testing</p><tr class='line_item_row' id='line_item_row_"+id+"'>"+
									"<td><input type='text' name='line_item_code[]' id='line_item_code_"+id+"' class='form-control' value='"+items[i].code+"'></td>"+
									"<td><input type='text' name='line_item_description[]' id='line_item_description_"+id+"' class='form-control' value='"+items[i].description+"'></td>"+
									"<td><input type='number' name='line_item_unit_price[]' id='line_item_unit_price_"+id+"' class='form-control' onchange='recalculateLineItem("+id+")' value="+items[i].price+"></td>"+
									"<td><input type='number' name='line_item_qty[]' id='line_item_qty_"+id+"' class='form-control' value='1' onchange='recalculateLineItem("+id+")' value="+items[i].code+"></td>"+
									"<td>"+
									"<select  name='line_item_vat[]' id='line_item_vat_"+id+"' class='form-control' onchange='recalculateLineItem("+id+")'>"+options+
									//"<option value='23' "+check_tax_option(items[i].tax, 23)+">23,0% - IVA23</option>"+
									//"<option value='18' "+check_tax_option(items[i].tax, 18)+">18,0% - IVA18</option>"+
									//"<option value='22' "+check_tax_option(items[i].tax, 22)+">22,0% - IVA22</option>"+
									//"<option value='0' "+check_tax_option(items[i].tax, 0)+">0,0% - Isento</option"+
									"</select>"+
									"</td>"+
									"<td><input type='number' name='line_item_discount[]' id='line_item_discount_"+id+"' class='form-control' value='0' onchange='recalculateLineItem("+id+")' value="+items[i].rrp+"></td>"+
									"<td><a href='#'  onclick='deleteDynamicRow("+id+",event)'><i class='fa fa-trash' style='cursor: pointer;font-size: 22px'></i></a></td>"+
									"</tr>";
							$('.line_item_body').append(html);
	recalculateLineItem(id);
						}
					}
					$('.item_button').slideDown();
					$('.open_item_selector').hide();

				});

			}else{
			}
		}
		function check_tax_option(tax = '', option = ''){
			if(tax == option){
				return 'selected';
			}
		}
		$(document).on('keyup', '.search_items_live', function(){
			$('#ItemList').empty();
			var item = $(this).val();
			fetch_items(item);
		});
		function fetch_items(item = '')
		{

			var token = "{{ csrf_token() }}";
			$.ajax({
				url:"{{ route('items.live.search') }}",
				method:'POST',
				data:{item:item,_token:token},
				success:function(data)
				{
					var items = JSON.parse(data);
					get_fetched_items(items);
				}
			});
		}
		$('#brand').change(function(obj){
			var brand_id = $(this).val();
			CSRF_TOKEN   = "{{ csrf_token() }}";
			$('#brand_template').empty();
			$.ajax({
				type: "POST",
				url: "{{route('brands.show.templates')}}",
				data: {brand_id: brand_id, _token: CSRF_TOKEN},
				success: function(data){
					var templates = JSON.parse(data);
					$('#brand_template').append('<option value="" disabled selected>Select Brand Template</option>');
					counter = 1;
					for(var i=0; i < templates.length; i++){
						var template = templates[i];
						$('#brand_template').append('<option value="'+template.id+'">'+template.name+'</option>');
						counter++;
					}
				}
			});
		})
	</script>
@endsection