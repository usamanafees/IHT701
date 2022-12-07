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
                        <div> Edit Vacations
                        </div>
                    </div>
                </div>

            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="/human_resource/company_settings/vacations/edit/update/{{$company_vacations->id}}">
                        {{ csrf_field() }}
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="name" class="">Name</label>
                                    <input type="text" id="name" name="name" value="{{$company_vacations->name}}" placeholder="Name..." class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">Period</label>
                                    <select class="form-control" name="period" id="period" type="number">
                                        <option value="days" @if($company_vacations->period=="days") selected @endif>
                                            Days</option>
                                        <option value="days or hours" @if($company_vacations->period=="days or hours") selected @endif>
                                            Days or Hours</option>
                                        <option value="days, hours or 1/2 day" @if($company_vacations->period=="days, hours or 1/2 day") selected @endif>
                                            Days, Hours or 1/2 day</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">Limit of days</label>
                                    <input type="number" id="limit" class="form-control" name="limit" value="{{$company_vacations->days_limit}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">Scheduling</label>
                                    <select class="form-control" name="scheduling" id="scheduling">
                                        <option value="work days and non-working days" @if($company_vacations->bookings=="work days and non-working days") selected @endif>
                                            Work days and non-working days</option>
                                        <option value="work days" @if($company_vacations->bookings=="work days") selected @endif>
                                            Work days</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <span> Include Food Subsidy?
                            <input type="checkbox" class="checkbox" name="food_subsidy" id="food_subsidy" @if($company_vacations->food_subsidy==1) checked @endif>
                        </span>
                        </div>
                        <div class="form-row">
                            <span> Paid?
                            <input type="checkbox" class="checkbox" name="paid" id="paid" @if($company_vacations->paid==1) checked @endif>
                        </span>
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