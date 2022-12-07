@extends('partials.main')

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
                            <a class="breadcrumb-item">{{trans('menu.report')}}</a>
                            <i class="fa fa-angle-right">&nbsp;</i>
                        </li>
                        <li>
                            <a class="breadcrumb-item active" href="">{{trans('menu.report_sms')}}</a>
                        </li>
                    </div>
                <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-graph icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('reports.sms_reports')}}	
                                </div>
                            </div>
                        </div>
						<br>
                          <div class="card-header-title font-size-sm font-weight-normal" style="float: left;color: grey;">
                         <i class="fas fa-info-circle"></i>
                            <h7> {{trans('reports.tip_sms')}}</h7>
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body"><h5 class="card-title"> {{trans('reports.sms_reports')}} </h5>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-xl-4">
                                <div class="card mb-3 widget-chart" style="height: 208px" >
                                    <div class="widget-chart-content">
                                        <a href="{{route('report.sms.sent')}}" style=" text-decoration: none;color: inherit;">
                                        <div class="icon-wrapper rounded">
                                            <div class="icon-wrapper-bg bg-warning"></div>
                                            <i class="fas fa-dollar-sign text-warning"></i></div>
                                        <div class="widget-subheading fsize-1 pt-2 opacity-10 text-warning font-weight-bold">{{trans('reports.sent_sms')}}</div>

                                        <div class="widget-description opacity-8">
                                            {{trans('reports.sent_sms_description')}}
                                        </div>
                                        </a>
                                    </div>
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
@endsection
@section('javascript')
<script type="text/javascript">
                function set_default_brand(bid,uid)
        {
            $.confirm({
            title: 'Are You sure!',
            content: 'Are you sure you want to set this as a default Brand ?',
            type: 'orange',
            typeAnimated: true,
            buttons: {
                confirm:{
                    text: 'Yes',
                    btnClass: 'btn-warning',
                    action: function(){
                        
                        set_default_brand_post(bid,uid)
                    }
                },
                close: function () {

                }
            }
        });
        }

function set_default_brand_post(bid,uid){

 	CSRF_TOKEN  = "{{ csrf_token() }}";
    	$.ajax({
                type: "POST",
                url: "{{route('brands.default_brand')}}",
                data: {b_id: bid,u_id:uid, _token: CSRF_TOKEN},
        success: function (data) {
            if(data['success']==="true")
            {
                notif({
                        msg: "<b>Success : </b>Brand with id = "+data['id']+" set as default Successfully",
                        type: "success"
                    });
            }
            else if(data['success']==="false")
            {
                notif({
                    msg: "<b>Error!</b> Brand with id = "+data['id']+" does not exist",
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