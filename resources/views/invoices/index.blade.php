@extends('partials.main')
@section('content')
    <head>
        <style>

            /* Important part */
            .modal-dialog{
                overflow-y: initial !important
            }
            .modal-body{
                height: 70vh;
                overflow-y: auto;
            }
        </style>
    </head>
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
                    <a class="breadcrumb-item active" href="">{{trans('menu.invoices')}}</a>
                </li>
            </div>

            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="mb-5 page-title-heading">


                        <div class="page-title-icon">
                            <i class="fas fa-file icon-gradient bg-tempting-azure">
                            </i>
                        </div>
                        <div>{{trans('menu.invoices')}}
                        </div>
                    </div>
                    @can('Create Invoice')
                        <div class="page-title-actions d-inline-block" style="margin-bottom: 30px">



                            <div class="dropdown" >
                                <button type="button" class="btn btn-lg btn-primary dropdown-toggle text-center" data-toggle="dropdown" style="width: 240px;"><span class="fas fa-edit"></span>&nbsp;{{trans('invoices.options')}}
                                </button>

                                <div class="dropdown-menu " >
                                    <a class="dropdown-item" href="{{route('invoices.add')}}?inv_type={{$is_invoice}}"><span class="fa fa-plus btn-icon-wrapper"></span>&nbsp;{{trans('invoices.add_invoices')}}</a>
                                    <div class="dropdown-divider"></div>
                                    <button type="button" data-toggle="modal" data-target="#exampleModal" class="dropdown-item" ><span class="fas fa-file-csv fa-lg"></span>&nbsp;{{trans('invoices.import_csv')}}</button>
                                    <button type="button" data-toggle="modal" data-target="#exampleModalEuPago" class="dropdown-item" ><span class="fas fa-file-csv fa-lg"></span>&nbsp;{{trans('invoices.import_csv_ep')}}</button>
                                    <div class="dropdown-divider"></div>
                                    <a href="{{route('import_wizard.export_clients')}}" class="dropdown-item" ><span class="fas fa-file-download fa-lg"></span>&nbsp;{{trans('invoices.export_invoices')}}</a>
                                </div>
                            </div>



                            <div class="dropdown" >
                                <button type="button" class="mt-3 btn-warning btn btn-lg btn-primary dropdown-toggle text-center" data-toggle="dropdown" style="width: 240px;"><span class="fas fa-receipt"></span>&nbsp;{{trans('menu.other_docs')}}
                                </button>

                                <div class="dropdown-menu " >

                                    <a class="dropdown-item" href="{{route('invoice_receipt')}}"><span class="fa fa-plus btn-icon-wrapper"></span>&nbsp;{{trans('menu.invoice_receipt')}}</a>
                                    <a class="dropdown-item" href="{{route('invoice_simplified')}}"><span class="fa fa-plus btn-icon-wrapper"></span>&nbsp;{{trans('menu.invoice_simplified')}}</a>
                                    <a class="dropdown-item" href="{{route('credit_note')}}"><span class="fa fa-plus btn-icon-wrapper"></span>&nbsp;{{trans('menu.credit_note')}}</a>

                                </div>
                            </div>
                            

                        </div>
                        </div>

                    @endif
            </div>
                <div class="main-card mb-3 card">
                <div class="card-body">
                    <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                        <thead>
                        <tr style="text-align: center;">
                            {{--<th>Invoice ID</th>--}}
                            <th>{{trans('invoices.Invoice_Date')}}</th>
                            <th>{{trans('invoices.invoice_number')}}</th>
                            {{--<th>{{trans('invoices.Remarks')}}</th>--}}
                            {{--<th>{{trans('invoices.Due')}}</th>--}}
                            {{--<th>{{trans('invoices.PO')}}</th>--}}
                            <th>{{trans('invoices.total_value')}}</th>
                            <th>{{trans('invoices.vat_value')}}</th>
                            <th>{{trans('invoices.net_value')}}</th>
                            {{--<th>Amount payable</th>--}}
                            <th>{{trans('invoices.status')}}</th>
                            <th>{{trans('invoices.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoices as $i)
                            <tr id={{'r'.$i->id }} style="text-align: center;">
                               {{-- <td>{{$i->id}}</td>--}}
                                <td>{{\Carbon\Carbon::parse($i->inv_date)->format('Y-m-d')}}</td>
                                <td>@php if($i->is_receipt=="invoice"){
                                    $name="FT";
                                }else if($i->is_receipt=="receipt"){
                                    $name="FR";
                                }else if($i->is_receipt=="simplified"){
                                    $name="FS";
                                } echo $name." ".$i->serie."/".$i->id;@endphp</td>
                                {{--<td>{{$i->remarks}}</td>--}}
                                {{--<td>{{$i->due}}</td>--}}
                                {{--<td>{{$i->po}}</td>--}}
                        <td style="text-align: left">@php $currency = explode("_",$i->currency);
                                     if(Session::get('locale')=='pt'){
                                               echo number_format($i->total_invoice_value - $i->inv_vat,2, ",", " ");
                                            }
                                            else{
                                                echo number_format($i->total_invoice_value - $i->inv_vat,2, ".", "");
                                            }
                                            echo(''.$currency[1]);
                            @endphp</td>
                                {{--<td style="text-align: left">@php $currency = explode("_",$i->currency);
                                    if(Session::get('locale')=='pt'){
                                                echo number_format($i->total_invoice_value,2,",", " ");
                                               }
                                               else{
                                                echo number_format($i->total_invoice_value,2,".", "");
                                               }
                                            echo(''.$currency[1]);
                                    @endphp
                                </td>--}}
                            {{--@php if($i->status==="final"){@endphp
                            <td>{{$i->fault_value}}€</td>
                                @php }else{@endphp
                                <td>-</td>
                                @php } @endphp--}}
                            <td style="text-align: left">@php $currency = explode("_",$i->currency);
                            if(Session::get('locale')=='pt'){
                                                echo number_format($i->inv_vat,2,","," ");
                                            }
                                            else{
                                                echo number_format($i->inv_vat,2,".","");
                                            } 
                                            echo(''.$currency[1]);
                                @endphp</td>
                            <td style="text-align: left">@php $currency = explode("_",$i->currency);
                            if(Session::get('locale')=='pt'){
                                                echo number_format($i->total_invoice_value,2,",", " ");
                                               }
                                               else{
                                                echo number_format($i->total_invoice_value,2,".", "");
                                               }
                                            echo(''.$currency[1]);
                                @endphp</td>
                                <td style="text-align: center">@php if($i->status==="final"){ @endphp
                                    <b style="background: green;color:white;">&nbsp;Final&nbsp;</b>
                                    @php } else if($i->status==="draft"){@endphp
                                    <b style="background: yellow;color:dark;">&nbsp;Draft&nbsp;</b>
                                    @php }else if($i->status==="canceled"){ @endphp
                                    <b style="background: red;color:white;">&nbsp;Canceled&nbsp;</b>
                                    @php }else{ @endphp
                                    <b style="background: gray;color:white;">&nbsp;Paid&nbsp;</b>
                                    @php } @endphp
                                </td>
                                <td style="text-align: center;">
                                    <div class="btn-group">
                                        @php if($i->status==="draft"){ @endphp
                                        <a title="Edit" href="{{route('invoices.edit',$i->id)}}?inv_type={{$is_invoice}}" class="btn-shadow btn btn-warning btn-sm" href="">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        @php } @endphp
                                        <a data-toggle="modal"
                                           data-id = "{{$i->brand_templates_id}}"
                                           data-invoice-id = "{{$i->id}}"
                                           data-title=preview_brand_template
                                           data-target=".template_preview_invoice"
                                           title="Preview"
                                           class="btn-shadow btn btn-primary btn-sm preview_row_invoice" href="">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @php if($i->status==="final"){ @endphp
                                        <a title="Download without signature" href="{{route('download.invoice.pdf',['id' => $i->id, 'digital' => 0])}}" class="btn-shadow btn btn-success btn-sm" href="">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        {{-- <a title="Download with signature" href="{{route('download.invoice.pdf',['id' => $i->id, 'digital' => 1])}}" class="btn-shadow btn btn-info btn-sm" href="">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <a title="Paid" data-toggle="modal"  data-target="#exampleModalPaid{{$i->id}}" href="" class="btn-shadow btn btn-secondary btn-sm">
                                            <i class="fas fa-wallet"></i>
                                        </a>--}}
                                        <a title="Cancel" href="javascript:;" onclick="cancel_invoice_confirm({{$i->id}});" class="btn-shadow btn btn-danger btn-sm" href="">
                                            <i class="fas fa-ban"></i>
                                        </a>

                                        @php } @endphp
                                        @php if($i->status==="draft"){ @endphp
                                        <a title="Delete" href="javascript:;" onclick="del_invoice_confirm({{$i->id}});" class="btn-shadow btn btn-danger btn-sm" href="">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        @php } @endphp
                                        @php if($i->status==="paid"){@endphp
                                        <a title="Create Credit Note" href="{{route('add_credit_note')}}?invcd={{$i->id}}" class="btn-shadow btn btn-warning btn-sm" href="">
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

    @endsection
    <!-- Modal -->
        <div class="modal fade" style="" id="exampleModal" tabindex="-2" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" >
                <div class="modal-content" style="overflow:hidden;">
                    <div class="modal-header">
                        <script>  </script>
                        <h5 class="modal-title" id="exampleModalLabel">{{trans('invoices.import_files')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="load" style="display:none; z-index:8; position:absolute;margin-left:43%; margin-top:25%;text-align:center;">
                        <img  src="{{asset("img/ajax-loader.gif")  }}" alt="this slowpoke moves"  width=50/>
                        <p>{{trans('invoices.please_wait')}} </p>
                    </div>
                    <div class="modal-body" id="aaa" >
                        {{-- {{ route('import_wizard.upload_clients') }} --}}
                        {{-- up_clients --}}
                        <div id ="ccc" style="">
                            <h3 class=>{{trans('invoices.import_invoices')}}</h3>
                            <form action="" id="up_clients" method="post" enctype="multipart/form-data">
                                {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="upload-file">{{trans('invoices.upload')}}</label>
                                    <input type="file" name="upload-file" id = "upload-file" class="form-control">                        </div>
                                <input class="btn btn-success" type="submit" value="{{trans('invoices.import_files')}}" name="submit"><a style="text-decoration: none; color: inherit;" href="{{route('import_wizard.sample_excel')}}">
                                <button type="button" class="btn btn-warning" data-dismiss="modal" style="width:166px"><span class="fas fa-receipt"></span>&nbsp;Download Template </a>
                            </form>
                        </div>
                        {{-- <hr class="mt-5"> --}}
                        {{-- {{ route('import_wizard.upload_items') }} --}}
                        {{-- up_items --}}
                        {{-- <h3 class=>Import Items</h3> --}}
                        {{-- <form action="" id="up_items" method="post" enctype="multipart/form-data"> --}}
                        {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
                        {{-- {{csrf_field()}}
                            <div class="form-group">
                                <label for="upload-file">Upload</label>
                                <input type="file" name="upload-items" id = "upload-items" class="form-control">                        </div>
                            <input class="btn btn-success" type="submit" value="Upload Items" name="submit">
                    </form> --}}

                    </div>
                    <div class="modal-footer" >
                        <span id="er_msg" class="align-self-center"></span>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('invoices.close')}}</button>
                        <div id="imp"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal EuPago -->
        <div class="modal fade" style="" id="exampleModalEuPago" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" >
                <div class="modal-content" style="overflow:hidden;">
                    <div class="modal-header">
                        <script>  </script>
                        <h5 class="modal-title" id="exampleModalLabel">{{trans('invoices.import_files')}} EuPago</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="load_eupago" style="display:none; z-index:8; position:absolute;margin-left:43%; margin-top:25%;text-align:center;">
                        <img  src="{{asset('img/ajax-loader.gif')  }}" alt="this slowpoke moves"  width=50/>
                        <p>{{trans('invoices.please_wait')}} </p>
                    </div>
                    <div class="modal-body" id="ddd" >
                        {{-- {{ route('import_wizard.upload_clients_eupago') }} --}}
                        {{-- up_clients_eupago --}}
                        <div id ="eee" style="">
                            <h3 class=>{{trans('invoices.import_invoices')}}</h3>
                            <form action="" id="up_clients_eupago" method="post" enctype="multipart/form-data">
                                {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="upload-file">{{trans('invoices.upload')}}</label>
                                    <input type="file" name="upload_file_eupago" id = "upload_file_eupago" class="form-control">                        </div>
                                <input class="btn btn-success" type="submit" value="{{trans('invoices.upload_invoices')}} Eupago" name="submit"><a style="text-decoration: none; color: inherit;" href="{{route('import_wizard.sample_excel')}}">
                                <button type="button" class="btn btn-warning" data-dismiss="modal" style="width:166px"><span class="fas fa-receipt"></span>&nbsp;Download Template </a>
                                </button>      </a>  
                            </form>
                            
                        </div>
                    </div>
                    <div class="modal-footer" >
                        <span id="er_msg_eupago" class="align-self-center"></span>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('invoices.close')}}</button>
                        <div id="imp_eupago"></div>
                    </div>
                </div>
            </div>
        </div>
        @foreach($invoices as $i)
            <div class="modal fade" style="" name="exampleModalPaid{{$i->id}}" id="exampleModalPaid{{$i->id}}" tabindex="-2" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" >
                    <div class="modal-content" style="overflow:hidden;">
                        <form method="POST" action="{{route('invoices.register_payment',$i->id)}}">
                            {{csrf_field()}}
                            <div class="modal-header">
                                <script>  </script>
                                <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div id="load" style="display:none; z-index:8; position:absolute;margin-left:43%; margin-top:25%;text-align:center;">
                                <img  src="{{asset('img/ajax-loader.gif')  }}" alt="this slowpoke moves"  width=50/>
                                <p>Please wait </p>
                            </div>
                            <div class="modal-body" id="aaa" >
                                <h6 class="modal-title" id="exampleModalLabel">Register Payment</h6>
                                <br>
                                <div class="row">
                                    <div class="col-3"><b>Value:</b>&nbsp;&nbsp;</div>
                                    <div class="col-9">
                                        <input type="text" name="value_paid" id="value_paid" step="2" max="{{$i->fault_value}}" required>&nbsp;&nbsp;€ of  {{ $i->fault_value   }}€ (total of {{ $i->total_invoice_value }}€ )
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-3"><b>Date:</b>&nbsp;&nbsp;</div>
                                    <div class="col-9">
                                        <input type="date" min="{{$i->inv_date}}" name="date_payment" id="date_payment" required>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-3"><b>Serie:</b>&nbsp;&nbsp;</div>
                                    <div class="col-6">
                                        <input type="text" name="serie" id="serie" value="{{$i->serie}}">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-3"><b>Payment Method:</b>&nbsp;&nbsp;</div>
                                    <div class="col-6">
                                        <select name="payment_method" id="payment_method" required>
                                            <option>Bank transfer or authorized direct debit</option>
                                            <option>MB WAY</option>
                                            <option>Payment reference for ATM</option>
                                            <option>Credit card</option>
                                            <option>Debit card</option>
                                            <option>Bank check</option>
                                            <option>Check or gift card</option>
                                            <option>Clearing current account balances</option>
                                            <option>Electronic money</option>
                                            <option>Business letter</option>
                                            <option>Cash</option>
                                            <option>Exchange of goods</option>
                                            <option>Restaurant Ticket</option>
                                            <option>International documentary credit</option>
                                            <option>Other means not marked here</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-3"><b>Observations:</b>&nbsp;&nbsp;</div>
                                    <div class="col-9">
                                        <textarea name="observations" id="observations" cols=50 rows=4 ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" >
                                <input type="button" class="btn btn-light" value="Cancel">
                                <button class="btn btn-success" type="submit">Register payment and create receipt</button>
                        </form>
                    </div>
                </div>
            </div>
    </div>
    </div>
    @endforeach
@section('javascript')
    <script>

        var flagsUrl = '{{ URL::asset('files') }}';
    </script>
    <script src="{{ asset('js/import_items.js') }}"></script>
    <script src="{{ asset('js/import_clients.js') }}?ver=123456"></script>
    <script src="{{ asset('js/import_clients_eupago.js') }}"></script>
    <script type="text/javascript">
        var APP_URL = {!! json_encode(url('/')) !!}
        $(document).bind("ajaxSend", function(){
            $("#load").show();
            $("#load_eupago").show();
            $("#ccc").hide();
            $("#aaa").html("");
            $("#ddd").html("");
            $("#eee").html("");
        }).bind("ajaxComplete", function(){
            $("#load").hide();
            $("#load_eupago").hide();
        });

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
        function del_invoice_confirm(val)
        {
            $.confirm({
                title: 'Confirm delete',
                content: 'Are you sure you want to delete?',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    confirm:{
                        text: 'Yes',
                        btnClass: 'btn-red',
                        action: function(){

                            del_invoices(val);
                        }
                    },
                    close: function () {
                    }
                }
            });
        }
        function del_invoices(id){

            CSRF_TOKEN  = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{route('invoices.destroy')}}",
                data: {invoice_id: id, _token: CSRF_TOKEN},
                success: function (data) {

                    if(data['success']==="true")
                    {
                        $("#r"+data['id']).hide();
                        notif({
                            msg: "<b>Success : </b>Invoice with id = "+data['id']+" deleted successfully!",
                            type: "success"
                        });
                    }
                    else if(data['success']==="false")
                    {
                        notif({
                            msg: "<b>Error!</b> Invoice with id = "+data['id']+" does not exist!",
                            type: "error",
                            position: "center"
                        });
                    }
                },
                error:function(err){
                    notif({
                        type: "warning",
                        msg: "<b>Warning:</b> Something Went Wrong!",
                        position: "left"
                    });
                }
            });
        }

        function cancel_invoice_confirm(val)
        {
            $.confirm({
                title: 'Confirm cancel',
                content: 'Are you sure you want to cancel?',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    confirm:{
                        text: 'Yes',
                        btnClass: 'btn-red',
                        action: function(){
                            cancel_invoices(val);
                        }
                    },
                    close: function () {
                    }
                }
            });
        }
        function cancel_invoices(id){

            CSRF_TOKEN  = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{route('invoices.cancel')}}",
                data: {invoice_id: id, _token: CSRF_TOKEN},
                success: function (data) {

                    if(data['success']==="true")
                    {
                        $("#r"+data['id']).html(ajax_load).load(loadUrl);
                        notif({
                            msg: "<b>Success : </b>Invoice with id = "+data['id']+" canceled successfully!",
                            type: "success"
                        });
                    }
                    else if(data['success']==="false")
                    {
                        notif({
                            msg: "<b>Error!</b> Invoice with id = "+data['id']+" does not exist!",
                            type: "error",
                            position: "center"
                        });
                    }
                },
                error:function(err){
                    notif({
                        type: "warning",
                        msg: "<b>Warning:</b> Something Went Wrong!",
                        position: "left"
                    });
                }
            });
        }
    </script>
@endsection