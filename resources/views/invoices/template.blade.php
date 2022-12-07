@extends('partials.main')
@section('style')
<style type="text/css">
    .note-toolbar{
            background-color: #caccce;
            border-color: #ddd;
    }
    .note-btn-group{
        background-color: white;
        border-color: black;
    }
    hr.line {
        border: 2px solid black;
        border-radius: 2px;
    }
    hr.line_slim{
        border: 1px solid black;
        border-radius: 2px;
    }
    p{
        font-size: 12px;
    }
    
</style>
@endsection
@section('content')
			<div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="pe-7s-print icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('invoices.Invoice_PDF_Template')}}
                                </div>
                            </div>
                             
                        </div>
                    </div> 
                    <div class="main-card mb-3 card">
                    <div class="card-body" style="background-color: #f0f1f3;">  
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <form class="print-form" method="post" action="{{route('print.invoice')}}">
                                        {{csrf_field()}}
                                            <textarea name="contents" class="editor contents" id="editor">
                                               @if($contents == NULL)
                                               <img class="" src="{{asset('admin/assets/images/template_logo.png')}}">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                                               <b>Invoice: BET A/{{$invoice->id}}
                                               </b><br>
                                                <div class="container-fluid">
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-6">
                                                                <br><br><br><p style="font-size: 17px;"><i><b>
                                                                 {{trans('invoices.Invoices_as_receipt')}}
                                                                </b></i></p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p style="background-color: #caccce;font-size: 15px;">
                                                                <!-- &nbsp;Dear Sir.:<br> -->
                                                                &nbsp;<b>{{$invoice->Clients->name}}</b><br>
                                                                &nbsp;{{$invoice->Clients->address}}<br>
                                                                &nbsp;{{$invoice->Clients->postal_code}} {{$invoice->Clients->city}}<br>
                                                                &nbsp;{{$invoice->Clients->Countries->name}}</p>
                                                        </div>
                                                    </div>
                                                    <br>

                                                    <div class="row">
                                                        <div class="col-3">
                                                                <span style="font-size: 17px;">
                                                                    {{trans('invoices.Order')}}
                                                                </span>
                                                                <p style="font-size: 15px;background-color: #e1e6e8;"><b>BET A/{{$invoice->id}}</b></p>
                                                        </div>
                                                        <div class="col-3">
                                                                <span style="font-size: 17px;">
                                                                    {{trans('invoices.Site')}}
                                                                </span>
                                                                <p style="font-size: 15px;background-color: #e1e6e8;"><b>Fixando, Unipessoal Lda</b></p>
                                                        </div>
                                                        <div class="col-3">
                                                                <span style="font-size: 17px;">
                                                                    {{trans('invoices.Payment_Method')}}
                                                                </span>
                                                                <p style="font-size: 15px;background-color: #e1e6e8;"><b>ATM - Payment</b></p>
                                                        </div>
                                                        <div class="col-3">
                                                                <span style="font-size: 17px;">
                                                                    {{trans('invoices.Document')}}
                                                                </span>
                                                                <p style="font-size: 15px;background-color: #e1e6e8;"><b>Original</b></p>
                                                        </div>
                                                        
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-3">
                                                                <span style="font-size: 17px;">
                                                                    {{trans('invoices.Page')}}
                                                                </span>
                                                                <p style="font-size: 15px;background-color: #e1e6e8;"><b>1/1</b></p>
                                                        </div>
                                                        <div class="col-3">
                                                                <span style="font-size: 17px;">
                                                                    {{trans('invoices.Issuance_Date')}}
                                                                </span>
                                                                <p style="font-size: 15px;background-color: #e1e6e8;"><b>
                                                                    {{\Carbon\Carbon::parse($invoice->inv_date)->format('d-m-Y')}}
                                                                </b></p>
                                                        </div>
                                                        <div class="col-3">
                                                                <span style="font-size: 17px;">
                                                                    {{trans('invoices.Sales_Channel')}}
                                                                </span>
                                                                <p style="font-size: 15px;background-color: #e1e6e8;"><b>By Phone</b></p>
                                                        </div>
                                                        <div class="col-3">
                                                                <span style="font-size: 17px;">
                                                                    {{trans('invoices.V_Taxpayer')}}
                                                                </span>
                                                                <p style="font-size: 15px;background-color: #e1e6e8;"><b>
                                                                    {{$invoice->Clients->vat_number}}
                                                                </b></p>
                                                        </div>
                                                        
                                                    </div>
                                                    <hr class="line">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <table class="table table-bordered" style="widows: 100%;">
                                                                <tbody><tr>
                                                                    <th>{{trans('invoices.Reference')}}</th>
                                                                    <th>{{trans('invoices.Description')}}</th>
                                                                    <th>{{trans('invoices.Qty')}}</th>
                                                                    <th>{{trans('invoices.Price_Unit')}}</th>
                                                                    <th>{{trans('invoices.VAT')}}</th>
                                                                    <th>{{trans('invoices.Total')}}</th>
                                                                </tr>
                                                                    @foreach($line_items as $items)
                                                                    <tr>
                                                                        <td>
                                                                            {{\Carbon\Carbon::parse($items->created_at)->format('d-m-Y')}}
                                                                        </td>
                                                                        <td>{{$items->description}}</td>
                                                                        <td>{{$items->qty}}</td>
                                                                        <td>{{$items->unit_price}}{{$currency}}</td>
                                                                        <td>{{$items->vat}}%</td>
                                                                        <td>{{$items->total}}{{$currency}}</td>
                                                                    </tr>
                                                                    @endforeach
                                                            </tbody>
                                                        </table>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="row">
                                                        <div class="col-8" style="text-align: center;">
                                                                <br>
                                                                <p style="font-size: 15px;"><i>Document Note:</i><br>
                                                                ** DEVELOPMENT MODE / WITHOUT TAX VALUE**
                                                                </p>
                                                                <br><br><br>
                                                        </div>
                                                    </div> -->
                                                    <!-- <br> -->
                                                    <hr class="line">
                                                    <!-- <br> -->
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="row" style="margin-left: 0%;background-color: #caccce;">
                                                                <div class="col-10">
                                                                    <p style="font-size: 15px;">
                                                                    &nbsp;<b>1. Payment of Services (ATM)</b><br>
                                                                    &nbsp;Company:  12229<br>
                                                                    &nbsp;<b>Reference</b>: 587 939 755<br>
                                                                    &nbsp;Amount:   65,00 Euros<br>
                                                                    <br>
                                                                    &nbsp;<b>2. Bank Transfer</b><br>
                                                                    &nbsp;IBAN: PT5000339999999999<br>
                                                                    &nbsp;SWIFT:    BCOMPTPL<br>
                                                                    </p>
                                                                </div>
                                                                <!-- <div class="col-2" style="margin-top: 12%;">
                                                                   <img src="http://invoicing.local/admin/assets/images/template_small_logo.png" style="width: 40px;">
                                                                </div> -->
                                                            </div>
                                                        </div>
                                                        <div class="col-3">
                                                            <p style="font-size: 15px;">
                                                               {{trans('invoices.Sub_Total')}}<br>
                                                                {{trans('invoices.VAT')}} 23%<br>
                                                                {{trans('invoices.Total_Document')}}</p>
                                                        </div>
                                                        <div class="col-3">
                                                            <p style="font-size: 15px;">
                                                            {{$currency}} {{$invoice->inv_subtotal}}<br>
                                                            {{$currency}} <br>
                                                            {{$currency}} {{$invoice->inv_subtotal}}</p>
                                                        </div>
                                                    </div>
                                                    <hr class="line_slim">
                                                    <div class="row">
                                                        <div class="col-4" style="text-align: center;">
                                                            <p style="font-size: 12px;"> {{trans('invoices.Location_Load')}}:  N/ Facilities<br>
                                                                {{trans('invoices.Unloading_Location')}}:  V/ Installations</p>
                                                        </div>
                                                        <div class="col-4" style="text-align: center;">
                                                            <p style="font-size: 12px;">{{trans('invoices.Shipping_Mode')}}:  V/ Vehicle<br>
                                                                {{trans('invoices.Registration')}}:   ___________</p>
                                                        </div>
                                                        <div class="col-4" style="text-align: center;">
                                                            <p style="font-size: 12px;">{{trans('invoices.Load_Time')}}:<br>
                                                            {{trans('invoices.Discharge_Time')}}:  ________</p>
                                                        </div>
                                                        <div class="col-12">
                                                            <span style="font-size: 12px;">
                                                               {{trans('invoices.invoices_goods')}}
                                                            </span><br>
                                                            <span style="font-size: 12px;">
                                                                {{trans('invoices.c_wr')}}
                                                            </span>
                                                            <p style="font-size: 12px; text-align: center;">
                                                                _____________________________________ 
                                                                <b>{{trans('invoices_between_line')}}</b> _____________________________________</p>
                                                            <span style="font-size: 12px;">Rua Prof. Mark Athias, Nº 4, 4º Dtº 1600-646 Lisboa
                                                            </span><br>
                                                            <span style="font-size: 12px;">Taxpayer No. 510 953 964 ~ Social Capital € 5,000.00 ~ Cons. Reg. Com. Lisboa 
                                                            </span>    
                                                                     
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                @else
                                                    {{$contents}}
                                                @endif      
                                            </textarea>
                                    
                                    <br>
                                    <div class="" style="text-align: right;">
                                          <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                                          <button type="submit" class="mb-2 mr-2 btn-icon btn btn-alternate"
                                          data-original-title="print">
                                          <i class="fas fa-download btn-icon-wrapper"></i>
                                            DOWNLOAD PDF</button>
                                        
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    </div>      
                </div>
            </div>
@endsection
@section('javascript')
<!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"> -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="{{asset('admin/assets/summernote/summernote.js')}}"></script>

<script type="text/javascript">
    $('#editor').summernote({
      toolbar: [
        ['fontsize', ['fontsize']],
        ['height', ['height']]
        ['style', ['style']],
        ['font', ['bold', 'underline', 'clear', 'italic']],
        ['fontname', ['fontname']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['view', ['codeview']],
        ],
    });

    $('button[data-original-title=print]').click(function () {   
        var contents =  $(".contents").summernote('code');
        $(".print-form").append("<input type='hidden' value='"+contents+"' name='pdf_data'>");
    });


</script>
@endsection