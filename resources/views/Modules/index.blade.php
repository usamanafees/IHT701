@extends('partials.main')

@section('content')
			<div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-clipboard-list icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('modules.Modules')}}
                                </div>
                            </div>
                              <div class="page-title-actions">
                                  <div class="d-inline-block dropdown">
                                      <a href="{{route('modules.add')}}" class="btn-shadow btn btn-info" href="">
                                          <i class="fa fa-plus btn-icon-wrapper"></i> &nbsp; {{trans('modules.add_module')}}</a>
                                  </div>
                              </div> 
                          </div>
                          
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{trans('modules.Module_Name')}}</th>
                                    <th>{{trans('modules.Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($module as $modules)
                                        <tr>
                                           <td>{{$modules->id}}</td>
                                           <td>{{$modules->name}}</td>
                                           <td>
                                              <div class="btn-group">
                                                 <a href="{{route('modules.edit',$modules->id)}}" class="btn-sm btn-shadow btn btn-warning" href="">
                                                     <i class="fas fa-pen"></i>
                                                 </a>
                                             </div>
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