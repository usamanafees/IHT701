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
                            <a class="breadcrumb-item active" href="{{route('users')}}">{{trans('menu.provider')}}</a>
                        </li>
                    </div>


                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-sms icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('sms.sms_provider')}}
                                </div>
                            </div>
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body" style="background-color: #CCCCCC;">
                            <h2><b>{{trans('sms.sms_provider')}}</b></h2>
                        </div>
                        <div class="card-body">
                                    <form class="form-horizontal" method="POST" action="{{ route('sms.provider.store') }}">
                                     	{{ csrf_field() }}
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                	<label for="" class="">{{trans('sms.Sender')}}</label>
                                                	<select class="form-control sms_provider" 
                                                            id="sel1" 
                                                            name="sms_provider">
                                                        <option value="" selected disabled>{{trans('sms.select_provider')}}</option>
                                                        <option
                                                            @if(!empty($sms_provider))
                                                                @if($sms_provider->provider_name == 'Nexmo') selected @endif
                                                            @endif
                                                            value="Nexmo">Nexmo</option>
                                                        <option
                                                            @if(!empty($sms_provider))
                                                                @if($sms_provider->provider_name == 'Twilio') selected @endif
                                                            @endif
                                                            value="Twilio">Twilio</option>
                                                        <option
                                                            @if(!empty($sms_provider))
                                                                @if($sms_provider->provider_name == 'Ez4U_SMS') selected @endif
                                                            @endif
                                                            value="Ez4U_SMS">Ez4U SMS</option>
                                                      </select>
                                                    @if ($errors->has('sms_provider'))
                                                        <span class="help-block" style="color: red;">
                                                            <strong>{{ $errors->first('sms_provider') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Twilio" id="Twilio" style="display: none;">
                                            <img style="opacity: 0.8;width: 5%;" src="{{asset('admin/twilio_logo.png')}}">
                                            <br>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                            <label for="" class="">{{trans('sms.twilio_client_id')}}</label>
                                                        <input name="client_id" id="client_id" placeholder="Twilio Client Id" type="text" class="form-control inp" 
                                                        value="{{old('client_id')}}">
                                                        @if ($errors->has('client_id'))
                                                            <span class="help-block" style="color: red;">
                                                                <strong>{{ $errors->first('client_id') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                            <label for="" class="">{{trans('sms.twilio_secret_token')}}</label>
                                                        <input name="client_secret" id="client_secret" placeholder="Twilio Secret Token" type="text" class="form-control inp" 
                                                        value="{{old('client_secret')}}">
                                                        @if ($errors->has('client_secret'))
                                                            <span class="help-block" style="color: red;">
                                                                <strong>{{ $errors->first('client_secret') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                            <label for="" class="">{{trans('sms.twilio_number')}}</label>
                                                        <input name="twilio_number" id="twilio_number" placeholder="Twilio Number" type="text" class="form-control inp"
                                                        value="{{old('twilio_number')}}">
                                                        @if ($errors->has('twilio_number'))
                                                            <span class="help-block" style="color: red;">
                                                                <strong>{{ $errors->first('twilio_number') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                            <label for="" class="">{{trans('sms.mob_prefix')}}</label>
                                                        <input name="tmob_prefix" id="tmob_prefix" placeholder="Mob. Prefix" type="text" class="form-control inp" 
                                                        value="{{old('tmob_prefix')}}">
                                                        @if ($errors->has('tmob_prefix'))
                                                            <span class="help-block" style="color: red;">
                                                                <strong>{{ $errors->first('tmob_prefix') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Nexmo" id="Nexmo" style="display: none;">
                                            <img style="opacity: 0.8;width: 5%;" src="{{asset('admin/nexmo_logo.png')}}">
                                            <br>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                            <label for="" class="">{{trans('sms.nexmo_client_id')}}</label>
                                                        <input name="Nexmo_client_id" id="Nexmo_client_id" placeholder="Nexmo Client ID" type="text" class="form-control inp" 
                                                        value="{{old('Nexmo_client_id')}}">
                                                        @if ($errors->has('Nexmo_client_id'))
                                                            <span class="help-block" style="color: red;">
                                                                <strong>{{ $errors->first('Nexmo_client_id') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                            <label for="" class="">{{trans('sms.nexmo_client_secret')}}</label>
                                                        <input name="Nexmo_client_secret" id="Nexmo_client_secret" placeholder="Nexmo Client Secret" type="text" class="form-control inp" 
                                                        value="{{old('Nexmo_client_secret')}}">
                                                        @if ($errors->has('Nexmo_client_secret'))
                                                            <span class="help-block" style="color: red;">
                                                                <strong>{{ $errors->first('Nexmo_client_secret') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                            <label for="" class="">{{trans('sms.mob_prefix')}}</label>
                                                        <input name="nmob_prefix" id="nmob_prefix" placeholder="Mob. Prefix" type="text" class="form-control inp" 
                                                        value="{{old('nmob_prefix')}}">
                                                        @if ($errors->has('nmob_prefix'))
                                                            <span class="help-block" style="color: red;">
                                                                <strong>{{ $errors->first('nmob_prefix') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="Ez4u" id="Ez4u" style="display: none;">
                                            <img style="background-color: #05b0d7;width: 11%;border-radius: 15%;" src="{{asset('admin/ez4u.png')}}">
                                            <br>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                            <label for="" class="">{{trans('sms-ez4u_account_id')}}</label>
                                                        <input name="ez4u_client_id" id="ez4u_client_id" placeholder="EZ4U Account ID" type="text" class="form-control inp" 
                                                        value="{{old('ez4u_client_id')}}">
                                                        @if ($errors->has('ez4u_client_id'))
                                                            <span class="help-block" style="color: red;">
                                                                <strong>{{ $errors->first('ez4u_client_id') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="position-relative form-group">
                                                            <label for="" class="">{{trans('sms.ez4u_licensekey')}}</label>
                                                        <input name="ez4u_client_secret" id="ez4u_client_secret" placeholder="EZ4U Licensekey(API Key)" type="text" class="form-control inp" 
                                                        value="{{old('ez4u_client_secret')}}">
                                                        @if ($errors->has('ez4u_client_secret'))
                                                            <span class="help-block" style="color: red;">
                                                                <strong>{{ $errors->first('ez4u_client_secret') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="position-relative form-group">
                                                            <label for="" class="">{{trans('sms.ez4u_url')}}</label>
                                                        <input name="ez4u_url" id="ez4u_url" placeholder="EZ4U URL" type="text" class="form-control inp" 
                                                        value="{{old('ez4u_url')}}">
                                                        @if ($errors->has('ez4u_url'))
                                                            <span class="help-block" style="color: red;">
                                                                <strong>{{ $errors->first('ez4u_url') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="position-relative form-group">
                                                            <label for="" class="">{{trans('sms.mob_prefix')}}</label>
                                                        <input name="mob_prefix" id="mob_prefix" placeholder="Mob. Prefix" type="text" class="form-control inp" 
                                                        value="{{old('mob_prefix')}}">
                                                        @if ($errors->has('mob_prefix'))
                                                            <span class="help-block" style="color: red;">
                                                                <strong>{{ $errors->first('mob_prefix') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            </div>
                                        </div>
                                        <div class="save_btn" style="text-align: right;display: none;">
                                            <button type="submit" class="mt-2 btn btn-success">{{trans('sms.add_sms_provider')}}</button>
                                        </div>

                                        @if(!empty($sms_provider))
                                            <div class="col-md-12">
                                                <h4><b>{{trans('sms.saved_service_provider')}}</b>
                                                    
                                                </h4>
                                                <table class="table table-bordered">
                                                    <thead class="thead-dark">
                                                        <tr>
                                                          <th width="10%" style="text-align: center;" scope="col">

                                                          </th>

                                                          @if($sms_provider->provider_name == 'Ez4U_SMS')
                                                            <th style="text-align: center;" scope="col">{{trans('sms.Account_id')}}</th>
                                                            <th style="text-align: center;" scope="col">{{trans('sms.license_key')}}</th>
                                                            <th style="text-align: center;" scope="col">{{trans('sms.ez4u_url')}}</th>
                                                            <th style="text-align: center;" scope="col">{{trans('sms.mob_prefix')}}</th>
                                                          @else  
                                                            <th style="text-align: center;" scope="col">{{trans('sms.client_id')}}</th>
                                                            <th style="text-align: center;" scope="col">{{trans('sms.client_secret')}}</th>
                                                            @if($sms_provider->provider_name != 'Twilio')
                                                            <th style="text-align: center;" scope="col">{{trans('sms.mob_prefix')}}</th>
                                                            @endif
                                                          @endif
                                                          
                                                          @if($sms_provider->provider_name == 'Twilio')
                                                            <th style="text-align: center;" scope="col">{{trans('sms.twilio_number')}}</th>
                                                            <th style="text-align: center;" scope="col">{{trans('sms.mob_prefix')}}</th>
                                                          @endif  
                                                        </tr>
                                                    </thead>
                                                <tbody style="text-align: center">
                                                    <tr>
                                                        <td style="text-align: center;">
                                                              @if($sms_provider->provider_name == 'Twilio')
                                                                  <img style="width: 50%;" src="{{asset('admin/twilio_logo.png')}}">
                                                              @endif
                                                              @if($sms_provider->provider_name == 'Nexmo')
                                                                  <img style="width: 50%;" src="{{asset('admin/nexmo_logo.png')}}">
                                                              @endif
                                                              @if($sms_provider->provider_name == 'Ez4U_SMS')
                                                                  <img style="background-color: #05b0d7;width: 100%;border-radius: 15%;" src="{{asset('admin/ez4u.png')}}">
                                                              @endif
                                                        </td>
                                                        <td>{{$sms_provider->client_id}}</td>
                                                        <td>{{$sms_provider->client_secret}}</td>
                                                        @if($sms_provider->provider_name == 'Ez4U_SMS')
                                                            <td style="text-align: center;" scope="col">
                                                                {{$sms_provider->ez4u_url}}
                                                            </td>
                                                        @endif
                                                        @if($sms_provider->provider_name == 'Twilio')
                                                            <td style="text-align: center;" scope="col">
                                                                {{$sms_provider->twilio_number}}
                                                            </td>
                                                        @endif
                                                        <td>{{$sms_provider->mobile_prefix}}</td>
                                                    </tr>
                                                </tbody>
                                                </table>
                                            </div>
                                        @endif
                                        
                                    </form>
                                </div>
                    </div>
                </div>
                  
            </div>
@endsection


@section('javascript')
<script type="text/javascript">
    $("select.sms_provider").change(function(){
        $('.save_btn').css('display','block');
        var provider = $(this).children("option:selected").val();
        if(provider == 'Twilio'){
            $('#Twilio').slideDown();
            $('#Nexmo').slideUp();
            $('#Ez4u').slideUp();

            //Make fields required for twilio
            // $('.Twilio input').attr('required','true');
            // $('.Nexmo input').attr('required','');
        }
        if(provider == 'Nexmo'){
            $('#Nexmo').slideDown();
            $('#Twilio').slideUp();
            $('#Ez4u').slideUp();

            //Make fields required for twilio
            // $('.Twilio input').attr('required','');
            // $('.Nexmo input').attr('required','true');
        }
        if(provider == 'Ez4U_SMS'){
            $('#Ez4u').slideDown();
            $('#Nexmo').slideUp();
            $('#Twilio').slideUp();
        }
    });
</script>
@endsection