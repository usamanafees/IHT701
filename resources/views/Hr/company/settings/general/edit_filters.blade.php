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
                        <div> Edit Default Filters
                        </div>
                    </div>
                </div>

            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                        <form class="form-horizontal" method="POST"
                              action="{{ route('hr.company.settings.general.edit.filters.update',$company_general->id) }}">
                            {{ csrf_field() }}
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="position-relative form-group">
                                        <input type="checkbox" name="default_filters" id="default_filters"
                                               @if($company_general->show_filters==1) checked @endif>
                                        <label><b>&nbsp;Show default filter in the 'Employees' menu.</b></label>
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