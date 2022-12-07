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
                            <a class="breadcrumb-item active" href="">{{trans('menu.rates')}}</a>
                        </li>
                    </div>
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-users icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('smsrate.sms_rate')}}
                                </div>
                            </div>
                        
                            <div class="page-title-actions">
                                <div class="d-inline-block dropdown">
                                    <a href="{{route('smsrates.add')}}" class="btn-shadow btn btn-info" href="">
                                        <i class="fa fa-plus btn-icon-wrapper"></i> &nbsp; {{trans('smsrate.add_rate')}}</a>
                                </div>
                            </div>    
                            </div>
                           </div>  
                           @if (\Session::has('success'))
                        <div class="alert alert-success">
                           <p>
                              {!! \Session::get('success') !!}
                           </p>
                        </div>
                        @endif          
                           <div class="main-card mb-3 card">
                           <div class="card-body">
                            <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{trans('smsrate.name')}}</th>
                                    <th>{{trans('smsrate.provider_name')}}</th>
                                    <th>{{trans('smsrate.sms_rate')}}</th>
                                    <th style="text-align: center;">{{trans('smsrate.action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($smsrates as $smsrate)
                                    <tr>
                                        <td>{{++$loop->index}}</td>
                                        <td>{{$smsrate->Country->name }}</td>
                                        <td>{{$smsrate->SMSProvider->provider_name}}</td>
                                        <td>{{$smsrate->rate}}</td>
                                        <td style="text-align: center;">
                                            <div class="btn-group">
                                               <a href="{{route('smsrates.destroy',$smsrate->id)}}"
                                                class="btn-sm btn-shadow btn btn-danger" 
                                                href="">
                                                   <i class="fas fa-trash"></i>
                                               </a>
                                               <a href="{{route('smsrates.edit',$smsrate->id)}}" 
                                                class="btn-sm btn-shadow btn btn-warning" href="">
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

