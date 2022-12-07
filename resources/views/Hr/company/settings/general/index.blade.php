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
                    <a href="{{ route('hr.company.settings.vacations')}}"
                       class="nav-link"><span>Vacations/Absences</span></a>
                    <a href="{{ route('hr.company.settings.extradays')}}" class="nav-link"><span>Extra Days</span></a>
                    <a href="{{ route('hr.company.settings.holidays')}}" class="nav-link"><span>Holidays</span></a>
                    <a href="{{ route('hr.company.settings.workdays')}}" class="nav-link"><span>Work Days</span></a>
                    <a href="{{ route('hr.company.settings.general')}}" class="nav-link active"><span>General</span></a>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <h5>Default Filters</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <div class="d-inline-block dropdown" style="float: right">
                                        <a href="/human_resource/company_settings/general/edit/default-filters/{{$company_general->id}}" class="btn-shadow btn btn-warning">
                                            <i class="fa fa-pen btn-icon-wrapper"> </i>&nbsp;
                                            Edit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    {{--@foreach($company_general as $general)--}}
                                    <b>Status:</b> @if($company_general->show_filters==1) Active @else Inactive @endif<br>
                                       {{-- @endforeach --}}
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <h5>'My Profile' Menus</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <div class="d-inline-block dropdown" style="float: right">
                                        <a href="/human_resource/company_settings/general/edit/my-profile-menus/{{$company_general->id}}" class="btn-shadow btn btn-warning">
                                            <i class="fa fa-pen btn-icon-wrapper"> </i>&nbsp;
                                            Edit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    {{-- @foreach($company_general as $general) --}}
                                    <b>Personal Info:</b> @if($company_general->menu_personal_info==1) Active @else Inactive @endif<br>
                                    <b>Expenses:</b> @if($company_general->menu_expenses==1) Active @else Inactive @endif<br>
                                    <b>Documents:</b> @if($company_general->menu_documents==1) Active @else Inactive @endif<br>
                                   {{-- @endforeach --}}
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <h5>KM Map</h5>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <div class="d-inline-block dropdown" style="float: right">
                                        <a href="{{ route('hr.company.settings.general.edit.km',$company_general->id) }}" class="btn-shadow btn btn-warning">
                                            <i class="fa fa-pen btn-icon-wrapper"> </i>&nbsp;
                                            Edit</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    {{--@foreach($company_general as $general)--}}
                                    <b>Price per km:</b> {{$company_general->price_km}}€
                                        {{--@endforeach--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection