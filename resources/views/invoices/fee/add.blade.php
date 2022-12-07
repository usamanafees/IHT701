@php
    $fees = json_decode($user->user_fee_list);
    $count_php = 0;
@endphp
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
                                <a href="{{route('showFees')}}">{{trans('menu.fee')}}</a>
                                <i class="fa fa-angle-right">&nbsp;</i>
                            </li>
                            <li>
                                <a class="breadcrumb-item active" href="">{{trans('invoices.add_fee')}}</a>
                            </li>
                        </div>
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-file icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>
                                    @if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                                   Add/Edit Tax for user with ID {{ $user->id }}
                                        @endif
                                </div>
                            </div>
                            @can('Create Invoice')
                                <div class="page-title-actions">
                                    
                                </div> 
                            @endif  
                        </div>
                    </div>   
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <div class="d-inline-block dropdown" style="float:right;">
                                <button onclick="add_fee()" class="btn btn-primary">{{trans('invoices.add_fee')}}</button>
                            </div>
                            <form class="row g-3 mt-3" method="POST" action="{{ route('fee.store') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="user_id" value="{{ $user->id }}"/>
                                <div id="panel" class="justify-content-center col-12" style="">
                                    @if (isset($fees))
                             
                                        @foreach($fees as $fee)
                                        <div style="display:none;">
                                        {{ $count_php = $count_php+1 }}
                                        {{ $noo = "no".$count_php."" }}
                                        </div>
                                        <div class="col-md-12 m-3" id="{{ 'no'.$count_php }}"> {{trans('invoices.value')}} % <input type="text" class="mr-3"  name="fee[{{ $count_php }}][0]" id="{{'fee1'.$count_php }}" value="{{ $fee[0] }}"/>
                                            {{trans('invoices.name')}}  <input type="text" class="" name="fee[{{ $count_php }}][1]" id="{{'fee'.$count_php }}" value="{{ $fee[1] }}"/>
                                            <button class="btn btn-danger btn-sm ml-3" data-id="{{ 'no'.$count_php }}" onclick= remove_fee("{{ 'no'.$count_php }}");>
                                                {{trans('invoices.remove')}}</button>
                                        </div>
                                        
                                        @endforeach 
                                    @endif
                                </div>
                                {{ Log::info(['sdfvbfdss',$count_php]) }}
                                <div class="d-inline-block dropdown" >
                                    <button type="submit" class="btn btn-primary" name='ins' id="ins">{{trans('invoices.submit')}}</button>
                                </div>
                            </form>
                    
                        </div>
                    </div>
                </div>
            </div>    
@endsection
@section('javascript')
<script type="text/javascript">
checkelements();
    var count= {!! json_encode($count_php) !!}
    console.log(count);
    function add_fee()
    {
        count = count + 1;
        $('#panel').append('<div class="col-md-12 m-3" id="no'+count+'"> Value <input type="text" class="mr-3" name="fee['+count+'][0]" id="fee'+count+'"/>  Name <input type="text" class="" name="fee['+count+'][1]" id="feename'+count+'"/>'+
        '<button class="btn btn-danger btn-sm ml-3" onclick= remove_fee("no'+count+'")>'+
        'remove</button></div>');
        checkelements();
    }
    function remove_fee(id)
    {
        console.log(id);
       
        $("#"+id).remove();
        checkelements();
    }
    function checkelements()
    {

       if($('#panel').children().length == 0)
       {
   
        $('#ins').prop("disabled", true);
       }
       else{

             $('#ins').prop("disabled", false);
       }
    }
</script>
@endsection