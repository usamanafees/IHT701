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
                        <a href="{{route('invoices.home')}}">{{trans('menu.invoicing')}}</a>
                        <i class="fa fa-angle-right">&nbsp;</i>
                    </li>
                    <li>
                        <a class="breadcrumb-item active" href="">{{trans('menu.fee')}}</a>

                    </li>

                </div>
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="fas fa-file icon-gradient bg-tempting-azure"></i>
                        </div>
                        <div>
                            {{trans('invoices.fee_taxes')}}
                        </div>
                    </div>
                </div>
            </div>            <div class="main-card mb-3 card">
                <div class="card-body">
                    <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                        <thead>
                        <tr style="text-align: center;">
                            <th>{{trans('invoices.user_id')}}</th>
                            <th>{{trans('invoices.user_name')}}</th>
                            <th>{{trans('invoices.user_fee')}}</th>
                            <th>{{trans('invoices.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if (isset($user) && !empty($user))
                            @foreach($user as $u)
                                <tr style="text-align: center">
                                    <td>{{ $u->id }}</td>
                                    <td>{{ $u->name }}</td>
                                    <td>

                                        <div style="max-height:80px;overflow-y: auto;overflow-x: auto;">
                                            <?php
                                            $val = json_decode($u->user_fee_list)
                                            ?>
                                            @if(isset($val) && !empty($val))
                                                @foreach ($val as $item)


                                                    <span style="color:blue">  Name: </span>"{{ $item[1] }}" ,
                                                    <span style="color:green">  Value : </span>  {{ $item[0] }} </br>

                                                @endforeach

                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                        <a title="Edit" href="{{route('fee.add',$u->id)}}" class="btn-shadow btn btn-primary " href="">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>
@endsection