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
.openmodal{
	text-decoration:underline;
	color:blue;
}
p.gfg {  
	word-break: break-all;
	padding-top: 10px;	
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
                    <a href="{{route('invoices.home')}}">{{trans('menu.invoicing')}}</a>
                    <i class="fa fa-angle-right">&nbsp;</i>
                </li>
                <li>
                    <a class="breadcrumb-item active" href="">{{trans('menu.billing_alerts')}}</a>
                </li>
            </div>


        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fas fa-envelope-open-text icon-gradient bg-tempting-azure">
                        </i>
                    </div>
                    <div>{{trans('billing.bl_alerts')}}
                    </div>
                </div>
                <div class="page-title-actions">
                    <div class="d-inline-block dropdown">
                        <a href="{{route('billing-alerts.add')}}" class="btn-shadow btn btn-info" href="">
                            <i class="fa fa-plus btn-icon-wrapper"></i> &nbsp;{{trans('billing.add_bl_alert')}}</a>
                    </div>
                </div> 
            </div>
           
        </div>   
        <div class="main-card mb-3 card container">
        
            <div class="card-body">
                <table style="width: 100%;" id="example-ter" class="table table-hover table-striped table-bordered display" >
                    <thead>
                        <tr>
                            <tr style="text-align:center">
                                <th>{{trans('billing.type')}}</th>
                                {{--<th >Id</th>--}}
                                <th >{{trans('billing.sms_message')}}</th>
                                <th >{{trans('billing.email_message')}}</th>
                                <th >{{trans('billing.email_subject')}}</th>
                                <th>{{trans('billing.days')}}</th>
                                {{--<th >{{trans('billing.sms_after')}}</th>
                                <th >{{trans('billing.email_msg_after')}}</th>
                                <th >{{trans('billing.email_subj_after')}}</th>
                                <th >Days</th>--}}
                                <th >{{trans('billing.action')}}</th>
                            </tr>
                    </thead>
                    <tbody>
                        @foreach($billing as $bil)
                            <tr id={{'r'.$bil->id }} style="text-align:center">
                               <td>
                                   @if($bil->is_before == 1)
                                   <span class="text-success"><b>{{trans('billing.before')}}</b></span>
                                   @else
                                   <span class= "text-danger"> <b>{{trans('billing.after')}}</b> </span>
                                   @endif
                                </td>
                               {{--<td>{{ $bil->id }}</td>--}}
                               
                               <td>
                                <div style="max-height:100px;overflow-y: auto;overflow-x: auto;max-width:217px;">
                                   @if(empty($bil->sms_message_before))
                                        {{ $bil->sms_message_after }}
                                    @else
                                        {{$bil->sms_message_before}}
                                   @endif
                                </div>
                                </td>
                               <td>
                                   <div style="max-height:100px;overflow-y: auto;overflow-x: auto;max-width:217px;">
                                       @if(empty($bil->email_message_before))
                                           {{ $bil->email_message_after }}
                                       @else
                                           {{ $bil->email_message_before }}
                                       @endif
                                   </div>
                                </td>
                               <td>
                                <div style="max-height:100px;overflow-y: auto;overflow-x: auto;max-width:217px;">
                                    @if(empty($bil->email_subject_before))
                                        {{ $bil->email_subject_after }}
                                    @else
                                        {{ $bil->email_subject_before }}
                                    @endif
                                </div>
                                </td>
                               <td>@if(empty($bil->days_before))
                                       {{ $bil->days_after }}
                                   @else
                                       {{ $bil->days_before }}
                                   @endif
                               </td>
                               {{--<td>
                                <div style="max-height:100px;overflow-y: auto;overflow-x: auto;max-width:217px;">
                                   {{ $bil->sms_message_after }}
                                </div>
                                </td>
                               <td>
                                <div style="max-height:100px;overflow-y: auto;overflow-x: auto;max-width:217px;">
                                   {{ $bil->email_message_after }}
                                </div>
                                </td>
                               <td>
                                <div style="max-height:100px;overflow-y: auto;overflow-x: auto;max-width:217px;">
                                   {{ $bil->email_subject_after }}
                                </div>
                                </td>
                               <td>{{ $bil->days_after }}</td>--}}
                               <td> <a href="javascript:;" onclick ="del_confirm({{ $bil->id }});" class="btn-sm btn-shadow btn btn-danger" href="">
                                <i class="fas fa-trash mt-1 mb-1"></i>
                                  </a>
                                  <a href="{{ route('billing-alerts.edit',$bil->id)}}" class="btn-shadow btn btn-warning btn-sm" href="">
                                    <i class="fas fa-pen mt-1 mb-1"></i>
                                </a>
                               </td>
                            </tr>
                        @endforeach
                    </tbody>
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
    $(document).ready(function() {
        $('#example-ter').DataTable( {
            "scrollX": true
        } );
    } );


function del_confirm(val)
{
	$.confirm({
    title: 'Confirm delete!',
    content: 'Are you sure you want to delete?',
    type: 'red',
    typeAnimated: true,
    buttons: {
		confirm:{
			text: 'Yes',
            btnClass: 'btn-red',
            action: function(){
                
				del_billing_alert(val);
            }
        },
        close: function () {

        }
    }
});
}
function del_billing_alert(id){

 	CSRF_TOKEN  = "{{ csrf_token() }}";
    	$.ajax({
                type: "POST",
                url: "{{route('billing-alerts.delete')}}",
                data: {cr_id: id, _token: CSRF_TOKEN},
	success: function (data) {
		
		if(data['success']==="true")
		{
			$("#r"+data['id']).hide();
			notif({
					msg: "<b>Success : </b>Billing Alert with id = "+data['id']+" deleted successfully!",
					type: "success"
				});
		}
		else if(data['success']==="false")
		{
			notif({
				msg: "<b>Error!</b> Billing Alert with id = "+data['id']+" does not exist!",
				type: "error",
				position: "center"
			});
		}
	},
    error:function(err){
		notif({
				type: "warning",
				msg: "<b>Warning:</b> Something Went Wrong",
				position: "left"
			});
    }
  });
}
</script>
@endsection