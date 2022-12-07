@extends('partials.main')
@section('style')
<style type="text/css">
    .help-block{
        color: #ba4a48;
    }
    .left_align{
        text-align: left;
    }
    .right_align{
        text-align: right;
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
                            <a >{{trans('menu.settings')}}</a>
                            <i class="fa fa-angle-right">&nbsp;</i>
                        </li>
                        <li>
                            <a >{{trans('menu.Account')}}</a>
                            <i class="fa fa-angle-right">&nbsp;</i>
                        </li>
                        <li>
                            <a class="breadcrumb-item active" href="">{{trans('accounts.Account_balance')}}</a>
                        </li>
                    </div>
                    <div class="main-card mb-3 card">
                      @if (number_format($user->AccountSettings->in_app_credit) == 0)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          <strong>{{trans('accounts.balance_warn')}} {{ number_format(Auth::user()->AccountSettings->in_app_credit,2,","," ") }}€ {{trans('accounts.balance_warn_2')}}</strong>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                      @endif
                        <div class="card-body" style="background-color: #ccc;">
                            <h2>{{trans('accounts.Account_balance')}}</h2>
                        </div>
                        @if (\Session::has('success'))
                            <div class="alert alert-success">
                               <p>
                                  {!! \Session::get('success') !!}
                               </p>
                            </div>
                        @endif
                        @if (\Session::has('error'))
                            <div class="alert alert-warning">
                               <p>
                                  {!! \Session::get('error') !!}
                               </p>
                            </div>
                        @endif
                        {{-- <div class="card-body" style="background-color: #eee;text-align: center;">
                              <h4 style="color: #00bb80;font-family: 'Oxygen-Light',Helvetica,Arial,sans-serif;">ACCOUNT IN TRIAL PERIOD</h4>
                                                            <h4 style="color: #00bb80;font-family: 'Oxygen-Light',Helvetica,Arial,sans-serif;">ACCOUNT BALANCE</h4>

                              <p>The period will be over on {{$user->AccountSettings->expires_on}}</p>
                        </div> --}}
                        <div class="card-body">
                            <form class="form-horizontal" method="POST" action="{{ route('users.store') }}">
                                     	{{ csrf_field() }}
                                  <br>
                                  <div class="row" style="line-height: 200%;">
                                      <div class="col-6 col-md-6">
                                        <h4>{{trans('accounts.Account')}}</h4>
                                            {{-- <div class="row">
                                              <div style="" class="left_align col-6 col-md-6">Plan:</div>
                                              <div style="" class="right_align col-6 col-md-6">
                                                <font style="font-family: 'Oxygen-Bold',Helvetica,Arial,sans-serif;color: #00bb80;">
                                                  <b>{{$user->AccountSettings->duration}}</b>
                                                </font> (
                                                {{$user->AccountSettings->amount}}€ / 
                                                  @if($user->AccountSettings->duration == 'M')
                                                    Month
                                                  @elseif($user->AccountSettings->duration == '6M')
                                                    6 Months
                                                  @elseif($user->AccountSettings->duration == '12M')
                                                    12 Months
                                                  @endif
                                                )
                                              </div>
                                            </div> --}}
                                            <div class="row">
                                              <div style="" class="left_align col-6 col-md-6">{{trans('accounts.balance')}}:</div>
                                              <div style="" class="right_align col-6 col-md-6">
                                                {{-- <font style="font-family: 'Oxygen-Bold',Helvetica,Arial,sans-serif;color: #e3be2d;"><b>{{$days}} Days</b></font> 
                                                ({{number_format($user->AccountSettings->in_app_credit ,2,","," ")}} €)</div> --}}
                                                 ({{number_format($user->AccountSettings->in_app_credit ,2,",","")}} €)</div>

                                              </div>
                                            {{-- <div class="row">
                                              <div style="" class="left_align col-6 col-md-6">Expires on:</div>
                                              <div style="" class="right_align col-6 col-md-6">
                                                {{$user->AccountSettings->expires_on}}
                                              </div>
                                            </div> --}}
                                      </div>
                                      <div class="col-6 col-md-6" style="border-left: 1px solid lightgray;">
                                        <h4>{{trans('accounts.Monthly_balance')}}</h4>
                                            <div class="row">
                                              <div class="left_align col-6 col-md-6">{{trans('accounts.docs')}}:</div>
                                              <div  class="right_align col-6 col-md-6">
                                                {{$user->AccountSettings->used_documents}} / {{$user->AccountSettings->total_documents}}
                                              </div>
                                            </div>
                                            <div class="row">
                                              <div class="left_align col-6 col-md-6">{{trans('accounts.users')}}:</div>
                                              <div  class="right_align col-6 col-md-6">
                                                {{$user->AccountSettings->used_users}} / {{$user->AccountSettings->total_users}}
                                              </div>
                                            </div>
                                      </div>
                                  </div>
                                  <br>
                                  {{-- <div class="card-body" style="background-color: #eee;padding: 0.5rem;">
                                      <p>
                                        <i class="fa fa-envelope" aria-hidden="true"></i>  <b>Free SMS sent</b>:
                                        {{$user->AccountSettings->free_sms_used}} / {{$user->AccountSettings->free_sms_total}} SMS 
                                        &nbsp; 
                                        <i class="fa fa-envelope" aria-hidden="true"></i>  <b>Bought SMS</b>:
                                            {{$user->AccountSettings->bought_sms_total}} SMS</p>
                                  </div> --}}
                            </form>
                        </div>
                        <div class="card-body" style="background-color: #eee;">
                          <div class="row">
                            <div class="col-6 col-md-6">
                                <input type="checkbox" name="renew_monthly_balance">
                                  &nbsp;&nbsp;&nbsp;
                                {{trans('accounts.auto_renew')}}
                            </div>
                            <div class="col-6 col-md-6 right_align">
                              <a href="{{route('account.manage_plan')}}" class="btn btn-success">{{trans('accounts.change_plan')}}</a>
                              <a href="{{route('payment.plan',$user->AccountSettings->payment_code)}}" class="btn btn-warning">{{trans('accounts.buy')}}</a>
                            </div>
                          </div>
                        </div>
                    </div>
                    <br>
                          <div class="card-header-title font-size-sm font-weight-normal" style="float: left;color: grey;">
                         <i class="fas fa-info-circle"></i>
                            <h7> {{trans('tips.account_balance')}}</h7>
                        </div>
                </div>
            </div>
@endsection