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
                            <a href="{{route('invoices.home')}}">{{trans('menu.invoicing')}}</a>
                            <i class="fa fa-angle-right">&nbsp;</i>
                        </li>
                        <li>
                            <a class="breadcrumb-item active" href="">{{trans('invoices.credit_notes')}}</a>
                        </li>
                    </div>

                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-list icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('invoices.credit_notes')}}
                                </div>
                            </div>
                          
                              <div class="page-title-actions">
                                  <div class="d-inline-block dropdown">




                                      <a href="{{route('add_credit_note')}}" class="btn btn-lg btn-primary text-center" style="width: 240px;" ><span class="fa fa-plus btn-icon-wrapper"> </span>
                                          &nbsp;{{trans('invoices.add_credit_note')}}</a>



                                      <div class="dropdown" >
                                          <button type="button" class="mt-3 btn-warning btn btn-lg btn-primary dropdown-toggle text-center" data-toggle="dropdown" style="width: 240px;"><span class="fas fa-receipt"></span>&nbsp;{{trans('menu.other_docs')}}
                                          </button>
                                          <div class="dropdown-menu " >
                                              <a class="dropdown-item" href="{{route('invoice_receipt')}}"><span class="fa fa-plus btn-icon-wrapper"></span>&nbsp;{{trans('menu.invoice_receipt')}}</a>
                                              <a class="dropdown-item" href="{{route('invoice_simplified')}}"><span class="fa fa-plus btn-icon-wrapper"></span>&nbsp;{{trans('menu.invoice_simplified')}}</a>
                                              <a class="dropdown-item" href="{{route('invoices')}}"><span class="fa fa-plus btn-icon-wrapper"></span>&nbsp;{{trans('menu.invoices')}}</a>

                                          </div>
                                      </div>





                                  </div>
                              </div> 
                               
                          </div> <br>
                          <div class="card-header-title font-size-sm font-weight-normal" style="float: left;color: grey;">
                         <i class="fas fa-info-circle"></i>
                            <h7> {{trans('tips.credit_note')}}</h7>
                        </div>
                        <br>
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                <thead>
                                <tr style="text-align: center;">
                                    
                                    <th>ID</th>
                                    <th>{{trans('invoices.reason')}}</th>
                                    <th>{{trans('invoices.date')}}</th>
                                    <th>{{trans('invoices.invoice')}}</th>
                                    <th>{{trans('invoices.action')}}</th>
                             
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($credit_notes as $cdn)
                                        <tr id={{'r'.$cdn->id }} style="text-align:center">
                                            <td>{{\Carbon\Carbon::parse($cdn->date)->format('Y-m-d')}}</td>
                                           <td>{{$cdn->id}}</td>
                                           <td>{{$cdn->reason}}</td>
                                           <td>{{$cdn->inv_id}}</td>
                                           <td> <a href="javascript:;" onclick ="del_confirm({{ $cdn->id }});" class="btn-sm btn-shadow btn btn-danger" href="">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a title="Edit" href="{{ route('edit_credit_note',$cdn->id ) }}" class="btn-shadow btn btn-warning btn-sm" href="">
                                            <i class="fas fa-pen"></i>
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
@section('javascript')
<script type="text/javascript">

function del_confirm(val)
{
	$.confirm({
    title: 'Are You sure!',
    content: 'Are you sure you want to delete',
    type: 'red',
    typeAnimated: true,
    buttons: {
		confirm:{
			text: 'Yes',
            btnClass: 'btn-red',
            action: function(){
                
				del_credit_note(val);
            }
        },
        close: function () {

        }
    }
});
}
function del_credit_note(id){

 	CSRF_TOKEN  = "{{ csrf_token() }}";
    	$.ajax({
                type: "POST",
                url: "{{route('delete_credit_note')}}",
                data: {cr_id: id, _token: CSRF_TOKEN},
	success: function (data) {
		
		if(data['success']==="true")
		{
			$("#r"+data['id']).hide();
			notif({
					msg: "<b>Success : </b>Test product with id = "+data['id']+" Deleted Successfully",
					type: "success"
				});
		}
		else if(data['success']==="false")
		{
			notif({
				msg: "<b>Error!</b> Test product with id = "+data['id']+" does not exist",
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