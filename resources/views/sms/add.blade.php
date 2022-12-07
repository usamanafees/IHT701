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
                                    <a href="{{route('sms.home')}}">SMS</a>
                                    <i class="fa fa-angle-right">&nbsp;</i>
                                </li>
                                <li>
                                    <a class="breadcrumb-item active" href="">{{trans('sms.add_sms')}}</a>

                                </li>

                            </div>

                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-envelope-open-text icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('sms.add_sms')}}
                                </div>
                            </div>
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body">
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

                            @if (number_format($user->AccountSettings->in_app_credit) == 0 &&
							sizeof(array_intersect(Auth::user()->roles()->pluck('name')->toArray(), ['Administrator','SMS Free'])) == 0
							)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              {{trans('sms.ballance_null')}}<a class="alert-link" href="{{route('account.balance')}}"><strong>{{trans('sms.recharge')}}</strong> </a>
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                        @endif
                                    <form class="form-horizontal" method="POST" action="{{ route('sms.store') }}">
                                     	{{ csrf_field() }}
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative ">
                                                    <label for="" class="">{{trans('sms.mobile')}}<font color="red"><b>*</b></font></label>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            
                                                                
                                                                @if(!empty($service_providers->mobile_prefix))
                                                                <input type="text" name="mobile_Code" id="mobile_code1" value="{{$service_providers->mobile_prefix}}"  disabled>

                                                            
                                                                @else
                                                                <select  class="select2 form-control" name="mobile_Code" id="mobile_code" id="get_rate" >
                                                                <option value="" selected disabled > {{trans('sms.select_code')}} </option>
                                                                @foreach($countries as $country)
                                                                <option @if($country->id == '171') selected @endif value="{{$country->isd_code}}">+{{$country->isd_code}}</option>
                                                                @endforeach
                                                                </select>
                                                                @endif
                                                                
                                                            
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="position-relative ">
                                                                <input style="height: 30px;" name="mobile_num" id="mobile_num" placeholder="Mobile" type="number" class="form-control" >
                                                                <TEXTAREA type="number" name="mobile_num_blk"  id="mobile_num1" placeholder="Mobile"  class="form-control" style="display: none;">
                                                                </TEXTAREA>
                                                                <b>*</b>
                                                                <small>{{trans('sms.number_no_code')}}</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                        <div class="col-md-6">
                                        <div class="position-relative " id ="rate">
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="position-relative " id ="provider1">
                                        </div>
                                        </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                    <label for="" class="">{{trans('sms.select_sender')}}</label>
                                                    <select  class="select2 form-control" name="sender"  id="sender_id">
                                                        <option value="" selected disabled > {{trans('sms.select_sender')}} </option>
                                                        @foreach($senders as $sender)
														@if(strtolower($sender->state) == 'approved')
															<option value="{{$sender->id}}">{{$sender->sender}}</option>
														@endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                    <label for="" class="">{{trans('sms.select_template')}}</label>
                                                    <select  class="select2 form-control" name="template_id"  id="template_id" onchange="template_text();">
                                                        <option value="" selected disabled > {{trans('sms.select_template')}} </option>
                                                        @foreach($templates as $template)
														
															<option value="{{$template->id}}">{{$template->name}}</option>
														
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        @if ( in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
													<label for="" class="">{{trans('sms.admin_comment')}}</label>
													<input type="text" class="form-control" name="admin_comment"><br>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                	<label for="" class="">{{trans('sms.Message')}}<font color="red"><b>*</b></font></label>
                                                	<textarea name="message" id = "msg_txt" class="form-control" required></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div class="form-col">
                                            <!-- <div class="col-md-1"></div> -->
                                            <div class="col-md-2">
                                                <div class="position-relative form-group">
                                                   <input type="checkbox" name="blk_Add" id= "blk_Add" value="blk_Add"> {{trans('sms.bulk_add')}}
                                                </div>
                                            </div>
                                             <div class="col-md-3">
                                                <div class="position-relative form-group">
                                                   <input class="temp_Add" type="checkbox" name="template_Add" value="template_Add"> {{trans('sms.saved_sms_template')}}

                                                   <input type="text" class="form-control open_temp_name" name="template_name" style="display: none;" placeholder="Template Model Name">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="position-relative form-group">
                                                   <input class="sms_schedule" type="checkbox" name="sms_schedule" value="sms_schedule"> {{trans('sms.sms_schedule')}}
                                                   <div class="form-row">
                                                  <div class="main-card mb-3 card dat" style="display: none;">
                                                  <div class="card-body">
                                                 <h5 class="card-title">{{trans('sms.start_date')}}</h5>
                                                 <div class="input-group">
                                                <div class="input-group-prepend datepicker-trigger">
                                                    
                                                </div>
                                                <!-- <label for="from">Date</label>  -->
                                                <input type="text" name='start_date' id="from" />
                                            </div>
                                        </div>
                                        <div class="container-fluid">
                                        <div class="row" style = "margin-bottom:1em">
                                        <div class="col-md-4">
                                        {{trans('sms.hh')}}
                                        <select name="hh" id="mySelect" style="margin-top:-2em;">
                                        </select>
                                        </div>
                                        <div class="col-md-4">
                                        {{trans('sms.mm')}}
                                        <select name="mm" id="mySelect1" style ="margin-top:-2em;">
                                       
                                        </select>
                                        </div>

                                        </div>
                                        </div>
                                    
                                    </div>
                                        </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="form-row">
                                            
                                        </div> -->
                                        <div style="text-align: right;">
                                       		<button @if (number_format($user->AccountSettings->in_app_credit) == 0 &&
											sizeof(array_intersect(Auth::user()->roles()->pluck('name')->toArray(), ['Administrator','SMS Free'])) == 0) disabled @endif type="submit" id="submit" class="mt-2 btn btn-success">{{trans('sms.Send_sms')}}</button>
                                        </div>
                                    </form>
                                </div>
                    </div>
                </div>
                  
            </div>
@endsection



@section('javascript')
<head>
<link href= 
'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css'
          rel='stylesheet'> 
      
    <script src= 
"https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" > 
    </script> 
      
    <script src= 
"https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" > 
    </script> 
</head>

<script type="text/javascript">

function template_text(){

    var APP_URL = {!! json_encode(url('/')) !!}
    var x = document.getElementById("template_id").value;
    $.ajax({
            type: "get",
            url: APP_URL + "/template_text/"+x,
            dataType: "JSON",
            success : function(data){
                
                $('#msg_txt').val(data);
            },
            error:function(err){
                //alert("error");
             }
            });
    
}


     $('.temp_Add').on('click',function(){
        $('.open_temp_name').toggle();
         $('.open_temp_name').attr('required',true);
    });
    $('#blk_Add').on('click',function(){
        $('#mobile_num').toggle();
        $('#mobile_num1').toggle();
    });
    $('#submit').on("click", function() {
   
    var getNumbers = $('#mobile_num1').val().split('').filter(function(item) {
    return item === ','
    }).length;
    var b =$('#mobile_num1').val();
    var code =$('#mobile_code1').val();
    code = code.substring(1);
    var tot_textnum = (getNumbers*9)+(getNumbers+9);
    var a= $('#mobile_num').val();
        if(a.length != 9 && b.length !=tot_textnum && code ==351){
            alert("Please enter 9 digit mobile number ");
            return false;
        }
        var sender_id =$('#sender_id').val();
        if(sender_id == null){
            alert("Please select sender");
            return false;
        }

    });

    $('.sms_schedule').on('click',function(){
        $('.dat').toggle();
    });

    
    $(document).ready(function(){
        var country_code =$('#mobile_code').val();
        if(country_code==null){
            country_code =$('#mobile_code1').val();
            country_code = country_code.substring(1);
        }
        country_code =$('#mobile_code1').val();
        country_code = country_code.substring(1);
        $.ajax({
        url: 'get_rate/'+country_code,
        type: 'get',
//    data:{country_id,provider_id},
       dataType: 'json',
       success: function(response){ 
           window.r = response;
       if(response != null){
        $('#rate').val('');
        providers = {1: 'EZ4U', 4: 'Twilio'};
        console.log( 'SMS Provider is '+providers[response['sms_provider_id']]);
        var final_rate = parseFloat(response['final_price']);
        if(!isNaN(final_rate)){
            $("#rate").html('<p> This would cost you: '+final_rate.toFixed(3)+'</p>');
        }
        else{
            $("#rate").html('<p> Country not supported </p>');
        }
        
    
       }
   } 
   });
        $("#mobile_code1").change(function (){
        country_code =$('#mobile_code1').val();
        country_code = country_code.substring(1);
        $.ajax({
        url: 'get_rate/'+country_code,
        type: 'get',
//    data:{country_id,provider_id},
       dataType: 'json',
       success: function(response){ 
           window.r = response;
       if(response != null){
        $('#rate').val('');
        providers = {1: 'EZ4U', 4: 'Twilio'};
        console.log( 'SMS Provider is '+providers[response['sms_provider_id']]);
        var final_rate = parseFloat(response['final_price']);
        if(!isNaN(final_rate)){
            $("#rate").html('<p> This would cost you: '+final_rate.toFixed(3)+'</p>');
        }
        else{
            $("#rate").html('<p> Country not supported </p>');
        }
        
    
       }
   } 
   });
    }); 
        

     var current_date = new Date();
     var current_time = current_date.getHours();
     var current_min = current_date.getMinutes();
     current_date = current_date.getDate();
        for(current_time;current_time<24;current_time++){
            if(current_time<10){
                current_time = "0"+current_time;
            }
            $('#mySelect').append( '<option value="'+current_time+'">'+current_time+'</option>' );
        }
        for(current_min;current_min<60;current_min++){
            if(current_min<10){
                current_min = "0"+current_min;
            }
            $('#mySelect1').append( '<option value="'+current_min+'">'+current_min+'</option>' );
        }

    $('#mobile_num1').hide();
    $('.dat').hide();
    $("#mobile_num1").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        if(e.which == 13) {
        e.preventDefault();
        $('#mobile_num1').val($('#mobile_num1').val()+',');
    }
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
    });
    
</script>
<script>
var dateToday = new Date();
$(document).ready(function(){
    var dateToday = new Date();
var dates = $("#from, #to").datepicker({
    defaultDate: "+1w",
    changeMonth: true,
    dateFormat: 'dd/mm/yy',
    numberOfMonths: 1,
    minDate: dateToday,
    onSelect: function(selectedDate) {
     var current_date = new Date();
     var current_time = current_date.getHours();
     var current_min = current_date.getMinutes();
     current_date = current_date.getDate();
    var sender =$('#from').val();
    var cal_date = selectedDate.split('/');
        if(cal_date[0]==current_date){
            $('#mySelect').empty();
            for(current_time;current_time<24;current_time++){
            if(current_time<10){
                current_time = "0"+current_time;
            }
            $('#mySelect').append( '<option value="'+current_time+'">'+current_time+'</option>' );
        }
        $('#mySelect1').empty();
        for(current_min;current_min<60;current_min++){
            if(current_min<10){
                current_min = "0"+current_min;
            }
            $('#mySelect1').append( '<option value="'+current_min+'">'+current_min+'</option>' );
        }

        }
        else{
            $('#mySelect').empty();
            for(var i=0;i<24;i++){
            if(i<10){
                i = "0"+i;
            }
            
            $('#mySelect').append('<option value="'+i+'">'+i+'</option>');
        }
        $('#mySelect1').empty();
        for(var j=0;j<60;j++){
            if(j<10){
                j = "0"+j;
            }
            $('#mySelect1').append('<option value="'+j+'">'+j+'</option>');

            // $('#mySelect1').append( '<option value="'+j+'">'+j+'</option>' );
        }

        }
        var option = this.id == "from" ? "minDate" : "maxDate",
            instance = $(this).data("datepicker"),
            date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
        dates.not(this).datepicker("option", option, date);
    }
});
   
});

</script>
@endsection

