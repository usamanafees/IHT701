<!DOCTYPE html>
<html lang="en">
<head>
  <title>Payment Plans</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style type="text/css">
    body{
      font-family: "Oxygen-Regular",Helvetica,Arial,sans-serif !important;

      color: #4f4f4f;
    }
    .nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
        color: #fff;
        background-color: #adadad !important;
        /* background-color: #337ab7; */
    }
    ul >  li >  a {
         border-radius: 5% !important; 
         border: 0 !important; 
         padding: 10px 30px !important; 
         background-color: #fff !important; 
        color: #adadad ; 
    }
  
     h3.subtitle {
        margin: 0px 0 20px 0;
        /*color: #00bb80;*/
        font-size: 16px;
        /*font-family: "Oxygen-Regular",Helvetica,Arial,sans-serif;*/
        font-weight: normal;
        line-height: 22px;
    }
    .comparison {
        /*max-width: 90%;*/
        margin:0 auto;
        font:13px/1.4 "Oxygen-Regular",Helvetica,Arial,sans-serif !important;
        text-align:center;
        padding:10px;
      }

      .comparison table {
        width:100%;
        border-collapse: collapse;
        border-spacing: 0;
        table-layout: fixed;
        border-bottom:1px solid #CCC;
      }

      .comparison td, .comparison th {
        border-right:1px solid #CCC;
        empty-cells: show;
        padding:10px;
      }

      .compare-heading {
        font-size:18px;
        font-weight:bold !important;
        border-bottom:0 !important;
        padding-top:10px !important;
      }

      .comparison tbody tr:nth-child(odd) {
        display:none;
      }

      .comparison .compare-row {
        /*background:#F5F5F5;*/
      }

      .comparison .tickblue {
        color:#0078C1;
      }

      .comparison .tickgreen {
        color:#009E2C;
      }

      .comparison .tickgrey {
        color:lightgrey;
      }

                  


      .comparison th {
        font-weight:normal;
        text-align: center;
        /*padding:0;*/
        /*border-bottom:1px solid #CCC;*/
      }

      .comparison tr td:first-child {
        text-align:left;
      }
        
      .comparison .qbse, .comparison .qbo, .comparison .tl {
        color:#FFF;
        padding:10px;
        font-size:13px;
        border-right:1px solid #CCC;
        border-bottom:0;
      }

      .comparison .tl2 {
        border-right:0;
      }

      .comparison .qbse {
        background:#0078C1;
        border-top-left-radius: 3px;
        border-left:0px;
      }

      .comparison .qbo {
        background:#009E2C;
        border-top-right-radius: 3px;
        border-right:0px;
      }

      .comparison .price-info {
        padding:5px 15px 15px 15px;
      }

      .comparison .price-was {
        color:#999;
        text-decoration: line-through;
      }

      .comparison .price-now, .comparison .price-now span {
        color:#ff5406;
      }

      .comparison .price-now span {
        font-size:32px;
      }

      .comparison .price-small {
          font-size: 18px !important;
          position: relative;
          top: -11px;
          left: 2px;
      }

      .comparison .price-buy {
        background:#ff5406;
        padding:10px 20px;
        font-size:12px;
        display:inline-block;
        color:#FFF;
        text-decoration:none;
        border-radius:3px;
        text-transform:uppercase;
        margin:5px 0 10px 0;
      }

      .comparison .price-try {
        font-size:12px;
      }

      .comparison .price-try a {
        color:#202020;
      }
      .table>tbody>tr>td{
        border-left: 1px solid #ddd;
      }

      @media (max-width: 767px) {
        .comparison td:first-child, .comparison th:first-child {
          display: none;
        }
        .comparison tbody tr:nth-child(odd) {
          display:table-row;
          background:#F7F7F7;
        }
        .comparison .row {
          background:#FFF;
        }
        .comparison td, .comparison th {
          border:1px solid #CCC;
        }
        .price-info {
        border-top:0 !important;
        
      }
        
      }

      @media (max-width: 639px) {
          .comparison .price-buy {
            padding:5px 10px;
          }
          .comparison td, .comparison th {
            padding:10px 5px;
          }
          .comparison .hide-mobile {
            display:none;
          }
          .comparison .price-now span {
          font-size:16px;
        }

        .comparison .price-small {
            font-size: 16px !important;
            top: 0;
            left: 0;
        }
        .comparison .qbse, .comparison .qbo {
            font-size:12px;
            padding:10px 5px;
        }
        .comparison .price-buy {
            margin-top:10px;
        }
        .compare-heading {
          font-size:13px;
        }
      }
      .newPlansPaymentMethod img {
          max-height: 26px;
          margin-left: 10px;
      }
      td.morePopularColumn {
          background-color: #fb9600 ;
          color: #fff ;
          text-transform: uppercase ;
          font-weight: bold ;
          padding: 5px 15px !important;
      }
      .green_btn{
        color: white !important;
        background: #00bb80 !important;
        padding: 11px 30px 9px 30px !important;
        outline: 0 !important;
          }
      .xl_plan {
          width: 100%;
          background-color: #1b344d;
          border-radius: 6px;
          color: #fff;
          text-align: center;
          font-size: 18px;
          font-weight: normal;
          padding: 20px;
          margin-top: 30px;
          margin-bottom: 60px;
      }
  </style>
</head>
<body style="background-color: #f5f5f5;">

<div class="container">
  <br>
  <br>
  <br>
  <div class="row">
    <div class="col-md-12" style="text-align: center;">
      <img src="{{asset('admin/logo.png')}}" title="Intellidus360">
    </div>
  </div>
  <div class="row">
    <div class="col-md-12" style="text-align: center;">
      <h1>
        New Plans to Speed up your Invoicing
      </h1>
      <h3 class="subtitle">Start by selecting the <strong>subscription period</strong> and choose the plan that fits your business the best.</h3>
    </div>
  </div>

    <br>
    <br>
    <div class="row">
      <div class="col-md-4"></div>
        <div class="col-md-8">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item active">
              <a class=" active" id="pills-3M-tab" data-toggle="pill" href="#pills-3M" role="tab" aria-controls="pills-3M" aria-selected="false">Monthly</a>
            </li>
            <li class="nav-item">
              <a class="" id="pills-6M-tab" data-toggle="pill" href="#pills-6M" role="tab" aria-controls="pills-6M" aria-selected="false">6 Months</a>
            </li>
            <li class="nav-item">
              <a class="" id="pills-12M-tab" data-toggle="pill" href="#pills-12M" role="tab" aria-controls="pills-12M" aria-selected="false">12 Months</a>
            </li>
          </ul>
        </div>
    </div>
    <br>
    <div class="row">
      <div class="col-md-12" style="text-align: center;">
           <div class="newPlansPaymentMethod">
          <span>Payment:</span> <img src="{{asset('admin/Paypal_new.png')}}">
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="tab-content" id="pills-tabContent" style="text-align: center;">

        <div class="tab-pane fade active in" id="pills-3M" role="tabpanel" aria-labelledby="pills-3M-tab">
            <div class="comparison">
              <table class="table" style="width:100% !important; ">
                <thead>
                  <tr>
                    <th style="border-color: transparent;width : 20%; "></th>
                    <th style="border-color: transparent;width : 20%; "></th>
                    <th style="border-color: transparent;width : 20%;"></th>
                     <th class="qbse" style="text-align: center;font-weight: 700;background-color: #fb9600;width : 20%">
                      MORE POPULAR
                    </th>
                    <th style="border-color: transparent;width : 20%; "></th>
                  </tr>
                  <tr style="background-color: white;">
                    <th class="tl" width="30%" ></th>
                    <th class="compare-heading" width="17.5%" style="background-color: #adadad !important;">
                    </th>
                    <th class="compare-heading" width="17.5%" style="background-color: #0d4373;">
                      <h2 style="color: white; font-size: 40px;"><b>S</b></h2>
                    </th>
                    <th class="compare-heading" width="17.5%" style="background-color: #0d4373;">
                      <h2 style="color: white; font-size: 40px;"><b>M</b></h2>
                    </th>
                   <th class="compare-heading" width="17.5%" style="background-color: #0d4373;">
                      <h2 style="color: white; font-size: 40px;"><b>L</b></h2>
                    </th>
                  </tr>
                  <tr style="background-color: white;">
                    <th>
                      <p>
                        <b>If you need help,<br>
                        <a style="color: #00bb80;" href="#">contact us.</a></b><br>
                        Rui Ferreira  <font color = "#00bb80">•</font> InvoiceXpress Team
                      </p>
                    </th>
                    <th class="price-info" style="background-color: #adadad !important;">
                      <h2>XS</h2>
                      <p>
                        Only available for yearly subscription
                      </p>
                    </th>
                    <th class="price-info">
                      <div class="price-now" style="font-weight: 600;">
                        <span style="color: #4f4f4f !important;">12
                          <span class="price-small" style="color: #4f4f4f !important;">€</span>
                        </span> <font color="#4f4f4f">/month</font>
                      </div>

                      <div>
                        <a href="{{route('payment.plan','Monthly-12-Small')}}" class="price-buy green_btn" >Choose 
                        </a>
                      </div>
                    </th>
                   <th class="price-info" style="background-color: #1b344d;">
                      <div class="price-now" style="font-weight: 600;">
                        <span style="color: white !important;">24
                          <span class="price-small" style="color: white !important;">€</span>
                        </span> <font color="white">/month</font>
                      </div>

                      <div>
                        <a href="{{route('payment.plan','Monthly-24-Medium')}}" class="price-buy green_btn" >Choose 
                        </a>
                      </div>
                    </th>
                    <th class="price-info">
                      <div class="price-now" style="font-weight: 600;">
                        <span style="color: #4f4f4f !important;">39
                          <span class="price-small" style="color: #4f4f4f !important;">€</span>
                        </span> <font color="#4f4f4f">/month</font>
                      </div>

                      <div>
                        <a href="{{route('payment.plan','Monthly-39-Large')}}" class="price-buy green_btn" >Choose 
                        </a>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody style="background-color: white;">
                  <tr>
                    <td></td>
                    <td colspan="4"><b>Documents</b> (monthly)<br><b>Users</b></td>
                  </tr>
                  <tr class="compare-row">
                    <td><b>Documents</b> (monthly)<br><b>Users</b></td>
                    <td style=""><span  style="color: black">
                      5 documents<br>1 user
                    </span></td>
                    <td style="">
                      <span  style="color: black">
                        20 documents<br>2 user
                      </span>
                    </td>
                     <td style="background-color: #1b344d">
                       <span  class="tickgrey">
                         500 documents<br>5 user
                       </span>
                     </td>
                    <td style="">
                      <span  style="color: black">
                        1500 documents<br>10 user
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="4">Lifetime and Free Updates </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Lifetime and Free Updates </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Communication with the AT </td>
                  </tr>
                  <tr>
                    <td>Communication with the AT</td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Technical Support </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Technical Support </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Send Documents by Email </td>
                  </tr>
                  <tr class="">
                    <td>Send Documents by Email </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Import Contacts / Items </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Import Contacts / Items </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Data Export in CSV, XLS or XML  </td>
                  </tr>
                  <tr class="">
                    <td>Data Export in CSV, XLS or XML  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Exporting the SAF-T PT file </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Exporting the SAF-T PT file </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">API Access for Integration  </td>
                  </tr>
                  <tr class="">
                    <td>API Access for Integration  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Application in Portuguese, English and Spanish  </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Application in Portuguese, English and Spanish  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Access to Mobile Version  </td>
                  </tr>
                  <tr class="">
                    <td>Access to Mobile Version  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Advanced Search </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Advanced Search  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Online Checking Account </td>
                  </tr>
                  <tr class="">
                    <td>Online Checking Account </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Custom Parameters per Client  </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Custom Parameters per Client  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Electronic Billing (digital signature)  </td>
                  </tr>
                  <tr class="">
                    <td>Electronic Billing (digital signature)  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Your Logo in Documents   </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Your Logo in Documents   </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Invoicing Scheduling   </td>
                  </tr>
                  <tr class="">
                    <td>Invoicing Scheduling  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Invoice with multiple brands  </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Invoice with multiple brands  </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Schedule Sending of SAF-T to Accountant </td>
                  </tr>
                  <tr class="">
                    <td>Schedule Sending of SAF-T to Accountant </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Multi-currency  </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Multi-currency  </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Invoices and Budgets with MB Ref. </td>
                  </tr>
                  <tr class="">
                    <td>Invoices and Budgets with MB Ref. </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Automatic Billing Alerts (Email / SMS)  </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Automatic Billing Alerts (Email / SMS)  </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Purchase Orders </td>
                  </tr>
                  <tr class="">
                    <td>Purchase Orders </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Billing reports </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Billing reports  </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                </tbody>
                <tfoot style="color: #4f4f4f;">
                  <tr style="background-color: white;">
                    <th>
                      <h4>YEARLY TOTAL</h4>
                      <p>
                        To the values presented VAT will be added at the applicable rate.
                      </p>
                    </th>
                    <th class="price-info">
                        <h2>---</h2>
                        <a href="#" class="price-buy green_btn" >Unavailable 
                        </a>
                    </th>
                    <th class="price-info">
                      <h2>144 €</h2>
                        <a href="{{route('payment.plan','Monthly-144-Small-Yearly')}}" class="price-buy green_btn" >Choose 
                        </a>
                    </th>
                   <th class="price-info" >
                     <h2>288 €</h2>
                        <a href="{{route('payment.plan','Monthly-288-Medium-Yearly')}}" class="price-buy green_btn" >Choose 
                        </a>
                    </th>
                    <th class="price-info">
                      <h2>468 € </h2>
                        <a href="{{route('payment.plan','Monthly-468-Large-Yearly')}}" class="price-buy green_btn" >Choose 
                        </a>
                    </th>
                  </tr>
                </tfoot>
              </table>
            </div>
        </div>
        <div class="tab-pane fade" id="pills-6M" role="tabpanel" aria-labelledby="pills-6M-tab">
            <div class="comparison">
              <table class="table" style="width:100% !important; ">
                <thead>
                  <tr>
                    <th style="border-color: transparent;width : 20%; "></th>
                    <th style="border-color: transparent;width : 20%; "></th>
                    <th style="border-color: transparent;width : 20%;"></th>
                     <th class="qbse" style="text-align: center;font-weight: 700;background-color: #fb9600;width : 20%">
                      MORE POPULAR
                    </th>
                    <th style="border-color: transparent;width : 20%; "></th>
                  </tr>
                  <tr style="background-color: white;">
                    <th class="tl" width="30%" ></th>
                    <th class="compare-heading" width="17.5%" style="background-color: #adadad !important;">
                    </th>
                    <th class="compare-heading" width="17.5%" style="background-color: #0d4373;">
                      <h2 style="color: white; font-size: 40px;"><b>S</b></h2>
                    </th>
                    <th class="compare-heading" width="17.5%" style="background-color: #0d4373;">
                      <h2 style="color: white; font-size: 40px;"><b>M</b></h2>
                    </th>
                   <th class="compare-heading" width="17.5%" style="background-color: #0d4373;">
                      <h2 style="color: white; font-size: 40px;"><b>L</b></h2>
                    </th>
                  </tr>
                  <tr style="background-color: white;">
                    <th>
                      <p>
                        <b>If you need help,<br>
                        <a style="color: #00bb80;" href="#">contact us.</a></b><br>
                        Rui Ferreira  <font color = "#00bb80">•</font> InvoiceXpress Team
                      </p>
                    </th>
                    <th class="price-info" style="background-color: #adadad !important;">
                      <h2>XS</h2>
                      <p>
                        Only available for yearly subscription
                      </p>
                    </th>
                    <th class="price-info">
                      <div class="price-now" style="font-weight: 600;">
                        <span style="color: #4f4f4f !important;">12
                          <span class="price-small" style="color: #4f4f4f !important;">€</span>
                        </span> <font color="#4f4f4f">/month</font>
                      </div>

                      <div>
                        <a href="{{route('payment.plan','6Months-12-Small')}}" class="price-buy green_btn" >Choose 
                        </a>
                      </div>
                    </th>
                   <th class="price-info" style="background-color: #1b344d;">
                      <div class="price-now" style="font-weight: 600;">
                        <span style="color: white !important;">24
                          <span class="price-small" style="color: white !important;">€</span>
                        </span> <font color="white">/month</font>
                      </div>

                      <div>
                       <a href="{{route('payment.plan','6Months-24-Medium')}}" class="price-buy green_btn" >Choose 
                        </a>
                      </div>
                    </th>
                    <th class="price-info">
                      <div class="price-now" style="font-weight: 600;">
                        <span style="color: #4f4f4f !important;">39
                          <span class="price-small" style="color: #4f4f4f !important;">€</span>
                        </span> <font color="#4f4f4f">/month</font>
                      </div>
                      <div>
                        <a href="{{route('payment.plan','6Months-39-Large')}}" class="price-buy green_btn" >Choose 
                        </a>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody style="background-color: white;">
                  <tr>
                    <td></td>
                    <td colspan="4"><b>Documents</b> (monthly)<br><b>Users</b></td>
                  </tr>
                  <tr class="compare-row">
                    <td><b>Documents</b> (monthly)<br><b>Users</b></td>
                    <td style=""><span  style="color: black">
                      5 documents<br>1 user
                    </span></td>
                    <td style="">
                      <span  style="color: black">
                        20 documents<br>2 user
                      </span>
                    </td>
                     <td style="background-color: #1b344d">
                       <span  class="tickgrey">
                         500 documents<br>5 user
                       </span>
                     </td>
                    <td style="">
                      <span  style="color: black">
                        1500 documents<br>10 user
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="4">Lifetime and Free Updates </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Lifetime and Free Updates </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Communication with the AT </td>
                  </tr>
                  <tr>
                    <td>Communication with the AT</td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Technical Support </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Technical Support </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Send Documents by Email </td>
                  </tr>
                  <tr class="">
                    <td>Send Documents by Email </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Import Contacts / Items </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Import Contacts / Items </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Data Export in CSV, XLS or XML  </td>
                  </tr>
                  <tr class="">
                    <td>Data Export in CSV, XLS or XML  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Exporting the SAF-T PT file </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Exporting the SAF-T PT file </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">API Access for Integration  </td>
                  </tr>
                  <tr class="">
                    <td>API Access for Integration  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Application in Portuguese, English and Spanish  </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Application in Portuguese, English and Spanish  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Access to Mobile Version  </td>
                  </tr>
                  <tr class="">
                    <td>Access to Mobile Version  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Advanced Search </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Advanced Search  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Online Checking Account </td>
                  </tr>
                  <tr class="">
                    <td>Online Checking Account </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Custom Parameters per Client  </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Custom Parameters per Client  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Electronic Billing (digital signature)  </td>
                  </tr>
                  <tr class="">
                    <td>Electronic Billing (digital signature)  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Your Logo in Documents   </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Your Logo in Documents   </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Invoicing Scheduling   </td>
                  </tr>
                  <tr class="">
                    <td>Invoicing Scheduling  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Invoice with multiple brands  </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Invoice with multiple brands  </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Schedule Sending of SAF-T to Accountant </td>
                  </tr>
                  <tr class="">
                    <td>Schedule Sending of SAF-T to Accountant </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Multi-currency  </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Multi-currency  </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Invoices and Budgets with MB Ref. </td>
                  </tr>
                  <tr class="">
                    <td>Invoices and Budgets with MB Ref. </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Automatic Billing Alerts (Email / SMS)  </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Automatic Billing Alerts (Email / SMS)  </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Purchase Orders </td>
                  </tr>
                  <tr class="">
                    <td>Purchase Orders </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Billing reports </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Billing reports  </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                </tbody>
                <tfoot style="color: #4f4f4f;">
                  <tr style="background-color: white;">
                    <th>
                      <h4>YEARLY TOTAL</h4>
                      <p>
                        To the values presented VAT will be added at the applicable rate.
                      </p>
                    </th>
                    <th class="price-info">
                        <h2>---</h2>
                        <a href="#" class="price-buy green_btn" >Unavailable 
                        </a>
                    </th>
                    <th class="price-info">
                      <h2>144 €</h2>
                        <a href="{{route('payment.plan','6Months-144-Small-Yearly')}}" class="price-buy green_btn" >Choose 
                        </a>
                    </th>
                   <th class="price-info" >
                     <h2>288 €</h2>
                        <a href="{{route('payment.plan','6Months-288-Medium-Yearly')}}" class="price-buy green_btn" >Choose 
                        </a>
                    </th>
                    <th class="price-info">
                      <h2>468 € </h2>
                        <a href="{{route('payment.plan','6Months-468-Large-Yearly')}}" class="price-buy green_btn" >Choose 
                        </a>
                    </th>
                  </tr>
                </tfoot>
              </table>
            </div>
        </div>
        
        <div class="tab-pane fade" id="pills-12M" role="tabpanel" aria-labelledby="pills-12M-tab">
            <div class="comparison">
              <table class="table" style="width:100% !important; ">
                <thead>
                  <tr>
                    <th style="border-color: transparent;width : 20%; "></th>
                    <th style="border-color: transparent;width : 20%; "></th>
                    <th style="border-color: transparent;width : 20%;"></th>
                     <th class="qbse" style="text-align: center;font-weight: 700;background-color: #fb9600;width : 20%">
                      MORE POPULAR
                    </th>
                    <th style="border-color: transparent;width : 20%; "></th>
                  </tr>
                  <tr style="background-color: white;">
                    <th class="tl" width="30%" ></th>
                    <th class="compare-heading" width="17.5%" style="background-color: #0d4373;">
                      <h2 style="color: white; font-size: 40px;"><b>XS</b></h2>
                    </th>
                    <th class="compare-heading" width="17.5%" style="background-color: #0d4373;">
                      <h2 style="color: white; font-size: 40px;"><b>S</b></h2>
                    </th>
                    <th class="compare-heading" width="17.5%" style="background-color: #0d4373;">
                      <h2 style="color: white; font-size: 40px;"><b>M</b></h2>
                    </th>
                   <th class="compare-heading" width="17.5%" style="background-color: #0d4373;">
                      <h2 style="color: white; font-size: 40px;"><b>L</b></h2>
                    </th>
                  </tr>
                  <tr style="background-color: white;">
                    <th>
                      <p>
                        <b>If you need help,<br>
                        <a style="color: #00bb80;" href="#">contact us.</a></b><br>
                        Rui Ferreira  <font color = "#00bb80">•</font> InvoiceXpress Team
                      </p>
                    </th>
                    <th class="price-info">
                      <div class="price-now" style="font-weight: 600;">
                        <span style="color: #4f4f4f !important;">4
                          <span class="price-small" style="color: #4f4f4f !important;">€</span>
                        </span> <font color="#4f4f4f">/month</font>
                      </div>

                      <div>
                        <a href="{{route('payment.plan','12Months-4-XSmall')}}" class="price-buy green_btn" >Choose 
                        </a>
                      </div>
                    </th>
                    <th class="price-info">
                      <div class="price-now" style="font-weight: 600;">
                        <span style="color: #4f4f4f !important;">9
                          <span class="price-small" style="color: #4f4f4f !important;">€</span>
                        </span> <font color="#4f4f4f">/month</font>
                      </div>

                      <div>
                        <a href="{{route('payment.plan','12Months-9-Small')}}" class="price-buy green_btn" >Choose 
                        </a>
                      </div>
                    </th>
                   <th class="price-info" style="background-color: #1b344d;">
                      <div class="price-now" style="font-weight: 600;">
                        <span style="color: white !important;">12
                          <span class="price-small" style="color: white !important;">€</span>
                        </span> <font color="white">/month</font>
                      </div>

                      <div>
                        <a href="{{route('payment.plan','12Months-12-Medium')}}" class="price-buy green_btn" >Choose 
                        </a>
                      </div>
                    </th>
                    <th class="price-info">
                      <div class="price-now" style="font-weight: 600;">
                        <span style="color: #4f4f4f !important;">29
                          <span class="price-small" style="color: #4f4f4f !important;">€</span>
                        </span> <font color="#4f4f4f">/month</font>
                      </div>

                      <div>
                        <a href="{{route('payment.plan','12Months-29-Large')}}" class="price-buy green_btn" >Choose 
                        </a>
                      </div>
                    </th>
                  </tr>
                </thead>
                <tbody style="background-color: white;">
                  <tr>
                    <td></td>
                    <td colspan="4"><b>Documents</b> (monthly)<br><b>Users</b></td>
                  </tr>
                  <tr class="compare-row">
                    <td><b>Documents</b> (monthly)<br><b>Users</b></td>
                    <td style=""><span  style="color: black">
                      5 documents<br>1 user
                    </span></td>
                    <td style="">
                      <span  style="color: black">
                        20 documents<br>2 user
                      </span>
                    </td>
                     <td style="background-color: #1b344d">
                       <span  class="tickgrey">
                         500 documents<br>5 user
                       </span>
                     </td>
                    <td style="">
                      <span  style="color: black">
                        1500 documents<br>10 user
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td></td>
                    <td colspan="4">Lifetime and Free Updates </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Lifetime and Free Updates </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgreen">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Communication with the AT </td>
                  </tr>
                  <tr>
                    <td>Communication with the AT</td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgreen">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Technical Support </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Technical Support </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgreen">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Send Documents by Email </td>
                  </tr>
                  <tr class="">
                    <td>Send Documents by Email </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgreen">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Import Contacts / Items </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Import Contacts / Items </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgreen">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Data Export in CSV, XLS or XML  </td>
                  </tr>
                  <tr class="">
                    <td>Data Export in CSV, XLS or XML  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgreen">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Exporting the SAF-T PT file </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Exporting the SAF-T PT file </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgreen">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">API Access for Integration  </td>
                  </tr>
                  <tr class="">
                    <td>API Access for Integration  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgreen">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Application in Portuguese, English and Spanish  </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Application in Portuguese, English and Spanish  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgreen">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Access to Mobile Version  </td>
                  </tr>
                  <tr class="">
                    <td>Access to Mobile Version  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgreen">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Advanced Search </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Advanced Search  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgreen">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Online Checking Account </td>
                  </tr>
                  <tr class="">
                    <td>Online Checking Account </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgreen">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Custom Parameters per Client  </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Custom Parameters per Client  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgreen">✔</span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Electronic Billing (digital signature)  </td>
                  </tr>
                  <tr class="">
                    <td>Electronic Billing (digital signature)  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Your Logo in Documents   </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Your Logo in Documents   </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Invoicing Scheduling   </td>
                  </tr>
                  <tr class="">
                    <td>Invoicing Scheduling  </td>
                    <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Invoice with multiple brands  </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Invoice with multiple brands  </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Schedule Sending of SAF-T to Accountant </td>
                  </tr>
                  <tr class="">
                    <td>Schedule Sending of SAF-T to Accountant </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Multi-currency  </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Multi-currency  </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Invoices and Budgets with MB Ref. </td>
                  </tr>
                  <tr class="">
                    <td>Invoices and Budgets with MB Ref. </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>

                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Automatic Billing Alerts (Email / SMS)  </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Automatic Billing Alerts (Email / SMS)  </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Purchase Orders </td>
                  </tr>
                  <tr class="">
                    <td>Purchase Orders </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="4">Billing reports </td>
                  </tr>
                  <tr class="compare-row">
                    <td>Billing reports  </td>
                     <td style="font-weight: 600;font-size: large;"><span class="tickgrey"></span></td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen"></span>
                    </td>
                     <td style="font-weight: 600;font-size: large;background-color: #1b344d; color: white">
                       <span class="tickgreen">✔</span>
                     </td>
                    <td style="font-weight: 600;font-size: large;">
                      <span class="tickgreen">✔</span>
                    </td>
                  </tr>
                </tbody>
                <tfoot style="color: #4f4f4f;">
                  <tr style="background-color: white;">
                    <th>
                      <h4>YEARLY TOTAL</h4>
                      <p>
                        To the values presented VAT will be added at the applicable rate.
                      </p>
                    </th>
                    <th class="price-info">
                        <h2>48 €</h2>
                        <a href="{{route('payment.plan','12Months-48-XSmall-Yearly')}}" class="price-buy green_btn" >Choose 
                        </a>
                    </th>
                    <th class="price-info">
                      <h2>128 €</h2>
                        <a href="{{route('payment.plan','12Months-128-Small-Yearly')}}" class="price-buy green_btn" >Choose 
                        </a>
                    </th>
                   <th class="price-info" >
                     <h2>228 €</h2>
                        <a href="{{route('payment.plan','12Months-228-Medium-Yearly')}}" class="price-buy green_btn" >Choose 
                        </a>
                    </th>
                    <th class="price-info">
                      <h2>348 € </h2>
                        <a href="{{route('payment.plan','12Months-348-Large-Yearly')}}" class="price-buy green_btn" >Choose 
                        </a>
                    </th>
                  </tr>
                </tfoot>
              </table>
            </div>
        </div>

      </div>
    </div>
    <div class="xl_plan">
    <h2>Does your business need a <b>XL Plan</b> with +1500 docs/month? <a href="mailto:comercial@intellidus360.com"><b>Contact us</b></a></h2>
  </div>
  <div class="row">
    <div class="col-md-12" style="text-align: center;">
      <a style="background-color: #f93;" href="{{route('account.balance')}}" class="btn btn-warning">Back to account</a>
    </div>
  </div>
  <br><br>
</div>

<!-- <div class="comparison">
  <table>
    <thead>
      <tr>
        <th class="qbse">
          Self-Employed & Freelance
        </th>
        <th class="qbse">
          Self-Employed & Freelance
        </th>
        <th colspan="3" class="qbo">
          Small businesses that need accounting, invoicing or payroll
        </th>
      </tr>
      <tr>
        <th class="compare-heading">
          Self-Employed
        </th>
        <th class="compare-heading">
          Self-Employed
        </th>
        <th class="compare-heading">
          Simple Start
        </th>
        <th class="compare-heading">
          Essentials
        </th>
        <th class="compare-heading">
          Plus
        </th>
      </tr>
      <tr>
        <th class="price-info">
          <div class="price-was">Was £6.00</div>
          <div class="price-now"><span>£4<span class="price-small">.20</span></span> /month</div>
          <div><a href="#" class="price-buy">Buy <span class="hide-mobile">Now</span></a></div>
          <div class="price-try"><span class="hide-mobile">or </span><a href="#">try <span class="hide-mobile">it free</span></a></div>
        </th>
        <th class="price-info">
          <div class="price-was">Was £6.00</div>
          <div class="price-now"><span>£4<span class="price-small">.20</span></span> /month</div>
          <div><a href="#" class="price-buy">Buy <span class="hide-mobile">Now</span></a></div>
          <div class="price-try"><span class="hide-mobile">or </span><a href="#">try <span class="hide-mobile">it free</span></a></div>
        </th>
        <th class="price-info">
          <div class="price-was">Was £7.00</div>
          <div class="price-now"><span>£5<span class="price-small">.60</span></span> /month</div>
          <div><a href="#" class="price-buy">Buy <span class="hide-mobile">Now</span></a></div>
          <div class="price-try"><span class="hide-mobile">or </span><a href="#">try <span class="hide-mobile">it free</span></a></div>
        </th>
        <th class="price-info">
          <div class="price-was">Was £15.00</div>
          <div class="price-now"><span>£10<span class="price-small">.50</span></span> /month</div>
          <div><a href="#" class="price-buy">Buy <span class="hide-mobile">Now</span></a></div>
          <div class="price-try"><span class="hide-mobile">or </span><a href="#">try <span class="hide-mobile">it free</span></a></div>
        </th>
        <th class="price-info">
          <div class="price-was">Was £25.00</div>
          <div class="price-now"><span>£15<span class="price-small">.00</span></span> /month</div>
          <div><a href="#" class="price-buy">Buy <span class="hide-mobile">Now</span></a></div>
          <div class="price-try"><span class="hide-mobile">or </span><a href="#">try <span class="hide-mobile">it free</span></a></div>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td></td>
        <td colspan="4">Seperate business from personal spending</td>
      </tr>
      <tr class="compare-row">
        <td>Seperate business/personal</td>
        <td><span class="tickblue">✔</span></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="4">Estimate tax payments</td>
      </tr>
      <tr>
        <td>Estimate tax payments</td>
        <td><span class="tickblue">✔</span></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="4">Track deductible mileage</td>
      </tr>
      <tr class="compare-row">
        <td>Track deductible mileage</td>
        <td><span class="tickblue">✔</span></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="4">Download online banking</td>
      </tr>
      <tr>
        <td>Download online banking</td>
        <td><span class="tickblue">✔</span></td>
        <td><span class="tickgreen">✔</span></td>
        <td><span class="tickgreen">✔</span></td>
        <td><span class="tickgreen">✔</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="4">Works on PC, Mac & mobile</td>
      </tr>
      <tr class="compare-row">
        <td>Multi-device</td>
        <td><span class="tickblue">✔</span></td>
        <td><span class="tickgreen">✔</span></td>
        <td><span class="tickgreen">✔</span></td>
        <td><span class="tickgreen">✔</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="4">Create invoices & estimates</td>
      </tr>
      <tr>
        <td>Create invoices & estimates</td>
        <td></td>
        <td><span class="tickgreen">✔</span></td>
        <td><span class="tickgreen">✔</span></td>
        <td><span class="tickgreen">✔</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="4">Manage VAT</td>
      </tr>
      <tr class="compare-row">
        <td>Manage VAT</td>
        <td></td>
        <td><span class="tickgreen">✔</span></td>
        <td><span class="tickgreen">✔</span></td>
        <td><span class="tickgreen">✔</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="4">Run payroll</td>
      </tr>
      <tr>
        <td>Run payroll</td>
        <td></td>
        <td><span class="tickgreen">✔</span></td>
        <td><span class="tickgreen">✔</span></td>
        <td><span class="tickgreen">✔</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="4">Number of users</td>
      </tr>
      <tr class="compare-row">
        <td>Number of users</td>
        <td class="tickblue">1 user</td>
        <td class="tickgreen">1 user</td>
        <td class="tickgreen">3 users</td>
        <td class="tickgreen">5 users</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="4">Manage bills & payments</td>
      </tr>
      <tr>
        <td>Manage bills & payments</td>
        <td></td>
        <td></td>
        <td><span class="tickgreen">✔</span></td>
        <td><span class="tickgreen">✔</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="4">Handle multiple currencies</td>
      </tr>
      <tr class="compare-row">
        <td>Handle multiple currencies</td>
        <td></td>
        <td></td>
        <td><span class="tickgreen">✔</span></td>
        <td><span class="tickgreen">✔</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="4">Create budgets</td>
      </tr>
      <tr>
        <td>Create budgets</td>
        <td></td>
        <td></td>
        <td></td>
        <td><span class="tickgreen">✔</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="4">Track employee time</td>
      </tr>
      <tr class="compare-row">
        <td>Track employee time</td>
        <td></td>
        <td></td>
        <td></td>
        <td><span class="tickgreen">✔</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="4">Stock control</td>
      </tr>
      <tr>
        <td>Stock control</td>
        <td></td>
        <td></td>
        <td></td>
        <td><span class="tickgreen">✔</span></td>
      </tr>
    </tbody>
  </table>
</div> -->

</body>
</html>
