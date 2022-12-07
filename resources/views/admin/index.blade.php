@extends('partials.main')

@section('content')
 
            <div class="app-main__outer">
                <div class="app-main__inner">
                   
                    <div class="tabs-animation">
                        <div class="mb-3 card">
                            @if (number_format($user->AccountSettings->in_app_credit) == 0 && Auth::user()->roles()->pluck('name')->implode(' ')  != 'Administrator')
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                  {{trans('admin.balance_null')}}<a class="alert-link" href="{{route('account.balance')}}"><strong>{{trans('admin.recharge')}}</strong> </a>
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                            @endif
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal">
                                    <i class="header-icon lnr-charts icon-gradient bg-happy-green"> </i>
                                    {{trans('invoices.invoicing')}}
                                </div>
                                <div class="btn-actions-pane-right text-capitalize">
                                    <a href="{{route('invoices')}}" class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm">{{trans('admin.view_all')}}</a>
                                </div>
                            </div>
                            <div class="no-gutters row">
                                <div class="col-sm-6 col-md-4 col-xl-4">
                                    <div class="card no-shadow rm-border bg-transparent widget-chart text-left">
                                        <div class="icon-wrapper rounded-circle">
                                            <div class="icon-wrapper-bg opacity-10 bg-warning"></div>
                                            <i class="fas fa-file text-dark opacity-8"></i></div>
                                        <div class="widget-chart-content">
                                            <div class="widget-subheading">{{trans('admin.today')}}</div>
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
                                            <div class="widget-subheading">{{trans('admin.this_month')}}</div>
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
                                            <div class="widget-subheading">{{trans('admin.this_year')}}</div>
                                            <div class="widget-numbers text-success"><span>{{$last_year_invoices}}</span></div>
                                            <div class="widget-description text-focus">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center d-block p-3 card-footer">
                                <a href="{{route('invoices')}}" class="btn-pill btn-shadow btn-wide fsize-1 btn btn-primary btn-lg">
                                    <span class="mr-2 opacity-7">
                                        <i class="icon icon-anim-pulse ion-ios-analytics-outline"></i>
                                    </span>
                                    <span class="mr-1">{{trans('admin.report')}}</span>
                                </a>
                            </div>
                        </div>
                       
                        <div class="row">
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
                                            <h6 class="widget-subheading mb-0 opacity-5">{{trans('admin.invoice_amount')}}<small></small>{{trans('admin.last_days')}}</h6></div>
                                        <div class="no-gutters widget-chart-wrapper mt-3 mb-3 pl-2 he-auto row">
                                            <div class="col-md-9">
                                                <!-- <div id="dashboard-sparklines-1"></div> -->
                                                <div id="chart"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-header-tab card-header">
                                <div class="card-header-title font-size-lg text-capitalize font-weight-normal"><i class="header-icon lnr-laptop-phone mr-3 text-muted opacity-6"> </i>Invoices Tables</div>
                            </div>
                            <div class="card-body">
                                <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Invoice ID</th>
                                    <th>{{trans('invoices.Invoice_Date')}}</th>
                                    <th>{{trans('invoices.Remarks')}}</th>
                                    <th>{{trans('invoices.Due')}}</th>
                                    <th>{{trans('invoices.PO')}}</th>
                                    <th>{{trans('invoices.Amount')}}</th>
                                    <th>{{trans('admin.action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($invoices as $invoice)
                                        <tr>
                                           <td>{{$invoice->id}}</td>
                                           <td>{{\Carbon\Carbon::parse($invoice->inv_date)->format('d m Y')}}</td>
                                           <td>{{$invoice->remarks}}</td>
                                           <td>{{$invoice->due}}</td>
                                           <td>{{$invoice->po}}</td>
                                           <td> @php $currency = explode("_",$invoice->currency);
                                               echo number_format(($invoice->inv_subtotal - $invoice->inv_discount + $invoice->inv_vat), 2, ',', ' ');
                                            echo(' '.$currency[1]);
                                            @endphp</td>
                                           <td style="text-align: right;">
                                            <div class="btn-group">
                                                @can('Edit Invoice')
                                                   <a href="{{route('invoices.edit',$invoice->id)}}" class="btn-shadow btn btn-warning btn-sm" href="">
                                                       <i class="fas fa-eye"></i>
                                                   </a>
                                                   <a href="{{route('invoices.destroy',$invoice->id)}}" class="btn-shadow btn btn-danger btn-sm" href="">
                                                       <i class="fas fa-trash"></i>
                                                   </a>
                                               @endcan
                                               <a href="{{route('download.invoice.pdf',$invoice->id)}}" class="btn-shadow btn btn-success btn-sm" href="">
                                                   <i class="fas fa-print"></i>
                                               </a>
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
            </div>


@endsection
@section('javascript')
<script type="text/javascript">
        var values = new Array();
    var days = new Array();

    

    values = <?php echo json_encode($values); ?>;
    days = <?php echo json_encode($days); ?>;


    var options = {
        chart: {
              type: 'area',
              height: 250,
              width: 900,
              zoom: {
                enabled: false
              }
            },
            dataLabels: {
              enabled: false
            },
            stroke: {
               curve: 'smooth',
            },
            colors: ['#dd3b62'],

          series: [{
            name: 'sales',
            data: values
          }],
          xaxis: {
            categories: days
          }
        }

    var chart = new ApexCharts(document.querySelector("#chart"), options);

    chart.render();
</script>
@endsection