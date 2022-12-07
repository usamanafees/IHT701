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
                </li>
            </div>

            <div class="tabs-animation">
                <!-- Button trigger modal -->
                <button style="display:none;" type="button" id="danas" class="btn btn-primary btn-lg" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#myModal">
                    Launch demo modal
                </button>

                <!-- Modal -->

                {{-- <div class="mb-3 card">

                    <div class="card-header-tab card-header">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                            <i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i>
                            SMS
                        </div>
                        <div class="btn-actions-pane-right text-capitalize">
                            <a href="{{route('invoices')}}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm">View All</a>
                        </div>
                    </div>
                    <div class="no-gutters row">
                        <div class="col-sm-6 col-md-4 col-xl-4">
                            <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                                <div class="icon-wrapper rounded-circle">
                                    <div class="icon-wrapper-bg opacity-10 bg-warning"></div>
                                    <i class="fas fa-file text-dark opacity-8"></i></div>
                                <div class="widget-chart-content">
                                    <div class="widget-subheading">Today</div>
                                    <div class="widget-numbers">{{$today}}</div>
                                    <div class="widget-description opacity-8 text-focus">

                                    </div>
                                </div>
                            </div>
                            <div class="divider m-0 d-md-none d-sm-block"></div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-xl-4">
                            <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                                <div class="icon-wrapper rounded-circle">
                                    <div class="icon-wrapper-bg opacity-9 bg-danger"></div>
                                    <i class="fas fa-calendar text-dark opacity-8"></i></div>
                                <div class="widget-chart-content">
                                    <div class="widget-subheading">This Month</div>
                                    <div class="widget-numbers"><span>{{$last_30_days_invoices}}</span></div>
                                    <div class="widget-description opacity-8 text-focus">

                                    </div>
                                </div>
                            </div>
                            <div class="divider m-0 d-md-none d-sm-block"></div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-xl-4">
                            <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                                <div class="icon-wrapper rounded-circle">
                                    <div class="icon-wrapper-bg opacity-9 bg-success"></div>
                                    <i class="fas fa-file-invoice text-dark opacity-8"></i></div>
                                <div class="widget-chart-content">
                                    <div class="widget-subheading">This Year</div>
                                    <div class="widget-numbers text-success"><span>{{$last_year_invoices}}</span></div>
                                    <div class="widget-description text-focus">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center d-block p-3 card-footer">
                        <a href="{{route('sms.list')}}" class="btn-pill btn-shadow btn-wide fsize-1 btn btn-primary btn-lg">
                            <span class="mr-2 opacity-7">
                                <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                            </span>
                            <span class="mr-1">View Complete Report</span>
                        </a>
                    </div>
                </div> --}}
                @if(in_array('2', $modules)  || in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))

                    <div id="invoices">
                            <div class="d-inline card-header-title font-size-lg text-capitalize font-weight-normal" style="float: left;">
                                <h3 > {{trans('invoices.invoicing')}}</h3>
                            </div>

                        <div class="btn-actions-pane-right text-capitalize"style="float: right;">
                            <a href="{{route('invoices')}}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm">{{trans('dash.view_all')}}</a>
                        </div>
                        <br>

                        <div class="mb-3 mt-5 card">
                            <div class="no-gutters row">
                                <div class="col-sm-6 col-md-4 col-xl-4">
                                    <div class="card no-shadow rm-border bg-transparent widget-chart text-left">

                                        <div class="widget-chart-content">
                                            <div class="widget-title opacity-5 text-uppercase">{{trans('dash.today')}}</div>
                                            <div class="widget-subheading" style="margin-top: 2px">{{trans('tips.tip_today_invoice')}}</div>
                                            <div class="widget-numbers">{{$today}}</div>
                                            <div class="widget-description opacity-8 text-focus">
                                                <div class="d-inline text-danger pr-1">
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
                                                <span class="pl-1">{{$set_compare_diff}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider m-0 d-md-none d-sm-block"></div>
                                </div>


                                <div class="col-sm-6 col-md-4 col-xl-4">
                                    <div class="card no-shadow rm-border bg-transparent widget-chart text-left">

                                        <div class="widget-chart-content">
                                            <div class="widget-title opacity-5 text-uppercase">{{trans('dash.this_month')}}</div>
                                            <div class="widget-subheading" style="margin-top: 2px">{{trans('tips.tip_month_invoice')}}</div>
                                            <div class="widget-numbers">{{$today_month_invoice}}</div>
                                            <div class="widget-description opacity-8 text-focus">
                                                <div class="d-inline text-danger pr-1">
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
                                                <span class="pl-1">{{$set_compare_diff_month}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider m-0 d-md-none d-sm-block"></div>
                                </div>



                                <div class="col-sm-6 col-md-4 col-xl-4">
                                    <div class="card no-shadow rm-border bg-transparent widget-chart text-left">

                                        <div class="widget-chart-content">
                                            <div class="widget-title opacity-5 text-uppercase">{{trans('dash.this_year')}}</div>
                                            <div class="widget-subheading" style="margin-top: 2px">{{trans('tips.tip_year_invoice')}}</div>
                                            <div class="widget-numbers">{{$today_year_invoice}}</div>
                                            <div class="widget-description opacity-8 text-focus">
                                                <div class="d-inline text-danger pr-1">
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
                                                <span class="pl-1">{{$set_compare_diff_year}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider m-0 d-md-none d-sm-block"></div>
                                </div>
                            </div>
                        </div>

                @endif
                @if(in_array('3', $modules)  || in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                    <div class="mt-2" id="SMSes">
                        <div class="card-header-title font-size-lg text-capitalize font-weight-normal" style="float: left;">
                            <i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i>
                            <h3>SMS</h3>
                        </div>
                        <div class="btn-actions-pane-right text-capitalize"style="float: right;">
                            <a href="{{route('sms.list')}}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm">{{trans('dash.view_all')}}</a>
                        </div>
                        <br>

                        <div class="mb-3 mt-5 card">
                            <div class="no-gutters row">
                                <div class="col-sm-6 col-md-4 col-xl-4">
                                    <div class="card no-shadow rm-border bg-transparent widget-chart text-left">

                                        <div class="widget-chart-content">
                                            <div class="widget-title opacity-5 text-uppercase">{{trans('dash.today')}}</div>
                                            <div class="widget-subheading" style="margin-top: 2px">{{trans('tips.tip_today_sms')}}</div>
                                            <div class="widget-numbers">{{$today_sms}}</div>
                                            <div class="widget-description opacity-8 text-focus">
                                                <div class="d-inline text-danger pr-1">
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
                                                <span class="pl-1">{{$set_compare_diff_sms}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider m-0 d-md-none d-sm-block"></div>
                                </div>


                                <div class="col-sm-6 col-md-4 col-xl-4">
                                    <div class="card no-shadow rm-border bg-transparent widget-chart text-left">

                                        <div class="widget-chart-content">
                                            <div class="widget-title opacity-5 text-uppercase">{{trans('dash.this_month')}}</div>
                                            <div class="widget-subheading" style="margin-top: 2px">{{trans('tips.tip_month_sms')}}</div>
                                            <div class="widget-numbers">{{$today_month_sms}}</div>
                                            <div class="widget-description opacity-8 text-focus">
                                                <div class="d-inline text-danger pr-1">
                                                    @php
                                                        if ($set_compare_month_sms ==0) {
                                                    @endphp
                                                    <span class="opacity-10 text-danger pr-2">
                                                            <i class="fa fa-angle-down"></i>
                                                            @php
                                                                } else if ($set_compare_month_sms ==1){
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
                                                <span class="pl-1">{{$set_compare_diff_sms_month}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider m-0 d-md-none d-sm-block"></div>
                                </div>



                                <div class="col-sm-6 col-md-4 col-xl-4">
                                    <div class="card no-shadow rm-border bg-transparent widget-chart text-left">

                                        <div class="widget-chart-content">
                                            <div class="widget-title opacity-5 text-uppercase">{{trans('dash.this_year')}}</div>
                                            <div class="widget-subheading" style="margin-top: 2px">{{trans('tips.tip_year_sms')}}</div>
                                            <div class="widget-numbers">{{$today_year_sms}}</div>
                                            <div class="widget-description opacity-8 text-focus">
                                                <div class="d-inline text-danger pr-1">
                                                    @php
                                                        if ($set_compare_year_sms==0) {
                                                    @endphp
                                                    <span class="opacity-10 text-danger pr-2">
                                                            <i class="fa fa-angle-down"></i>
                                                            @php
                                                                } else if ($set_compare_year_sms ==1){
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
                                                <span class="pl-1">{{$set_compare_diff_sms_year}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider m-0 d-md-none d-sm-block"></div>
                                </div>
                            </div>
                        </div>













                    </div>
                    {{-- <div class="row">
                        <div class="col-md-12 col-xl-12">
                            <div class="card mb-3 widget-chart widget-chart2 text-left card-btm-border card-shadow-success border-success">
                                <div class="widget-chat-wrapper-outer">
                                    <div class="widget-chart-content pt-3 pl-3 pb-1">
                                        <div class="widget-chart-flex">
                                            <div class="widget-numbers">
                                                <div class="widget-chart-flex">
                                                    <div class="fsize-4">
                                                        <span>{{number_format(floatval($total), 2, ',', ' ')}}</span>
                                                        <small class="opacity-5">€</small></div>
                                                </div>
                                            </div>
                                        </div>
                                        <h6 class="widget-subheading mb-0 opacity-5">Total Invoice Amount<small></small>(For Last 30 Days)</h6></div>
                                    <div class="no-gutters widget-chart-wrapper mt-3 mb-3 pl-2 he-auto row">
                                        <div class="col-md-9">
                                            <!-- <div id="dashboard-sparklines-1"></div> -->
                                            <div id="chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
            </div>



            @endif
        </div>
    </div>


@endsection

<div id="myModal" class="modal fade"  role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Select Module</h4>
                {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
            </div>
            <div class="modal-body">
                <p>Select Module</p>
                <form  method="POST" action="{{ route('choose_module') }}">
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="col-12">
                            <input type="hidden" name="uid" value="{{ Auth::user()->id }}"/>
                            <select style="width:70%" class="select2 form-control" name="modules[]"  id="modules"  multiple="multiple" required>
                                <option value=""  disabled > Select Module </option> 
                                    @foreach($all_modules as $module)
                                            @if($module->name == "SMS" )
                                                <option value="{{$module->id}}">{{$module->name}}</option>
                                            @endif
                                            @if($module->name == "Invoicing" || $module->name == "Human Resource")
                                            <option  value="{{$module->id}}" disabled>{{$module->name}}</option>
                                            @endif
                                    @endforeach
                            </select>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <button type="submit" class="mt-2 btn btn-primary">{{trans('users.Save')}}</button>
                    </div>
                </form>
            </div>
            {{-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> --}}
        </div>
    </div>
</div>
@section('javascript')
    <script type="text/javascript">
        var ch_module = {!! json_encode($chosen_module) !!}
        $( document ).ready(function() {
            if(ch_module == null || ch_module == 0)
            {
                $("#danas").click();
            }
        });

        //     var values = new Array();
        // var days = new Array();



        // values = <?php echo json_encode($values); ?>;
        // days = <?php echo json_encode($days); ?>;


        // var options = {
        //     chart: {
        //           type: 'area',
        //           height: 250,
        //           width: 900,
        //           zoom: {
        //             enabled: false
        //           }
        //         },
        //         dataLabels: {
        //           enabled: false
        //         },
        //         stroke: {
        //            curve: 'smooth',
        //         },
        //         colors: ['#dd3b62'],

        //       series: [{
        //         name: 'sales',
        //         data: values
        //       }],
        //       xaxis: {
        //         categories: days
        //       }
        //     }

        // var chart = new ApexCharts(document.querySelector("#chart"), options);

        // chart.render();
    </script>
@endsection