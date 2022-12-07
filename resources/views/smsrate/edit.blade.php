@extends('partials.main')

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
                            <a>{{trans('menu.admin')}}</a>
                            <i class="fa fa-angle-right">&nbsp;</i>
                        </li>
                        <li>
                            <a>SMS</a>
                            <i class="fa fa-angle-right">&nbsp;</i>
                        </li>
                        <li>
                            <a href="{{route('smsrates')}}">{{trans('menu.rates')}}</a>
                            <i class="fa fa-angle-right">&nbsp;</i>
                        </li>
                        <li>
                            <a class="breadcrumb-item active" href="">{{trans('smsrate.edit_user')}}</a>
                        </li>
                    </div>
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-list icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('smsrate.edit_user')}}
                                </div>
                            </div>
                           <!--  <div class="page-title-actions">
                                <div class="d-inline-block dropdown">
                                    <a href="{{route('clients.add')}}" class="btn-shadow btn btn-info" href="">Add Client</a>
                                </div>
                            </div>     -->
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                        	<!-- <h5 class="card-title">Grid Rows</h5> -->
                                    <form  class="form-horizontal" method="POST" action="{{ route('smsrates.update', $sms_rate->id) }}" id="user_form">
                                     	{{ csrf_field() }}
                                         <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="country" class="control-label">{{trans('smsrate.country')}}</label>
                                                        <select class="bs-select form-control" 
                                                        data-live-search="true"  name="country_name">
                                                            <option value="" disabled>{{trans('smsrate.select_country')}}</option>
                                                          @foreach ($countries as $country)
                                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                                          @endforeach
                                                        </select>
                                                    @if ($errors->has('country_name'))
                                                        <span class="help-block"><strong>{{ $errors->first('country_name') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="country" class="control-label">{{trans('smsrate.sms_provider')}}</label>
                                                        <select class="bs-select form-control" id="provider"
                                                        data-live-search="true"  name="provider_name">
                                                            <option value="" disabled>{{trans('smsrate.select_provider')}}</option>
                                                          @foreach ($provider as $provider)
                                                            <option value="{{$provider->id}}">{{$provider->provider_name}}</option>
                                                          @endforeach
                                                        </select>
                                                    @if ($errors->has('provider_name'))
                                                        <span class="help-block"><strong>{{ $errors->first('provider_name') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                        <div class="col-md-2">
                                        <div class="position-relative ">
                                        <label for="country" class="control-label">{{trans('smsrate.sms_rate')}}</label>
                                        <input style="height: 30px;" name="rate" value="{{$sms_rate->rate}}" id="rate" placeholder="Enter Rate" type="text" class="form-control" >
                                                               
                                        </div>
                                        @if ($errors->has('rate'))
                                        <span class="help-block"><strong>{{ $errors->first('rate') }}</strong></span>
                                        @endif
                                        </div>
                                        </div>
                                        
                                        <div style="text-align: right;">
                                       		<button type="submit" class="mt-2 btn btn-primary">{{trans('smsrate.update')}}</button>
                                        </div>
                                    </form>
                                </div>
                    </div>
                </div>
                  
            </div>
 

@endsection