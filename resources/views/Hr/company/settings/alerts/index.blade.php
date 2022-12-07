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
                    <div> Company Settings
                    </div>
                </div>
            </div>

        </div>
        <div class="container">
        <div class="nav nav-pills">
        <a href="{{ route('hr.company.settings.alerts')}}" class="nav-link active"><span>Alerts</span></a>
        <a href="{{ route('hr.company.settings.vacations')}}" class="nav-link"><span>Vacations/Absences</span></a>
        <a href="{{ route('hr.company.settings.extradays')}}" class="nav-link"><span>Extra Days</span></a>
        <a href="{{ route('hr.company.settings.holidays')}}" class="nav-link"><span>Holidays</span></a>
        <a href="{{ route('hr.company.settings.workdays')}}" class="nav-link"><span>Work Days</span></a>
        <a href="{{ route('hr.company.settings.general')}}" class="nav-link"><span>General</span></a>
        </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                            <!--<div class="main-card mb-3 card">
                        <div class="card-body">-->
                            <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr style="text-align: center">
                                        <th>Type</th>
                                        <th>Remember</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach( $company_alerts as $alerts)
                                    <tr style="text-align:center">
                                        <td>{{$alerts->type}}</td>
                                        <td>{{$alerts->remember_time}}</td>
                                        @if($alerts->status==0)
                                        <td>Inactive</td>
                                        @else
                                            <td>Active</td>
                                        @endif
                                        <td>
                                            <div class="btn-group">
                                                <a href="/human_resource/company_settings/alerts/edit/{{$alerts->id}}" class="btn-shadow btn btn-warning btn-sm">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!--<div class="tab-pane tabs-animation fade show" id="tab-content-1" role="tabpanel">-->
                           <!-- <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr style="text-align: center">
                                        <th>Name</th>
                                        <th>Days Limit</th>
                                        <th>Period</th>
                                        <th>Bookings</th>
                                        <th>Include Food Subsidy?</th>
                                        <th>Paid</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="text-align:center">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="" class="btn-shadow btn btn-warning btn-sm" href="">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <a href="" class="btn-shadow btn btn-danger btn-sm" href="">
                                                    <i class="fas fa-ban"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>-->
                        </div>
                        <!--<div class="tab-pane tabs-animation fade show" id="tab-content-2" role="tabpanel">
                            <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr style="text-align: center">
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Recurrence</th>
                                        <th>Country</th>
                                        <th>Region</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="text-align:center">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="" class="btn-shadow btn btn-danger btn-sm" href="">
                                                    <i class="fas fa-ban"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane tabs-animation fade show" id="tab-content-3" role="tabpanel">
                            <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr style="text-align: center">
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Recurrence</th>
                                        <th>Country</th>
                                        <th>Region</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="text-align:center">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="" class="btn-shadow btn btn-danger btn-sm" href="">
                                                    <i class="fas fa-ban"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane tabs-animation fade show" id="tab-content-4" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-xl-2">
                                    <label for="mondaycheck">Monday
                                        <input type="checkbox" name="mondaycheck" id="mondaycheck">
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-6 col-xl-2">
                                    <label for="tuesdaycheck">Tuesday
                                        <input type="checkbox" name="tuesdaycheck" id="tuesdaycheck">
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-6 col-xl-2">
                                    <label for="wednesdaycheck">Wednesday
                                        <input type="checkbox" name="wednesdaycheck" id="wednesdaycheck">
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-6 col-xl-2">
                                    <label for="thursdaycheck">Thursday
                                        <input type="checkbox" name="thursdaycheck" id="thursdaycheck">
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-6 col-xl-2">
                                    <label for="fridaycheck">Friday
                                        <input type="checkbox" name="fridaycheck" id="fridaycheck">
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-xl-2">
                                    <label for="saturdaycheck">Saturday
                                        <input type="checkbox" name="saturdaycheck" id="saturdaycheck">
                                    </label>
                                </div>
                                <div class="col-sm-12 col-md-6 col-xl-2">
                                    <label for="sundaycheck">Sunday
                                        <input type="checkbox" name="sundaycheck" id="sundaycheck">
                                    </label>
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-xl-6">
                                    <span for="holidaysWorkcheck">Consider holidays as a working day
                                        <input type="checkbox" name="holidaysWorkcheck" id="holidaysWorkcheck">
                                    </span>
                                    </form>
                                </div>
                            </div>
                        </div>
                                <div class="tab-pane tabs-animation fade show" id="tab-content-5" role="tabpanel">
                                <form>123</form>

                                </div>

                            </div>
                        </div>-->
                    </div>
                    @endsection