<?php
$count = 0;
// dd($line_items);
?>
@extends('partials.main')

@section('content')
			<div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                   <i class="fas fa-user-friends icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('invoices.edit_credit_note')}}
                                </div>
                            </div>
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body" style="background-color: #cad3d8;">
                            <h3><b>{{trans('invoices.edit_credit_note')}}</b></h3>
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
                        
                            <form class="form-horizontal" method="POST" action="{{ route('update_credit_note')}}">
                            {{ csrf_field() }}

                            <div class="card-body" style="background-color: #f7f9fa;">
                                <div class="form-row">
                                    <input name="credit_note_id"  type="hidden" value="{{ $credit_note->id }}" placeholder="Date"  class="form-control" >
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                                <label for="" class="">{{trans('invoices.reason')}}<font color="red"><b>*</b></font></label>
                                            <input name="reason" id="reason" placeholder="{{trans('invoices.reason')}}" type="text" class="form-control" value="{{ $credit_note->reason }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                                <label for="" class="">{{trans('invoices.date')}} </label>
                                            <input name="date" id="date" type="date" value="{{ $credit_note->date }}" placeholder="{{trans('invoices.date')}}"  class="form-control" >
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
                                                    @if(in_array($inv->id ,$sel_invoices))
                                                    selected
                                                    @endif
                                                    > {{ $inv->id.'/'.$inv->cid.'/'.$inv->total_invoice_value }}</option>
                                                @endforeach
											</select>
										</div>
									</div>
                                </div>   
                                <div class=" col-12" id="line_items" style="">
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
                                            @foreach ($line_items as $items)
                                            <tr id="inv_item{{$items->invid}}" class="item_row_detect line_item_row rem_cl_{{$items->invid}}" >
                                                    <input type="hidden" class="" name="inv_items[]" value="{{$items->invid.','.$items->id}}"/>	
                                                    <td><ul><h6 class="text-primary">Invoice ID {{$items->invid}}</h6></ul></td>
                                                    <td class= ""><input value="{{$items->code}}" class="form-control "></td>
                                                    <td><input value="{{$items->unit_price}}" class="form-control "  ></td>
                                                    <td><input value="{{$items->qty}}"  class="form-control "   disabled ></td>
                                                    <td>
                                                        <input value="{{$items->vat}}" class="form-control "  disabled >
                                                    </td>
                                                    <td><input value="{{$items->discount}}" class="form-control " disabled ></td>
                                                    <td><a title="Delete" href="javascript:;" class="btn-shadow btn btn-danger btn-sm " onclick= remove_inv_items("inv_item{{$items->invid }}")>
                                                 <i class="fas fa-trash"></i>
                                                 </a></td>
                                                    </tr>
                                                    <span style="display:none;">{{ $count++ }}</span>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </thead>
                                </div>                              
                                <div style="text-align: right;">
                                       <button type="submit" class="mt-2 btn btn-primary">{{trans('invoices.edit')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
@endsection
@section('javascript')
<script type="text/javascript">

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
                    for (let [key, value] of Object.entries(data)) {
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
                    }
               });   
}
function remove_inv_items(id)
{
   $('#'+id).remove();
}
</script>
@endsection