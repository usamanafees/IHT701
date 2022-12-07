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
                        <div> Edit 'My Profile' Menus
                        </div>
                    </div>
                </div>

            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                        <form class="form-horizontal" method="POST"
                              action="{{ route('hr.company.settings.general.edit.menus.update',$company_general->id) }}">
                            {{ csrf_field() }}
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="position-relative form-group">
                                        <input type="checkbox" name="personal_information" id="personal_information"
                                               @if($company_general->menu_personal_information==1) checked @endif>
                                        <label><b>&nbsp;Personal info - show personal info data in user's profile besides 'Full name', 'Birth date' and 'About me'.</b></label>
                                        <br><input type="checkbox" name="expenses" id="expenses"
                                               @if($company_general->menu_expenses==1) checked @endif>
                                        <label><b>&nbsp;Expenses - show menu in user's profile.</b></label>
                                        <br><input type="checkbox" name="documents" id="documents"
                                               @if($company_general->menu_documents==1) checked @endif>
                                        <label><b>&nbsp;
                                                Documents - show menu in user's profile.</b></label>
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