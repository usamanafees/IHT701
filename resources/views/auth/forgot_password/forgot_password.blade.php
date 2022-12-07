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
<link href="{{asset('admin/assets/style.css')}}" rel="stylesheet"></head>


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
                                <span>sign in to your account.</span></h4>
                            <h6 class="mt-3"><a href="{{route('/')}}" class="text-primary">Sign In</a></h6>
                            <div class="divider row"></div>
                            <div>
                                <form class="form-horizontal" method="POST" action="{{ route('varify') }}">
                                     {{ csrf_field() }}
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                <label for="exampleEmail" class="">Enter your Registered Email</label>
                                                <input id="exampleEmail" placeholder="Email here..." type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                                                @if ($errors->has('email'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                    <span class="help-block" id="email_exists" style="color:red;">
                                    </span>
                                </div><br>
                                    <div class="d-flex align-items-center">
                                        <div class="">
                                            <!-- <a href="javascript:void(0);" class="btn-lg btn btn-link">
                                                Recover Password</a> -->
                                            <button id="submit" type="submit" class="btn btn-primary btn-lg align-center">Submit</button>
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

<script type="text/javascript" src="{{asset('admin/assets/scripts/main.87c0748b313a1dda75f5.js')}}"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
 <script>

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#exampleEmail").keyup(function(){
            var APP_URL = {!! json_encode(url('/')) !!};
            var token = $('meta[name="csrf-token"]').attr('content');
            var email = $('#exampleEmail').val();               
            $.ajax({
                type: 'POST',
                url: APP_URL + '/verifyEmail',
                data: {"email": email,"_token": "{{ csrf_token() }}",},
                success: function(data){
                   if(data != 'done'){
                       $("#email_exists").css("display","block");
                       $("#email_exists").text(data);
                       $("#submit").attr('disabled', true);
                   } 
                   else
                   {
                        $("#email_exists").css("display","none");
                        $("#submit").attr('disabled', false);
                   }
                } 
            });
        });

    });

 </script>
</body>
</html>
