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
                            <a class="breadcrumb-item active" href="">{{trans('sms.add_sender')}}</a>

                        </li>

                    </div>


                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-user icon-gradient bg-tempting-azure">
                                    </i>
                                </div> 
                                <div>{{trans('sms.add_sender')}}
                                </div>
                            </div>
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
                         @if (number_format($user->AccountSettings->in_app_credit) < 5)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              {{trans('sms.balance_insufficent')}}<a class="alert-link" href="{{route('account.balance')}}"><strong> {{trans('sms.recharge')}}</strong> </a>
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                        @endif
                        <div class="card-body" style="background-color: #CCCCCC;">
                            <h2><b>{{trans('sms.new_sender')}}</b></h2>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                                    <form class="form-horizontal" method="POST" action="{{ route('sender.store') }}">
                                     	{{ csrf_field() }}
                                        <p>
                                            {{trans('sms.personalized_your_sms')}}
                                        </p>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                		<label for="" class="">{{trans('sms.Sender')}}</label>
                                                	<input name="sender" id="sender" placeholder="Sender" type="text"   class="form-control inp" maxlength="11" minlength="1"
                                                    value="{{old('sender')}}">
                                                    <span id="err" class="help-block" style="color: red;"></span>
                                                    @if ($errors->has('sender'))
                                                        <span class="help-block" style="color: red;">
                                                            <strong>{{ $errors->first('sender') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <p>
                                            {{trans('sms.note')}}{{Auth::user()->sender_rate}} {{trans('sms.note_text')}}
                                            {{-- {{trans('sms.add_sender_note')}} --}}
                                        </p>
                                        @if (Auth::user()->roles()->pluck('name')->implode(' ') == 'Administrator')
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>{{trans('sms.offer')}}</label>
                                                <input type="checkbox" name="offerSender" value="true">
                                            </div>
                                        </div>
                                        @endif
                                        <div class="" style="text-align: right;">
                                                <!-- <div class="position-relative form-group" style="top: 25%;"> -->
                                                        {{-- <button @if (number_format($user->AccountSettings->in_app_credit) < 5 && Auth::user()->roles()->pluck('name')->implode(' ')  != 'Administrator') disabled @endif type="submit" class="mt-2 btn btn-success">{{trans('sms.add_sender')}}</button> --}}
                                                        <button type="submit" class="mt-2 btn btn-success">{{trans('sms.add_sender')}}</button>

                                                        <!-- </div> -->
                                        </div>
                                    </form>
                                </div>
                    </div>
                </div>
            </div>
@endsection
@section('javascript')
<script>
  
  $(function() {
        $('#sender').on('keyup', function(e) {
            
         
            var eleVal = document.getElementById('sender');
            eleVal.value= eleVal.value.toUpperCase().replace(/ /g,'');
            // if ((e.which == 32) ||(e.which >=97 && e.which<=122) ){
            //     $("#err").text("no spaces or small characters are allowed");
            //     return false;
            // }else
            // {
            //     $("#err").text("");
            // }    
        });
});


</script>
@endsection