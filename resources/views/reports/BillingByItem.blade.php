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
                    <a class="breadcrumb-item active" href="">{{trans('reports.billing_item')}}</a>
                </li>
            </div>
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-graph icon-gradient bg-tempting-azure">
                            </i>
                        </div>
                        <div>{{trans('reports.billing_item')}}
                        </div>
                    </div>
                </div>
                <br>
                <div class="card-header-title font-size-sm font-weight-normal" style="float: left;color: grey;">
                    <i class="fas fa-info-circle"></i>
                    <h7> {{trans('reports.bbi_tip')}}</h7>
                </div>
            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <form action="" method="GET">
                        <div class="col">
                            <input type="text" class="form-control" name="search" required/>
                            <input class="mt-1 btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm"
                                   type="submit" value="{{trans('reports.search')}}">
                    </form>
                    <br><br>
                    <form action="" method="get">
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" name="daterange" id="daterange"/>
                            </div>
                            <div class="col mt-1">
                                <input class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm"
                                       type="submit" value="{{trans('reports.view_reportSmsSent')}}">
                            </div>
                        </div>
                        <div class="mt-1" id="checkboxes">
                            @if(isset($names))
                                @foreach ($names as $name)
                                    <input type="checkbox" id="item_id" name="item_id" value="{{ $name->id}}">
                                    <label for="item_id">{{ $name->description}}</label><br>
                                @endforeach
                            @else
                                <p>{{trans('reports.no_items')}}</p>
                            @endif
                        </div>
                    </form>
                    <br><br>
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
                    {{$result->Total.','}}
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
                        @php echo('"');@endphp {{$result->description}} - {{$result->PriceTotal}}€ @php echo('",');@endphp
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