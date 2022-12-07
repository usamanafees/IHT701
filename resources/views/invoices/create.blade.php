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
			recalculateLineItem(id);
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

		function culateLineItem(id){
			console.log(id);
		}

		// setInterval(function() {
		// 		 ObserveInputValue(id);
		// 		}, 100);

		// function ObserveInputValue(id){
		// 	// console.log(id);
		// }
		// console.log($('.item_row_detect').attr('data-id'));

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

				Vat = parseFloat(Vat) + ((value.line_item_total - line_item_discount_calc) * (value.line_item_vat/100));

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
					$('#invoice-save').prop("disabled", false);
					$('#invoice-draft').prop("disabled", false);
				}
			}
			$('input[name=total_invoice_value]').val(thousands_separators(Total.toFixed(2)));
		}
		saveInvoice = function (){
			var client_id = $('input[name=client_id]').val();
			var client_vat_number = $('input[name=vat_number]').val();
			 var client_name= $('input[name=name]').val();
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


			$(".invoice-form").append("<input type='hidden' value='"+JSON.stringify(ArraysOfObjects)+"' name='ArraysOfObjects'>");

			if(((client_id != '') || (client_vat_number != '' && client_name != '')) && (ArraysOfObjects.length != 0)){
					$('.save_invoice').attr('type','submit');
				}
		}

		saveDraft = function (){
			var client_id = $('input[name=client_id]').val();
			if(client_id == ''){
				$('.error_area').css('display','block');
				$('#client_error_top').css('display','block');
				$('.client_error').css('border','1px solid #ba4a48');
				$("html, body").animate({ scrollTop: 0 }, "slow");
			}
			if(ArraysOfObjects.length == 0){
				$('.error_area').css('display','block');
				$('#item_error_top').css('display','block');
				$("html, body").animate({ scrollTop: 0 }, "slow");
			}


			$(".invoice-form").append("<input type='hidden' value='"+JSON.stringify(ArraysOfObjects)+"' name='ArraysOfObjects'>");

			if(client_id != '' && ArraysOfObjects.length != 0){
				$('.save_draft').attr('type','submit');
			}
		}
	</script>
	<div class="app-main__outer">
		<div class="app-main__inner">
			<div class="breadcrumb mb-5" style="margin-top: -12px">
				<li>
					<i class="fa fa-home"></i>
					<a href="{{route('/')}}">{{trans('menu.home')}}</a>
					<i class="fa fa-angle-right">&nbsp;</i>
				</li>
				<li>
					<a href="{{route('invoices.home')}}">{{trans('menu.invoicing')}}</a>
					<i class="fa fa-angle-right">&nbsp;</i>
				</li>
				<li>
					<a href="{{route('invoices')}}">{{trans('menu.invoices')}}</a>
					<i class="fa fa-angle-right">&nbsp;</i>
				</li>
				<li>
					<a class="breadcrumb-item active" href="">

						@if ($inv_type == "receipt")
							{{trans('invoices.add_invoice_receipt')}}
						@elseif ($inv_type == "simplified")
							{{trans('invoices.add_simplified_invoice')}}
						@else
							{{trans('invoices.add_invoices')}}
						@endif

					</a>
				</li>
			</div>

			<div class="app-page-title">
				<div class="page-title-wrapper">
					<div class="page-title-heading">
						<div class="page-title-icon">
							<i class="fas fa-file icon-gradient bg-tempting-azure">
							</i>
						</div>						
						
						@if ($inv_type == "receipt")
						<div>{{trans('invoices.add_invoice_receipt')}}</div>
						@elseif ($inv_type == "simplified")
							<div>{{trans('invoices.add_simplified_invoice')}}</div>
						@else
						<div>{{trans('invoices.add_invoices')}}</div>
						@endif
					</div>
				</div><br>
                          <div class="card-header-title font-size-sm font-weight-normal" style="float: left;">
                         <i class="fas fa-info-circle"></i>
                            <h7> {{trans('tips.add_invoice')}}</h7>
                        </div>
			</div>

			<div class="main-card mb-3 card">
			<!-- method="POST" action="{{route('invoices.createNewInvoiceAJAX')}}" -->
				<form class="invoice-form" method="POST" action="{{route('invoices.createNewInvoiceAJAX')}}">
					<!-- //Client Section -->
					<input type="hidden" name="inv_type" value="{{ $inv_type }}">
					{{csrf_field()}}
					<div class="main-card mb-3 card">
						<div class="card-body error_area" style="display:none; background-color: #f2dede">
							<div style="text-align: left;color: #ba4a48;">
								<h4>{{trans('invoices.warning')}}!</h4>
								<ul>
									<li style="display: none;" id="client_error_top">
										<i class="fas fa-dot-circle 1x"></i>
										{{trans('invoices.warning_item_select')}}</li>
									<li style="display: none;" id="item_error_top">
										<i class="fas fa-dot-circle 1x"></i>
										{{trans('invoices.warning_client_select')}}</li>
								</ul>
							</div>
						</div>
						<div class="card-body" style="background-color: #f5f7f8;">
							<h2><b>
									@if($inv_type == "receipt")
								{{trans('invoices.add_invoice_receipt_btn')}}
									@elseif($inv_type == "simplified")
										{{trans('invoices.add_simplified_invoice_btn')}}
								@else
										{{trans('invoices.add_invoice_btn')}}

								@endif
								</b></h2>
							<div style="text-align: right;">
								<h8>{{trans('invoices.Required_Fields')}}<font color="red">*</font></h8>
							</div>
						</div>
						@if(Session::has('success'))
							<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<strong>{{trans('invoices.sucess')}}!</strong> {{ Session::get('message', '') }}
							</div>
						@endif
						@if(Session::has('error'))
							<div class="alert alert-error">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								<strong style="color:red">{{trans('invoices.error')}}!</strong> {{ Session::get('message', '') }}
							</div>
						@endif
						<div class="card-body search_area" style="background-color: #f5f7f8;">
							<div class="col-md-12 ">
		                        <span>{{trans('invoices.search_client_invoices')}}
		                        </span>
								<div class="input-group">
									<input type="text" name="clients" id="clients" class="client_error search clients form-control" placeholder="{{trans('invoices.find_or_create')}}" autocomplete="false"
										   autofocus="false" >
									<div class="input-group-addon search_icon" style="margin-top: -1%;display: none;">
										<i class="fas fa-spinner fa-spin fa-2x"></i>
									</div>
								</div>
								<p id="select_client" style="display: none; color: red">{{trans('invoices.pls_select_client')}}.</p>
								<div id="ClientList" style="position: relative;">
								</div>
							</div>
						</div>
						<div class="card-body client_area" style="display: none;">
							<div class="col-md-12 ">
								<h3>{{trans('invoices.client_data')}}</h3>
								<hr>
								<div class="form-row">
									<div class="col-md-6">
										<div class="position-relative form-group">
											<label for="" class="">{{trans('invoices.name')}}</label>
											<input name="name" id="name" placeholder="Name, Company name" type="text" class="form-control" >
										</div>
									</div>
									<div class="col-md-6">
										<div class="position-relative form-group">
											<label for="" class="">{{trans('invoices.Vat_Number')}}</label>
											<input name="vat_number" id="vat_number" placeholder="VAT number for invoices" type="text" class="form-control" >
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-6">
										<div class="position-relative form-group">
											<label for="" class="">{{trans('invoices.country')}}</label>
											<input name="country" id="country" placeholder="Country of company" type="text" class="form-control" >
										</div>
									</div>
									<div class="col-md-6">
										<div class="position-relative form-group">
											<label for="" class="">{{trans('invoices.address')}}</label>
											<input name="address" id="address" placeholder="Address of company" type="text" class="form-control" >
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-6">
										<div class="position-relative form-group">
											<label for="" class="">{{trans('invoices.city')}}</label>
											<input name="city" id="city" placeholder="City of company" type="text" class="form-control" >
										</div>
									</div>
									<div class="col-md-6">
										<div class="position-relative form-group">
											<label for="" class="">{{trans('invoices.postal-code')}}</label>
											<input name="postal_code" id="postal_code" placeholder="Postal code of company" type="text" class="form-control" >
										</div>
									</div>
								</div>
								<input name="client_id" id="client_id" type="hidden">
								<div class="form-row">
									<div class="col-md-12" style="text-align: right">
										<a href="javascript:void(0)" id="show_Search_area">
											{{trans('invoices.remove_client')}}</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body">

						<h3>{{trans('invoices.Document_Details')}}</h3>
						<hr>

						<div class="form-row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-2">
									
									<div class="position-relative form-group"><label for="invoice_date" class="">
									{{-- {{ $inv_type == "receipt" ? 'Invoice Receipt Date' : $inv_type == "futura" ? 'futura simplificada date':trans('invoices.Invoice_Date')}} --}}
									{{trans('invoices.Invoice_Date')}}
									</label></div>
									</div>
									<div class="col-md-10">
										<div class="input-group mb-3">
											<input type="text" class="form-control" data-toggle="datepicker-button" id="invoice_date"
												   name="invoice_date" >
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
										<div class="position-relative form-group"><textarea name="invoice_remarks" id="invoice_remarks"  class="form-control" >
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
											<select class="form-control-sm form-control" name="invoice_due" id="invoice_due" >
												<option value="" selected disabled>{{trans('invoices.Select_Due')}}</option>
												<option value="Immediately">Immediately</option>
												<option value="15">15</option>
												<option value="30">30</option>
												<option value="45">45</option>
												<option value="90">90</option>
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
										<div class="position-relative form-group"><input name="invoice_po" id="invoice_po"  class="form-control" type="number" >
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
											<select class="form-control-sm form-control" id="invoice_sequence" >
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
										<div class="position-relative form-group"><input name="invoice_retention" id="invoice_retention"  class="form-control" onkeyup="check_less_than_0(this)" type="number" min="1">
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="col-md-6">
								<div class="row">
									<div class="col-md-2">
										<div class="position-relative form-group">
											<label for="invoice_currency" class="">{{trans('invoices.Currency')}}</label>
										</div>
									</div>
									<div class="col-md-10">
										<div class="input-group mb-3">
											<select class="form-control-sm form-control currency" id="invoice_currency"  name="invoice_currency">
												<option value=""  disabled>Select Currency</option>
												<option value="EUR_€" selected>Euro (€)</option>
												<option value="USD_$">U.S. dollar ($)</option>
												<option value="GBP_£">Pound sterling (£)</option>
												<option value="CAD_C$">Canadian dollar (C$)</option>
												<option value="AUD_A$">Australian dollar (A$)</option>
												<option value="ZAR_R">South African rand (R)</option>
												<option value="AFN_؋">Afghan afghani (؋)</option>
												<option value="ALL_L">Albanian lek (L)</option>
												<option value="DZD_د.ج">Algerian dinar (د.ج)</option>
												<option value="AOA_Kz">Angolan kwanza (Kz)</option>
												<option value="ARS_$">Argentine peso ($)</option>
												<option value="AMD_դր.">Armenian dram (դր.)</option>
												<option value="AWG_ƒ">Aruban florin (ƒ)</option>
												<option value="AZN_¤">Azerbaijani manat (¤)</option>
												<option value="BSD_$">Bahamian dollar ($)</option>
												<option value="BHD_ب.د">Bahraini dinar (ب.د)</option>
												<option value="BDT_¤">Bangladeshi taka (¤)</option>
												<option value="BBD_$">Barbadian dollar ($)</option>
												<option value="BYR_Br">Belarusian ruble (Br)</option>
												<option value="BZD_$">Belize dollar ($)</option>
												<option value="BMD_$">Bermudian dollar ($)</option>
												<option value="BTN_¤">Bhutanese ngultrum (¤)</option>
												<option value="BOB_Bs.">Bolivian boliviano (Bs.)</option>
												<option value="BAM_KM">Bosnia &amp; Herzegovina mark (KM)</option>
												<option value="BWP_P">Botswana pula (P)</option>
												<option value="BRL_R$">Brazilian real (R$)</option>
												<option value="BND_$">Brunei dollar ($)</option>
												<option value="BGN_лв">Bulgarian lev (лв)</option>
												<option value="BIF_Fr">Burundian franc (Fr)</option>
												<option value="KHR_¤">Cambodian riel (¤)</option>
												<option value="CVE_Esc">Cape Verdean escudo (Esc)</option>
												<option value="KYD_$">Cayman Islands dollar ($)</option>
												<option value="XAF_Fr">Central African CFA franc (Fr)</option>
												<option value="XPF_Fr">CFP franc (Fr)</option>
												<option value="CLP_$">Chilean peso ($)</option>
												<option value="CNY_¥">Chinese yuan (¥)</option>
												<option value="COP_$">Colombian peso ($)</option>
												<option value="KMF_Fr">Comorian franc (Fr)</option>
												<option value="CDF_Fr">Congolese franc (Fr)</option>
												<option value="CRC_₡">Costa Rican colón (₡)</option>
												<option value="HRK_kn">Croatian kuna (kn)</option>
												<option value="CUC_$">Cuban convertible peso ($)</option>
												<option value="CUP_$">Cuban peso ($)</option>
												<option value="CZK_Kč">Czech koruna (Kč)</option>
												<option value="DKK_kr.">Danish krone (kr.)</option>
												<option value="DJF_Fr">Djiboutian franc (Fr)</option>
												<option value="DOP_$">Dominican peso ($)</option>
												<option value="XCD_$">East Caribbean dollar ($)</option>
												<option value="EGP_ج.م">Egyptian pound (ج.م)</option>
												<option value="ERN_Nfk">Eritrean nakfa (Nfk)</option>
												<option value="EEK_KR">Estonian kroon (KR)</option>
												<option value="ETB_¤">Ethiopian birr (¤)</option>
												<option value="FKP_£">Falkland Islands pound (£)</option>
												<option value="FJD_$">Fijian dollar ($)</option>
												<option value="GMD_D">Gambian dalasi (D)</option>
												<option value="GEL_ლ">Georgian lari (ლ)</option>
												<option value="GHS_₵">Ghanaian cedi (₵)</option>
												<option value="GIP_£">Gibraltar pound (£)</option>
												<option value="GTQ_Q">Guatemalan quetzal (Q)</option>
												<option value="GNF_Fr">Guinean franc (Fr)</option>
												<option value="GYD_$">Guyanese dollar ($)</option>
												<option value="HTG_G">Haitian gourde (G)</option>
												<option value="HNL_L">Honduran lempira (L)</option>
												<option value="HKD_$">Hong Kong dollar ($)</option>
												<option value="HUF_Ft">Hungarian forint (Ft)</option>
												<option value="ISK_kr">Icelandic króna (kr)</option>
												<option value="INR_Rs">Indian rupee (Rs)</option>
												<option value="IDR_Rp">Indonesian rupiah (Rp)</option>
												<option value="IRR_﷼">Iranian rial (﷼)</option>
												<option value="IQD_ع.د">Iraqi dinar (ع.د)</option>
												<option value="ILS_₪">Israeli new sheqel (₪)</option>
												<option value="JMD_$">Jamaican dollar ($)</option>
												<option value="JPY_¥">Japanese yen (¥)</option>
												<option value="JOD_د.ا">Jordanian dinar (د.ا)</option>
												<option value="KZT_〒">Kazakhstani tenge (〒)</option>
												<option value="KES_Sh">Kenyan shilling (Sh)</option>
												<option value="KWD_د.ك">Kuwaiti dinar (د.ك)</option>
												<option value="KGS_¤">Kyrgyzstani som (¤)</option>
												<option value="LAK_₭">Lao kip (₭)</option>
												<option value="LVL_Ls">Latvian lats (Ls)</option>
												<option value="LBP_ل.ل">Lebanese pound (ل.ل)</option>
												<option value="LSL_L">Lesotho loti (L)</option>
												<option value="LRD_$">Liberian dollar ($)</option>
												<option value="LYD_ل.د">Libyan dinar (ل.د)</option>
												<option value="LTL_Lt">Lithuanian litas (Lt)</option>
												<option value="MOP_P">Macanese pataca (P)</option>
												<option value="MKD_ден">Macedonian denar (ден)</option>
												<option value="MGA_¤">Malagasy ariary (¤)</option>
												<option value="MWK_MK">Malawian kwacha (MK)</option>
												<option value="MYR_RM">Malaysian ringgit (RM)</option>
												<option value="MVR_Rf">Maldivian rufiyaa (Rf)</option>
												<option value="MRO_UM">Mauritanian ouguiya (UM)</option>
												<option value="MUR_₨">Mauritian rupee (₨)</option>
												<option value="MXN_$">Mexican peso ($)</option>
												<option value="MDL_L">Moldovan leu (L)</option>
												<option value="MNT_₮">Mongolian tögrög (₮)</option>
												<option value="MAD_MAD">Moroccan dirham (MAD)</option>
												<option value="MZN_MZN">Mozambican metical (MZN)</option>
												<option value="MMK_K">Myanma kyat (K)</option>
												<option value="NAD_$">Namibian dollar ($)</option>
												<option value="NPR_₨">Nepalese rupee (₨)</option>
												<option value="ANG_ƒ">Netherlands Antillean guilder (ƒ)</option>
												<option value="TWD_$">New Taiwan dollar ($)</option>
												<option value="NZD_$">New Zealand dollar ($)</option>
												<option value="NIO_C$">Nicaraguan córdoba (C$)</option>
												<option value="NGN_₦">Nigerian naira (₦)</option>
												<option value="KPW_₩">North Korean won (₩)</option>
												<option value="NOK_kr">Norwegian krone (kr)</option>
												<option value="OMR_ر.ع.">Omani rial (ر.ع.)</option>
												<option value="PKR_₨">Pakistani rupee (₨)</option>
												<option value="PAB_B/.">Panamanian balboa (B/.)</option>
												<option value="PGK_K">Papua New Guinean kina (K)</option>
												<option value="PYG_₲">Paraguayan guaraní (₲)</option>
												<option value="PEN_S/.">Peruvian nuevo sol (S/.)</option>
												<option value="PHP_₱">Philippine peso (₱)</option>
												<option value="PLN_zł">Polish złoty (zł)</option>
												<option value="QAR_ر.ق">Qatari riyal (ر.ق)</option>
												<option value="RON_L">Romanian leu (L)</option>
												<option value="RUB_р.">Russian ruble (р.)</option>
												<option value="RWF_Fr">Rwandan franc (Fr)</option>
												<option value="SHP_£">Saint Helena pound (£)</option>
												<option value="SVC_₡">Salvadoran colón (₡)</option>
												<option value="WST_T">Samoan tala (T)</option>
												<option value="STD_Db">São Tomé and Príncipe dobra (Db)</option>
												<option value="SAR_ر.س">Saudi riyal (ر.س)</option>
												<option value="RSD_дин.">Serbian dinar (дин.)</option>
												<option value="SCR_₨">Seychellois rupee (₨)</option>
												<option value="SLL_Le">Sierra Leonean leone (Le)</option>
												<option value="SGD_$">Singapore dollar ($)</option>
												<option value="SBD_$">Solomon Islands dollar ($)</option>
												<option value="SOS_Sh">Somali shilling (Sh)</option>
												<option value="KRW_₩">South Korean won (₩)</option>
												<option value="LKR_Rs">Sri Lankan rupee (Rs)</option>
												<option value="SDG_£">Sudanese pound (£)</option>
												<option value="SRD_$">Surinamese dollar ($)</option>
												<option value="SZL_L">Swazi lilangeni (L)</option>
												<option value="SEK_kr">Swedish krona (kr)</option>
												<option value="CHF_Fr">Swiss franc (Fr)</option>
												<option value="SYP_ل.س">Syrian pound (ل.س)</option>
												<option value="TJS_ЅМ">Tajikistani somoni (ЅМ)</option>
												<option value="TZS_Sh">Tanzanian shilling (Sh)</option>
												<option value="THB_฿">Thai baht (฿)</option>
												<option value="TOP_T$">Tongan paʻanga (T$)</option>
												<option value="TTD_$">Trinidad and Tobago dollar ($)</option>
												<option value="TND_د.ت">Tunisian dinar (د.ت)</option>
												<option value="TRY_TL">Turkish lira (TL)</option>
												<option value="TMM_m">Turkmenistani manat (m)</option>
												<option value="UGX_Sh">Ugandan shilling (Sh)</option>
												<option value="UAH_₴">Ukrainian hryvnia (₴)</option>
												<option value="AED_د.إ">United Arab Emirates dirham (د.إ)</option>
												<option value="UYU_$">Uruguayan peso ($)</option>
												<option value="UZS_¤">Uzbekistani som (¤)</option>
												<option value="VUV_Vt">Vanuatu vatu (Vt)</option>
												<option value="VEF_Bs F">Venezuelan bolívar (Bs F)</option>
												<option value="VND_₫">Vietnamese đồng (₫)</option>
												<option value="XOF_Fr">West African CFA franc (Fr)</option>
												<option value="YER_﷼">Yemeni rial (﷼)</option>
												<option value="ZMK_ZK">Zambian kwacha (ZK)</option>
												<option value="ZWR_$">Zimbabwean dollar ($)</option>
												<option value="XDR_SDR">Special Drawing Rights (SDR)</option>
												<option value="TMT_m">Turkmen manat (m)</option>
												<option value="VEB_Bs">Venezuelan bolivar (Bs)</option>
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
										<div class="input-group mb-3" id="vat_exemption">
											<select name="invoice_tax_exemption_reason" class="form-control-sm form-control" id="invoice_tax_exemption_reason" >
												<option value="" selected disabled>Select Tax Exemption Reason</option>
												<option value="M09">IVA ‐ não confere direito a dedução.</option>
												<option value="M08">IVA – autoliquidação.</option>
												<option value="M07">Isento Artigo 9º do CIVA.</option>
												<option value="M06">Isento Artigo 15º do CIVA.</option>
												<option value="M05">Isento Artigo 14º do CIVA.</option>
												<option value="M04">Isento Artigo 13º do CIVA.</option>
												<option value="M03">Exigibilidade de caixa.</option>
												<option value="M02">Artigo 6º do Decreto‐Lei nº 198/90, de 19 de Junho.</option>
												<option value="M01">Artigo 16º nº 6 do CIVA.</option>
												<option value="M16">Isento Artigo 14º do RITI.</option>
												<option value="M15">Regime da margem de lucro–Objetos de coleção e antiguidades.</option>
												<option value="M14">Regime da margem de lucro – Objetos de arte.</option>
												<option value="M13">Regime da margem de lucro – Bens em segunda mão.</option>
												<option value="M12">Regime da margem de lucro – Agências de viagens.</option>
												<option value="M11">Regime particular do tabaco.</option>
												<option value="M10">IVA – Regime de isenção.</option>
												<option value="M99">Não sujeito; não tributado (ou similar).</option>
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
											<select class="form-control-sm form-control" id="brand" name="brands_id" >
												<option value="" disabled selected>Select Brand</option>
												@foreach($brands as $brand)
													<option value="{{$brand->id}}"
														@if (Auth::user()->default_brand == $brand->id)
															selected
														@endif
														>{{$brand->name}}</option>
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
											<select class="form-control-sm form-control" name="brand_templates_id" id="brand_template" >

											</select>
										</div>
									</div>
								</div>
							</div>
						</div>

						<h3>{{trans('invoices.Items')}}<span style="color:red;">*</span></h3>
						<hr>


						<table class="mb-0 table">
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

							</tbody>

						</table>
						<!-- <div class="add-another-text">
										   <a id="addAnotherLine" onclick="addAnotherLine(event)" href="#"><i class="fa fa-plus"></i> Add line item</a>
						</div> -->
						<div class="main-card mb-3 card">
							<div class="card-body" style="background-color: #f5f7f8;">
								<div class="col-md-12 ">
									<div class="row">
										<div class="col-12 item_button" style="text-align: right;">
											{{trans('invoices.Search_for_an_existing_items')}}
											<a type="button" class="mt-2 btn btn-success item_selector" id="item_selector"><i class="fa fa-plus"></i></a>
										</div>
									</div>
								</div>
								<div class="col-md-12 open_item_selector" style=" display: none;">
									<div class="input-group">
										<input type="text" name="clients" id="items" class="search_items_live items form-control" placeholder="{{trans('invoices.find_items')}}" autocomplete="false">
										<div class="input-group-addon search_icon_item" style="margin-top: -1%;display: none;">
											<i class="fas fa-spinner fa-spin fa-2x"></i>
										</div>
									</div>
									<p id="select_client" style="display: none; color: red">{{trans('invoices.warning_item_select')}}.</p>
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
												<input type="hidden" name="total_invoice_value" id="total_invoice_value"  value="">
												<span style="display:none;" class="text-danger" id="alert_amount">{{trans('invoices.warning_amount')}} 1000€</span>											<input type="hidden" name="total_invoice_value">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						</br>

				</form>
				<div style="text-align: right;">
					<button type="button" name="invoicebtn" id="invoice-draft" onclick="saveDraft()" class="save_draft mt-2 btn btn-warning" value="saveDraft">{{trans('invoices.save_draft')}}</button>
					<button type="button" name="invoicebtn" id="invoice-save" onclick="saveInvoice()" class="save_invoice mt-2 btn btn-primary" value="saveInvoice">{{trans('invoices.create_final_invoice')}}</button>
				</div>
			</div>

		</div>
	</div>
	</div>



@endsection
@section('javascript')
	<script type="text/javascript">



		var inv_type = {!! json_encode($inv_type) !!};
		var default_user_fee  = {!! json_encode($fee_list) !!};
		var user_default_template  = {!! json_encode(Auth::user()->default_template) !!};
		var clients_fee_list =[];
		var client_default_fee ="";

		$(document).click(function() {
			$("#ClientList").hide();
			$('#ItemList').hide();
		});

	function check_less_than_0()
	{
		if($('#invoice_retention').val() <= 0 || ($('#invoice_retention').val() == '')){
		$('#invoice_retention').val("");
		}
	}
		
		//Clients Section
		$('#clients').click(function(e) {
			var clients_count = $('.clients').val();

			if(!clients_count){

				$("#ClientList").html('<span>Searching...</span>');
				$('.search_icon').css('display','block');
				var token = "{{ csrf_token() }}";
				var url = "{{route('client_list')}}";
				$.ajax({
					type: "POST",
					url: url,
					data: {_token:token},
					success: function(data) {
						var clients = JSON.parse(data);
						get_fetched_clients(clients);
					}

				});

			}
		});
		$('#show_Search_area').click(function() {
			$('input[name=client_id]').val('');
			$("#invoice_tax_exemption_reason").val('');
			$('.client_area').hide();
			$('.search_area').fadeIn();
		});
		$(document).on('keyup', '.search', function(){
			$('#select_client').css('display','none');
			$('.client_error').css('border','1px solid #85f0bd');

			$('#ClientList').empty();
			var client = $(this).val();
			fetch_clients(client);
		});
		function fetch_clients(client = '')
		{

			var token = "{{ csrf_token() }}";

			$.ajax({
				url:"{{ route('client.live.search') }}",
				method:'POST',
				data:{client:client,_token:token},
				success:function(data)
				{
					var clients = JSON.parse(data);
					get_fetched_clients(clients);
				}
			});
		}
		function get_fetched_clients(clients = ''){
			if(clients.length > 0){
				$('.search_icon').css('display','none');
				$("#ClientList").empty();
				var output = '<ul class="dropdown-menu" style="display:block;width: 100%;">';
				for( var i=0 ; i< clients.length ; i++){
					output += '<li class="get_client"><a style="font-weight: 600;" href="javascript:void(0)" id="get_client" class"get_selected_client" data-id="'+clients[i].id+'">&nbsp;'+clients[i].name+'</a></li>';
				}
				output += '</ul>';
				$('#ClientList').fadeIn();
				$('#ClientList').html(output);

				$('.get_client').click(function(e) {
					var client_id = $(this).find('a').attr('data-id');

					reset_client_data();
					$("#invoice_tax_exemption_reason").val('');

					for( var i=0 ; i< clients.length ; i++){
						if(clients[i].id == client_id){
							get_client_fee_list(clients[i].user_id,clients[i].default_fee);
							$('input[name=name]').attr('value',clients[i].name);
							$('input[name=vat_number]').attr('value',clients[i].vat_number);
							$('input[name=country]').attr('value',clients[i].country);
							$('input[name=address]').attr('value',clients[i].address);
							$('input[name=city]').attr('value',clients[i].city);
							$('input[name=postal_code]').attr('value',clients[i].postal_code);
							$('input[name=client_id]').attr('value',clients[i].id);
							$("#invoice_tax_exemption_reason").val(clients[i].vat_exemption);
							$('input[name=name]').attr('disabled','true');
							$('input[name=vat_number]').attr('disabled','true');
							$('input[name=country]').attr('disabled','true');
							$('input[name=address]').attr('disabled','true');
							$('input[name=city]').attr('disabled','true');
							$('input[name=postal_code]').attr('disabled','true');
						}
					}



					$('.client_area').slideDown();
					$('.search_area').hide();

				});

			}else{

				$('.search_icon').css('display','none');

				var client_name = $('.clients').val();
				if(!client_name){
					var output = '<a href="javascript:void(0)" id="create_client"><u>Not Found. Create Client...</u></a>';
				}else{
					var output = 'Create<a href="javascript:void(0)" id="create_client"> <u>'+client_name +'</u></a>';
				}

				$('#ClientList').fadeIn();
				$('#ClientList').html(output);

				$('#create_client').click(function() {

					reset_client_data();

					$('input[name=name]').prop("disabled", false);
					$('input[name=vat_number]').prop("disabled", false);
					$('input[name=country]').prop("disabled", false);
					$('input[name=address]').prop("disabled", false);
					$('input[name=city]').prop("disabled", false);
					$('input[name=postal_code]').prop("disabled", false);

					var client_name = $('.clients').val();
					$('input[name=name]').attr('value',client_name);

					$('.client_area').slideDown();
					$('.search_area').hide();
				});
			}
		}
		function reset_client_data(){
			$('input[name=name]').attr('value','');
			$('input[name=vat_number]').attr('value','');
			$('input[name=country]').attr('value','');
			$('input[name=address]').attr('value','');
			$('input[name=city]').attr('value','');
			$('input[name=postal_code]').attr('value','');
			$('input[name=client_id]').attr('value','');
		}

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

							if(clients_fee_list !="")
							{
								for (let key in clients_fee_list) {

									if(client_default_fee == clients_fee_list[key][1])
									{
										options +=	"<option value='"+clients_fee_list[key][0]+"' selected>"+clients_fee_list[key][0]+' - '+clients_fee_list[key][1] +"</option>";

									}else
									{
										options +=	"<option value='"+clients_fee_list[key][0]+"' >"+clients_fee_list[key][0]+' - '+clients_fee_list[key][1] +"</option>";
									}
								}
							}
							
							if(options == "")
							{
								if(default_user_fee  != "")
								{
									for (let key in default_user_fee) {
										
										if(default_user_fee == default_user_fee[key][0])
										{
											options +=	"<option value='"+default_user_fee[key][0]+"' selected>"+default_user_fee[key][0]+' - '+default_user_fee[key][1] +"</option>";

										}else
										{
											options +=	"<option value='"+default_user_fee[key][0]+"' >"+default_user_fee[key][0]+' - '+default_user_fee[key][1] +"</option>";
										}
									}
								}
							}

							var html = "<tr data-id="+id+" class='item_row_detect line_item_row' id='line_item_row_"+id+"'>"+
									"<input type='hidden' name='idd[]' id='idd"+id+"' class='form-control' value='"+items[i].id+"' >"+
									"<td><input type='text' name='line_item_code[]' id='line_item_code_"+id+"' class='form-control' value='"+items[i].code+"'></td>"+

									"<td><input type='text' name='line_item_description[]' id='line_item_description_"+id+"' class='form-control' value='"+items[i].description+"'></td>"+

									"<td><input type='number' name='line_item_unit_price[]' id='line_item_unit_price_"+id+"' class='input_qty form-control'  onchange='recalculateLineItem("+id+")' value="+items[i].price+"></td>"+

									"<td><input type='number' name='line_item_qty[]' id='line_item_qty_"+id+"' class='form-control ' value='1' onchange='recalculateLineItem("+id+")' oninput='culateLineItem("+id+")'></td>"+
									"<td>"+

									"<select  name='line_item_vat[]' id='line_item_vat_"+id+"' class='form-control' onchange='recalculateLineItem("+id+")'>"+options+
									// "<option value='23' "+check_tax_option(items[i].tax, 23)+">23,0% - IVA23</option>"+
									// "<option value='18' "+check_tax_option(items[i].tax, 18)+">18,0% - IVA18</option>"+
									// "<option value='22' "+check_tax_option(items[i].tax, 22)+">22,0% - IVA22</option>"+
									// "<option value='0' "+check_tax_option(items[i].tax, 0)+">0,0% - Isento</option"+
									"</select>"+
									"</td>"+
									"<td><input type='number' name='line_item_discount[]' id='line_item_discount_"+id+"' class='form-control' value='0' onchange='recalculateLineItem("+id+")' value="+items[i].rrp+"></td>"+
									"<td><a href='#'  onclick='deleteDynamicRow("+id+",event)'><i class='fa fa-trash' style='cursor: pointer;font-size: 22px'></i></a></td>"+
									"</tr>";
							$('.line_item_body').append(html);
							recalculateLineItem(object.id);
						}
					}
					$('.item_button').slideDown();
					$('.open_item_selector').hide();

				});

			}else{
			}
		}
		function get_client_fee_list(id,default_fee)
		{
			var token = "{{ csrf_token() }}";
			var url = "{{route('get_client_fee_list')}}";
			$.ajax({
				type: "POST",
				url: url,
				data: {_token:token,cl_id:id},
				success: function(data) {
					clients_fee_list = JSON.parse(data);
					client_default_fee = default_fee;
					//get_fetched_items(items);
				}
			});
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
						if(template.id != user_default_template)
						{
							$('#brand_template').append('<option value="'+template.id+'">'+template.name+'</option>');
						}
						if(template.id == user_default_template)
						{
							$('#brand_template').append('<option value="'+template.id+'" selected>'+template.name+'</option>');
						}
						counter++;
					}
				}
			});
		})
		first_brand_cehck();
		function first_brand_cehck()
		{
			var brand_id = $('#brand').val();
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
						if(template.id != user_default_template)
						{
							$('#brand_template').append('<option value="'+template.id+'">'+template.name+'</option>');
						}
						if(template.id == user_default_template)
						{
							$('#brand_template').append('<option value="'+template.id+'" selected>'+template.name+'</option>');
						}
						counter++;
					}
				}
			});
		}
	</script>
@endsection