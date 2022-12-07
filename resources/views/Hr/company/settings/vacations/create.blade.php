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
                        <div> Create Vacations
                        </div>
                    </div>
                </div>

            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('hr.company.settings.vacations.create')}}">
                        {{ csrf_field() }}
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="name" class="">Name<span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" value="" placeholder="Name..." class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">Period<span class="text-danger">*</span></label>
                                    <select class="form-control" name="period" id="period" type="number" required>
                                    <option disabled selected hidden>Select one option...</option>
                                        <option value="days">
                                            Days</option>
                                        <option value="days or hours">
                                            Days or Hours</option>
                                        <option value="days, hours or 1/2 day">Days, Hours or 1/2 day</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">Limit of days</label>
                                    <input type="number" id="limit" class="form-control" name="limit" value="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">Scheduling<span class="text-danger">*</span></label>
                                    <select class="form-control" name="scheduling" id="scheduling" required>
                                    <option disabled selected hidden>Select one option...</option>
                                        <option value="work days and non-working days">
                                            Work days and non-working days</option>
                                        <option value="work days">
                                            Work days</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <span> Include Food Subsidy?
                            <input type="checkbox" class="checkbox" name="food_subsidy" id="food_subsidy">
                        </span>
                        </div>
                        <div class="form-row">
                            <span> Paid?
                            <input type="checkbox" class="checkbox" name="paid" id="paid">
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