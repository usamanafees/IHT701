<?php
?>
@extends('partials.main')
@section('style')
<style type="text/css">
    .help-block {
        color: #ba4a48;
    }
</style>
@endsection
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
                <a href="{{route('hr.dashboard')}}">{{trans('menu.human_resources')}}</a>
                <i class="fa fa-angle-right">&nbsp;</i>
            </li>
            <li>
                <a class="breadcrumb-item active" href="">{{trans('menu.employee_details')}}</a>
            </li>
        </div>
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fas fa-users icon-gradient bg-tempting-azure">
                        </i>
                    </div>
                    <div>{{trans('menu.employee_details')}}
                    </div>
                </div>
            </div>
        </div>
        <div class="nav nav-pills">
        @foreach ($employee_details_prof as $given_result)
            <a href="{{ route('employee_edit.personal_data',[$given_result->user_id])}}" class="nav-link"><span>Personal Data</span></a>
            <a href="{{ route('employee_edit.professional_data',[$given_result->user_id])}}" class="nav-link active"><span>Professional Data</span></a>
            @endforeach
        </div>
        <div class="main-card mb-3 card">
            <div class="card-body">
                @foreach ($employee_details_prof as $given_result)
                <form action="/human_resource/employee_make_edit/professional_data/{{$given_result->id}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="col-md-3">
                            <div class="position-relative form-group"><label for="employee_code" class="">{{trans('human_resources.employee_code')}}</label><input name="employee_code" id="employee_code" value="{{$given_result->employee_code}}" type="text" class="form-control"></div>
                        </div>
                        <div class="col-md-9">
                            <div class="position-relative form-group"><label for="job_role" class="">{{trans('human_resources.job_role')}}</label><input name="job_role" id="job_role" value="{{$given_result->job_role}}" type="text" class="form-control"></div>
                        </div>
                    </div>
                    <div class="position-relative form-group"><label for="job_role_desc" class="">{{trans('human_resources.job_role_desc')}}</label><input name="job_role_desc" id="job_role_desc" value="{{$given_result->job_role_desc}}" type="text" class="form-control"></div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group"><label for="prof_phone" class="">{{trans('human_resources.prof_phone')}}</label><input name="prof_phone" id="prof_phone" value="{{$given_result->prof_phone}}" type="number" class="form-control"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group"><label for="prof_email" class="">{{trans('human_resources.prof_email')}}</label><input name="prof_email" id="prof_email" value="{{$given_result->prof_email}}" type="email" class="form-control"></div>
                        </div>
                    </div>
                    <div class="position-relative form-group"><label for="cost_center" class="">{{trans('human_resources.cost_center')}}</label><input name="cost_center" id="cost_center" value="{{$given_result->cost_center}}" type="text" class="form-control"></div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group"><label for="country" class="">{{trans('human_resources.country')}}</label><input name="country" id="country" value="{{$given_result->country}}" type="text" class="form-control"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group"><label for="region" class="">{{trans('human_resources.region')}}</label><input name="region" id="region" value="{{$given_result->region}}" type="text" class="form-control"></div>
                        </div>
                    </div>
                    <div class="position-relative form-group"><label for="manager" class="">{{trans('human_resources.manager')}}</label><input name="manager" id="manager" value="{{$given_result->manager}}" type="text" class="form-control"></div>
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="position-relative form-group"><label for="base_salary" class="">{{trans('human_resources.base_salary')}}</label><input name="base_salary" id="base_salary" value="{{$given_result->base_salary}}" type="text" class="form-control"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative form-group"><label for="expenses" class="">{{trans('human_resources.expenses')}}</label><input name="expenses" id="expenses" value="{{$given_result->expenses}}" type="text" class="form-control"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative form-group"><label for="food_allowance" class="">{{trans('human_resources.food_allowance')}}</label><input name="food_allowance" id="food_allowance" value="{{$given_result->food_allowance}}" type="text" class="form-control"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group"><label for="value_per_hour" class="">{{trans('human_resources.value_per_hour')}}</label><input name="value_per_hour" id="value_per_hour" value="{{$given_result->value_per_hour}}" type="text" class="form-control"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group"><label for="felexible_work_hours" class="">{{trans('human_resources.flexible_work_hours')}}</label><input name="felexible_work_hours" id="felexible_work_hours" value="{{$given_result->felexible_work_hours}}" type="text" class="form-control"></div>
                        </div>
                    </div>
                    <div class="position-relative form-group"><label for="observations" class="">{{trans('human_resources.observations')}}</label><input name="observations" id="observations" value="{{$given_result->observations}}" type="text" class="form-control"></div>
                    @endforeach
                    <button type="submit" class="mt-2 btn btn-primary">{{trans('human_resources.submit')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
@endsection