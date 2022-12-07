@extends('partials.main')
@section('style')
    <style type="text/css">
        .avatar {
            border: 0.3rem solid rgba(#fff, 0.3);
            margin-top: -6rem;
            margin-bottom: 1rem;
            max-width: 7rem;
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
                            <i class="fas fa-users icon-gradient bg-tempting-azure">
                            </i>
                        </div>
                        <div> Edit Alerts
                        </div>
                    </div>
                </div>

            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="/human_resource/company_settings/alerts/edit/update/{{$company_alerts->id}}">
                        {{ csrf_field() }}
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">Trigger</label>
                                    <select class="form-control" name="trigger" id="trigger" type="number">
                                        <option value="1" @if($company_alerts->remember_time==1) selected @endif>
                                            Triggered 1 day(s) before</option>
                                        <option value="7" @if($company_alerts->remember_time==7) selected @endif>
                                            Triggered 7 day(s) before</option>
                                        <option value="14" @if($company_alerts->remember_time==14) selected @endif>
                                            Triggered 14 day(s) before</option>
                                        <option value="30" @if($company_alerts->remember_time==30) selected @endif>
                                            Triggered 30 day(s) before</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">Status</label>
                                    <select class="form-control" name="status" id="status">
                                            <option value="0">Inactive</option>
                                        <option value="1">Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="description" class="">Type</label>
                                    <input type="text" id="description" value="{{$company_alerts->type}}" placeholder="Description..." class="form-control" disabled>
                                </div>
                            </div>
                        </div>

                        <div style="text-align: right;">
                            <button type="submit" class="mt-2 btn btn-success">{{trans('items.Update')}}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection