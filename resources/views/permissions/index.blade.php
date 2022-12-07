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
                                <a  href="">{{trans('menu.permissions')}}</a>
                            </li>
                        </div>
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-list icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('permissions.permissions')}}
                                </div>
                            </div>
                           <!--  <div class="page-title-actions">
                                <div class="d-inline-block dropdown">
                                    <a href="{{URL::to('permissions/create')}}" class="btn-shadow btn btn-info" href="">
                                        <i class="fa fa-plus btn-icon-wrapper"></i> &nbsp; Add Permission</a>
                                </div>
                            </div>    --> 
                          </div>
                    </div>   
                          
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{trans('permissions.permissions')}}</th>
                                    <!-- <th>Operation</th> -->
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                      <tr>
                                        <td>{{++$loop->index}}</td>
                                          <td>{{ $permission->name }}</td>
                                          <td>
                                            <!-- <div class="btn-group">
                                                  <a href="{{ URL::to('permissions/'.$permission->id.'/edit') }}"
                                                    class="btn btn-warning pull-left btn-sm" style="margin-right: 3px;">
                                                  <i class="fa fa-eye"></i></a>

                                                    <form action="{{route('permissions.destroy', $permission->id)}}" method="post">
                                                          {{csrf_field()}}
                                                     <input name="_method" type="hidden" value="DELETE">
                                                      <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Are you sure you want to delete this?')"> <i class="fa fa-trash" aria-hidden="true"></i></button>
                                                      </form>
                                            </div>  -->         
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