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
                    <a class="breadcrumb-item">{{trans('menu.report')}}</a>
                    <i class="fa fa-angle-right">&nbsp;</i>
                </li>
                <li>
                    <a class="breadcrumb-item"
                       href="{{route('report.invoice.index')}}">{{trans('reports.invoice_reports')}}</a>
                    <i class="fa fa-angle-right">&nbsp;</i>
                </li>
                <li>
                    <a class="breadcrumb-item active" href="">{{trans('reports.invoices_per_brand')}}</a>
                </li>
            </div>
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-graph icon-gradient bg-tempting-azure">
                            </i>
                        </div>
                        <div>{{trans('reports.invoices_per_brand')}}
                        </div>
                    </div>
                </div>
                <br>
                <div class="card-header-title font-size-sm font-weight-normal" style="float: left;color: grey;">
                    <i class="fas fa-info-circle"></i>
                    <h7> {{trans('reports.invoices_per_brand_tip')}}</h7>
                </div>
            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">

                    <form action="" method="get">
                        <div class="position-relative row form-group"><label for="exampleSelect" class="col-sm-2 col-form-label">{{trans('reports.brand')}}</label>
                            <div class="col-sm-10"><select name="brand_id" id="brand_id" class="form-control">
                                    <option value=""></option>
                                    @if(isset($brands_available))
                                        @foreach ($brands_available as $name)
                                            <option value="{{$name->id}}">{{$name->name}}</option>
                                        @endforeach
                                    @endif
                                </select></div>
                        </div>
                        <div class="position-relative row form-group"><label for="exampleSelect" class="col-sm-2 col-form-label">{{trans('reports.inv_type')}}</label>
                            <div class="col-sm-10"><select name="inv_type" id="inv_type" class="form-control">
                                    <option value=""></option>
                                    @if(isset($inv_type_available))
                                        @foreach ($inv_type_available as $inv_type)
                                            <option value="{{$inv_type->is_receipt}}">{{trans('invoices.'.$inv_type->is_receipt)}}</option>
                                        @endforeach
                                    @endif
                                </select></div>
                        </div>
                        <input class="mt-1 btn-wide btn-outline-2x btn btn-outline-focus btn-sm float-right" type="submit" value="{{trans('reports.filter')}}">
                    </form>
                    <br><br><br>
                    <div id="chart"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        var options = {
            series: [{
                name: '',
                data: [@foreach($give_result as $result)
                    {{$result->total_invoices.','}}
                    @endforeach]
            }],
            chart: {
                height: 350,
                type: 'bar',
            },
            plotOptions: {
                bar: {
                    borderRadius: 10,
                    dataLabels: {
                        position: 'top', // top, center, bottom
                    },
                }
            },
            dataLabels: {
                enabled: false,
                formatter: function (val) {
                    return val;
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                }
            },
            xaxis: {
                categories: [@foreach($give_result as $result)
                    @php echo('"');@endphp {{$result->name}} @php echo('",');@endphp
                    @endforeach
                ],
                position: 'top',
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                crosshairs: {
                    fill: {
                        type: 'gradient',
                        gradient: {
                            colorFrom: '#D8E3F0',
                            colorTo: '#BED1E6',
                            stops: [0, 100],
                            opacityFrom: 0.4,
                            opacityTo: 0.5,
                        }
                    }
                },
                tooltip: {
                    enabled: true,
                }
            },
            yaxis: {
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    show: false,
                    formatter: function (val) {
                        return val;
                    }
                }

            },
        };
        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endsection