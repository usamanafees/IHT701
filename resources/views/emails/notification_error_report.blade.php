<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width"/>

</head>
<body>
<table class="body-wrap">
    <tr>
        <td class="container">
            <div>
                <div>
                    <div align="center" class="masthead">
                        <h1>Intelidus system</h1>
                    </div>
                </div>
                <div>
					<h1 style="font-size:20px;">User : @if(isset(Auth::user()->first_name)) {{Auth::user()->first_name}} @endif @if(isset(Auth::user()->last_name)) {{Auth::user()->last_name}}@endif</h1>
                    <div class="content">
                        <div class="element">
							<h3>Request Url: {{$url}}</h3>
                          {!! $content !!}
                        </div>
                    </div>
                </div>
            </div>

        </td>
    </tr>
</table>

<style>

* {
  margin: 0;
  padding: 0;
  font-size: 100%;
  font-family: 'Avenir Next', "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
  line-height: 1.65; }

img {
  max-width: 100%;
  margin: 0 auto;
  display: block; }

body,
.body-wrap {
  width: 100% !important;
  height: 100%;
  background: #efefef;
  -webkit-font-smoothing: antialiased;
  -webkit-text-size-adjust: none; }

a {
  color: #2a3542;
  text-decoration: none; }

.text-center {
  text-align: center; }

.text-right {
  text-align: right; }

.text-left {
  text-align: left; }

.button {
  display: inline-block;
  color: white;
  background: #2a3542;
  border: solid #2a3542;
  border-width: 10px 20px 8px;
  font-weight: bold;
  border-radius: 4px; }

h1, h2, h3, h4, h5, h6 {
  line-height: 1; }

h1 {
  font-size: 32px; }

h2 {
  font-size: 14px; }

h3 {
  font-size: 24px; }

h4 {
  font-size: 20px; }

h5 {
  font-size: 16px; }

p, ul, ol {
  font-size: 14px;
  font-weight: normal; }



.container {
  display: block !important;
  clear: both !important;
  margin: 0 auto !important;
  max-width: 580px !important; }
  .container table {
    width: 100% !important;
    border-collapse: collapse; }
  .container .masthead {
    padding: 80px 0;
    background: #2a3542;
    color: white; }
    .container .masthead h1 {
      margin: 0 auto !important;
      max-width: 90%;
      text-transform: uppercase; }
  .container .content {
    background: white;
    padding: 30px 35px; }
    .container .content.footer {
      background: none; }
      .container .content.footer p {
        margin-bottom: 0;
        color: #888;
        text-align: center;
        font-size: 14px; }
      .container .content.footer a {
        color: #888;
        text-decoration: none;
        font-weight: bold; }

  .element{ font-size: 8pt;}
  .main-table { margin-top: 50px;}
  .header_element {font-size: 12px;}

</style>
</body>
</html>
