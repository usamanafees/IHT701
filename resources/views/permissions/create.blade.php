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
                                <a  href="{{route('permissions.index')}}">{{trans('menu.permissions')}}</a>
                                <i class="fa fa-angle-right">&nbsp;</i>
                            </li>
                            <li>
                                <a class="breadcrumb-item active" href="">{{trans('permissions.add_permission')}}</a>
                            </li>
                        </div>
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-list icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('permissions.add_permission')}}
                                </div>
                            </div>
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                          <!-- <h5 class="card-title">Grid Rows</h5> -->
                              <form action="{{route('permissions.store')}}" method="POST" enctype="multipart/form-data" >
                               {{csrf_field()}}
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="name">{{trans('permissions.permission_name')}}</label>
                                                    <input type="name" class="form-control" id="name" name="name" required autocomplete="off"
                                                    value="{{ old('name') }}">
                                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <h5>Roles</h5>
                                                      @foreach ($roles as $role)
                                                          <label>{{$role->name}}
                                                          <input type="checkbox" name="roles[]" value="{{$role->id}}" />
                                                          </label>
                                                          &nbsp;&nbsp;&nbsp;
                                                      @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div style="text-align: right;">
                                          <button type="submit" class="mt-2 btn btn-primary">{{trans('roles.Save')}}</button>
                                        </div>
                                    </form>
                                </div>
                    </div>
                </div>
                  
            </div>
@endsection