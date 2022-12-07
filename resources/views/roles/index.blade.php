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
                                <a class="breadcrumb-item active" href="">{{trans('menu.roles')}}</a>
                            </li>
                        </div>


                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-list icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('roles.Roles')}}
                                </div>
                            </div>
                            <div class="page-title-actions">
                                <div class="d-inline-block dropdown">
                                    <a href="{{URL::to('roles/create')}}" class="btn-shadow btn btn-info" href="">
                                        <i class="fa fa-plus btn-icon-wrapper"></i> &nbsp; {{trans('roles.add_role')}}</a>
                                </div>
                            </div>    </div>
                    </div>            <div class="main-card mb-3 card">
                        <div class="card-body">
                            <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>{{trans('roles.role')}}</th>
                                    <th>{{trans('roles.permission')}}</th>
                                    <th>{{trans('roles.operation')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                      <tr>

                                          <td>{{ $role->name }}</td>

                                          <td>{{ str_replace(array('[',']','"'),'', $role->permissions()->pluck('name')) }}</td>
                                          {{-- Retrieve array of permissions associated to a role and convert to string --}}
                                          <td>
                                            <form action="{{route('roles.destroy', $role->id)}}" method="post">
                                                  {{csrf_field()}}
                                              <div class="btn-group" role="group">
                                                 <a href="{{ URL::to('roles/'.$role->id.'/edit') }}" class="btn btn-warning pull-left btn-sm">
                                                  <i class="fa fa-eye"></i></a>
                                                <input name="_method" type="hidden" value="DELETE">
                                                  <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Are you sure you want to delete this?')"> <i class="fa fa-trash" aria-hidden="true"></i></button>
                                              </div>

                                            </form>

                                          </td>
                                      </tr>
                                      @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
@endsection