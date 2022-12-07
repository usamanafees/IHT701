<?php


?>
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
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-users icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>Add Employee
                                </div>
                            </div>
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                        	<!-- <h5 class="card-title">Grid Rows</h5> -->
                                    <form class="form-horizontal" method="POST" action="{{ route('hr.store_employee') }}">
                                     	{{ csrf_field() }}
                                        <div class="form-row">

                                            <div class="col-md-6">
                                                <div class="position-relative form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                    <label for="exampleName" class="">Name</label>
                                                    <input name="name" value="{{ old('name') }}"  id="exampleName" placeholder="Name here..." type="text" class="form-control" required>
                                                    @if ($errors->has('name'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

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
                                          
                                        </div>
                                      
                                        <div class="form-row">
                                        
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="permission" class="control-label">Permissions*</label>
                                                        <select class=" form-control" 
                                                         name="role" onchange="set_manager()" id="emp_permission" required>
                                                            <option value="" disabled selected>Select Permission</option>
                                                          @foreach ($roles as $role)
                                                          @if(($role->name == "Manager" || $role->name == "Employee")&&(Auth::user()->is_hr_admin == 'admin'))
                                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                                          @elseif($role->name == "Employee")
                                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                                          @endif
                                                            @endforeach 
                                                        </select>
                                                    @if ($errors->has('permission'))
                                                        <span class="help-block"><strong>{{ $errors->first('permission') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="manager" class="control-label">Manager*</label>
                                                        <select class=" form-control" 
                                                         name="manager" id="emp_manager" required>
                                                            <option value="" disabled selected>Select Manager</option>
                                                            @foreach ($users as $user)
                                                                @if($user->hasRole('Manager') || $user->is_hr_admin=='admin')
                                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    @if ($errors->has('manager'))
                                                        <span class="help-block"><strong>{{ $errors->first('manager') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                            

                                        </div>
                                        <div class="form-row">
                                        
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="country" class="control-label">Country*</label>
                                                        <select class=" form-control" 
                                                         name="country" onchange="set_region()" id="sel_country" required>
                                                            <option value="" disabled selected>Select Country</option>
                                                          @foreach ($countries as $ctr)
                                                            <option value="{{$ctr->id}}">{{$ctr->name}}</option>
                                                          @endforeach
                                                        </select>
                                                    @if ($errors->has('country'))
                                                        <span class="help-block"><strong>{{ $errors->first('country') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="region" class="control-label">Region*</label>
                                                        <select class=" form-control" 
                                                            name="region" id="ctr_regions" required>
                                                            <option value="" >Select Region</option>
                                                          {{-- @foreach ($cntry as $ctr)
                                                            <option value="{{$ctr->iso_code}}">{{$ctr->name}}</option>
                                                          @endforeach --}}
                                                        </select>
                                                    @if ($errors->has('region'))
                                                        <span class="help-block"><strong>{{ $errors->first('region') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                            

                                        </div>
                                        <div class="form-row" >
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                              
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                        <input type="checkbox" name="send_invite"/> <b> Send invite to employee</b><br>
                                                        If you want to send the invitation later, go to the employee's profile -> account -> send invite.
                                                    @if ($errors->has('send_invite'))
                                                        <span class="help-block"><strong>{{ $errors->first('send_invite') }}</strong></span>
                                                    @endif
                                                </div>
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
var current_user = {!! json_encode(Auth::user()) !!}
function set_manager()
{
   if($('#emp_permission').val() == 8)
   {
    $("#emp_manager > option").each(function() {

            if(this.value != current_user['id'])
            {
                $(this).prop( "disabled", true );
            }
        });
   }
   if($('#emp_permission').val() == 9)
   {
    $("#emp_manager > option").each(function() {
            $(this).prop( "disabled", false );
        });
   }
}

function set_region()
{
            var c_id = $('#sel_country').val();
            CSRF_TOKEN  = "{{ csrf_token() }}";
            $.ajax({
                    type: "POST",
                    url: "{{route('hr.set_region')}}",
                    data: {cid: c_id, _token: CSRF_TOKEN},
            success: function (data) {
                if(data['success']==="true")
                {
                    $('#ctr_regions')
                    .find('option')
                    .remove();
                   
                    for(var i=0;i<data['regions'].length;i++)
                    {
                        $('#ctr_regions').append('<option value='+data['regions'][i].id+'>'+data['regions'][i].name+'</option>');
                    }
                }
                },
                // else if(data['success']==="false")
                // {
                //     notif({
                //         msg: "<b>Error!</b> region does not exist",
                //         type: "error",
                //         position: "center"
                //     });
                //     }
                // },
                error:function(err){
                notif({
                        type: "warning",
                        msg: "<b>Warning:</b> Something Went Wrong while selecting the country",
                        position: "left"
                    });
                }
                });
}

</script>

@endsection