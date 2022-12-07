
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Register - Intellidus360</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"
    />
    <meta name="description" content="Invoicing System">

    <meta name="msapplication-tap-highlight" content="no">

    <link href="{{asset('admin/assets/style.css')}}" rel="stylesheet">

    <style type="text/css">
         @media (min-width: 320px) and (max-width: 768px) {
          .d-lg-flex{
            display: none;
          }
          
        }
        @media (min-width: 768px) and (max-width: 1024px) and (orientation: landscape) {
  
          .d-lg-flex{
            display: none;
          }
          
        }
        @media (min-width: 768px) and (max-width: 1024px) and (orientation: portrait) {
  
          .d-lg-flex{
            display: none;
          }
          
        }
    </style>
</head>
    
<body>
<div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
            <div class="h-100">
                <div class="h-100 no-gutters row">
                    <div class="h-100 d-md-flex d-sm-block bg-white justify-content-center align-items-center col-md-12 col-lg-7">
                        <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
                            <div class="app-logo" style="margin-bottom: 0.8rem !important;"></div>
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                    <form class="form-horizontal" 
                                              method="POST" 
                                              action="{{ route('custom_register.register') }}">
                                                 {{ csrf_field() }}
                                            <div id="smartwizard">
                                                <ul class="forms-wizard">
                                                    <li class="step_1_li">
                                                        <a href="#step-form" >
                                                            <em>1</em><span>Account Information</span>
                                                        </a>
                                                    </li>
                                                    <li class="step_2_li">
                                                        <a href="#step-2" >
                                                            <em>2</em><span>Contact Information</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                
                                                <div class="form-wizard-content">
                                                    <div id="step-form" class="step-1">
                                                       @include('auth.register_form_steps.step1')
                                                    </div>
                                                    <div id="step-2" class="step-2">
                                                       @include('auth.register_form_steps.step2')
                                                    </div>
                                                </div>

                                            </div>

                                                <div class="divider"></div>
                                                <div class="clearfix">
                                                    <!-- id="next-btn" -->
                                                     <button type="button" class="btn-shadow btn-wide float-right btn-pill btn-hover-shine btn btn-success check_user_info" id="submit">Save and Continue</button>

                                                     <p>Already Have Account! <a href="{{route('login')}}">Please Login</a></p>

                                                </div>
                                    </form>    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-lg-flex d-xs-none col-lg-5">
                        <div class="slider-light">
                            <div class="slick-slider slick-initialized">
                                <div>
                                    <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-premium-dark" tabindex="-1">
                                        <div class="slide-img-bg" style="background-image: url('admin/assets/images/originals/citynights.jpg');"></div>
                                        <div class="slider-content"><h3>Welcome</h3>
                                            <p>It only takes a <span class="text-success">few seconds</span> to create your account
                                            </p>
                                            <h3>Discover the Simple Side of Billing</h3>
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
<script type="text/javascript" src="{{asset('admin/assets/scripts/main.87c0748b313a1dda75f5.js')}}"></script>

<script type="text/javascript">
    $('.check_user_info').on('click',function(){
        var company_name = $('#company_name').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var country_id = $('#country_id').children("option:selected").val();
        var phone_no = $('#phone_no').val();
        var name = $('#name').val();

        if( company_name != ''  && email != ''  && password != ''  && country_id != ''  && phone_no != ''  && name != '' ){
            $('.check_user_info').attr('type','submit');
        }
        if(company_name == ''  || email == ''  || password == ''  || country_id == ''){
            if(company_name == ''){
                $('#company_name_error').css('display','block');
            }else{
                $('#company_name_error').css('display','none');
            }
            if(email == ''){
                $('#email_error').css('display','block');
            }else{
                $('#email_error').css('display','none');
            }
            if(password == ''){
                $('#password_error').css('display','block');
            }else{
                $('#password_error').css('display','none');
            }
            if(country_id == ''){
                $('#country_id_error').css('display','block');
            }   else{
                $('#country_id_error').css('display','none');
            }
        }
        if($('#agreed').prop("checked") == false){
                $('#agreed_text').css('color','red');
            }else{
                $('#agreed_text').css('color','black');
        }


        if(company_name != ''  && email != ''  
            && password != ''  && country_id != '' 
            && $('#agreed').prop("checked") == true){

            $('.step-1').css('display','none');
            $('.step_1_li').addClass('nav-item done');
            
            $('.step-2').css('display','block');
            $('.step_2_li').addClass('nav-item active');
            $('.form-wizard-content').css('min-height','');

        }

        if(phone_no == ''){
                $('#phone_error').css('display','block');
            }else{
                $('#phone_error').css('display','none');
        }

        if(name == ''){
                $('#name_error').css('display','block');
            }else{
                $('#name_error').css('display','none');
        }

    });
</script>

</body>
</html>
