@php
    $modules = explode(',', Auth::user()->access_modules);
    $chosen_module = Auth::user()->choose_module;
@endphp
@extends('partials.main')

@section('content')

    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="breadcrumb " style="margin-top: -12px">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="{{route('/')}}">{{trans('menu.home')}}</a>
                    <i class="fa fa-angle-right">&nbsp;</i>
                </li>
                <li>
                    <a class="breadcrumb-item active" href="">{{trans('menu.invoicing')}}</a>
                </li>

            </div>
            <div class="tabs-animation">
                @if(in_array('2', $modules)  || in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                    <div id="invoices">

                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal" style="float: left;">
                            <i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i>
                            <h3>{{trans('invoices.invoicing')}}</h3>
                        </div>
                    </div>


                        <br><br>
                        <div class="card-header-title font-size-sm font-weight-normal" style="float: left; color: grey;">
                         <i class="fas fa-info-circle"></i>
                            <h7> {{trans('tips.invoicing')}}</h7>
                        </div>


                    </div>

            <div class="row mt-5" >
                <div class="col-md-6 col-lg-4 ">
                    <div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-left card">
                        <div class="widget-chat-wrapper-outer">
                            <div class="widget-chart-content">
                                <div class="widget-title opacity-5 text-uppercase">{{trans('dash.today')}}</div>
                                <div class="widget-subheading" style="margin-top: 2px">{{trans('tips.tip_today_invoice')}}</div>
                                <div class="widget-chart-flex">
                                    <div class="widget-numbers mb-0 w-100">
                                        <div>
                                            @php
                                                if ($set_compare_today_invoice ==0) {
                                            @endphp
                                            <span class="opacity-10 text-danger pr-2">
                                                            <i class="fa fa-angle-down"></i>
                                                            @php
                                                                } else if ($set_compare_today_invoice ==1){
                                                            @endphp
                                                            <span class="opacity-10 text-success pr-2">
                                                            <i class="fa fa-angle-up"></i>
                                                            @php
                                                                } else{
                                                            @endphp
                                                            <span class="opacity-10 text-secondary pr-2">
                                                            <i class="fas fa-grip-lines"></i>
                                                        @php
                                                            }
                                                        @endphp
                                                            </span>
                                                                {{$today}}
                                                        <small class="opacity-5 pl-1"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 ">
                    <div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-left card">
                        <div class="widget-chat-wrapper-outer">
                            <div class="widget-chart-content">
                                <div class="widget-title opacity-5 text-uppercase">{{trans('dash.this_month')}}</div>
                                <div class="widget-subheading" style="margin-top: 2px">{{trans('tips.tip_month_invoice')}}</div>
                                <div class="widget-chart-flex">
                                    <div class="widget-numbers mb-0 w-100">
                                        <div>

                                            @php
                                                if ($set_compare_month_invoice ==0) {
                                            @endphp
                                            <span class="opacity-10 text-danger pr-2">
                                                            <i class="fa fa-angle-down"></i>
                                                            @php
                                                                } else if ($set_compare_month_invoice ==1){
                                                            @endphp
                                                            <span class="opacity-10 text-success pr-2">
                                                            <i class="fa fa-angle-up"></i>
                                                            @php
                                                                } else{
                                                            @endphp
                                                            <span class="opacity-10 text-secondary pr-2">
                                                            <i class="fas fa-grip-lines"></i>
                                                                    @php
                                                                        }
                                                                    @endphp
                                                            </span>
                                                            {{$today_month_invoice}}
                                                            <small class="opacity-5 pl-1"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-left card">
                        <div class="widget-chat-wrapper-outer">
                            <div class="widget-chart-content">
                                <div class="widget-title opacity-5 text-uppercase">{{trans('dash.this_year')}}</div>
                                <div class="widget-subheading" style="margin-top: 2px">{{trans('tips.tip_year_invoice')}}</div>
                                <div class="widget-chart-flex">
                                    <div class="widget-numbers mb-0 w-100">
                                        <div>
                                            @php
                                                if ($set_compare_year_invoice ==0) {
                                            @endphp
                                            <span class="opacity-10 text-danger pr-2">
                                                            <i class="fa fa-angle-down"></i>
                                                            @php
                                                                } else if ($set_compare_year_invoice ==1){
                                                            @endphp
                                                            <span class="opacity-10 text-success pr-2">
                                                            <i class="fa fa-angle-up"></i>
                                                            @php
                                                                } else{
                                                            @endphp
                                                            <span class="opacity-10 text-secondary pr-2">
                                                            <i class="fas fa-grip-lines"></i>
                                                                    @php
                                                                        }
                                                                    @endphp
                                                        </span>
                                                        {{$today_year_invoice}}
                                                        <small class="opacity-5 pr-1"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

                        

                    <div class="card mt-2 mb-3">
                        <div class="card-header-tab card-header">
                            <div class="card-header-title font-size-lg text-capitalize font-weight-normal"><i class="header-icon lnr-laptop-phone mr-3 text-muted opacity-6"> </i>{{trans('invoices.invoices_table')}}</div>
                        </div>
                        <div class="card-body">
                            <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                <thead>
                                <tr style="text-align: center">
                                    <th>{{trans('invoices.Invoice_Date')}}</th>
                                    <th>{{trans('invoices.invoice_number')}}</th>
                                    {{--<th>{{trans('invoices.Invoice_Date')}}</th>
                                    <th>{{trans('invoices.Remarks')}}</th>
                                    <th>{{trans('invoices.Due')}}</th>
                                    <th>{{trans('invoices.PO')}}</th>--}}
                                    <th>{{trans('invoices.total_value')}}</th>
                                    <th>{{trans('invoices.vat_value')}}</th>
                                    <th>{{trans('invoices.net_value')}}</th>
                                    <th>{{trans('invoices.status')}}</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($invoices as $i)
                                    <tr>
                                        <td style="text-align: center">{{\Carbon\Carbon::parse($i->inv_date)->format('Y-m-d')}}</td>
                                        <td style="text-align: center">@php if($i->is_receipt=="invoice"){
                                    $name="FT";
                                }else if($i->is_receipt=="receipt"){
                                    $name="FR";
                                }else if($i->is_receipt=="simplified"){
                                    $name="FS";
                                } echo $name." ".$i->serie."/".$i->id;@endphp</td>
                                        {{--<td style="text-align: center">{{$i->remarks}}</td>
                                        <td style="text-align: center">{{$i->due}}</td>
                                        <td style="text-align: center">{{$i->po}}</td>--}}
                                        <td style="text-align: left">@php $currency = explode("_",$i->currency);
                                            if(Session::get('locale')=='pt'){
                                               echo number_format($i->total_invoice_value - $i->inv_vat,2,","," ");
                                            }
                                               else{
                                                echo number_format($i->total_invoice_value - $i->inv_vat,2,".","");
                                            }
                                            echo(''.$currency[1]);
                                            @endphp</td>
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

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>
        </div>


        @endsection

        @section('javascript')
            <script type="text/javascript">

            </script>
@endsection