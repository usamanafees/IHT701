<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title>Invoice</title>
  <style type="text/css">
    @page {
        margin: 20px 15px 20px 15px;
    }
    body {
          margin-top: 3.75cm;
          font-family: sans-serif;
      }
    .note-toolbar{
            background-color: #caccce;
            border-color: #ddd;
    }
    .note-btn-group{
        background-color: white;
        border-color: black;
    }
    hr.line {
        border: 2px solid black;
        border-radius: 2px;
    }
    hr.line_slim{
        border: 1px solid black;
        border-radius: 2px;
    }
    p{
        font-size: 12px;
    }
    /*.table {*/

    /*}*/
    /*th{
      border: 1px solid black;
      border-spacing: 0px;
    }*/
    /*td{
      border: 1px solid lightgrey;
      border-spacing: 0px;
    }*/
    .col-6 {
      float: left;
      width: 50%;
      /*padding: 10px;*/
    }
    table{
      width : 100%;
    }
    .col-3 {
      float: left;
      width: 25%;
      padding: 5px;
    }
    .col-4{
      float: left;
      width: 33%;
      /*padding: 10px;*/
    }
    .col-8{
      float: left;
      width: 80%;
      /*padding: 10px;*/
    }
    /*.col-10 {
      float: left;
      width: 80%;
      padding: 10px;
    }*/
   /* .col-2 {
      float: left;
      width: 20%;
      padding: 10px;
    }*/
    /* Clear floats after the columns */
    .row:after {
      content: "";
      display: table;
      clear: both;
    }

    #header { position: fixed; top: 0; left: 0px; right: 0px;  padding: .5em; width:100%; background-color: #fff; }
     /*#footer {position: fixed; bottom: -50px;width:100%; }*/
     #footer {position: fixed; bottom: 450px; left: 0px; right: 0px; }

    /* table, th, td{
      width: 100%;
      border-collapse: collapse;
      border: 1px solid #000;
    } */
    table {border-collapse:collapse; table-layout:fixed; width:100%;}
    table td {border:solid 1px; width:100px; word-wrap:break-word;}
  </style>

 </head>
 <body style="margin-top:0px; page-break-inside: always;">
        <header id='header'>
           {!!$header!!}
        </header>

      
        @if($base64 != 'none')
        <span style="position:relative; bottom: 150px; left: 470px;z-index: 1;">
          <img style="height:100px;transform: rotate(340deg);" src="{{ $base64 }}" alt="">
        </span>
        @endif
  <div style="width:100%;">
       {!! $body !!}
  </div>
  <div  style="">
    {!!$footer!!}
   </div>
   <script type="text/javascript" src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
<script>
</script>
</body>

</html>
