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
                    <a class="breadcrumb-item active" href="">{{trans('invoices.add_invoice_receipt')}}</a>
                </li>
            </div>
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="fas fa-file icon-gradient bg-tempting-azure">
                            </i>
                        </div>
                        <div>{{trans('invoices.invoice_receipt')}}
                        </div>
                    </div>
                    @can('Create Invoice')
                        <div class="page-title-actions">
                            <div class="d-inline-block dropdown">




                                <a href="{{route('invoices.add')}}?inv_type={{$is_receipt}}" class="btn btn-lg btn-primary text-center" style="width: 240px;" ><span class="fa fa-plus btn-icon-wrapper"> </span>
                                    &nbsp;{{trans('invoices.add_invoice_receipt')}}</a>



                                <div class="dropdown" >
                                    <button type="button" class="mt-3 btn-warning btn btn-lg btn-primary dropdown-toggle text-center" data-toggle="dropdown" style="width: 240px;"><span class="fas fa-receipt"></span>&nbsp;{{trans('menu.other_docs')}}
                                    </button>
                                    <div class="dropdown-menu " >

                                        <a class="dropdown-item" href="{{route('invoice_simplified')}}"><span class="fa fa-plus btn-icon-wrapper"></span>&nbsp;{{trans('menu.invoice_simplified')}}</a>
                                        <a class="dropdown-item" href="{{route('invoices')}}"><span class="fa fa-plus btn-icon-wrapper"></span>&nbsp;{{trans('menu.invoices')}}</a>
                                        <a class="dropdown-item" href="{{route('add_credit_note')}}"><span class="fa fa-plus btn-icon-wrapper"></span>&nbsp;{{trans('menu.credit_note')}}</a>

                                    </div>
                                </div>







                            </div>
                        </div>
                    @endif
                </div><br>
                <div class="card-header-title font-size-sm font-weight-normal" style="float: left; color: grey;">
                         <i class="fas fa-info-circle"></i>
                            <h7> {{trans('tips.invoice_receipt')}}</h7>
                        </div>
            </div>            
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                        <thead>
                        <tr style="text-align: center;">
                            {{--<th>Receipt ID</th>--}}
                            <th>{{trans('invoices.receipt_date')}}</th>
                            <th>{{trans('invoices.receipt_number')}}</th>
                            {{--<th>{{trans('invoices.Remarks')}}</th>
                            <th>{{trans('invoices.Due')}}</th>
                            <th>{{trans('invoices.PO')}}</th>
                            <th>{{trans('invoices.Amount')}}</th>--}}
                            <th>{{trans('invoices.total_value')}}</th>
                            <th>{{trans('invoices.vat_value')}}</th>
                            <th>{{trans('invoices.net_value')}}</th>
                            <th>{{trans('invoices.status')}}</th>
                            <th>{{trans('invoices.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoices as $invoice)
                            <tr>
                                <td style="text-align:center;">{{\Carbon\Carbon::parse($invoice->inv_date)->format('Y-m-d')}}</td>
                                <td style="text-align:center;">@php if($invoice->is_receipt=="invoice"){
                                    $name="FT";
                                }else if($invoice->is_receipt=="receipt"){
                                    $name="FR";
                                }else if($invoice->is_receipt=="simplified"){
                                    $name="FS";
                                } echo $name." ".$invoice->serie."/".$invoice->id;@endphp</td>
                            {{--<td style="text-align:center;">{{$invoice->remarks}}</td>
                            <td style="text-align:center;">{{$invoice->due}}</td>
                            <td style="text-align:center;">{{$invoice->po}}</td>--}}
                            {{-- <td style="text-align:left;">{{$invoice->inv_subtotal - $invoice->inv_discount + $invoice->inv_vat }}</td> --}}
                                {{--<td>@php $currency = explode("_",$invoice->currency);
                                    if(Session::get('locale')=='pt'){
                                               echo number_format(($invoice->inv_subtotal - $invoice->inv_discount + $invoice->inv_vat), 2, ',', ' ');
                                    }
                                    else{
                                        echo number_format(($invoice->inv_subtotal - $invoice->inv_discount + $invoice->inv_vat), 2, '.', '');
                                    }
                                            echo(' '.$currency[1]);
                                    @endphp
                                </td>--}}
                                <td>@php $currency = explode("_",$invoice->currency);
                                         if(Session::get('locale')=='pt'){
                                               echo number_format($invoice->total_invoice_value - $invoice->inv_vat,2, ",", " ");
                                         }
                                         else{
                                            echo number_format($invoice->total_invoice_value - $invoice->inv_vat,2, ".", "");
                                         }
                                            echo(''.$currency[1]);
                                    @endphp</td>
                                <td>@php $currency = explode("_",$invoice->currency);
                                        if(Session::get('locale')=='pt'){
                                               echo number_format($invoice->inv_vat,2, ",", " ");
                                        }
                                        else{
                                            echo number_format($invoice->inv_vat,2, ".", "");
                                        }
                                            echo(''.$currency[1]);
                                    @endphp</td>
                                <td>@php $currency = explode("_",$invoice->currency);
                                         if(Session::get('locale')=='pt'){
                                               echo number_format($invoice->total_invoice_value,2,","," ");
                                         }
                                         else{
                                            echo number_format($invoice->total_invoice_value,2, ".", "");
                                         }
                                            echo(''.$currency[1]);
                                    @endphp</td>
                                <td style="text-align: center">@php if($invoice->status==="final"){ @endphp
                                    <b style="background: green;color:white;">&nbsp;Final&nbsp;</b>
                                    @php } else if($invoice->status==="draft"){@endphp
                                    <b style="background: yellow;color:dark;">&nbsp;Draft&nbsp;</b>
                                    @php }else if($invoice->status==="canceled"){ @endphp
                                    <b style="background: red;color:white;">&nbsp;Canceled&nbsp;</b>
                                    @php }else{ @endphp
                                    <b style="background: gray;color:white;">&nbsp;Paid&nbsp;</b>
                                    @php } @endphp
                                </td>
                                <td style="text-align: center;">
                                    <div class="btn-group">
                                        @php if($invoice->status==="draft"){ @endphp
                                        <a title="Edit" href="{{route('invoices.edit',$invoice->id)}}?inv_type={{$is_receipt}}" class="btn-shadow btn btn-warning btn-sm" href="">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        @php } @endphp
                                        <a data-toggle="modal"
                                           data-id = "{{$invoice->brand_templates_id}}"
                                           data-invoice-id = "{{$invoice->id}}"
                                           data-title=preview_brand_template
                                           data-target=".template_preview_invoice"
                                           title="Preview"
                                           class="btn-shadow btn btn-primary btn-sm preview_row_invoice" href="">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @php if($invoice->status==="final"){ @endphp
                                        <a title="Download without signature" href="{{route('download.invoice.pdf',['id' => $invoice->id, 'digital' => 0])}}" class="btn-shadow btn btn-success btn-sm" href="">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        {{-- <a title="Download with signature" href="{{route('download.invoice.pdf',['id' => $i->id, 'digital' => 1])}}" class="btn-shadow btn btn-info btn-sm" href="">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <a title="Paid" data-toggle="modal"  data-target="#exampleModalPaid{{$i->id}}" href="" class="btn-shadow btn btn-secondary btn-sm">
                                            <i class="fas fa-wallet"></i>
                                        </a>--}}
                                        <a title="Cancel" href="javascript:;" onclick="cancel_invoice_confirm({{$invoice->id}});" class="btn-shadow btn btn-danger btn-sm" href="">
                                            <i class="fas fa-ban"></i>
                                        </a>

                                        @php } @endphp
                                        @php if($invoice->status==="draft"){ @endphp
                                        <a title="Delete" href="javascript:;" onclick="del_invoice_confirm({{$invoice->id}});" class="btn-shadow btn btn-danger btn-sm" href="">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        @php } @endphp
                                        @php if($invoice->status==="paid"){@endphp
                                        <a title="Create Credit Note" href="{{route('add_credit_note')}}?invcd={{$invoice->id}}" class="btn-shadow btn btn-warning btn-sm" href="">
                                            <i class="fas fa-undo-alt"></i>
                                        </a>
                                        @php } @endphp
                                    </div>
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
        $('.preview_row_invoice').on('click',function(obj){
            var template_id = $(this).attr('data-id');
            var invoice_id = $(this).attr('data-invoice-id');
            // console.log(template_id, invoice_id);
            // return false;
            $('#header_invoice').html('');
            $('#body_invoice').html('');
            $('#footer_invoice').html('');

            var id = $('input[name=preview_template]').val();
            // console.log(id);
            CSRF_TOKEN   = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{route('preview_template_invoice')}}",
                data: {invoice_id:invoice_id,template_id:template_id, _token: CSRF_TOKEN},
                success: function(data){

                    var template = JSON.parse(data);
                    // console.log(JSON.parse(template['body']));

                    var header = JSON.parse(template['header']);
                    var footer = JSON.parse(template['footer']);
                    var body = JSON.parse(template['body']);

                    console.log(header,footer,body);
                    // var name = template.name;

                    $('#template_preview_name_invoice').text(name);
                    $('#header_invoice').html(header);
                    $('#body_invoice').html(body);
                    $('#footer_invoice').html(footer);

                    // $('.modal').css('overflow-y', 'auto');

                }
            });
        });
    </script>
@endsection