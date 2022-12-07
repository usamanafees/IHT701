
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

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">

<link href="{{asset('admin/assets/style.css')}}" rel="stylesheet"></head>

<body>
<div class="app-container app-theme-white body-tabs-shadow">
        <div class="app-container">
            <div class="h-100">
                <div class="h-100 no-gutters row">
                    <div class="h-100 d-md-flex d-sm-block bg-white justify-content-center align-items-center col-md-12 col-lg-9">
                        <div class="mx-auto app-login-box col-sm-12 col-md-10 col-lg-9">
                            <div class="app-logo" style="margin-bottom: 0.8rem !important;"></div>
                             <div class="card-body" style="background-color: #6d6969;">
                                    <h2><b><font color="white">Account setup</font> </b></h2>
                                    <div style="text-align: right;">
                                    </div>
                                </div> 
                            <div class="main-card mb-3 card">
                                <div class="card-body">
                                <form class="form-horizontal" method="POST" 
                                    action="{{ route('custom_register.update', $user->id) }}">
                                    {{ csrf_field() }}
                                               
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="exampleName" class="">Company:<font color="red"><b>*</b></font></label>
                                            <input name="company_name"  id="company_name" placeholder="Company Name" type="text" class="form-control" value="{{$user->company_name}}" required>
                                                

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="exampleEmail" class=""> Taxpayer:<font color="red"><b>*</b></font></label>
                                             <input name="taxpayer" id="taxpayer" placeholder="Tax Payer" class="form-control" required>
                                                    
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="exampleName" class="">Name:<font color="red"><b>*</b></font></label>
                                            <input name="name"  id="name" placeholder="Company Name" type="text" class="form-control"  value="{{$user->name}}" required>
                                                

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="exampleEmail" class=""> Moile:</label>
                                                <input name="phone_no" id="Mobile" placeholder="Mobile" class="form-control" value="{{$user->phone_no}}">
                                                   
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="exampleName" class="">City:<font color="red"><b>*</b></font></label>
                                            <input name="city"  id="city" placeholder="City" type="text" class="form-control" required>
                                               

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="exampleEmail" class=""> Postal Code:<font color="red"><b>*</b></font></label>
                                                <input name="postal_code" id="postal_code" placeholder="Postal code" class="form-control" required>
                                                  
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label for="exampleName" class="">Address:<font color="red"><b>*</b></font></label>
                                          
                                           <textarea name="address" class="form-control" required></textarea>
                                               

                                        </div>
                                    </div>
                                
                                    <div class="col-md-12">
                                        <button type="submit" class="btn-shadow btn-wide float-right btn-pill btn-hover-shine btn btn-success check_user_info">Save and Move</button>
                                    </div>
                                </div> 

                                </form>    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-lg-flex d-xs-none col-lg-3">
                        <div class="slider-light">
                            <div class="slick-slider slick-initialized">
                                <div>
                                    <div class="position-relative h-100 d-flex justify-content-center align-items-center bg-premium-dark" tabindex="-1">
                                        <div class="sideimg slide-img-bg" style="background-image: url('https://i.pinimg.com/originals/94/e1/d0/94e1d0b610326388140c620591f212ce.jpg');"></div>
                                        <div class="slider-content"><h3>Welcome</h3>
                                          
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
    var APP_URL = {!! json_encode(url('/')) !!}
    $('.sideimg').css('background-image',APP_URL+'/admin/assets/images/originals/citynights.jpg'); 
    // console.log(APP_URL);
</script>
</body>
</html>
