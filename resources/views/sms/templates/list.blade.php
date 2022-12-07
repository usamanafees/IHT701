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
                            <a href="{{route('sms.home')}}">SMS</a>
                            <i class="fa fa-angle-right">&nbsp;</i>
                        </li>
                        <li>
                            <a class="breadcrumb-item active" href="">{{trans('sms.Templates')}}</a>

                        </li>

                    </div>

                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-align-left icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('sms.Templates')}}
                                </div>
                            </div>
                          </div><br>
                          <div class="card-header-title font-size-sm font-weight-normal" style="float: left;color: grey;">
                         <i class="fas fa-info-circle"></i>
                            <h7> {{trans('tips.list_templates')}}</h7>
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                <thead>
                                  <tr>
                                      <th>{{trans('sms.name')}}</th>
                                      <th>{{trans('sms.template')}}</th>
                                      <th>{{trans('sms.Entry_Date')}}</th>
                                      <th>{{trans('sms.action')}}</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($sms_template as $template)
                                    <tr>
                                      <td>
                                          {{$template->name}}
                                      </td>
                                      <td>
                                          {{ str_limit($template->template, 50)}}
                                      </td>
                                      <td>
                                          {{ \Carbon\Carbon::parse($template->created_at)->format('d/m/Y')}}
                                      </td>
                                      <td>
                                        <a title="View Template" 
                                           href="{{route('template.edit',$template->id)}}" 
                                           class="btn btn-warning btn-sm"> 
                                          <i class="fa fa-eye"></i>
                                        </a>
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