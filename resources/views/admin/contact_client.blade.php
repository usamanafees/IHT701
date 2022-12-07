@extends('partials.main') 
@section('content')
<style>
	input[type="checkbox"]{
  width: 20px; /*Desired width*/
  height: 20px; /*Desired height*/
}
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
                                <div>
									{{trans('admin.contact_client')}}
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
							
							<form class="form-horizontal" method="POST" action="{{ route('contact_client_via_email_s') }}">
								{{ csrf_field() }}
								<div class="form-row">
									<div class="col-md-12">
										<div class="position-relative form-group">
											<label for="" class="">{{trans('admin.select_client')}}<span style="color:red">*</span></label>
											<select  class="select2 form-control" name="client[]"  id="client"  multiple="multiple" required>
												<option value=""  disabled > {{trans('admin.select_client')}} </option>
													@foreach($clients as $client)
														<option value="{{$client->id}}">{{$client->company_name." - ".$client->id}}</option>
													@endforeach
											</select>
										</div>
									</div>
									<div class="form-row">
										<div class="col-md-12">
											<div class="position-relative form-group ml-2" >
										<label  for="" >{{trans('admin.check_ative_clients')}}</label>
										<input type="checkbox" id="check_box" name="check_box" value="1" >
									</div></div></div>
									</div>
								<div class="form-row">
									<div class="col-md-12">
										<div class="position-relative form-group">
											<label for="" class="">{{trans('admin.subject')}}<span style="color:red">*</span></label>
											<input type="text" class="form-control" name="subject" required><br>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="col-md-12">
										<div class="position-relative form-group">
											<label for="" class="">{{trans('sms.Message')}}<font color="red"><b>*</b></font></label>
											<textarea name="message" id = "msg_txt" class="form-control" hidden></textarea>
											<div id="editor" style="max-width: 1000px">
											
											</div>
										</div>
									</div>
								</div>
								<div style="text-align: right;">
									<button  type="submit" id="submit" class="mt-2 btn btn-success">{{trans('admin.insert')}}</button>
								</div>
							</form>
						</div>
                    </div>
                </div>
                  
            </div>
@endsection
@section('javascript')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
// $('#client').select2();
var quill = new Quill('#editor', {

	modules: {
    toolbar: [
      [{ align: '' }, { align: 'center' }, { align: 'right' }, { align: 'justify' }],
	  ['bold', 'italic', 'underline', 'strike']
	  ]
    
  },
    theme: 'snow'
  });
  $('form').submit(function ( e ) {
	// e.preventDefault();
        var myEditor = document.querySelector('#editor')
        var html = myEditor.children[0].innerHTML;
		$('#msg_txt').val(html);
		console.log($('#msg_txt').val());
  });
</script>
@endsection

