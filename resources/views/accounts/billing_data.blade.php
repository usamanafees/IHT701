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
                            <a class="breadcrumb-item active" href="">{{trans('accounts.Billing_data')}}</a>
                        </li>
                    </div>



                  @if ($user->Subsidiaries->taxpayer == null || $user->Subsidiaries->city == null || $user->Subsidiaries->postal_code == null || $user->Subsidiaries->address == null || $user->Subsidiaries->vat_number == null)
                    <div class="alert alert-danger">{{trans('accounts.please_complete_bl_info')}}</div>
                  @endif
                    <div class="main-card mb-3 card">
                        <div class="card-body" style="background-color: #ccc;">
                            <h2>{{trans('accounts.Billing_data')}}</h2>
                        </div>
                        <div class="card-body">
                          <p>
                              {{trans('accounts.data_info_use_bl')}}
                          </p>
                            <form class="form-horizontal" method="POST" action="{{ route('billing.store') }}">
                                     	{{ csrf_field() }}
                                  <br>
                                 <br>
                                  <div class="form-row" style="line-height: 0.5rem;">
                                      <div class="col-md-6">
                                          <div class="position-relative form-group">
                                              <label for="exampleName" class=""><b>{{trans('accounts.organization')}}:</b>
                                              </label>
                                              <input name="company_name"  id="company_name" placeholder="{{trans('accounts.organization')}}" type="text" class="form-control" value="{{$user->company_name}}">
                                          </div>
                                      </div>
                                    <div class="col-md-6">
                                          <div class="position-relative form-group">
                                              <label for="exampleEmail" class=""><b>{{trans('accounts.postal_code')}}</b></label>
                                                  <input name="postal_code" id="postal_code" placeholder="{{trans('accounts.postal_code')}}" class="form-control" value="{{$user->Subsidiaries->postal_code}}">
                                                   
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-row" style="line-height: 0.5rem;">
                                      <div class="col-md-6">
                                          <div class="position-relative form-group">
                                              <label for="exampleName" class=""><b>{{trans('accounts.city')}}:</b></label>
                                              <input name="city"  id="city" placeholder="{{trans('accounts.city')}}" type="text" class="form-control" value="{{$user->Subsidiaries->city}}">
                                                 

                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="position-relative form-group">
                                              <label for="exampleName" class=""><b>Email:</b></label>
                                              <input name="email"  id="email" placeholder="email" type="text" class="form-control"  value="{{$user->email}}">
                                              @if ($errors->has('email'))
                                                     <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif 
                                          </div>
                                      </div>
                                      <!--  -->
                                  </div>
                                  <div class="form-row" style="line-height: 0.5rem;">
                                      <div class="col-md-6">
                                          <div class="position-relative form-group">
                                              <label for="exampleEmail" class=""><b>{{trans('accounts.vat')}}:</b></label>
                                                  <input name="vat_number" id="VAT Number" placeholder="{{trans('accounts.vat')}}" class="form-control" value="{{$user->Subsidiaries->vat_number}}">
                                                     
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="position-relative form-group">
                                              <label for="exampleEmail" class=""><b>{{trans('accounts.country')}}:</b></label>
                                                  <select class="select form-control" name="country_id" id=country_id >
                                                      <option value="" selected disabled>{{trans('accounts.country')}}</option>
                                                      @foreach($countries as $country)
                                                        <option @if($user->country_id == $country->iso_code) selected @endif value="{{$country->iso_code}}">{{$country->name}}</option>
                                                      @endforeach
                                                  </select>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-row" style="line-height: 0.5rem;">
                                      
                                      <div class="col-md-12">
                                          <div class="position-relative form-group">
                                              <label for="exampleName" class=""><b>{{trans('accounts.Adress')}}:</b></label>
                                             <textarea name="address" class="form-control">         
                                                  {{$user->Subsidiaries->address}}
                                             </textarea>
                                          </div>
                                      </div>
                                  </div>
                                  <div style="text-align: right;">
                                    <button type="submit" class="mt-2 btn btn-success">{{trans('users.Save')}}</button>
                                  </div>
                            </form>
                        </div>
                    </div>
                </div>
                  
            </div>
@endsection