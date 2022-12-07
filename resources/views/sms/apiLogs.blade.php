@extends('partials.main')
<style>
.span3{
    width: 23.076923076923077%;
}
.infographic-box.colored {
    border: 0 none !important;
    color: #fff;
    
}
.main-box {
    background: none repeat scroll 0 0 padding-box #ffffff;
    border-radius: 3px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
    margin-bottom: 16px;
}
.infographic-box {
    padding: 15px;
}
.red-bg {
    background-color: #3f6ad8 !important;
}
.boldTitle{
    font-weight: bold;
}
#body_id table tr td{
	border:1px solid;
}

/* Important part */
.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
    overflow-y: auto;
}


</style>
@section('content')
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
                <a>API</a>
                <i class="fa fa-angle-right">&nbsp;</i>
            </li>
            <li>
                <a class="breadcrumb-item active" href="">{{trans('sms.apiLogs')}}</a>
            </li>
        </div>



        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fas fa-envelope-open-text icon-gradient bg-tempting-azure">
                        </i>
                    </div>
                    <div>{{trans('sms.apiLogs')}}
                    </div>
                </div>
            </div>
        </div>   
        @if (\Session::has('success'))
            <div class="alert alert-success">
               <p>
                  {!! \Session::get('success') !!}
               </p>
            </div>
        @endif
        @if (\Session::has('error'))
            <div class="alert alert-warning">
               <p>
                  {!! \Session::get('error') !!}
               </p>
            </div>
        @endif  
        <div class="main-card mb-3 card">
            <div class="row mt-4">
                <div class="col-sm"  style="margin-left:35px; margin-right: 35px;">
                <div class="main-box infographic-box colored red-bg">
                    <i class="fa fa-bullseye" style="font-size:65px;"></i>
                    <span class="headline" style="float:right;"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{trans('sms.api_calls')}}</font></font><br><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">{{trans('sms.yesterday_today')}}</font></font></span></br>
                    <span class="value" style="float:right;"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><strong>{{$yesterday}}/{{$today}} </strong></font></font></span>
                    <br><br>
                </div>
            </div>
            
            
        </div>
        <div class="main-card mb-3 card">
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{ route('sms.apiLogs') }}">
                    {{ csrf_field() }}
                    <div class="col-md-12">
                        <div class="row">
                           
                            <div class="col-md-6">
                                <label for="invoice_due" class="">{{trans('sms.filter')}}</label>
                                <div class="input-group mb-3">
                                    <select class="form-control-sm form-control" name="filter" id="filter">
                                        <option @if($filter == "today") selected @endif value="today">{{trans('sms.today')}} ( {{  now()->format('d-m-Y') }} )</option>
                                        <option @if($filter == "yesterday") selected @endif value="yesterday">{{trans('sms.yesterday')}} ( {{ Carbon\Carbon::yesterday()->format('d-m-Y') }} )</option>
                                        <option @if($filter == "this_week") selected @endif value="this_week">{{trans('sms.this_week')}} ( {{ Carbon\Carbon::now()->startOfWeek()->format('d-m-Y') }} to {{Carbon\Carbon::now()->endOfWeek()->format('d-m-Y' )}})</option>
                                        <option @if($filter == "last_week") selected @endif value="last_week">{{trans('sms.last_week')}} ( {{  Carbon\Carbon::today()->startOfWeek()->subWeek()->format('d-m-Y') }} to {{Carbon\Carbon::today()->startOfWeek()->format('d-m-Y')}} )</option>
                                        <option @if($filter == "this_month") selected @endif value="this_month">{{trans('sms.this_month')}} ( {{  Carbon\Carbon::now('m')->startOfMonth()->format('m-Y') }} )</option>
                                        <option @if($filter == "last_month") selected @endif value="last_month">{{trans('sms.last_month')}} ( {{  Carbon\Carbon::now('m')->subMonth()->startOfMonth()->format('m-Y') }} )</option>
                                        <option @if($filter == "before_last_month") selected @endif value="before_last_month">{{trans('sms.before_last_month')}} ( {{  Carbon\Carbon::now('m')->subMonth(2)->startOfMonth()->format('m-Y') }} )</option>
                                        <option @if($filter == "last_qarter") selected @endif value="last_qarter">{{trans('sms.last_qarter')}} ( {{  Carbon\Carbon::now('m')->subMonth(3)->startOfMonth()->format('d-m-Y') }} to {{Carbon\Carbon::now('m')->endOfMonth()->format('d-m-Y')}} )</option>
                                        <option @if($filter == "last_half") selected @endif value="last_half">{{trans('sms.last_half')}} ( {{  Carbon\Carbon::now('m')->subMonth(6)->startOfMonth()->format('d-m-Y') }} to {{Carbon\Carbon::now('m')->endOfMonth()->format('d-m-Y')}} )</option>
                                        <option @if($filter == "this_year") selected @endif value="this_year">{{trans('sms.this_year')}} ( {{  Carbon\Carbon::now('m')->startOfYear()->format('Y') }} )</option>
                                        <option @if($filter == "last_year") selected @endif value="last_year">{{trans('sms.last_year')}} ( {{  Carbon\Carbon::now('m')->subYear()->startOfYear()->format('Y') }} )</option>
                                        <option @if($filter == "select_date") selected @endif value="select_date">{{trans('sms.select_date')}}</option>
                                        <option @if($filter == "all") selected @endif value="all">{{trans('sms.all')}}</option>
                                    </select>
                                </div>
                            </div>  
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="invoice_due" class="">{{trans('sms.select_action')}}</label>
                                    <select class="form-control-sm form-control" name="filter_action" id="filter_action">
                                        <option @if($action =="ALL") selected @endif value="ALL">ALL</option>
                                        <option @if($action =="Create Sender") selected @endif value="Create Sender">{{trans('sms.create_sender')}}</option>
                                        <option @if($action =="Add Payment") selected @endif value="Add Payment">{{trans('sms.add_payment')}}</option>
                                        <option @if($action =="SMS SUBMIT") selected @endif value="SMS SUBMIT">{{trans('sms.sms_submit')}}</option>
										<option @if($action =="Contact Client") selected @endif value="Contact Client">{{trans('sms.contact_client')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="select_date"  @if($filter != "select_date")style="display: none;" @endif>
                            <div class="col-md-6" >
                                <label>{{trans('sms.start_date')}}</label>
                                <input type="date" name="start_date" style="width: 100%;" value="{{$start_date}}">
                            </div>
                            <div class="col-md-6">
                                <label>{{trans('sms.end_date')}}</label>
                                <input type="date" name="end_date" style="width: 100%;" value="{{$end_date}}">
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-4">
                                <button type="submit" class="mt-2 btn btn-success">{{trans('sms.Update_filter')}}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
            <div class="card-body">
                <table style="width: 100%;" id="example-ter" class="table table-hover table-striped table-bordered" >
                    <thead>
                        <tr>
                        <th>{{trans('sms.api_id')}}</th>
                        <th>Action</th>
                        {{-- <th>{{trans('sms.sms_id')}}</th> --}}
                        <th>I360 ID</th>
                        <th>{{trans('sms.sms_request_details')}}</th>
                        <th>{{trans('sms.sms_response_details')}}</th>
                           @if ( Auth::user()->roles()->pluck('name')->implode(' ')  == 'Administrator')
                           <th>{{trans('sms.client_id')}}</th> 
                           
                            @endif
                            <th>{{trans('sms.client')}}</th>
                            {{-- <th>{{trans('sms.mobile_num')}}</th> --}}
                            <th>{{trans('sms.status')}}</th>
                            <th>{{trans('sms.date')}}</th>
                            <th>{{trans('sms.hours')}}</th>
                            <th>{{trans('sms.ip')}}</th>
                        </tr>
                    </thead>
                    
                </table>
            </div>
        </div>
    </div>
      
</div>
@endsection

<head>
    <style type="text/css" href="//cdn.datatables.net/v/bs4/dt-1.10.21/af-2.3.5/b-1.6.3/datatables.min.css"/></style>
</head>
@section('javascript')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/v/bs4/dt-1.10.21/af-2.3.5/b-1.6.3/datatables.min.js"></script>
<script>

$(document).ready(function(){

    $('#patchedDiv').css("display","unset");

    $("#filter").change(function() {
      if($(this).val() == 'select_date'){

          $("#select_date").css('display', 'block');

      }else{
          $("#select_date").css('display', 'none');
      }
    });
    var APP_URL = {!! json_encode(url('/')) !!}
    $('#example-ter').DataTable( 
    {
        "order": [],
        "dom": "<'top'<'row'<'col-sm-6'l><'col-sm-6'f>>>rt<'bottom'<'row'<'col-sm-6'i><'col-sm-6'p>>>",
        "processing": true,
 
            "serverSide": true,
 
            "ajax":{
 
                     "url": "{{ route( 'sms.apiLogsajax') }}",
 
                     "dataType": "json",
 
                     "type": "POST",
 
                     "data":{ _token: "{{csrf_token()}}",route:'apiLogsajax' , filter : $("#filter :selected").val(),	filter_action : $("#filter_action :selected").val(),	start_date : $("input[name='start_date']").val(), end_date : $("input[name='end_date']").val()}
                   },
 
            "columns": [
 
                { "data": 'api_id' },
                { "data": 'sub' },
                { "data": 'sms_id' },
                { "data": 'sms_detail'},
                { "data": 'sms_detail_resp'},
                @if ( Auth::user()->roles()->pluck('name')->implode(' ')  == 'Administrator')
                { "data": 'clientid' },
                @endif
                { "data": 'name' },
                // { "data": 'mobile_num'},
                { "data": 'state'},
                { "data": 'date'},
                { "data": 'hours'},
                { "data": 'ip'}, 
            ],
 
            aoColumnDefs: [
 
            {
               bSortable: false,
 
               aTargets: [ -1,-2,-7,-8 ]
 
            }
 
          ]  
    });
    });
</script>


<script>

$(document).ready(function(){
    $('.userinfo').click(function(){
        var mobileNum = $(this).val();
        var sms_id = $("#current_sms_id_in_modal").val();
        // var userid = $(this).data('id');
        $.ajax({
           url: 'ez4u/'+sms_id,
           type: 'get',
           dataType: 'json',
           success: function(response){ 
             var returnedData = JSON.stringify(response, null, 2);
            $('#status_values_modal').html("<pre style = 'margin-right:10em'>"+"<span>"+returnedData+"<span>");
           }
        });
    });
});

 
function loadData(sms_id){
    var request = new XMLHttpRequest();

    request.open("GET", "getApiLogs?id="+sms_id);

    request.onreadystatechange = function() {
        if(this.readyState === 4 && this.status === 200) {
            var jsonResponse = JSON.parse(this.responseText);
			var returnedData = JSON.stringify(jsonResponse.response, null, 2);
			var argsHtml = "";
			if(!jQuery.isEmptyObject(jsonResponse.request)){
				// if(jsonResponse.action == "Contact Client"){
				// 	$.each(jsonResponse.request,function(key,value){
				// 		argsHtml += "<tr><td>"+key+"</td><td>"+value+"</tr>";
				// 		console.log(["loop", key , value]);
				// 	});
				// 	$("#table_request_body_initial").css("display","none");
				// }else{
					$("#table_request_body_initial").css("display","block");
					$("#apilogs_ip").text(jsonResponse.request.ip);
					$("#apilogs_script_name").text(jsonResponse.request.script_name);
					$("#apilogs_host").text(jsonResponse.request.host);
					$("#apilogs_function").text(jsonResponse.request.function);
					$.each(jsonResponse.request.args,function(key,value){
						argsHtml += "<tr><td>"+key+"</td><td style='width:100%'>"+value+"</tr>";
					});
				
				
				
				$("#table_request_body").html(argsHtml);
			}else
			{
				console.log("else");
				$("#apilogs_ip").text("");
				$("#apilogs_script_name").text("");
				$("#apilogs_host").text("");
				$("#apilogs_function").text("");
				$("#apilogs_args").text("");
			}
            
            $("#current_sms_id_in_modal").val(jsonResponse.apilogs_id);
            // $("#status_values_modal").html("<pre style = 'margin-right:20em;'>"+"<span>"+returnedData+"<span>");
            $("#status_values_modal").html("");
            $("#myModaltest").modal("toggle");
        }
    };

    request.send();
}

function loadResponseData(sms_id){
    var request = new XMLHttpRequest();

    request.open("GET", "getApiLogs?id="+sms_id);

    request.onreadystatechange = function() {
        if(this.readyState === 4 && this.status === 200) {
            var jsonResponse = JSON.parse(this.responseText);
			var returnedData = JSON.stringify(jsonResponse.response, null, 2);
			// if(!jQuery.isEmptyObject(jsonResponse.request)){
				// $("#apilogs_ip").text(jsonResponse.request.ip);
				// $("#apilogs_session_id").text(jsonResponse.request.session_id);
				// $("#apilogs_user_agent").text(jsonResponse.request.user_agent);
				// $("#apilogs_script_name").text(jsonResponse.request.script_name);
				// $("#apilogs_host").text(jsonResponse.request.host);
				// $("#apilogs_function").text(jsonResponse.request.function);
				// $("#apilogs_args").text(JSON.stringify(jsonResponse.request.args, null, 2));
				// $("#apilogs_zero").text(jsonResponse.request.zero);
			// }else
			// {
				// $("#apilogs_ip").text("");
				// $("#apilogs_session_id").text("");
				// $("#apilogs_user_agent").text("");
				// $("#apilogs_script_name").text("");
				// $("#apilogs_host").text("");
				// $("#apilogs_function").text("");
				// $("#apilogs_args").text("");
				// $("#apilogs_zero").text("");
			// }
            
            // $("#current_sms_id_in_modal").val(jsonResponse.sms_id);
            $("#status_values_modal_response").html("<pre style = 'margin-right:10em;'>"+"<span>"+returnedData+"<span>");
            $("#myModaltestrepsonse").modal("toggle");
            console.log(jsonResponse);
        }
    };

    request.send();
}

</script>



<div class="modal " id="myModaltest" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable">
        <div class="modal-content" style="overflow:hidden;">
            <div class="modal-header">
                <h4 class="modal-title">{{trans('sms.request')}}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="body_id" style="border:1px solid #fff;">
				<table style="width: 100%;" cellpadding="3" id="table_request">
				<tbody id="table_request_body_initial">	
					<tr>
                        <td class="boldTitle">ip</td>
                        <td id="apilogs_ip" style="width:100%"></td>
                    </tr>
                    
                    <tr>
                        <td class="boldTitle" >script_name</td>
                        <td id="apilogs_script_name" style="width:100%"></td>
                    </tr>
                    <tr>
                   
                        <td class="boldTitle" >function</td>
                        <td id="apilogs_function" ></td>
                   
                    </tr>
					<tr>
                        <td class="boldTitle" colspan="2" style="text-align:center;">args</td>                   
                    </tr>
					</tbody>
					</tbody>
                    
                    <h4 class="modal-title">{{trans('sms.request')}}</h4>
				  
                </table>
            {{-- <div class="modal-body" id="body_id" style="border:1px solid #fff;"> --}}
            <table style="width: 100%" cellpadding="3" id="table_request">
                {{-- <colgroup>
                   <col span="1" style="width: 50%;">
                   <col span="1" style="width: 50%;">
                </colgroup> --}}
                <tbody id="table_request_body" style="width: 100%;" cellpadding="3">
                </table>
            {{-- </div> --}}
            </div>
			<div>
			
			</div>
           <div class="modal-footer" id="status_values_modal">
                
            </div>
            
            <div class="modal-footer" >
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal " id="myModaltestrepsonse">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{trans('sms.response')}}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            		
           <div class="modal-footer" id="status_values_modal_response">
                
            </div>
            
            <div class="modal-footer" >
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection