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
                            <a class="breadcrumb-item active" href="">{{trans('menu.brands')}}</a>
                        </li>
                    </div>
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-settings icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('brands.brands')}}
                                </div>
                            </div>
                            @can('Create Brand')
                            <div class="page-title-actions">
                                <div class="d-inline-block dropdown">
                                    <a href="{{route('brands.add')}}" class="btn-shadow btn btn-info" href="">
                                        <i class="fa fa-plus btn-icon-wrapper"> </i>&nbsp;
                                    {{trans('brands.add_brand')}}</a>
                                </div>
                            </div>  
                            @endcan  
                        </div>
                    </div>



                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                <thead>
                                <tr style="text-align: center;">
                                    <th>{{trans('brands.default')}}</th>
                                    <th>{{trans('brands.brand_name')}}</th>
                                    <th>{{trans('brands.company_name')}}</th>
                                    <th>{{trans('brands.company_vat')}}</th>
                                    <th>{{trans('brands.action')}}</th>
                              
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($brand as $brands)
                                    <tr style="text-align: center">
                                        <td>
                                            
                                                <input type="radio" name="default_brand" value="{{$brands->id}}" onclick="set_default_brand({{ $brands->id }},{{ Auth::user()->id }})"
                                                    @if ($brands->id == Auth::user()->default_brand)
                                                        checked="checked"
                                                    @endif
                                                />
                                            
                                        </td>
                                        <td>{{$brands->name}}</td>
                                        <td>{{$brands->company_name}}</td>
                                        <td>{{$brands->company_vat}}</td>
                                        <td style="text-align: center;">
                                            @can('Edit Brand')
                                                <div class="btn-group" >
                                                    <a href="{{route('brands.edit',$brands->id)}}" class="btn-shadow btn btn-warning btn-sm" href="">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                    <a href="{{route('brands.destroy',$brands->id)}}" class="btn-shadow btn btn-danger btn-sm" href="">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </div>
                                            @endcan
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