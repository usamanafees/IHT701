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
							<a>{{trans('menu.admin')}}</a>
							<i class="fa fa-angle-right">&nbsp;</i>
						</li>
						<li>
							<a> {{trans('menu.balance_movements')}}</a>
							<i class="fa fa-angle-right">&nbsp;</i>
						</li>
						<li>
							<a class="breadcrumb-item active" href="">{{trans('menu.create_movements')}}</a>
						</li>
					</div>



                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-envelope-open-text icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('accounts.balance_movements')}}
                                </div>
                            </div>
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
							
							<form class="form-horizontal" method="POST" action="{{ route('balance-movements.save') }}">
								{{ csrf_field() }}
								<div class="form-row">
									<div class="col-md-6">
										<div class="position-relative form-group">
											<label for="" class="">{{trans('accounts.cid')}} <span style="color:red">*</span></label>
											<select  class="select2 form-control" name="client"  id="client" required>
												<option value="" selected disabled > Select Client </option>
													@foreach($clients as $client)
														<option value="{{$client->id}}">{{$client->company_name." - ".$client->id}}</option>
													@endforeach
											</select>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-6">
										<div class="position-relative form-group">
											<label for="" class="">{{trans('accounts.description')}}<span style="color:red">*</span></label>
											<input type="text" class="form-control" name="description" required><br>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-6">
										<div class="position-relative form-group">
											<label for="" class="">{{trans('accounts.private_description')}}</label>
											<input type="text" class="form-control" name="private_description"><br>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-2">
										<div class="position-relative form-group">
											<label for="" class="">{{trans('accounts.type_of_movement')}}<span style="color:red">*</span></label>
											<select  class="select2 form-control" name="type_of_movement"  id="type_of_movement" required>
												<option value="" selected disabled > Select Type </option>
													<option value="standard">Standard</option>
													<option value="account">Account Payment</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-2">
										<div class="position-relative form-group">
											<label for="" class="">{{trans('accounts.movement')}} <span style="color:red">*</span></label>
											<select  class="select2 form-control" name="movement"  id="movement" required>
												<option value="" selected disabled > Select Movement </option>
													<option value="debit">Debit</option>
													<option value="credit">Credit</option>
											</select>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-2">
										<div class="position-relative form-group">
											<label for="" class="">{{trans('accounts.value')}}<span style="color:red">*</span></label>
											<input type="number" class="form-control" name="movement_value" required step="0.01"><br>
										</div>
									</div>
								</div>
								<div style="text-align: right;">
									<button  type="submit" id="submit" class="mt-2 btn btn-success">{{trans('accounts.insert')}}</button>
								</div>
							</form>
						</div>
                    </div>
                </div>
                  
            </div>
@endsection



@section('javascript')

@endsection

