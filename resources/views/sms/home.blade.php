@php

    $modules = explode(',', Auth::user()->access_modules);

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
                    <a class="breadcrumb-item active" href="">SMS</a>
                </li>

            </div>

            <div class="tabs-animation">
                @if(in_array('3', $modules)  || in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                    <div id="SMSes">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal" style="float: left;">
                            <i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i>
                            <h3>SMS</h3>
                        </div>
                        <br>
                        <div class="row mt-5" >
                            <div class="col-md-6 col-lg-4  ">
                                <div class="card-shadow-primary mb-3 widget-chart widget-chart2 text-left card">
                                    <div class="widget-chat-wrapper-outer">
                                        <div class="widget-chart-content">
                                            <div class="widget-title opacity-5 text-uppercase">{{trans('dash.today')}}</div>
                                            <div class="widget-subheading" style="margin-top: 2px">{{trans('tips.tip_today_sms')}}</div>
                                            <div class="widget-chart-flex">
                                                <div class="widget-numbers mb-0 w-100">
                                                    <div>
                                                        @php
                                                            if ($set_compare_today_sms ==0) {
                                                        @endphp
                                                        <span class="opacity-10 text-danger pr-2">
                                                            <i class="fa fa-angle-down"></i>
                                                            @php
                                                                } else if ($set_compare_today_sms ==1){
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
                                                        {{$today_sms}}
                                                        <small class="opacity-5 pr-1"></small>
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
                                            <div class="widget-subheading" style="margin-top: 2px">{{trans('tips.tip_month_sms')}}</div>
                                            <div class="widget-chart-flex">
                                                <div class="widget-numbers mb-0 w-100">
                                                    <div>
                                                        @php
                                                            if ($set_compare_month_sms ==0) {
                                                        @endphp
                                                        <span class="opacity-10 text-danger pr-2">
                                                            <i class="fa fa-angle-down"></i>
                                                            @php
                                                                } else if ($set_compare_month_sms==1){
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
                                                        {{$today_month_sms}}
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
                                            <div class="widget-title opacity-5 text-uppercase">{{trans('dash.this_year')}}</div>
                                            <div class="widget-subheading" style="margin-top: 2px">{{trans('tips.tip_year_sms')}}</div>
                                            <div class="widget-chart-flex">
                                                <div class="widget-numbers mb-0 w-100">
                                                    <div>
                                                        @php
                                                            if ($set_compare_year_sms ==0) {
                                                        @endphp
                                                        <span class="opacity-10 text-danger pr-2">
                                                            <i class="fa fa-angle-down"></i>
                                                            @php
                                                                } else if ($set_compare_year_sms==1){
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
                                                        {{ $today_year_sms }}
                                                        <small class="opacity-5 pl-1"></small>
                                                    </div>

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
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal"><i class="header-icon lnr-laptop-phone mr-3 text-muted opacity-6"> </i>{{trans('sms.sms_table')}}</div>
                            </div>
                            <div class="card-body">
                                <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                <thead>
                                <tr style="text-align: center">
                                  {{--<th>{{trans('sms.sms_id')}}</th>--}}
                                  <th>{{trans('sms.date')}}</th>
                                  <th>{{trans('sms.hours')}}</th>
                                  <th>{{trans('sms.Sender')}}</th>
                                    <th>{{trans('sms.mobile_num')}}</th>
                                    <th>{{trans('sms.cost_charged')}}</th>
                                    <th>{{trans('sms.state')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($smss as $sms)
                                    <tr>
                                        {{--<td style="text-align: center;">{{$sms->id}}</td>--}}
                                        <td style="text-align: center;">{{\Carbon\Carbon::parse($sms->date)->format("Y-m-d")}}</td>
                                        <td style="text-align: center;">{{\Carbon\Carbon::parse($sms->date)->format("H:i")}}</td>
                                        <td style="text-align: center;">{{$sms->sender}}</td>
                                        <td style="text-align: center;">{{$sms->mobile_num}}</td>
                                        <td style="text-align: left;">@php
                                        if(Session::get('locale')=='pt'){
                                            echo number_format($sms->cost_charged,3,","," ")."€";
                                                    }
                                                    else{
                                                        echo number_format($sms->cost_charged,3,".","")."€";
                                                    }                          
                                                
                                            @endphp</td>
                                        <td style="text-align: center;">{{$sms->state}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection


@section('javascript')
    <script type="text/javascript">

    </script>
@endsection