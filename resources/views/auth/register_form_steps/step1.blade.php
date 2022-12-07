<div class="form-row">
    <div class="col-md-6">
        <div class="position-relative form-group">
            <label for="exampleName" class="">Company</label>
            <input name="company_name"  id="company_name" placeholder="Company Name" type="text" class="form-control" >
                <span class="help-block" id="company_name_error" style="display:none; color:red;">
                    Company Name is required
                </span>

        </div>
    </div>
    <div class="col-md-6">
        <div class="position-relative form-group">
            <label for="exampleEmail" class=""> Email</label>
                <input name="email" id="email" placeholder="Email" class="form-control">
                    <span class="help-block" id="email_error" style="display:none; color:red;">
                       Email is required
                    </span>
                    <span class="help-block" id="email_exists" style="display:none; color:red;">
                       Email already exists
                    </span>
        </div>
    </div>
    
</div>    
<div class="form-row">
    <div class="col-md-6">
        <div class="position-relative form-group">
            <label for="examplePassword" class=""> Password</label>
            <input name="password" id="password" placeholder="Password" type="password" class="form-control">
                <span class="help-block" id="password_error" style="display:none; color:red;">
                   Password is required
                </span>
        </div>
    </div>
    <div class="col-md-6">
        <div class="position-relative form-group">
            <label for="" class="">{{trans('clients.Country')}}</label>
             <select class="select2 form-control" name="country_id" id=country_id >
                <option value="" selected disabled>Select Country</option>
                @foreach($countries as $country)
                <option @if($country->id == '171') selected @endif value="{{$country->iso_code}}">{{$country->name}}</option>
                @endforeach
            </select>
            <span class="help-block" id="country_id_error" style="display:none; color:red;">
               Country is required
            </span>
         </div>
     </div>

</div>
<p>
    <input type="checkbox" name="agreed" id="agreed">
    <span id="agreed_text">I agree with the 
        <a href="#">Terms</a> and 
    <a href="#">Privacy Policy</a></span><br>
    <input type="checkbox" name="">
    <span>I want to receive news about Tax Authority, business and exclusive discounts. <a href="#">Know more.</a> GET all video tutorials from the Invoicing Free Course for Entrepreneurs.</span>
 </p>


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
 <script>

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#email").keyup(function(){
            var APP_URL = {!! json_encode(url('/')) !!};
            var token = $('meta[name="csrf-token"]').attr('content');
            var email = $('#email').val();               
            $.ajax({
                type: 'POST',
                url: APP_URL + '/checkEmail',
                data: {"email": email,"_token": "{{ csrf_token() }}",},
                success: function(data){
                   if(data != ''){
                       $("#email_exists").css("display","block");
                       $("#submit").prop('disabled', true);
                   }
                   else
                   {
                        $("#email_exists").css("display","none");
                       $("#submit").prop('disabled', false);
                   }
                } 
            });
        });

    });

 </script>