@extends('partials.main')
@section('style')
<style type="text/css">
    .help-block{
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
                            <a >{{trans('menu.admin')}}</a>
                            <i class="fa fa-angle-right">&nbsp;</i>
                        </li>
                        <li>
                            <a  href="{{route('users')}}">{{trans('menu.users')}}</a>
                            <i class="fa fa-angle-right">&nbsp;</i>
                        </li>
                        <li>
                            <a class="breadcrumb-item active" href="">{{trans('users.add_user')}}</a>
                        </li>
                    </div>
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-users icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('users.add_user')}}
                                </div>
                            </div>
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                        	<!-- <h5 class="card-title">Grid Rows</h5> -->
                                    <form class="form-horizontal" method="POST" action="{{ route('users.store') }}">
                                     	{{ csrf_field() }}
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                    <label for="exampleEmail" class="">
                                                        <span class="text-danger">*</span> Email</label>
                                                        <input name="email" id="exampleEmail" placeholder="Email here..." 
                                                        value="{{ old('email') }}"  class="form-control">
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
                                                    <input name="name" value="{{ old('name') }}"  id="exampleName" placeholder="Name here..." type="text" class="form-control" >
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
                                                    <input name="password" id="examplePassword" placeholder="Password here..."  type="password" class="form-control">
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
                                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="country" class="control-label">{{trans('users.acess_module')}}</label>
                                                        <select class="bs-select form-control" 
                                                        data-live-search="true" multiple name="access_module[]">
                                                            <option value="" disabled>Select Roles</option>
                                                          @foreach ($modules as $module)
                                                            <option value="{{$module->id}}">{{$module->name}}</option>
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
                                                            <option value="" disabled>Select Roles</option>
                                                          @foreach ($roles as $role)
                                                            @if(($role->name != 'Employee') && ($role->name != 'Manager'))
                                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                                            @endif
                                                          @endforeach
                                                        </select>
                                                    @if ($errors->has('roles'))
                                                        <span class="help-block"><strong>{{ $errors->first('roles') }}</strong></span>
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
                                                        value="{{ old('sms_percentage') }}"  class="form-control" >
                                                        @if ($errors->has('sms_percentage'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('sms_percentage') }}</strong>
                                                            </span>
                                                        @endif
                                                </div>
                                            </div>





                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="country" class="control-label">{{trans('users.country')}}</label>
                                                        <select class=" form-control" onchange="settax(this)" 
                                                         name="country">
                                                            <option value="" >Select Country</option>
                                                          @foreach ($cntry as $ctr)
                                                            <option value="{{$ctr->iso_code}}">{{$ctr->name}}</option>
                                                          @endforeach
                                                        </select>
                                                    @if ($errors->has('country'))
                                                        <span class="help-block"><strong>{{ $errors->first('country') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>

                                                                                    


                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group{{ $errors->has('sms_percentage') ? ' has-error' : '' }}">
                                                    <label for="tax_percentage" class="">
                                                        <span class="text-danger">*</span> {{trans('users.tax_percentage')}}</label>
                                                        <input name="tax_percentage" id="tax_percentage" placeholder="Tax Percentage" 
                                                        value="{{ old('tax_percentage') }}"  class="form-control" >
                                                        @if ($errors->has('tax_percentage'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('tax_percentage') }}</strong>
                                                            </span>
                                                        @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-5">
                                                
                                                <label for="" class="ml-3">{{trans('users.active')}} </label>
                                                <input class=" ml-2 " type="checkbox" id="check_box" name="check_box" value="1" checked>
                                            </div>
                                        </div>
                                        <div style="text-align: right;">
                                       		<button type="submit" class="mt-2 btn btn-primary">{{trans('users.Save')}}</button>
                                        </div>
                                    </form>
                                </div>
                    </div>
                </div>
            </div>
@endsection

@section('javascript')
<script>
function settax(cntry)
{
    if(cntry.value==="PT")
{
  
    document.getElementById('tax_percentage').value=23
}
    
}

</script>

@endsection