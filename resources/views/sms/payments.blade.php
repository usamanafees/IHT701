 @extends('partials.main')
 
@section('content')

<style>



.ui-datepicker-calendar{
	background-color : #fff;
	border:none !important;
	
	
	font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    font-size: .88rem !important;
    font-weight: 400 !important;
    line-height: 1.5 !important;
    color: #495057 !important;
    text-align: left !important;
}
.ui-widget-header{
	background-color : #fff !important;
	background : #fff !important;
	border : none !important;
	color : #333333 !important;
}
.ui-widget-content{
	background : #fff !important;
}
.ui-datepicker-calendar table{
	background : #fff !important;
}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active{
	color : #333333 !important;
	background-color : #fff !important;
	background : #fff !important;
	border: none !important;
}

.ui-datepicker td span,
.ui-datepicker td a{
	font-weight:300 !important;
}
.ui-datepicker-calendar thead tr th{
	font-weight:300 !important;
}
</style>
			<div class="app-main__outer">
                <div class="app-main__inner">
					<div class="breadcrumb mb-5" style="margin-top: -12px">
						<li>
							<i class="fa fa-home"></i>
							<a href="{{route('/')}}">{{trans('menu.home')}}</a>
							<i class="fa fa-angle-right">&nbsp;</i>
						</li>
						<li>
							<a >{{trans('menu.settings')}}</a>
							<i class="fa fa-angle-right">&nbsp;</i>
						</li>
						<li>
							<a class="breadcrumb-item active" href="">{{trans('menu.payments')}}</a>
						</li>
					</div>


                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-envelope-open-text icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('sms.add_payment')}} 	
                                </div>
                            </div>
                        </div>
						<br>
                          <div class="card-header-title font-size-sm font-weight-normal" style="float: left;color: grey;">
                         <i class="fas fa-info-circle"></i>
                            <h7> {{trans('tips.payments')}}</h7>
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body">
								@if ($errors->any())
									<div class="alert alert-danger">
										<ul>
											@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif
                            @if (\Session::has('responseCode'))
                                <div 
								@if(\Session::get('responseCode') == 200) 
									class="alert alert-success" 
								@else  
									class="alert alert-warning"
								@endif
								>
                                   <p>
                                      {!! \Session::get('message') !!}
                                   </p>
                                </div>
                            @endif
							
							<form class="form-horizontal" method="POST" action="{{ route('sms.addPayments') }}">
								{{ csrf_field() }}
						
						{{--<div class="form-row">
									<div class="col-md-6">
										<div class="position-relative form-group">
											<label for="" class="">{{trans('accounts.cid')}} <span style="color:red">*</span></label>
											<select  class="select2 form-control" name="client"  id="client" required>
													@foreach($clients as $client)
														@if(Auth()->user()->id == $client->id)
															<option value="{{$client->id}}" selected>{{$client->name}}</option>
														@endif
													@endforeach
											</select>
										</div>
									</div>
						</div>--}}
								<div class="form-row">
									<div class="col-md-2">
										<div class="position-relative form-group">
											<label for="" class="">{{trans('sms.payment_methods')}}<span style="color:red">*</span></label>
											<select  class="select2 form-control" name="type_of_movement"  id="type_of_movement" required>
												<option value="" selected disabled >{{trans('sms.select_type')}}</option>
													<option value="PC:PT">Multibanco</option>
													<option value="MW:PT">MB WAY</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-row mobile_number" style="display:none;">
									<div class="col-md-2">
										<div class="position-relative form-group">
											<label for="" class="">{{trans('sms.mobile_num')}}<span style="color:red">*</span></label>
											<input type="number" class="form-control" name="mobile_number"><br>
										</div>
									</div>
								</div>
							<div class="row" >
								<div class="form-row col-3" style="float:left">
									<div class="col-md-2" >
										<div class="position-relative form-group">
											<label for="" class="">{{trans('sms.value')}}<span style="color:red">*</span></label>
											<input type="number" class="form-control" style="width:180px;"   id="movement_value"  name="movement_value" required step="0.01" onkeyup="show_text(this.value)" ><br>
										</div>
									</div>
								</div>
								<div class="col-md-4  " style="float: left; text-align: left; padding-top:12px;;" >
										
									<p id="display_text" class="alert alert-success" style="display:none;border-radius:15px">
										&nbsp;
									</p>
								  
							   </div>

							</div>
		
								<div  style="text-align: right;">
                                        

									<button  type="submit" id="submit" class="mt-2 btn btn-success">{{trans('sms.insert')}}</button>
								</div>
							</form>
						</div>

						
						
                    </div>
                </div>                  
            </div>
			
@if(\Session::has('entidade'))
<div class="modal " id="myModalPayment"   style="margin-top:3%;" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" &times;>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" onclick="hide_model();" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="{{asset('admin/eupago_mbway.jpg')}}" style="max-width: 480px; margin-left:50px;"></img>
				<br>
                 <table style="width: 100%" cellpadding="3">
                    <tr>
                        <td class="boldTitle">Entidade</td>
                        <td>{!! \Session::get('entidade') !!}</td>
                    </tr>
                    <tr>
                        <td class="boldTitle">Referencia</td>
                        <td>{!! \Session::get('referencia') !!}</td>
                    </tr>
                    <tr>
                        <td class="boldTitle">Montante</td>
                        <td>{!! \Session::get('montante') !!}</td>
                    </tr> 
				</table>
				
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="hide_model();" >Close</button>
            </div>
        </div>
    </div>
</div>
@endif			
@endsection



@section('javascript')

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script>
$("#type_of_movement").change(function(){
	if($('option:selected', this).val() === "PC:PT"){
		$(".mobile_number").css('display','none');
	}else{
		$(".mobile_number").css('display','block');
	}	
});
function show_text(val)
{
if(val != ""){
tax_p ={{$tax_p->tax}}
tax = (val/((tax_p/100)+1));
tax1=  tax.toFixed(2);
final_value = val - tax;
final_value1=final_value.toFixed(2);
tax2=tax1.replace(".",",");
final_value2 =final_value1.replace(".",",");
$("#display_text").css('display','block');
$("#display_text").html("Sujeição ao imposto IVA/VAT ("+tax_p+"%) : "+ final_value2 +" €</br>Valor a Creditar : "+tax2+" € <hr/> Total a pagar : "+val+" €"
);
}else
{
	$("#display_text").hide();
	//$("#display_text").html("");
}

}
</script>

@if(\Session::has('entidade'))
<script>
$(document).ready(function(){
	
	console.log("working");
	$("#myModalPayment").toggle();
	// $("#myModalPayment").modal('toggle');

	$("body").on("click", ".modal", function(e) {
        if ($(e.target).hasClass('modal')) {
            hide_model();
        }
    });



});

function hide_model()
{
	$(document).ready(function(){
	$("#myModalPayment").toggle();	
});
}



</script>
@endif
@endsection

