<style>
    .hover
    {
        width: 100% !important;
        color:#3f6ad8 !important;
        padding-left: 10px;
    }
    .hover a
    {
        display: block !important;
        width: 100% !important;
        padding: 5px !important;
        text-decoration:none !important;
    }
    .hover a:hover
    {
        display: block !important;
        background-color: #e0f3ff !important;
        color: blue  !important;
    }
	.bg-info {
		background-color: #fafbfc !important;
	}
	.account-balance-header{
		color :red;
		font-size: 1.5rem;
		font-weight: 500;
		font-style: inherit;
	}


@media (max-width: 991.98px){
.popover, .dropdown-menu {

margin-top:5% !important;
width: 50% !important;
margin-left: 17%;
text-align: start !important;

}

}
ul {
  list-style: none;
  margin: 0;
  padding: 0;
}

.notification-drop {
  font-family: 'Ubuntu', sans-serif;
  color: #444;
}
.notification-drop .item {
  padding: 10px;
  font-size: 18px;
  position: relative;
  border-bottom: 1px solid #ddd;
}
.notification-drop .item:hover {
  cursor: pointer;
}
.notification-drop .item i {
  margin-left: 10px;
}
.notification-drop .item ul {
  display: none;
  position: absolute;
  top: 100%;
  background: #fff;
  left: -200px;
  right: 0;
  z-index: 1;
  border-top: 1px solid #ddd;
}
.notification-drop .item ul li {
  font-size: 16px;
  padding: 15px 0 15px 25px;
}
.notification-drop .item ul li:hover {
  background: #ddd;
  color: rgba(0, 0, 0, 0.8);
}

@media screen and (min-width: 500px) {
  .notification-drop {
    display: flex;
    justify-content: flex-end;
  }
  .notification-drop .item {
    border: none;
  }
}



.notification-bell{
  font-size: 20px;
}

.btn__badge {
  background: #FF5D5D;
  color: white;
  font-size: 12px;
  position: absolute;
  top: 0;
  right: 0px;
  padding:  3px 10px;
  border-radius: 50%;
}

.pulse-button {
  box-shadow: 0 0 0 0 rgba(255, 0, 0, 0.5);
  -webkit-animation: pulse 1.5s infinite;
}

.pulse-button:hover {
  -webkit-animation: none;
}

@-webkit-keyframes pulse {
  0% {
    -moz-transform: scale(0.9);
    -ms-transform: scale(0.9);
    -webkit-transform: scale(0.9);
    transform: scale(0.9);
  }
  70% {
    -moz-transform: scale(1);
    -ms-transform: scale(1);
    -webkit-transform: scale(1);
    transform: scale(1);
    box-shadow: 0 0 0 50px rgba(255, 0, 0, 0);
  }
  100% {
    -moz-transform: scale(0.9);
    -ms-transform: scale(0.9);
    -webkit-transform: scale(0.9);
    transform: scale(0.9);
    box-shadow: 0 0 0 0 rgba(255, 0, 0, 0);
  }
}

.notification-text{
  font-size: 14px;
  font-weight: bold;
}

.notification-text span{
  float: right;
}


</style>


<!-- Load font awesome icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<head>
    <script src="{{asset('js/app.js')}}"></script>
    <script>
        var cal =0;
      Echo.private('home.'+{!!json_decode(Auth::user()->id)!!})
      .listen('BroadCastMessage', (e) =>{
          console.log("aaaaaaaaaaaa");
          cal++;
        document.getElementById("not_count").innerHTML=''+cal;
        $('#messages_call').append(
            '<a class="dropdown-item d-flex pb-4" id="msg_line_styles" href="#">'
                            +'<span class="avatar mr-3 br-3 align-self-center avatar-md cover-image bg-primary-transparent text-primary"><i class="fe fe-mail"></i></span>'
                            +'<div>'
                            +'<span class="font-weight-bold"> '+e['message'].substring(0,23)+'... </span>'
                            +'</div>'
                            +'</a>')
        // document.getElementById("cal_messages").innerHTML=
      });
    </script>
 </head>

<div class="app-header header-shadow" >
        <div class="app-header__logo">
            <div class="logo-src"></div>
            <div class="header__pane ml-auto">
                <div>
                    <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="app-header__mobile-menu">
            <div>
                <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
        <div class="app-header__menu">
            <span>
                <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                    <span class="btn-icon-wrapper">
                        <i class="fa fa-ellipsis-v fa-w-6"></i>
                    </span>
                </button>
            </span>
        </div>  
        <div class="app-header__content">
            <div class="app-header-left">
                 <div class="search-wrapper">
                    <div class="input-holder" style="position: relative">
                    @if ( in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))                       
                        @if(app('request')->input('xyz'))
                            <input type="text" id="search_1"  class="search-input" placeholder="Type to search" value="{{app('request')->input('xyz')}}" onkeyup="search(this.value)"/>
                        @else
                            <input type="text" id="search_1"  class="search-input" placeholder="Type to search"  onkeyup="search(this.value)"/>
                        @endif
                       <button class="search-icon" id="searchbutton" ><span></span></button>
                    @endif
                    </div>
                    <div id="showuser" style=" margin-left:17px; padding:10px;  position: absolute; z-index:999; margin-top:0px;  ">
                    </div>
                    <button class="close" onclick="hideusers();"></button>
                </div>
                @if(Session::get('previous_user') !== null)   
            <button class="mb-2 mr-2 border-0 btn-transition btn btn-shadow btn-outline-light">    <span style=""><a href="{{ URL('user_based_login_home')}}"><i class="fas fa-key"></i> &nbsp; Go back to Previous Session</a><span></button>
                @endif
            </div>

                </div>
                <!-- <div class="widget-content-right header-user-info ml-3">
                    <a href="{{route('company.info', Auth::user()->id)}}" class="btn-shadow btn btn-primary btn-sm">
                        <i style="font-weight: 600;" class="fa fa-gear  pe-7s-settings "></i> 
                        <b>Settings</b>
                    </a>
                </div> -->
                {{--     --}}
                @if(in_array('5',explode(',', Auth::user()->access_modules)))
                <div class="dropdown d-md-flex header-message" id="cal_messages">
                    <a class="nav-link icon" data-toggle="dropdown">
                        <i class="far fa-bell fa-lg" style="color: black"></i>
                        <span id="not_count" class="nav-unread badge badge-danger badge-pill mb-3 mr-2">
                            0
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow" id="not_messages">
                        <a class="dropdown-item text-center" href="#">Notifications</a>

                        <div class="dropdown-divider"></div>
                        <div id="messages_call">
                      </div>
                        <div class="dropdown-divider"></div>
                        <div class="text-center dropdown-btn pb-3">
                            <div class="btn-list">
                                <a href="#" class=" btn btn-secondary btn-sm"><i class="fe fe-eye mr-1"></i>View All</a>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- for request notifications     --}}
                {{-- <ul class="notification-drop">
                        <li class="item">
                            <i class="far fa-bell"></i> <span class="btn__badge pulse-button mb-7" style="">4</span>     
                            <ul>
                                <li>First Item</li>
                                <li>Second Item</li>
                                <li>Third Item</li>
                            </ul>
                        </li>
                    </ul> --}}
                @endif    
                @if(isset(Auth::user()->AccountSettings->in_app_credit))
                   @if(Auth::user()->AccountSettings->in_app_credit > 0)
                    @if (Session::get('locale')=='pt')
                   <span class="account-balance-header" style="color: green">{{ number_format(Auth::user()->AccountSettings->in_app_credit,2,","," ") }} €</span>
                   @else 
                   <span class="account-balance-header" style="color: green">{{ number_format(Auth::user()->AccountSettings->in_app_credit,2,".","") }} €</span>
                    @endif
                   @else
                   @if (Session::get('locale')=='pt')
                   <span class="account-balance-header" style="color: red">{{ number_format(Auth::user()->AccountSettings->in_app_credit,2,","," ") }} €</span>
                   @else 
                   <span class="account-balance-header" style="color: red">{{ number_format(Auth::user()->AccountSettings->in_app_credit,2,".","") }} €</span>
                    @endif
                   @endif
               @endif
                {{-- <span class="account-balance-header">{{isset(Auth::user()->AccountSettings->in_app_credit)? number_format(Auth::user()->AccountSettings->in_app_credit,2,",",","): "" }} €</span> --}}
                      
                <div class="header-btn-lg pr-0">
                    <div class="widget-content p-0">
                     
                        <div class="widget-content-wrapper">


                            <div class="widget-content-left  mr-3 header-user-info">
                                <div class="widget-heading">
                                    {{Auth::user()->name}}
                                </div>
                                <div class="widget-subheading">
                                    {{ Auth::user()->roles()->pluck('name')->implode(' / ') }}
                                </div>
                            </div>
                            <div class="widget-content-left">
                             
                                <div class="btn-group">
                                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">

                                        <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                    </a>

<div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">

        <div class="dropdown-menu-header">
            <div class="dropdown-menu-header-inner">
                <div class="menu-header-content text-left">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">

                            <div class="widget-content-left mr-3">
                                @if(isset(Auth::user()->image))
                                    <img width="42" class="rounded-circle" src="{{Auth::user()->image}}" alt="">
                                @else
                                    <i width="42" class="fas fa-user"></i>
                                @endif
                            </div>
                            <div class="widget-content-left">
                                <div class="widget-heading">{{Auth::user()->name}}
                                </div>
                                <div class="widget-subheading opacity-8">{{Auth::user()->email}}
                                </div>
                            </div>
                            <div class="widget-content-right mr-2">
                                <a class="btn-pill btn-shadow btn-shine btn btn-focus" href="{{route('logout')}}"
                                    onclick="event.preventDefault();
							        document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid-menu grid-menu-2col">
            <div class="no-gutters row">
                <div class="col-sm-6">
                    <a href="{{route('account.user_details')}}" class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-warning">


                        <i class="lnr-user icon-gradient bg-amy-crisp btn-icon-wrapper mb-2"></i>
                        <b>{{trans('menu.account_man')}}</b>
                    </a>
                </div>
                <div class="col-sm-6">
                    <a href="malito:360@intelidus.com" class="btn-icon-vertical btn-transition btn-transition-alt pt-2 pb-2 btn btn-outline-danger">
                        <i class="pe-7s-chat icon-gradient bg-amy-crisp btn-icon-wrapper mb-2"></i>
                        <b>{{trans('menu.support')}}</b>
                    </a>
                </div>
            </div>
        </div>

    </div>
                                </div>
                            </div>
                            <div class="app-header-right">
                                <div class="header-dots">
                                    <form class="p-0 ml-2 mb-0 mr-0 btn btn-link" name="lan-form" id="lan-form" method="POST" action="{{route('language.switch')}}">
                                        {{csrf_field()}}
                                        <div class="dropdown d-sm-inline-block">
                                            <button type="button" data-toggle="dropdown" class="p-0 mr-2 btn btn-link">

                            <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                <span class="icon-wrapper-bg bg-focus"></span>
                                @php
                                    if (Session::get('locale')=='pt'){
                                @endphp
                                <span class="language-icon opacity-8 flag large PT"></span>
                                @php
                                    } else{
                                @endphp
                                <span class="language-icon opacity-8 flag large US"></span>
                                @php
                                    }
                                @endphp
                            </span>
                                            </button>
                                            <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu dropdown-menu-right">
                                                <div class="dropdown-menu-header">
                                                    <div class="dropdown-menu-header-inner pt-4 pb-4 bg-focus">
                                                        <div class="menu-header-content text-center text-white">
                                                            <h6 class="menu-header-subtitle mt-0">
                                                                {{trans('menu.choose_lang')}}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="lng" id="lng">
                                                <ul class="language_nav nav">
                                                    <!-- settings start -->
                                                    <button id="id_btn_en" type="button" href="javascript:void(0) " onclick="set_language('en')" tabindex="0" class="dropdown-item">
                                                        <span class="mr-3 opacity-8 flag large US"></span>
                                                        EN
                                                    </button>
                                                    <button id="id_btn_pt" type="button" href="javascript:void(0) " onclick="set_language('pt')" tabindex="0" class="dropdown-item">
                                                        <span class="mr-3 opacity-8 flag large PT"></span>
                                                        PT
                                                    </button>
                                                    {{-- <li id="id_btn_pt" class="mb-2 mr-2 border-0 btn-transition btn btn-shadow btn-outline-light  @php= (Config::get('app.locale') == 'pt') ? 'open' : '' @endphp">
                                                        <a href="javascript:void(0)" onclick="" >Portugese</a>
                                                    </li>  --}}
                                                </ul>
                                    </form>
                                </div>
                            </div>
                            <div class="dropdown">
                                <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="p-0 mr-2 btn btn-link">
                            <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                                <span class="icon-wrapper-bg bg-primary"></span>
                                <i class="icon text-primary ion-android-apps"></i>
                            </span>
                                </button>
                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                                    <div class="dropdown-menu-header">
                                        <div class="dropdown-menu-header-inner bg-focus">
                                            <div class="menu-header-content text-white">
                                                <h5 class="menu-header-title">{{trans('invoices.rapid_nav')}}</h5>
                                                <h6 class="menu-header-subtitle">{{trans('invoices.rapid_nav_desc')}}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-menu grid-menu-xl grid-menu-3col">
                                        <div class="no-gutters row">

                                            <div class="col-sm-6 col-xl-4">
                                                <a href="{{route('invoices.add')}}?inv_type=simplified" class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                                    <i class="fas fa-file-alt btn-icon-wrapper btn-icon-lg mb-3"></i>
                                                    {{trans('menu.invoice_simplified')}}
                                                </a>
                                            </div>
                                            <div class="col-sm-6 col-xl-4">
                                                <a href="{{route('invoices.add')}}?inv_type=invoice" class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                                    <i class="fas fa-file-invoice btn-icon-wrapper btn-icon-lg mb-3"></i>
                                                    {{trans('menu.invoices')}}
                                                </a>
                                            </div>
                                            <div class="col-sm-6 col-xl-4">
                                                <a href="{{route('invoices.add')}}?inv_type=receipt" class="btn-icon-vertical btn-square btn-transition btn btn-outline-link">
                                                    <i class="fas fa-file-invoice-dollar btn-icon-wrapper btn-icon-lg mb-3"></i>
                                                    {{trans('menu.invoice_receipt')}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
        </div>
    </div>
    <script type="text/javascript" src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script>
   

$(document).ready(function() {
  $(".notification-drop .item").on('click',function() {
    $(this).find('ul').toggle();
  });
});
function hideusers()
{
    $(document).ready(function(){
  $('#showuser').hide();
});
}

function search(val){
    var APP_URL = {!! json_encode(url('/')) !!}
 if((val=="" )|| (val==" "))
 {  

    $(document).ready(function(){
  $('#showuser').hide();
});
     
 }
 else{

    $(document).ready(function(){
  $('#showuser').show();
});

    $.ajax({
            type: "get",
            url: APP_URL + "/search/"+val,
            dataType: "JSON",
            success : function(data){
            $('#showuser').fadeIn();            
            let html = '<ul class="dropdown-menu" style="overflow-y: auto; border-radius:20px; max-height:500px; margin-top:-18px; display:block; padding:15px; padding-left:12px; position:absolute; z-index:999;">';
            if( data.length > 0){
                for(var i=0; i < data.length; i++)
                {
                    html += '<li><a href="'+APP_URL + '/users/edit/'+data[i]['id']+'?xyz='+val+'">'+data[i]['id']+'&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;'+data[i]['company_name']+'</a></li>';
                }
            }else{
                html += '<li><a href="#">No results</a></li>';
            }
            
            html +='</ul>';
            $('#showuser').html(html);
            },
            error:function(err){
                //alert("error");
             }
            });
}
}

    function set_language(lng){
       $('#lng').val(lng);
       $('#lan-form').submit();
    }

</script>
@section('javascript')
<script>
@if(app('request')->input('xyz'))
$(document).ready(function(){
    jQuery('#searchbutton').click();
  });
@endif
  </script>
@endsection