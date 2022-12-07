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
                    <a class="breadcrumb-item active" href="">{{trans('reports.invoice_reports')}}</a>

                </li>
            </div>
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="pe-7s-graph icon-gradient bg-tempting-azure">
                            </i>
                        </div>
                        <div>{{trans('reports.invoice_reports')}}
                        </div>
                    </div>
                </div>
                <br>
                <div class="card-header-title font-size-sm font-weight-normal" style="float: left;color: grey;">
                    <i class="fas fa-info-circle"></i>
                    <h7> {{trans('reports.tip_report')}}</h7>
                </div>
            </div>
            <div class="main-card mb-3 card">
                <div class="card-body"><h5 class="card-title"> {{trans('reports.invoice_reports')}} </h5>
                    <div class="row">
                        <!--<div class="col-sm-12 col-md-6 col-xl-4">
                            <a href="#" style="text-decoration: none; color: inherit;">
                                <div class="card mb-3 widget-chart" style="height: 208px">
                                    <div class="widget-chart-content">
                                        <div class="icon-wrapper rounded">
                                            <div class="icon-wrapper-bg bg-warning"></div>
                                            <i class="fas fa-dollar-sign text-warning"></i></div>
                                        <div class="widget-subheading fsize-1 pt-2 opacity-10 text-warning font-weight-bold">{{trans('reports.client_account')}}</div>
                                        <div class="widget-description opacity-8">
                                            {{trans('reports.revenues')}}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>-->
                        <!--<div class="col-sm-12 col-md-6 col-xl-4">
                            <a href="#" style="text-decoration: none; color: inherit;">
                                <div class="card mb-3 widget-chart" style="height: 208px">
                                    <div class="widget-chart-content">
                                        <div class="icon-wrapper rounded">
                                            <div class="icon-wrapper-bg bg-danger"></div>
                                            <i class="fas fa-file-invoice text-danger"></i></div>
                                        <div class="widget-subheading fsize-1 pt-2 opacity-10 text-danger font-weight-bold">{{trans('reports.invoice_client')}}</div>
                                        <div class="widget-description opacity-8">
                                            {{trans('reports.invoice_client_description')}}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>-->
                        <!--<div class="col-sm-12 col-md-6 col-xl-4">
                            <a href="#" style="text-decoration: none; color: inherit;">
                                <div class="card mb-3 widget-chart" style="height: 208px">
                                    <div class="widget-chart-content">
                                        <div class="icon-wrapper rounded">
                                            <div class="icon-wrapper-bg bg-primary"></div>
                                            <i class="fas fa-file-invoice-dollar text-primary"></i></div>
                                        <div class="widget-subheading fsize-1 pt-2 opacity-10 text-primary font-weight-bold">{{trans('reports.missing_payments')}}</div>
                                        <div class="widget-description opacity-8">
                                            {{trans('reports.missing_payment_description')}}
                                        </div>
                                    </div>
                                </div>
                        </div>
                        </a>
                    </div>-->
                    <!--<div class="row">
                        <div class="col-sm-12 col-md-6 col-xl-4">
                            <a href="#" style="text-decoration: none; color: inherit;">
                                <div class="card mb-3 widget-chart" style="height: 208px">
                                    <div class="widget-chart-content">
                                        <div class="icon-wrapper rounded">
                                            <div class="icon-wrapper-bg bg-success"></div>
                                            <i class="fas fa-money-check-alt text-success"></i></div>
                                        <div class="widget-subheading fsize-1 pt-2 opacity-10 text-success font-weight-bold">{{trans('reports.client_balance')}}</div>
                                        <div class="widget-description opacity-8">
                                            {{trans('reports.client_balance_description')}}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>-->
                        <!--<div class="col-sm-12 col-md-6 col-xl-4">
                            <a href="#" style="text-decoration: none; color: inherit;">
                                <div class="card mb-3 widget-chart" style="height: 208px">
                                    <div class="widget-chart-content">
                                        <div class="icon-wrapper rounded">
                                            <div class="icon-wrapper-bg bg-secondary"></div>
                                            <i class="fas fa-hand-holding-usd text-secondary"></i></div>
                                        <div class="widget-subheading fsize-1 pt-2 opacity-10 text-secondary font-weight-bold">{{trans('reports.tax_map')}}</div>
                                        <div class="widget-description opacity-8">
                                            {{trans('reports.tax_map_description')}}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>-->
                        <!--<div class="col-sm-12 col-md-6 col-xl-4">
                            <a href="#" style="text-decoration: none; color: inherit;">
                                <div class="card mb-3 widget-chart" style="height: 208px">
                                    <div class="widget-chart-content">
                                        <div class="icon-wrapper rounded">
                                            <div class="icon-wrapper-bg bg-warning"></div>
                                            <i class="fas fa-paste text-warning"></i></div>
                                        <div class="widget-subheading fsize-1 pt-2 opacity-10 text-warning font-weight-bold">{{trans('reports.payments_statement')}}</div>
                                        <div class="widget-description opacity-8">
                                            {{trans('reports.payments_statement_description')}}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>-->
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-xl-4">
                            <a href="{{route('report.invoice.BillingByItem')}}"
                               style="text-decoration: none; color: inherit;">
                                <div class="card mb-3 widget-chart" style="height: 208px">
                                    <div class="widget-chart-content">
                                        <div class="icon-wrapper rounded">
                                            <div class="icon-wrapper-bg bg-danger"></div>
                                            <i class="fas fa-scroll text-danger"></i></div>
                                        <div class="widget-subheading fsize-1 pt-2 opacity-10 text-danger font-weight-bold">{{trans('reports.billing_item')}}</div>
                                        <div class="widget-description opacity-8">
                                            {{trans('reports.payments_statement_description')}}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!--<div class="col-sm-12 col-md-6 col-xl-4">
                            <a href="#" style="text-decoration: none; color: inherit;">
                                <div class="card mb-3 widget-chart" style="height: 208px">
                                    <div class="widget-chart-content">
                                        <div class="icon-wrapper rounded">
                                            <div class="icon-wrapper-bg bg-alternate"></div>
                                            <i class="fas fa-pause text-alternate"></i></div>
                                        <div class="widget-subheading fsize-1 pt-2 opacity-10 text-alternate font-weight-bold">{{trans('reports.pending_statement')}}</div>
                                        <div class="widget-description opacity-8">
                                            {{trans('reports.pending_statement_description')}}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>-->
                        <!--<div class="col-sm-12 col-md-6 col-xl-4">
                            <a href="{{route('report.invoice.InvoicesPerBrand')}}" style="text-decoration: none; color: inherit;">
                                <div class="card mb-3 widget-chart" style="height: 208px">
                                    <div class="widget-chart-content">
                                        <div class="icon-wrapper rounded">
                                            <div class="icon-wrapper-bg bg-success"></div>
                                            <i class="fas fa-copyright text-success"></i></div>
                                        <div class="widget-subheading fsize-1 pt-2 opacity-10 text-success font-weight-bold">{{trans('reports.invoices_per_brand')}}</div>
                                        <div class="widget-description opacity-8">
                                            {{trans('reports.invoices_per_brand_tip')}}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script type="text/javascript">
        function set_default_brand(bid, uid) {
            $.confirm({
                title: 'Are You sure!',
                content: 'Are you sure you want to set this as a default Brand ?',
                type: 'orange',
                typeAnimated: true,
                buttons: {
                    confirm: {
                        text: 'Yes',
                        btnClass: 'btn-warning',
                        action: function () {

                            set_default_brand_post(bid, uid)
                        }
                    },
                    close: function () {

                    }
                }
            });
        }

        function set_default_brand_post(bid, uid) {

            CSRF_TOKEN = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{route('brands.default_brand')}}",
                data: {b_id: bid, u_id: uid, _token: CSRF_TOKEN},
                success: function (data) {
                    if (data['success'] === "true") {
                        notif({
                            msg: "<b>Success : </b>Brand with id = " + data['id'] + " set as default Successfully",
                            type: "success"
                        });
                    } else if (data['success'] === "false") {
                        notif({
                            msg: "<b>Error!</b> Brand with id = " + data['id'] + " does not exist",
                            type: "error",
                            position: "center"
                        });
                    }
                },
                error: function (err) {
                    notif({
                        type: "warning",
                        msg: "<b>Warning:</b> Something Went Wrong",
                        position: "left"
                    });
                }
            });
        }
    </script>
@endsection