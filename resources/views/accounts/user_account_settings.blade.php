@extends('partials.main')
@section('content')
    <style>
        .ui-datepicker-calendar {
            background-color: #fff;
            border: none !important;


            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-size: .88rem !important;
            font-weight: 400 !important;
            line-height: 1.5 !important;
            color: #495057 !important;
            text-align: left !important;
        }

        .ui-widget-header {
            background-color: #fff !important;
            background: #fff !important;
            border: none !important;
            color: #333333 !important;
        }

        .ui-widget-content {
            background: #fff !important;
        }

        .ui-datepicker-calendar table {
            background: #fff !important;
        }

        .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active {
            color: #333333 !important;
            background-color: #fff !important;
            background: #fff !important;
            border: none !important;
        }

        .ui-datepicker td span,
        .ui-datepicker td a {
            font-weight: 300 !important;
        }

        .ui-datepicker-calendar thead tr th {
            font-weight: 300 !important;
        }
    </style>
    <div class="app-main__outer">
        <div class="app-main__inner">

            <div class="breadcrumb mb-5" style="margin-top: -12px">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="{{route('/')}}">{{trans('menu.home')}}</a>
                    <i class="fa fa-angle-right">&nbsp;</i>
                </li>
                <li>
                    <a >{{trans('menu.settings')}}</a>
                    <i class="fa fa-angle-right">&nbsp;</i>
                </li>
                <li>
                    <a >{{trans('menu.Account')}}</a>
                    <i class="fa fa-angle-right">&nbsp;</i>
                </li>
                <li>
                    <a class="breadcrumb-item active" href="">{{trans('accounts.account_details')}}</a>
                </li>
            </div>
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="lnr-user icon-gradient bg-tempting-azure">
                            </i>
                        </div>
                        <div>{{trans('accounts.account_details')}}
                        </div>
                    </div>
                </div>
                <br>
                <div class="card-header-title font-size-sm font-weight-normal" style="float: left;color: grey;">
                    <i class="fas fa-info-circle"></i>
                    <h7> {{trans('accounts.balance_movements_tip')}} </h7>
                </div>
            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div class="panel-body">
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form class="form-horizontal" method="POST" action="{{ route('changePassword') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="col-md-4 control-label">{{trans('accounts.current_password')}}</label>
                                <div class="col-md-6">
                                    <input id="current-password" type="password" class="form-control"
                                           name="current-password" required>
                                    @if ($errors->has('current-password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="col-md-4 control-label">{{trans('accounts.new_password')}}</label>
                                <div class="col-md-6">
                                    <input id="new-password" type="password" class="form-control" name="new-password"
                                           required>
                                    @if ($errors->has('new-password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="new-password-confirm" class="col-md-4 control-label">{{trans('accounts.confirm_new_password')}}</label>
                                <div class="col-md-6">
                                    <input id="new-password-confirm" type="password" class="form-control"
                                           name="new-password_confirmation" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{trans('accounts.change_password')}}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
@endsection
@section('javascript')
@endsection

