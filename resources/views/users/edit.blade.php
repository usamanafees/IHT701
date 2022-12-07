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
                            <a >{{trans('menu.admin')}}</a>
                            <i class="fa fa-angle-right">&nbsp;</i>
                        </li>
                        <li>
                            <a  href="{{route('users')}}">{{trans('menu.users')}}</a>
                            <i class="fa fa-angle-right">&nbsp;</i>
                        </li>
                        <li>
                            <a class="breadcrumb-item active" href="">{{trans('users.edit_user')}}</a>
                        </li>
                    </div>
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-list icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('users.edit_user')}}
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
                          @if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()) && !in_array("Administrator" , $user->roles()->pluck('name')->toArray()))
					            <span style="margin:18px; margin-bottom:0px;float:right;margin-left:95%;"><a href="{{ URL('users/user_based_login/'.$user->id)}}"><i class="fas fa-key"></i></a></span>
							@endif
                        <div class="card-body">
							@if ($errors->any())
								<div class="alert alert-danger">
									<ul>
										@foreach ($errors->all() as $error)
											<li>{{ $error }}</li>
										@endforeach
									</ul>
								</div>
							@endif
							@if (\Session::has('success'))
								<div class="alert alert-success">
								   <p>
									  {!! \Session::get('success') !!}
								   </p>
								</div>
                            @endif
                          
                        	<!-- <h5 class="card-title">Grid Rows</h5> -->
                                    <form enctype="multipart/form-data" class="form-horizontal" method="POST" action="{{ route('users.update', $user->id) }}" id="user_form">
                                     	{{ csrf_field() }}
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                    <label for="exampleEmail" class="">
                                                        <span class="text-danger">*</span> Email</label>
                                                        <input name="email" id="exampleEmail" placeholder="Email here..." 
                                                        value="{{$user->email}}"  class="form-control">
                                                        @if ($errors->has('email'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('email') }}</strong>
                                                            </span>
                                                        @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                    <label for="exampleName" class="">{{trans('users.name')}}</label>
                                                    <input name="name" value="{{$user->name}}"  id="exampleName" placeholder="Name here..." type="text" class="form-control" >
                                                    @if ($errors->has('name'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                                    <label for="examplePassword" class="">
                                                        <span class="text-danger">*</span> {{trans('users.password')}}</label>
                                                    <input name="password" id="examplePassword" placeholder="Password here..."  type="password" class="form-control" readonly>
                                                    @if ($errors->has('password'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                        <label for="examplePasswordRep" class=""><span class="text-danger">*</span> {{trans('users.repeat_password')}}</label>
                                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="country" class="control-label">{{trans('users.acess_module')}}</label>
                                                        <select class="bs-select form-control" 
                                                        data-live-search="true" multiple name="access_module[]">
                                                            <option value="" disabled>{{trans('users.select_roles')}}</option>
                                                          @foreach($modules as $module)
                                                            <option value="{{$module->id}}" @if(in_array($module->id, $selected_modules)) selected @endif>{{$module->name}}</option>
                                                          @endforeach
                                                        </select>
                                                    @if ($errors->has('access_module'))
                                                        <span class="help-block"><strong>{{ $errors->first('access_module') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="country" class="control-label">{{trans('users.roles')}}</label>
                                                        <select class="bs-select form-control" 
                                                        data-live-search="true" multiple name="roles[]">
                                                            <option value="" disabled>{{trans('users.select_roles')}}</option>
                                                          @foreach ($roles as $role)
                                                            <option value="{{$role->id}}"
                                                              @if(in_array($role->id, $user_role)) selected @endif
                                                              >{{$role->name}}</option>
                                                          @endforeach
                                                        </select>
                                                    @if ($errors->has('role'))
                                                        <span class="help-block"><strong>{{ $errors->first('role') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group{{ $errors->has('sms_percentage') ? ' has-error' : '' }}">
                                                    <label for="sms_percentage" class="">
                                                        <span class="text-danger">*</span> {{trans('users.sms_percentage')}}</label>
                                                        <input name="sms_percentage" id="sms_percentage" placeholder="SMS Percentage" 
                                                        value="{{$user->sms_cost_percentage}}"  class="form-control">
                                                        @if ($errors->has('sms_percentage'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('sms_percentage') }}</strong>
                                                            </span>
                                                        @endif
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="position-relative form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                                    <label for="image" class="">
                                                        {{trans('users.profile_image')}}</label>
                                                        <div style="height:0px;overflow:hidden">
                                                        <input class="btn btn-secondry" name="image" id="image" type="file" placeholder="Choose image">
                                                        </div>
                                                        <button class="btn btn-info" type="button" onclick="chooseFile();">{{trans('users.choose_image')}}</button>

                                                        @if ($errors->has('image'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('image') }}</strong>
                                                            </span>
                                                        @endif
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                            <img id="image_preview" style="width: 100px;height: 100px;" src="{{$user->image}}" alt="No image selected">
                                                        
                                                </div>
                                            </div>
											
										<div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                                    <label for="address" class="">
                                                        {{trans('users.address')}}</label>
                                                        <input name="address" id="address" placeholder="Address" 
                                                        value="{{$user->address}}"  class="form-control">
                                                        @if ($errors->has('address'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('address') }}</strong>
                                                            </span>
                                                        @endif
                                                </div>
                                            </div>
											<div class="col-md-6">
                                                <div class="position-relative form-group{{ $errors->has('taxpayer_no') ? ' has-error' : '' }}">
                                                    <label for="taxpayer_no" class="">
                                                        {{trans('users.taxpayer')}}.</label>
                                                        <input name="taxpayer_no" id="taxpayer_no" placeholder="Taxpayer No." 
                                                        value="{{$user->taxpayer_no}}"  class="form-control">
                                                        @if ($errors->has('taxpayer_no'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('taxpayer_no') }}</strong>
                                                            </span>
                                                        @endif
                                                </div>
                                            </div>
										</div>
										<div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group{{ $errors->has('postal_code') ? ' has-error' : '' }}">
                                                    <label for="postal_code" class="">
                                                        {{trans('users.postal_code')}}</label>
                                                        <input name="postal_code" id="postal_code" placeholder="Postal Code" 
                                                        value="{{$user->postal_code}}"  class="form-control">
                                                        @if ($errors->has('postal_code'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('postal_code') }}</strong>
                                                            </span>
                                                        @endif
                                                </div>
                                            </div>
											<div class="col-md-6">
                                                <div class="position-relative form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                                                    <label for="location" class="">
                                                        {{trans('users.location')}}</label>
                                                        <input name="location" id="location" placeholder="Location" 
                                                        value="{{$user->location}}"  class="form-control">
                                                        @if ($errors->has('location'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('location') }}</strong>
                                                            </span>
                                                        @endif
                                                </div>
                                            </div>
										</div>
										<div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group{{ $errors->has('wid') ? ' has-error' : '' }}">
                                                    <label for="sms_percentage" class="">
                                                        WID</label>
                                                        <input name="wid" id="wid" placeholder="WID" 
                                                        value="{{$user->wid}}"  class="form-control">
                                                        @if ($errors->has('wid'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('wid') }}</strong>
                                                            </span>
                                                        @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-5">
                                                
                                                <label for="" class="ml-3">{{trans('users.active')}}</label>
                                                <input class=" ml-2 " type="checkbox" id="check_box" name="check_box" value="1"
                                                {{  ($user->active == 1 ? ' checked' : '') }}
                                                >
                                            </div>
										</div>			

                                        </div>


                                <div class="form-row pl-3 pr-3">

                                    <div class="col-md-6">
                                        <div class="position-relative form-group{{ $errors->has('sms_percentage') ? ' has-error' : '' }}">
                                            <label for="tax_percentage" class="">
                                                <span class="text-danger">*</span> {{trans('users.tax_percentage')}}</label>
                                                
                                                <input name="tax_percentage" id="tax_percentage" placeholder="Tax Percentage" class="form-control"value="{{ isset($tax->tax)? $tax->tax :''}}"
                                                
                                                   />
                                                {{-- value="{{ old('tax_percentage') }}"  class="form-control" > --}}
                                                @if ($errors->has('tax_percentage'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('tax_percentage') }}</strong>
                                                    </span>
                                                @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="country" class="control-label">{{trans('users.country')}}</label>
                                                <select class=" form-control" onchange="settax(this)" 
                                                 name="country">
                                                    <option value="" >Select Country </option>
                                                  @foreach ($cntry as $ctr)
                                                    <option value="{{$ctr->iso_code}}"
                                                        @if($user->country_id === $ctr->iso_code) selected @endif
                                                        >{{$ctr->name}}
                                                      </option>
                                                     @endforeach
                                                </select>
                                            @if ($errors->has('country'))
                                                <span class="help-block"><strong>{{ $errors->first('country') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="form-row pl-3 pr-3">
                                <div class="col-md-6">
                                    <div class="position-relative form-group{{ $errors->has('sender_rate') ? ' has-error' : '' }}">
                                        <label for="sms_percentage" class="">
                                            {{trans('users.sender_rate')}}</label>
                                            <input name="sender_rate" type=number step="0.1" id="sender_rate" placeholder="sender rate" 
                                            value="{{$user->sender_rate}}"  class="form-control">
                                            @if ($errors->has('sender_rate'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('sms_percentage') }}</strong>
                                                </span>
                                            @endif
                                    </div>
                                </div>
                            </div>
                                        <div style="text-align: right;">
                                       		<button type="submit" class="mt-2 btn btn-success">{{trans('users.Update')}}</button>
                                        </div>
                                    </form>
                                </div>
                    </div>
                </div>
                  
            </div>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<script>
    function chooseFile() {
      $("#image").click();
   }
    $(document).ready(function (e) {
   
   $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
   });
  
   $('#image').change(function(){
           
    let reader = new FileReader();

    reader.onload = (e) => { 

      $('#image_preview').attr('src', e.target.result); 
    }

    reader.readAsDataURL(this.files[0]); 
  
   });
});
</script>

@endsection