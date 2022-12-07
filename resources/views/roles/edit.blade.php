 @extends('partials.main')

@section('content')
      <div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
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
                                <a  href="{{route('roles.index')}}">{{trans('menu.roles')}}</a>
                                <i class="fa fa-angle-right">&nbsp;</i>
                            </li>
                            <li>
                                <a class="breadcrumb-item active" href="">{{trans('roles.edit_role')}}</a>
                            </li>
                        </div>
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-list icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('roles.edit_role')}}
                                </div>
                            </div>
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                          <!-- <h5 class="card-title">Grid Rows</h5> -->
                              <form action="{{route('roles.update',$role->id)}}" method="POST" enctype="multipart/form-data" >
                                  {{ method_field('PUT') }}{{csrf_field()}}
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="name">{{trans('roles.role_name')}}</label>
                                                    <input type="name" class="form-control" id="name" name="name" required autocomplete="off"
                                                    value="{{ $role->name}}">
                                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="country" class="control-label">{{trans('roles.permissions')}}</label>
                                                        <select class="bs-select form-control" 
                                                        data-live-search="true" multiple name="permissions[]">
                                                            <option value="" disabled>{{trans('roles.select_permissions')}}</option>
                                                            @foreach ($permissions as $permission)
                                                              <option value="{{$permission->id}}"
                                                                @if(in_array($permission->id, $role_permissions)) selected @endif
                                                                >{{$permission->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    @if ($errors->has('permission'))
                                                        <span class="help-block"><strong>{{ $errors->first('permission') }}</strong></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div style="text-align: right;">
                                          <button type="submit" class="mt-2 btn btn-primary">{{trans('roles.Update')}}</button>
                                        </div>
                                    </form>
                                </div>
                    </div>
                </div>
                  
            </div>
@endsection