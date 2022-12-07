@extends('partials.main')
 
@section('content')

<style>



.ui-datepicker-calendar{
	background-color : #fff;
	border:none !important;
	
	
	font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    font-size: .88rem !important;
    font-weight: 400 !important;
    line-height: 1.5 !important;
    color: #495057 !important;
    text-align: left !important;
}
.ui-widget-header{
	background-color : #fff !important;
	background : #fff !important;
	border : none !important;
	color : #333333 !important;
}
.ui-widget-content{
	background : #fff !important;
}
.ui-datepicker-calendar table{
	background : #fff !important;
}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active{
	color : #333333 !important;
	background-color : #fff !important;
	background : #fff !important;
	border: none !important;
}

.ui-datepicker td span,
.ui-datepicker td a{
	font-weight:300 !important;
}
.ui-datepicker-calendar thead tr th{
	font-weight:300 !important;
}
</style>
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fas fa-edit icon-gradient bg-tempting-azure">
                        </i>
                    </div>
                    <div>{{trans('digitalsig.add_digital_sig')}}</div>
                </div>
            </div>
        </div>            
        <div class="main-card mb-3 card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (\Session::has('responseCode'))
                    <div 
                    @if(\Session::get('responseCode') == 200) 
                        class="alert alert-success" 
                    @else  
                        class="alert alert-warning"
                    @endif
                    >
                        <p>
                            {!! \Session::get('message') !!}
                        </p>
                    </div>
                @endif
                @php
                 Session::forget('responseCode');
                 Session::forget('message');
                @endphp
                <form class="form-horizontal" method="POST" action="{{ route('digital_signature') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="" class="">{{trans('digitalsig.signature')}}</label>
                                <input class="form-control-file" type="file" name="file" value="" id="file" class="required" required >
                                <input type="hidden" name="action" value="save">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                    
                            </div>
                        </div>
                    </div>
                    

                    <div  style="text-align: right;">
                        <button  type="submit" id="submit" class="mt-2 btn btn-success">{{trans('digitalsig.upload')}}</button>
                    </div>
                </form>
            </div>

            @if ($user->digital_signature != '')
            <div class="card-body">
                <table style="width: 100%;"  class="table table-hover table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>{{trans('digitalsig.digital_signature')}}</th>
                        <th>{{trans('digitalsig.action')}}</th>
                        <!-- <th>Operation</th> -->
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><img style="height: 90px;" src="{{ asset('/img/digital_signature/'.$user->digital_signature) }}" alt="digital_signature"></td>
                            <td>
                                <div class="btn-group">
                                    <a title="Delete" href="{{ url('delete_digital_signature/'.$user->id) }}" class="btn-shadow btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif

        </div>
    </div>                  
</div>
		
@endsection



@section('javascript')

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

@endsection

