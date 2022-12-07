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
                <a href="{{ route('hr.company.settings.alerts')}}" class="nav-link"><span>Alerts</span></a>
                <a href="{{ route('hr.company.settings.vacations')}}" class="nav-link"><span>Vacations/Absences</span></a>
                <a href="{{ route('hr.company.settings.extradays')}}" class="nav-link"><span>Extra Days</span></a>
                <a href="{{ route('hr.company.settings.holidays')}}" class="nav-link"><span>Holidays</span></a>
                <a href="{{ route('hr.company.settings.workdays')}}" class="nav-link active"><span>Work Days</span></a>
                <a href="{{ route('hr.company.settings.general')}}" class="nav-link"><span>General</span></a>
            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    @foreach($company_workdays as $workdays)
                        <form>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-xl-2">
                            <label for="mondaycheck">Monday
                                <input type="checkbox" name="mondaycheck" id="mondaycheck" @if($workdays->monday==1) checked @endif>
                            </label>
                        </div>
                        <div class="col-sm-12 col-md-6 col-xl-2">
                            <label for="tuesdaycheck">Tuesday
                                <input type="checkbox" name="tuesdaycheck" id="tuesdaycheck" @if($workdays->tuesday==1) checked @endif>
                            </label>
                        </div>
                        <div class="col-sm-12 col-md-6 col-xl-2">
                            <label for="wednesdaycheck">Wednesday
                                <input type="checkbox" name="wednesdaycheck" id="wednesdaycheck" @if($workdays->wednesday==1) checked @endif>
                            </label>
                        </div>
                        <div class="col-sm-12 col-md-6 col-xl-2">
                            <label for="thursdaycheck">Thursday
                                <input type="checkbox" name="thursdaycheck" id="thursdaycheck" @if($workdays->thursday==1) checked @endif>
                            </label>
                        </div>
                        <div class="col-sm-12 col-md-6 col-xl-2">
                            <label for="fridaycheck">Friday
                                <input type="checkbox" name="fridaycheck" id="fridaycheck" @if($workdays->friday==1) checked @endif>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-xl-2">
                            <label for="saturdaycheck">Saturday
                                <input type="checkbox" name="saturdaycheck" id="saturdaycheck" @if($workdays->saturday==1) checked @endif>
                            </label>
                        </div>
                        <div class="col-sm-12 col-md-6 col-xl-2">
                            <label for="sundaycheck">Sunday
                                <input type="checkbox" name="sundaycheck" id="sundaycheck" @if($workdays->sunday==1) checked @endif>
                            </label>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-xl-6">
                            <span for="holidaysWorkcheck">Consider holidays as a working day
                                <input type="checkbox" name="holidaysWorkcheck" id="holidaysWorkcheck" @if($workdays->holidays_workdays==1) checked @endif>
                            </span>
                        </div>
                            @endforeach
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endsection