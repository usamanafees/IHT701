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
                            <a href="{{route('credit_note')}}">{{trans('invoices.credit_notes')}}</a>
                            <i class="fa fa-angle-right">&nbsp;</i>
                        </li>
                        <li>
                            <a class="breadcrumb-item active" href="">{{trans('invoices.add_credit_note')}}</a>
                        </li>
                    </div>

                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                   <i class="fas fa-user-friends icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('invoices.add_credit_note')}}
                                </div>
                            </div>
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body" style="background-color: #cad3d8;">
                            <h3><b>{{trans('invoices.new_credit_note')}}</b></h3>
                            <div style="">
                                {{-- <h8>Required Fields<font color="red">*</font></h8> --}}
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                            <form class="form-horizontal" method="POST" action="{{ route('store_credit_note')}}">
                            {{ csrf_field() }}

                            <div class="card-body" style="background-color: #f7f9fa;">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                                <label for="" class="">{{trans('invoices.reason')}}<font color="red"><b>*</b></font></label>
                                            <input name="reason" id="reason" placeholder="{{trans('invoices.reason')}}" type="text" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                                <label for="" class="">{{trans('invoices.date')}}</label>
                                            <input name="date" id="date" type="date" placeholder="Date"  class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card-body">
                                <h4>{{trans('invoices.select_invoices')}}</h4>
                                <hr>
                                <div class="form-row">
                                    <div class="col-md-6">
										<div class="position-relative form-group">
											<label for="" class="">{{trans('invoices.select_invoices')}}<span style="color:red">*</span></label>
											<select  class="select2 form-control" name="invoices[]"  id="invoice" onchange="" multiple="multiple" required>
												<option value=""  disabled > Select Client </option>
                                                @foreach ($invoices as $inv)
                                                <option value="{{ $inv->id }}"  
                                                 
                                                @if(isset($from_invoice) && !empty($from_invoice))
                                                    @if($inv->id == $from_invoice) selected 
                                                       
                                                    @endif
                                                @endif
                                                > {{ $inv->id.'/'.$inv->cid.'/'.$inv->total_invoice_value }}</option>
                                                @endforeach
											</select>
										</div>
									</div>
                                </div>   
                                <div class=" col-12" id="line_items" style="display:none;">
                                    <table class="mb-0 table">
                                        <thead>
                                        <tr>
                                            <th>{{trans('invoices.invoice_id')}}</th>
                                            <th>{{trans('invoices.Description')}}</th>
                                            <th>{{trans('invoices.Unit_Price')}} </th>
                                            <th>{{trans('invoices.Qty')}}</th>
                                            <th>{{trans('invoices.Vat')}}</th>
                                            <th>{{trans('invoices.Disc_')}}</th>
                                            <th>{{trans('invoices.action')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="line_item_body" id="line_item_body">
                            
                                        </tbody>
                                        
                                    </table>
                                    </thead>
                                </div>                              
                                <div style="text-align: right;">
                                       <button type="submit" class="mt-2 btn btn-primary">{{trans('invoices.create')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
@endsection
@section('javascript')
<script type="text/javascript">

window.onload = function(){
        var x = $('#invoice').val(); 
        x = x.toString();
        get_line_items(x);
        // $('#invoice').prop('disabled',true); 
    };

$('#invoice').on('select2:select', function (e) {
    var data = e.params.data;
    get_line_items(data.id);
});

$('#invoice').on('select2:unselect', function (e) {
    var data = e.params.data;
    $('.rem_cl_'+data.id).remove();
});

function get_line_items(inv_id)
{
    	CSRF_TOKEN  = "{{ csrf_token() }}";
    	$('#brand_template').empty();
    	$.ajax({
                type: "POST",
                url: "{{route('credit_note_line_items')}}",
                data: {inv_id: inv_id, _token: CSRF_TOKEN},
                success: function(data){
                    $('#line_items').show();
                    // var outer_div = '<div class="col-12 mt-3" id="line_item_g'+inv_id+'">';
                    // var outer_div = '<tr class="" id="line_item_g'+inv_id+'">';

                    //     $('#line_items').append(outer_div);
                    for (let [key, value] of Object.entries(data)) {
                    //  var divs = '<div id="inv_item'+value.id+'"><span class="text-primary">Invoice id : '+inv_id+' | </span>'+
                    // 'Name &nbsp;<input value="'+value.code+'">'+
                    // ' &nbsp;Unit price &nbsp;<input value="'+value.unit_price+'" disabled>'+
                    // ' &nbsp;qty&nbsp; <input value="'+value.qty+'" disabled style="width:52px;">'+
                    // ' &nbsp;Vat &nbsp; <input value="'+value.vat+'" disabled style="width:70px;">'+
                    // ' &nbsp;Vat &nbsp; <input value="'+value.discount+'" disabled style="width:70px;">'+
                    // '<input type="hidden" class="" name="inv_items[]" value="'+inv_id+','+value.id+'"/>'+
                    // ' <a title="Delete" href="javascript:;" class="btn-shadow btn btn-danger btn-sm" onclick= remove_inv_items("inv_item'+value.id+'")>'+
                    // '<i class="fas fa-trash"></i>'+
                    // '</a>'+
                    // '</div>';
                    var divs = '<tr id="inv_item'+value.id+'" class="item_row_detect line_item_row rem_cl_'+inv_id+'" >"'+
                        '<input type="hidden" class="" name="inv_items[]" value="'+inv_id+','+value.id+'"/>'+	
                        '<td><ul><h6 class="text-primary">Invoice ID '+inv_id+'</h6></ul></td>'+
                        '<td class= ""><input value="'+value.code+'" class="form-control "></td>'+
                        '<td><input value="'+value.unit_price+'" class="form-control "  ></td>'+
                        '<td><input value="'+value.qty+'"  class="form-control "   disabled ></td>'+
                        '<td>'+
                            '<input value="'+value.vat+'" class="form-control "  disabled >'+
                        '</td>'+
                        '<td><input value="'+value.discount+'" class="form-control " disabled ></td>'+
                        '<td><a title="Delete" href="javascript:;" class="btn-shadow btn btn-danger btn-sm " onclick= remove_inv_items("inv_item'+value.id+'")>'+
                     '<i class="fas fa-trash"></i>'+
                     '</a></td>'+
                        '</tr>';
                     $('#line_item_body').append(divs);
                    }
                    //$('#line_items').append('</div>');
                    }
               });   
}
function remove_inv_items(id)
{
   $('#'+id).remove();
}
</script>
@endsection