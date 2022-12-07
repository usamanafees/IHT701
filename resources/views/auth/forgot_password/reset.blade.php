<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Login - Intellidus360</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"
    />
    <meta name="description" content="Invoicing System">

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">

<!-- <link href="./main.87c0748b313a1dda75f5.css" rel="stylesheet"></head> -->
<link href="{{asset('admin/assets/style.css')}}" rel="stylesheet">
<style>
.error{
  color:red;
}
</style>

</head>


<body>
<div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
            <div class="h-100">
                <div class="h-100 no-gutters row">
                    <div class="d-none d-lg-block col-lg-4">
                        <div class="slider-light">
                            <div class="slick-slider">
                                <div>
                                    <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-plum-plate" tabindex="-1">
                                        <div class="slide-img-bg" style="background-image: url('admin/assets/images/originals/city.jpg');"></div>
                                        <div class="slider-content"><h3>Perfect Balance</h3>
                                            <p>ArchitectUI is like a dream. Some think it's too good to be true! Extensive collection of unified React Boostrap Components and Elements.</p></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-premium-dark" tabindex="-1">
                                        <div class="slide-img-bg" style="background-image: url('admin/assets/images/originals/citynights.jpg');"></div>
                                        <div class="slider-content"><h3>Scalable, Modular, Consistent</h3>
                                            <p>Easily exclude the components you don't require. Lightweight, consistent Bootstrap based styles across all elements and components</p></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-sunny-morning" tabindex="-1">
                                        <div class="slide-img-bg" style="background-image: url('admin/assets/images/originals/citydark.jpg');"></div>
                                        <div class="slider-content"><h3>Complex, but lightweight</h3>
                                            <p>We've included a lot of components that cover almost all use cases for any type of application.</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="h-100 d-flex bg-white justify-content-center align-items-center col-md-12 col-lg-8">
                        <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
                            <div class="app-logo"></div>
                            <h4 class="mb-0">
                                <span class="d-block">Welcome</span>
                                <span>Please Reset your Password</span></h4>
                            <div class="divider row"></div>
                            <div>
                                <form class="validatedForm" class="form-horizontal" method="POST" action="{{ route('custom_register.updates_password') }}">
                                     {{ csrf_field() }}
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                                <label for="password" class="">Enter Password</label>
                                                <input type="hidden" name="id" value="{{$user->id}}">
                                                <input id="password" placeholder="Enter Password" type="password" class="form-control" name="password" value="{{ old('password') }}" required autofocus>
                                                @if ($errors->has('password'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                                <label for="confirmpassword" class="">Confirm Password</label>
                                                <input id="confirmpassword" placeholder="Confirm Password" type="password" class="form-control" name="confirmpassword" value="{{ old('confirmpassword') }}" required autofocus>
                                                @if ($errors->has('confirmpassword'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('confirmpassword') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                </div>
                                <span class="help-block" id="email_exists" style="color:red;display: none;">
                                    Your password and confirmation password do not match
                                </span>
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <!-- <a href="javascript:void(0);" class="btn-lg btn btn-link">
                                                Recover Password</a> -->
                                            <button id="submit" type="submit" class="btn btn-primary btn-lg align-center">Update</button>
                                        </div>
                                    </div>
                                    <div class="divider row"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script>
        
    $(document).ready(function(){
    
        jQuery('.validatedForm').validate({
            rules : {
                password : {
                    minlength : 6
                },
                confirmpassword : {
                    minlength : 6,
                    equalTo : "#password"
                }
            }
        });

        $('#submit').click(function(){
            $("#email_exists").css("display","none").valid();
            $("#submit").attr('disabled', false).valid();
        });

    });



</script>


</body>
</html>
