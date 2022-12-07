@extends('partials.main')

@section('content')
    <link href="{{asset('css/mini-menu.css')}}" rel="stylesheet">
    <link href="{{asset('css/tabs.css')}}" rel="stylesheet">
    <link href="{{asset('css/radio-button.css')}}" rel="stylesheet">
    <div class="app-main__outer">
        <div class="app-main__inner">

            <div class="breadcrumb mb-5" style="margin-top: -12px">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="{{route('/')}}">{{trans('menu.home')}}</a>
                    <i class="fa fa-angle-right">&nbsp;</i>
                </li>
                <li>
                    <a >{{trans('menu.settings')}}</a>
                    <i class="fa fa-angle-right">&nbsp;</i>
                </li>
                <li>
                    <a class="breadcrumb-item active" href="">{{trans('menu.contact_client')}}</a>
                </li>
            </div>


            <div class="app-page-title">
                <div class="page-title-wrapper">

                    <div class="page-title-heading">

                        <div class="page-title-icon">

                            <i class="fas fa-sliders-h icon-gradient bg-tempting-azure">
                            </i>
                        </div>
                        <div>
                            {{trans('clients.contact_client')}}
                        </div>
                        <div class="page-title-actions">
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-card mb-3 card">
                    @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <p>
                                {!! \Session::get('success') !!}
                            </p>
                        </div>
                    @endif
                    @if (\Session::has('error'))
                        <div class="alert alert-warning">
                            <p>
                                {!! \Session::get('error') !!}
                            </p>
                        </div>
                    @endif
                <div class="card-body">
                    <div class="tab-content text-center">
                        <div class="tab-pane active" id="before" role="tabpanel">
                            <form class="form-horizontal" method="POST" action="{{ route('clients.contact_client_usr_post') }}" >
                                {{ csrf_field() }}
                                <div class="form-row">
                                    <div class="col-md-6">
                                        {{trans('clients.contact_client')}} via
                                        <label for="send_message">&nbspSMS
                                         
                                                <input type="checkbox" id="send_message_before" name="send_message_before" value="send message before" >
                                     
                                        </label>
                                        <label for="send_email">&nbspEmail
                                            
                                                <input type="checkbox" id="send_email_before" name="send_email_before" value="send email before" >
                                           
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="number_days_before">
                                          
                                                <select  class="select2 form-control" name="client[]"  id="client"  multiple="multiple" required>
                                                    <option value=""  disabled > {{trans('clients.select_client')}} </option>
                                                        @foreach($clients as $client)
                                                            <option value="{{$client->id}}">{{$client->name." - ".$client->id}}</option>
                                                        @endforeach
                                                </select>
                                        </label> {{trans('clients.select_client')}}
                                    </div>
                                </div>
                                <div class="tab-content text-center mt-5">
                                    <input class="checkbox-tools" type="radio" name="tools" id="tool-1" onclick="show_email()" checked>
                                    <label class="for-checkbox-tools" for="tool-1">
                                        <i class='fas fa-envelope'></i>
                                        Email
                                    </label>
                                    <input class="checkbox-tools" type="radio" name="tools" id="tool-2" onclick="show_message()">
                                    <label class="for-checkbox-tools" for="tool-2">
                                        <i class='fas fa-comment'></i>
                                        {{trans('clients.message')}}
                                    </label>
                                </div>
                                <div id="show-email" style="padding-top: 30px">
                                    <div class="form-row">
                                        <label for="subject_before">{{trans('clients.subject')}}</label>
                                        <div class="input-group">
                                           
                                                <input type="text" id="subject_before" name="subject_before" class="form-control" value="" disabled>
                                            
                                            {{-- <div class="input-group-append">
                                                <label for="subject_dropdown"></label>
                                                <select class="btn btn-outline-secondary" id="subject_dropdown" name="subject_dropdown" onChange="addTextSubject(this);" disabled>
                                                    <optgroup label="Company">
                                                        <option value="%name%">Name</option>
                                                        <option value="%nif%">NIF</option>
                                                        <option value="%preferred_contact_name%">Preferred Contact Name</option>
                                                        <option value="%preferred_contact_email%">Preferred Contact Email</option>
                                                        <option value="%preferred_contact_phone%">Preferred Contact Phone</option>
                                                        <option value="%open_account_link%">Online Checking Account Link</option>
                                                    </optgroup>
                                                    <optgroup label="Documents">
                                                        <option value="%current_account_url%">Online Checking Account Link</option>
                                                        <option value="%document_list%">Document List</option>
                                                        <option value="%days_to_expire%">Days to Expire</option>
                                                    </optgroup>  
                                                </select>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <label for="email_message_before" style="padding-top: 20px">{{trans('clients.message')}}</label>
                                        <div class="input-group">
                                      
                                                <textarea type="text" id="email_message_before" name="email_message_before" class="form-control" cols="50" rows="5" disabled></textarea>
                                       
                                            {{-- <div class="input-group-append">
                                                <label for="email_message_dropdown"></label><select class="btn btn-outline-secondary " id="email_message_dropdown" onChange="addTextSubject1(this);"  disabled>
                                                    <optgroup label="Company">
                                                        <option value="%name%">Name</option>
                                                        <option value="%nif%">NIF</option>
                                                        <option value="%preferred_contact_name%">Preferred Contact Name</option>
                                                        <option value="%preferred_contact_email%">Preferred Contact Email</option>
                                                        <option value="%preferred_contact_phone%">Preferred Contact Phone</option>
                                                        <option value="%open_account_link%">Online Checking Account Link</option>
                                                    </optgroup>
                                                    <optgroup label="Documents">
                                                        <option value="%current_account_url%">Online Checking Account Link</option>
                                                        <option value="%document_list%">Document List</option>
                                                        <option value="%days_to_expire%">Days to Expire</option>
                                                    </optgroup>
                                                </select>
                                            </div> --}}
                                        </div>
                                    </div>
                                    
                                </div>
                                <div id="show-message" style="display: none">
                                    <div class="form-row" >
                                        <label for="sms_message_before" style="padding-top: 20px">{{trans('clients.message')}}</label>
                                        <div class="input-group">
                                        
                                                <textarea type="text" id="sms_message_before" name="sms_message_before" class="form-control" cols="50" rows="5" disabled></textarea>
                                           
                                            {{-- <div class="input-group-append">
                                                <label for="message_dropdown"></label><select class="btn btn-outline-secondary dropdown-toggle" id="message_dropdown" onChange="addTextSubject2(this);" disabled>
                                                    <optgroup label="Company">
                                                        <option value="%name%">Name</option>
                                                        <option value="%nif%">NIF</option>
                                                        <option value="%preferred_contact_name%">Preferred Contact Name</option>
                                                        <option value="%preferred_contact_email%">Preferred Contact Email</option>
                                                        <option value="%preferred_contact_phone%">Preferred Contact Phone</option>
                                                        <option value="%open_account_link%">Online Checking Account Link</option>
                                                    </optgroup>
                                                    <optgroup label="Documents">
                                                        <option value="%current_account_url%">Online Checking Account Link</option>
                                                        <option value="%document_list%">Document List</option>
                                                        <option value="%days_to_expire%">Days to Expire</option>
                                                    </optgroup>
                                                </select>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="text-align: right;">
                                    <button type="submit" id="before_submit"  class="mt-2 btn btn-success">{{trans('clients.Save')}}</button>
                                </div>
                            </form>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- </div> --}}
@endsection
@section('javascript')
    <script>
        check_state_before();
        
       $("#send_message_before").change(function() {
        check_state_before();
        });
        $("#send_email_before").change(function() {
            check_state_before();
        });
        function check_state_before()
        {
            if ($('#send_message_before').is(':checked') || $('#send_email_before').is(':checked')){
                $('#before_submit').prop("disabled", false);
            }else
            {
                $('#before_submit').prop("disabled", true);
            }
        }
        
      
        function show_email(){
            document.getElementById('show-email').style.display ='block';
            document.getElementById('show-message').style.display ='none';
        }
        function show_message(){
            document.getElementById('show-message').style.display ='block';
            document.getElementById('show-email').style.display ='none';
        }

        if(document.getElementById('send_email_before').checked){
            document.getElementById('email_message_before').disabled = this.checked;
            document.getElementById('subject_before').disabled = this.checked;
            //document.getElementById('email_message_dropdown').disabled = this.checked;
            //getElementById('subject_dropdown').disabled = this.checked;
            // document.getElementById('checkbox_send_me_before').disabled = this.checked;
        }else{
            document.getElementById('email_message_before').disabled = !this.checked;
            document.getElementById('subject_before').disabled = !this.checked;
        // document.getElementById('email_message_dropdown').disabled = !this.checked;
            //document.getElementById('subject_dropdown').disabled = !this.checked;
            // document.getElementById('checkbox_send_me_before').disabled = !this.checked;
        }

        document.getElementById('send_email_before').onchange = function() {
            document.getElementById('email_message_before').disabled = !this.checked;
            document.getElementById('subject_before').disabled = !this.checked;
            //document.getElementById('email_message_dropdown').disabled = !this.checked;
            //document.getElementById('subject_dropdown').disabled = !this.checked;
            // document.getElementById('checkbox_send_me_before').disabled = !this.checked;
        };


        if(document.getElementById('send_message_before').checked){
            document.getElementById('sms_message_before').disabled = this.checked;
           // document.getElementById('message_dropdown').disabled = this.checked;
        }else{
            document.getElementById('sms_message_before').disabled = !this.checked;
            //document.getElementById('message_dropdown').disabled = !this.checked;
        }

        document.getElementById('send_message_before').onchange = function() {
            document.getElementById('sms_message_before').disabled = !this.checked;
           // document.getElementById('message_dropdown').disabled = !this.checked;
        };

        function addTextSubject(sel) {
            
            var text = sel.options[sel.selectedIndex].value;
            var x = document.getElementById("subject_before").value;
            document.getElementById("subject_before").value += text;
        }

        function addTextSubject1(sel){
            var text = sel.options[sel.selectedIndex].value;
            var x = document.getElementById("email_message_before").value;
            document.getElementById("email_message_before").value += text;
        }

        function addTextSubject2(sel){
            var text = sel.options[sel.selectedIndex].value;
            var x = document.getElementById("sms_message_before").value;
            document.getElementById("sms_message_before").value += text;
        }

    </script>

    @endsection
