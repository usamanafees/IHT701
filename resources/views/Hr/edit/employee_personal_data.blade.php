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
        <div class="container">
            <div class="nav nav-pills">
            @foreach ($employee_details as $given_result)
                <a href="{{ route('employee_edit.personal_data',[$given_result->user_id])}}" class="nav-link active"><span>Personal Data</span></a>
                <a href="{{ route('employee_edit.professional_data',[$given_result->user_id])}}" class="nav-link"><span>Professional Data</span></a>
                @endforeach
            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    @foreach ($employee_details as $given_result)
                    <form action="/human_resource/employee_make_edit/personal_data/{{$given_result->id}}" method="post">
                        {{ csrf_field() }}
                        <div class="form-row">
                            <div class="col-md-1">
                                <div class="position-relative form-group"><label for="user_id" class="">ID</label><input name="user_id1" id="user_id" value="{{$given_result->user_id}}" type="text" class="form-control" disabled></div>
                            </div>
                            <div class="col-md-11">
                                <div class="position-relative form-group"><label for="name" class="">{{trans('human_resources.name')}}</label><input name="name" id="name" value="{{$given_result->name}}" type="text" class="form-control"></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-10">
                                <div class="position-relative form-group"><label for="address" class="">{{trans('human_resources.address')}}</label><input name="address" id="address" value="{{$given_result->address}}" type="text" class="form-control"></div>
                            </div>
                            <div class="col-md-2">
                                <div class="position-relative form-group"><label for="postal_code" class="">{{trans('human_resources.postal_code')}}</label><input name="postal_code" id="postal_code" type="text" value="{{$given_result->postal_code}}" class="form-control"></div>
                            </div>
                            <div class="col-md-12">
                                <div class="position-relative form-group"><label for="location" class="">{{trans('human_resources.location')}}</label><input name="location" id="location" value="{{$given_result->location}}" type="text" class="form-control"></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group"><label for="phone_no" class="">{{trans('human_resources.phone')}}</label><input name="phone_no" id="phone_no" value="{{$given_result->phone_no}}" type="number" class="form-control"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group"><label for="email" class="">Email</label><input name="email" id="email" value="{{$given_result->email}}" type="email" class="form-control"></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group"><label for="civil_state" class="">{{trans('human_resources.civil_state')}}</label><input name="civil_state" id="civil_state" value="{{$given_result->civil_state}}" type="text" class="form-control"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group"><label for="birth_date" class="">{{trans('human_resources.birth_date')}}</label><input name="birth_date" id="birth_date" value="{{$given_result->birth_date}}" type="date" class="form-control"></div>
                            </div>
                        </div>
                        <div class="position-relative form-group"><label for="emergency_name" class="">{{trans('human_resources.emergency_name')}}</label><input name="emergency_name" id="emergency_name" value="{{$given_result->emergency_name}}" type="text" class="form-control"></div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group"><label for="emergency_phone" class="">{{trans('human_resources.emergency_phone')}}</label><input name="emergency_phone" id="emergency_phone" value="{{$given_result->emergency_phone}}" type="text" class="form-control"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group"><label for="emergency_kinship" class="">{{trans('human_resources.emergency_kinship')}}</label><input name="emergency_kinship" id="emergency_kinship" value="{{$given_result->emergency_kinship}}" type="text" class="form-control"></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3">
                                <div class="position-relative form-group"><label for="citizen_card" class="">{{trans('human_resources.citizen_card')}}</label><input name="citizen_card" id="citizen_card" value="{{$given_result->citizen_card}}" type="text" class="form-control"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="position-relative form-group"><label for="fiscal_id" class="">{{trans('human_resources.fiscal_id')}}</label><input name="fiscal_id" id="fiscal_id" value="{{$given_result->fiscal_id}}" type="text" class="form-control"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="position-relative form-group"><label for="social_security" class="">{{trans('human_resources.social_security')}}</label><input name="social_security" id="social_security" value="{{$given_result->social_security}}" type="text" class="form-control"></div>
                            </div>
                            <div class="col-md-3">
                                <div class="position-relative form-group"><label for="driving_license" class="">{{trans('human_resources.driving_license')}}</label><input name="driving_license" id="driving_license" value="{{$given_result->driving_license}}" type="text" class="form-control"></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group"><label for="car_plate" class="">{{trans('human_resources.car_plate')}}</label><input name="car_plate" id="car_plate" value="{{$given_result->car_plate}}" type="text" class="form-control"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group"><label for="other_docs" class="">{{trans('human_resources.other_docs')}}</label><input name="other_docs" id="other_docs" value="{{$given_result->other_docs}}" type="text" class="form-control"></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="position-relative form-group"><label for="academic_degree" class="">{{trans('human_resources.academic_degree')}}</label><input name="academic_degree" id="academic_degree" value="{{$given_result->academic_degree}}" type="text" class="form-control"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative form-group"><label for="school" class="">{{trans('human_resources.school')}}</label><input name="school" id="school" value="{{$given_result->school}}" type="text" class="form-control"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative form-group"><label for="course" class="">{{trans('human_resources.course')}}</label><input name="course" id="course" value="{{$given_result->course}}" type="text" class="form-control"></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2">
                                <div class="position-relative form-group"><label for="number_dependents" class="">{{trans('human_resources.number_of_dependents')}}</label><input name="number_dependents" id="number_dependents" value="{{$given_result->number_dependents}}" type="text" class="form-control"></div>
                            </div>
                            <div class="col-md-5">
                                <div class="position-relative form-group"><label for="deficiencies" class="">{{trans('human_resources.deficiencies')}}</label><input name="deficiencies" id="deficiencies" value="{{$given_result->deficiencies}}" type="text" class="form-control"></div>
                            </div>
                            <div class="col-md-5">
                                <div class="position-relative form-group"><label for="income_ownership" class="">{{trans('human_resources.income_ownership')}}</label><input name="income_ownership" id="income_ownership" value="{{$given_result->income_ownership}}" type="text" class="form-control"></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="position-relative form-group"><label for="bank_name" class="">{{trans('human_resources.bank_name')}}</label><input name="bank_name" id="bank_name" value="{{$given_result->bank_name}}" type="text" class="form-control"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative form-group"><label for="iban" class="">IBAN</label><input name="iban" id="iban" value="{{$given_result->iban}}" type="text" class="form-control"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative form-group"><label for="swift" class="">Swift</label><input name="swift" id="swift" value="{{$given_result->swift}}" type="text" class="form-control"></div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="position-relative form-group"><label for="facebook" class="">Facebook</label><input name="facebook" id="facebook" value="{{$given_result->facebook}}" type="text" class="form-control"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative form-group"><label for="twitter" class="">Twitter</label><input name="twitter" id="twitter" value="{{$given_result->twitter}}" type="text" class="form-control"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative form-group"><label for="linkedin" class="">Linkedin</label><input name="linkedin" id="linkedin" value="{{$given_result->linkedin}}" type="text" class="form-control"></div>
                            </div>
                        </div>
                        @endforeach
                        <button type="submit" class="mt-2 btn btn-primary">{{trans('human_resources.submit')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
@endsection