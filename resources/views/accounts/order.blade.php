
<html lang="en" style="overflow-x: hidden;">

<head>

  <title>Order Placements</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style type="text/css">
          body {
              margin: 0 !important;
              font-family: "Oxygen-Regular",Helvetica,Arial,sans-serif !important;
              font-size: 13px !important;
              line-height: 20px !important;
              color: #4f4f4f !important;
              background: #ddd !important;
              -webkit-font-smoothing: antialiased !important;
          }
          .form-control{
            width: 90% !important;
          }
          .receipt-content .logo a:hover {
            text-decoration: none;
            color: #7793C4; 
          }

          .receipt-content .invoice-wrapper {
            background: #FFF;
            border: 1px solid #CDD3E2;
            box-shadow: 0px 0px 1px #CCC;
            padding: 40px 40px 60px;
            margin-top: 40px;
            border-radius: 4px; 
          }

          .receipt-content .invoice-wrapper .payment-details span {
            color: #A9B0BB;
            display: block; 
          }
          .receipt-content .invoice-wrapper .payment-details a {
            display: inline-block;
            margin-top: 5px; 
          }

          .receipt-content .invoice-wrapper .line-items .print a {
            display: inline-block;
            border: 1px solid #9CB5D6;
            padding: 13px 13px;
            border-radius: 5px;
            color: #708DC0;
            font-size: 13px;
            -webkit-transition: all 0.2s linear;
            -moz-transition: all 0.2s linear;
            -ms-transition: all 0.2s linear;
            -o-transition: all 0.2s linear;
            transition: all 0.2s linear; 
          }

          .receipt-content .invoice-wrapper .line-items .print a:hover {
            text-decoration: none;
            border-color: #333;
            color: #333; 
          }
          @media (min-width: 1200px) {
            .receipt-content .container {width: 900px; } 
          }

          .receipt-content .logo {
            text-align: center;
            margin-top: 50px; 
          }

          .receipt-content .logo a {
            font-family: Myriad Pro, Lato, Helvetica Neue, Arial;
            font-size: 36px;
            letter-spacing: .1px;
            color: #555;
            font-weight: 300;
            -webkit-transition: all 0.2s linear;
            -moz-transition: all 0.2s linear;
            -ms-transition: all 0.2s linear;
            -o-transition: all 0.2s linear;
            transition: all 0.2s linear; 
          }

          .receipt-content .invoice-wrapper .intro {
            line-height: 25px;
            color: #444; 
          }

          .receipt-content .invoice-wrapper .payment-info {
            margin-top: 25px;
            padding-top: 15px; 
          }

          .receipt-content .invoice-wrapper .payment-info span {
            color: #A9B0BB; 
          }

          .receipt-content .invoice-wrapper .payment-info strong {
            display: block;
            color: #444;
            margin-top: 3px; 
          }

          @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .payment-info .text-right {
            text-align: left;
            margin-top: 20px; } 
          }
          .receipt-content .invoice-wrapper .payment-details {
            border-top: 2px solid #EBECEE;
            margin-top: 30px;
            padding-top: 20px;
            line-height: 22px; 
          }


          @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .payment-details .text-right {
            text-align: left;
            margin-top: 20px; } 
          }
          .receipt-content .invoice-wrapper .line-items {
            margin-top: 40px; 
          }
          .receipt-content .invoice-wrapper .line-items .headers {
            color: #A9B0BB;
            font-size: 13px;
            letter-spacing: .3px;
            border-bottom: 2px solid #EBECEE;
            padding-bottom: 4px; 
          }
          .receipt-content .invoice-wrapper .line-items .items {
            margin-top: 8px;
            border-bottom: 2px solid #EBECEE;
            padding-bottom: 8px; 
          }
          .receipt-content .invoice-wrapper .line-items .items .item {
            padding: 10px 0;
            color: #696969;
            font-size: 15px; 
          }
          @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .line-items .items .item {
            font-size: 13px; } 
          }
          .receipt-content .invoice-wrapper .line-items .items .item .amount {
            letter-spacing: 0.1px;
            color: #84868A;
            font-size: 16px;
           }
          @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .line-items .items .item .amount {
            font-size: 13px; } 
          }

          .receipt-content .invoice-wrapper .line-items .total {
            margin-top: 30px; 
          }

          .receipt-content .invoice-wrapper .line-items .total .extra-notes {
            float: left;
            width: 40%;
            text-align: left;
            font-size: 13px;
            color: #7A7A7A;
            line-height: 20px; 
          }

          @media (max-width: 767px) {
            .receipt-content .invoice-wrapper .line-items .total .extra-notes {
            width: 100%;
            margin-bottom: 30px;
            float: none; } 
          }

          .receipt-content .invoice-wrapper .line-items .total .extra-notes strong {
            display: block;
            margin-bottom: 5px;
            color: #454545; 
          }

          .receipt-content .invoice-wrapper .line-items .total .field {
            margin-bottom: 7px;
            font-size: 14px;
            color: #555; 
          }

          .receipt-content .invoice-wrapper .line-items .total .field.grand-total {
            margin-top: 10px;
            font-size: 16px;
            font-weight: 500; 
          }

          .receipt-content .invoice-wrapper .line-items .total .field.grand-total span {
            color: #20A720;
            font-size: 16px; 
          }

          .receipt-content .invoice-wrapper .line-items .total .field span {
            display: inline-block;
            margin-left: 20px;
            min-width: 85px;
            color: #84868A;
            font-size: 15px; 
          }

          .receipt-content .invoice-wrapper .line-items .print {
            margin-top: 50px;
            text-align: center; 
          }



          .receipt-content .invoice-wrapper .line-items .print a i {
            margin-right: 3px;
            font-size: 14px; 
          }

          .receipt-content .footer {
            margin-top: 40px;
            margin-bottom: 110px;
            text-align: center;
            font-size: 12px;
            color: #969CAD; 
          }           
          h2.title {
              margin: 0 0 20px 0;
              color: #303030;
              font-size: 30px;
              font-family: "Oxygen-Regular",Helvetica,Arial,sans-serif;
              font-weight: normal;
          }  
          h3.subtitlePlan {
              margin: -10px 0 30px 0;
              font-size: 15px;
              font-family: "Oxygen-Bold",Helvetica,Arial,sans-serif;
              font-weight: normal;
          }       
          h3.subtitlePlan span.plan {
              margin-left: 3px;
              color: #00bb80;
              font-size: 20px;
          }
          h3.subtitlePlan span.plan span.price {
              font-family: "Oxygen-Regular",Helvetica,Arial,sans-serif;
              font-weight: normal;
              color: #999;
              font-size: 13px;
          }
          ul.totalBox {
              list-style: none;
              float: left;
              margin: 0;
              width: 40%;
              text-align: center;
          }
          ul.totalBox li.spacing {
                letter-spacing: 2px;
                text-transform: uppercase;
                color: #999;
            }
            li.amount {
                font-family: "Oxygen-Bold",Helvetica,Arial,sans-serif;
                color: #4f4f4f;
                font-size: 20px;
                margin: 0 0 8px 0;
            }
            li.taxIncluded {
                color: #999;
            }
  </style>
</head>

<body style="background-color: #d6cfcf;">
    <br>
    <div class="row">
      <div class="col-md-12" style="text-align: center;">
        <img src="{{asset('admin/logo.png')}}" title="Intellidus360">
      </div>
    </div>          
    <div class="receipt-content">
      <div class="container bootstrap snippet">
        <div class="row">
          <div class="col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
            <div class="invoice-wrapper">
              <h2 class="title">Payment</h2>
              <h3 class="subtitlePlan">Plan: <span class="plan">

                @if($user->AccountSettings->duration == 'M')
                  M
                @elseif($user->AccountSettings->duration == '6M')
                  6M
                @elseif($user->AccountSettings->duration == '12M')
                  12M
                @endif

               <span class="price">(24.00€ / month)</span></span></h3>

              <div class="row">
                <div class="col-md-6">
                  <input class="months" data-payment-type="paypal" id="payment_type_paypal" name="payment_type" type="radio" value="paypal" checked>
                  <label class="" for="payment_type_paypal">
                    <span>24.00€/month <span>
                      - @if($user->AccountSettings->duration == 'M')
                          M
                        @elseif($user->AccountSettings->duration == '6M')
                          6M
                        @elseif($user->AccountSettings->duration == '12M')
                          12M
                        @endif
                    </span> 
                      <span class="disabledNotice"></span>
                    </span>
                  </label>
                  <br><br>
                  <br><br>
                  <div class="col-md-12" style="text-align: left;">
                      <img src="{{asset('admin/Paypal_new.png')}}" style="width: 18%;">
                  </div>
                </div>
                <div class="col-md-6" style="background-color: #f4f4f4;border-left: 2px solid darkgray;">
                      <div class="row">
                        <div class="col-md-6">
                        <p></p>
                          <p><font style="text-align: left;">Plan:</font>
                              <font style="float: right;">
                                    {{$user->AccountSettings->amount}}
                              €</font>
                            </p>
                          <p><font style="text-align: left;">Discount:</font>
                              <font style="float: right;">0.00€</font>
                            </p>
                          <p><font style="text-align: left;">Before Taxes:</font>
                              <font style="float: right;">
                                    {{$user->AccountSettings->amount}}
                              €</font>
                            </p>
                          <p><font style="text-align: left;">Tax:</font>
                              <font style="float: right;">0.00€</font>
                            </p>
                        </div>
                        <div class="col-md-6" style="border-left: 1px solid darkgrey;">
                        <p></p>

                          <ul class="totalBox">
                            <li class="spacing">To Pay</li>
                            <li class="amount">
                                  {{$user->AccountSettings->amount}}
                            €</li>
                            <li class="taxIncluded">(VAT included)</li>
                          </ul>
                        </div>
                      </div>
                </div>
              </div>

              <br><br><br><br>

              <div class="row">
                <div class="col-md-12" style="background-color: #ddd;">
                  <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h2>{{trans('accounts.Billing_data')}}</h2>
                        </div>
                        <div class="card-body">
                          <p>
                           This billing data will be used to issue the invoices for your payments. Don't forget to complete your information in 
                           <a href="{{ url('accounts/'.Auth::user()->id.'/billing_data/')}}">
                            Settings > Company Information.</a>
                          </p>
                            <form class="form-horizontal" method="POST" action="{{ route('billing.store') }}">
                                      {{ csrf_field() }}
                                  <br>
                                 <br>
                                  <div class="form-row" style="line-height: 0.5rem;">
                                      <div class="col-md-6">
                                          <div class="position-relative form-group">
                                              <label for="exampleName" class=""><b>Organization:</b>
                                              </label>
                                              <input name="company_name"  id="company_name" placeholder="Company Name" type="text" class="form-control" value="{{$user->company_name}}" disabled>
                                          </div>
                                      </div>
                                    <div class="col-md-6">
                                          <div class="position-relative form-group">
                                              <label for="exampleEmail" class=""><b>Postal Code:</b></label>
                                                  <input name="postal_code" id="postal_code" placeholder="Postal code" class="form-control" value="{{$user->Subsidiaries->postal_code}}" disabled>
                                                   
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-row" style="line-height: 0.5rem;">
                                      <div class="col-md-6">
                                          <div class="position-relative form-group">
                                              <label for="exampleName" class=""><b>City:</b></label>
                                              <input name="city"  id="city" placeholder="City" type="text" class="form-control" value="{{$user->Subsidiaries->city}}" disabled>
                                                 

                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="position-relative form-group">
                                              <label for="exampleName" class=""><b>Email:</b></label>
                                              <input name="email"  id="email" placeholder="email" type="text" class="form-control"  value="{{$user->email}}" disabled>
                                              @if ($errors->has('email'))
                                                     <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif 
                                          </div>
                                      </div>
                                      <!--  -->
                                  </div>
                                  <div class="form-row" style="line-height: 0.5rem;">
                                      <div class="col-md-6">
                                          <div class="position-relative form-group">
                                              <label for="exampleEmail" class=""><b>VAT Number:</b></label>
                                                  <input name="vat_number" id="VAT Number" placeholder="VAT Number" class="form-control" value="{{$user->Subsidiaries->vat_number}}" disabled>
                                                     
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="position-relative form-group">
                                              <label for="exampleEmail" class=""><b>Country:</b></label>
                                                  <select class="select2 form-control" name="country_id" id=country_id  disabled>
                                                      <option value="" selected disabled>Select Country</option>
                                                      @foreach($countries as $country)
                                                        <option @if($user->country_id == $country->iso_code) selected @endif value="{{$country->iso_code}}">{{$country->name}}</option>
                                                      @endforeach
                                                  </select>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="form-row" style="line-height: 0.5rem;">
                                      
                                      <div class="col-md-12">
                                          <div class="position-relative form-group">
                                              <label for="exampleName" class=""><b>Address:</b></label>
                                             <textarea name="address" class="form-control" disabled>   
                                                  {{$user->Subsidiaries->address}}
                                             </textarea>
                                          </div>
                                      </div>
                                  </div>
                                  <div style="text-align: right;">
                                    <button type="submit" class="mt-2 btn btn-primary" disabled>{{trans('users.Save')}}</button>
                                  </div>
                            </form>
                        </div>
                  </div>
                </div>
              </div>
              <br>
              <div class="row" style="text-align: right;">
                <a href="{{ route('paypal_order',$user->AccountSettings->payment_code) }}" class="btn" style="background: #f93;color: white;box-shadow: 0 3px #eb7500;">Payment through paypal</a>
                <a  href="{{ route('account.balance') }}"
                class="btn" 
                style="border: 1px solid #bfbfbf;background: white;color: #666;box-shadow: 0 3px #bfbfbf;">Cancel</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>                    

<script type="text/javascript">
$('textarea').each(function(){
    $(this).val($(this).val().trim());
    }
);
</script>

</body>
</html>
