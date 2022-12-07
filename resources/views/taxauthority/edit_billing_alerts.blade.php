@extends('partials.main')

@section('content')
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
                    <a href="{{route('invoices.home')}}">{{trans('menu.invoicing')}}</a>
                    <i class="fa fa-angle-right">&nbsp;</i>
                </li>
                <li>
                    <a href="{{route('billing-alerts')}}">{{trans('menu.billing_alerts')}}</a>
                    <i class="fa fa-angle-right">&nbsp;</i>
                </li>
                <li>
                    <a class="breadcrumb-item active" href="">{{trans('billing.edit_bl_alerts')}}</a>

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
                        </div>
                        <div class="page-title-actions">
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-card mb-3 card">
                <div class="card-body" style="background-color: #cad3d8;">
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
                    <h3>
                        <b>{{trans('billing.edit_bl_alerts')}}</b>

                    </h3>
                </div>
                <ul class="nav nav-tabs justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a style="display:{{ $billings[0]->is_before != 1 ? 'none' : ''   }}" class="nav-link {{ $billings[0]->is_before == 1 ? 'active' : ''   }} " data-toggle="tab" href="#before" role="tab">
                            {{trans('billing.before_exp_date')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a style="display:{{ $billings[0]->is_before == 1 ? 'none' : ''   }}" class="nav-link {{ $billings[0]->is_before != 1 ? 'active' : ''   }}" data-toggle="tab" href="#after" role="tab">
                            {{trans('billing.after_exp_date')}}
                        </a>
                    </li>
                </ul>
                <div class="card-body">
                    <div class="tab-content text-center">
                        <div class="tab-pane {{ $billings[0]->is_before == 1 ? 'active' : ''   }}" id="before" role="tabpanel">
                            <form class="form-horizontal" method="POST" action="{{ route('billing-alerts.before') }}?edit={{ $billings[0]->id }}"  >
                                {{ csrf_field() }}
                                <div class="form-row">
                                    <div class="col-md-6">
                                        {{trans('billing.send_auto')}}
                                        <label for="send_message">&nbspSMS
                                            @foreach ($billings as $billing)
                                                <input type="checkbox" id="send_message_before" name="send_message_before" value="send message before" <?php echo ($billing->sms_before==1 ? 'checked' : '');?>>
                                            @endforeach
                                        </label>
                                        <label for="send_email">&nbspEmail
                                            @foreach ($billings as $billing)
                                                <input type="checkbox" id="send_email_before" name="send_email_before" value="send email before" <?php echo ($billing->email_before==1 ? 'checked' : '');?>>
                                            @endforeach
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="number_days_before">
                                            @foreach ($billings as $billing)
                                                <input type="number" class="small" id="number_days_before" name="number_days_before" min="0" value="<?php echo $billing->days_before;?>">
                                            @endforeach
                                        </label>&nbsp{{trans('billing.days_before_exp_date')}}.
                                    </div>
                                </div>
                                <div class="tab-content text-center">
                                    <input class="checkbox-tools" type="radio" name="tools" id="tool-1" onclick="show_email()" checked>
                                    <label class="for-checkbox-tools" for="tool-1">
                                        <i class='fas fa-envelope'></i>
                                        Email
                                    </label>
                                    <input class="checkbox-tools" type="radio" name="tools" id="tool-2" onclick="show_message()">
                                    <label class="for-checkbox-tools" for="tool-2">
                                        <i class='fas fa-comment'></i>
                                        {{trans('billing.message')}}
                                    </label>
                                </div>
                                <div id="show-email" style="padding-top: 30px">
                                    <div class="form-row">
                                        <label for="subject_before">{{trans('billing.subject')}}</label>
                                        <div class="input-group">
                                            @foreach ($billings as $billing)
                                                <input type="text" id="subject_before" name="subject_before" class="form-control" value="{{$billing->email_subject_before}}" disabled>
                                            @endforeach
                                            <div class="input-group-append">
                                                <label for="subject_dropdown"></label><select class="btn btn-outline-secondary dropdown-toggle" id="subject_dropdown" name="subject_dropdown" onChange="addTextSubject(this);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled>
                                                    <optgroup label="Company">
                                                        <option value="%name%">{{trans('billing.name')}}</option>
                                                        <option value="%nif%">NIF</option>
                                                        <option value="%preferred_contact_name%">{{trans('billing.pref_contact_name')}}</option>
                                                        <option value="%preferred_contact_email%">{{trans('billing.pref_contact_email')}}</option>
                                                        <option value="%preferred_contact_phone%">{{trans('billing.pref_contact_phone')}}</option>
                                                        <option value="%open_account_link%">{{trans('billing.online_acc_checking_link')}}</option>
                                                    </optgroup>
                                                    <optgroup label="Documents">
                                                        <option value="%current_account_url%">{{trans('billing.online_acc_checking_link')}}</option>
                                                        <option value="%document_list%">{{trans('billing.doc_list')}}</option>
                                                        <option value="%days_to_expire%">{{trans('billing.days_to_exp')}}</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <label for="email_message_before" style="padding-top: 20px">{{trans('billing.message')}}</label>
                                        <div class="input-group">
                                            @foreach ($billings as $billing)
                                                <textarea type="text" id="email_message_before" name="email_message_before" class="form-control" cols="50" rows="5" disabled>{{$billing->email_message_before}}</textarea>
                                            @endforeach
                                            <div class="input-group-append">
                                                <label for="email_message_dropdown"></label><select class="btn btn-outline-secondary dropdown-toggle" id="email_message_dropdown" onChange="addTextSubject1(this);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled>
                                                    <optgroup label="Company">
                                                        <option value="%name%">{{trans('billing.name')}}</option>
                                                        <option value="%nif%">NIF</option>
                                                        <option value="%preferred_contact_name%">{{trans('billing.pref_contact_name')}}</option>
                                                        <option value="%preferred_contact_email%">{{trans('billing.pref_contact_email')}}</option>
                                                        <option value="%preferred_contact_phone%">{{trans('billing.pref_contact_phone')}}</option>
                                                        <option value="%open_account_link%">{{trans('billing.online_acc_checking_link')}}</option>
                                                    </optgroup>
                                                    <optgroup label="Documents">
                                                        <option value="%current_account_url%">{{trans('billing.online_acc_checking_link')}}</option>
                                                        <option value="%document_list%">{{trans('billing.doc_list')}}</option>
                                                        <option value="%days_to_expire%">{{trans('billing.days_to_exp')}}</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row" style="padding-top: 20px">
                                        <label for="checkbox_send_me_before">Send me one copy:
                                            @foreach ($billings as $billing)
                                                <input id="checkbox_send_me_before" name="checkbox_send_me_before" type="checkbox" class="custom-checkbox" value="checkbox_send_me_before" <?php echo ($billing->send_me_email_before==1 ? 'checked' : '');?> disabled>
                                            @endforeach
                                        </label>
                                    </div>
                                </div>
                                <div id="show-message" style="display: none">
                                    <div class="form-row" >
                                        <label for="sms_message_before" style="padding-top: 20px">{{trans('billing.message')}}</label>
                                        <div class="input-group">
                                            @foreach ($billings as $billing)
                                                <textarea type="text" id="sms_message_before" name="sms_message_before" class="form-control" cols="50" rows="5" disabled>{{$billing->sms_message_before}}</textarea>
                                            @endforeach
                                            <div class="input-group-append">
                                                <label for="message_dropdown"></label><select class="btn btn-outline-secondary dropdown-toggle" id="message_dropdown" onChange="addTextSubject2(this);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled>
                                                    <optgroup label="Company">
                                                        <option value="%name%">{{trans('billing.name')}}</option>
                                                        <option value="%nif%">NIF</option>
                                                        <option value="%preferred_contact_name%">{{trans('billing.pref_contact_name')}}</option>
                                                        <option value="%preferred_contact_email%">{{trans('billing.pref_contact_email')}}</option>
                                                        <option value="%preferred_contact_phone%">{{trans('billing.pref_contact_phone')}}</option>
                                                        <option value="%open_account_link%">{{trans('billing.online_acc_checking_link')}}</option>
                                                    </optgroup>
                                                    <optgroup label="Documents">
                                                        <option value="%current_account_url%">{{trans('billing.online_acc_checking_link')}}</option>
                                                        <option value="%document_list%">{{trans('billing.doc_list')}}</option>
                                                        <option value="%days_to_expire%">{{trans('billing.days_to_exp')}}</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-align: right;">
                                    <button type="submit" id="before_submit"  class="mt-2 btn btn-success">Save</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane {{ $billings[0]->is_before != 1 ? 'active' : ''  }}" id="after" role="tabpanel">
                            <form class="form-horizontal" method="POST" action="{{ route('billing-alerts.after') }}?edit={{ $billings[0]->id }}" >
                                {{ csrf_field() }}
                                <div class="form-row">
                                    <div class="col-md-6">
                                        {{trans('billing.send_auto')}}
                                        <label for="send_message_After">&nbspSMS
                                            @foreach ($billings as $billing)
                                                <input type="checkbox" id="send_message_after" name="send_message_after" value="send message after" <?php echo ($billing->sms_after==1 ? 'checked' : '');?>>
                                            @endforeach
                                        </label>
                                        <label for="send_email_after">&nbspEmail
                                            @foreach ($billings as $billing)
                                                <input type="checkbox" id="send_email_after" name="send_email_after" value="send email after" <?php echo ($billing->email_after==1 ? 'checked' : '');?>>
                                            @endforeach
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="number_days_after">
                                            @foreach ($billings as $billing)
                                                <input type="number" class="small" id="number_days_after" name="number_days_after" min="0" value="<?php echo $billing->days_after;?>">
                                            @endforeach
                                        </label>&nbsp{{trans('billing.days_expire_cicle')}}
                                    </div>
                                </div>
                                <div class="tab-content text-center">
                                    <input class="checkbox-tools" type="radio" name="tools1" id="tool-3" onclick="show_email1()" checked>
                                    <label class="for-checkbox-tools" for="tool-3">
                                        <i class='fas fa-envelope'></i>
                                        Email
                                    </label>
                                    <input class="checkbox-tools" type="radio" name="tools1" id="tool-4" onclick="show_message1()">
                                    <label class="for-checkbox-tools" for="tool-4">
                                        <i class='fas fa-comment'></i>
                                        {{trans('billing.message')}}
                                    </label>
                                </div>
                                <div id="show-email1" style="padding-top: 30px">
                                    <div class="form-row">
                                        <label for="subject_after">{{trans('billing.subject')}}</label>
                                        <div class="input-group">
                                            @foreach ($billings as $billing)
                                                <input type="text" id="subject_after" name="subject_after" class="form-control" value="{{$billing->email_subject_after}}" disabled>
                                            @endforeach
                                            <div class="input-group-append">
                                                <label for="subject_dropdown_1"></label><select class="btn btn-outline-secondary dropdown-toggle" id="subject_dropdown_1" name="subject_dropdown_1" onChange="addTextSubject3(this);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled>
                                                    <optgroup label="Company">
                                                        <option value="%name%">{{trans('billing.name')}}</option>
                                                        <option value="%nif%">NIF</option>
                                                        <option value="%preferred_contact_name%">{{trans('billing.pref_contact_name')}}</option>
                                                        <option value="%preferred_contact_email%">{{trans('billing.pref_contact_email')}}</option>
                                                        <option value="%preferred_contact_phone%">{{trans('billing.pref_contact_phone')}}</option>
                                                        <option value="%open_account_link%">{{trans('billing.online_acc_checking_link')}}</option>
                                                    </optgroup>
                                                    <optgroup label="Documents">
                                                        <option value="%current_account_url%">{{trans('billing.online_acc_checking_link')}}</option>
                                                        <option value="%document_list%">{{trans('billing.doc_list')}}</option>
                                                        <option value="%days_to_expire%">{{trans('billing.days_to_exp')}}</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <label for="email_message_after" style="padding-top: 20px">Message</label>
                                        <div class="input-group">
                                            @foreach ($billings as $billing)
                                                <textarea type="text" id="email_message_after" name="email_message_after" class="form-control" cols="50" rows="5" disabled>{{$billing->email_message_after}}</textarea>
                                            @endforeach
                                            <div class="input-group-append">
                                                <label for="email_message_dropdown_1"></label><select class="btn btn-outline-secondary dropdown-toggle" id="email_message_dropdown_1" onChange="addTextSubject4(this);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled>
                                                    <optgroup label="Company">
                                                        <option value="%name%">{{trans('billing.name')}}</option>
                                                        <option value="%nif%">NIF</option>
                                                        <option value="%preferred_contact_name%">{{trans('billing.pref_contact_name')}}</option>
                                                        <option value="%preferred_contact_email%">{{trans('billing.pref_contact_email')}}</option>
                                                        <option value="%preferred_contact_phone%">{{trans('billing.pref_contact_phone')}}</option>
                                                        <option value="%open_account_link%">{{trans('billing.online_acc_checking_link')}}</option>
                                                    </optgroup>
                                                    <optgroup label="Documents">
                                                        <option value="%current_account_url%">{{trans('billing.online_acc_checking_link')}}</option>
                                                        <option value="%document_list%">{{trans('billing.doc_list')}}</option>
                                                        <option value="%days_to_expire%">{{trans('billing.days_to_exp')}}</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row" style="padding-top: 20px">
                                        <label for="checkbox_send_me_after">Send me one copy:
                                            @foreach ($billings as $billing)
                                                <input id="checkbox_send_me_after" name="checkbox_send_me_after" type="checkbox" class="custom-checkbox" value="checkbox_send_me_after" <?php echo ($billing->send_me_email_after==1 ? 'checked' : '');?> disabled>
                                            @endforeach
                                        </label>
                                    </div>
                                </div>
                                <div id="show-message1" style="display: none">
                                    <div class="form-row" >
                                        <label for="sms_message_after" style="padding-top: 20px">Message</label>
                                        <div class="input-group">
                                            @foreach ($billings as $billing)
                                                <textarea type="text" id="sms_message_after" name="sms_message_after" class="form-control" cols="50" rows="5" disabled>{{$billing->sms_message_after}}</textarea>
                                            @endforeach
                                            <div class="input-group-append">
                                                <label for="message_dropdown_1"></label><select class="btn btn-outline-secondary dropdown-toggle" id="message_dropdown_1" onChange="addTextSubject5(this);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled>
                                                    <optgroup label="Company">
                                                        <option value="%name%">{{trans('billing.name')}}</option>
                                                        <option value="%nif%">NIF</option>
                                                        <option value="%preferred_contact_name%">{{trans('billing.pref_contact_name')}}</option>
                                                        <option value="%preferred_contact_email%">{{trans('billing.pref_contact_email')}}</option>
                                                        <option value="%preferred_contact_phone%">{{trans('billing.pref_contact_phone')}}</option>
                                                        <option value="%open_account_link%">{{trans('billing.online_acc_checking_link')}}</option>
                                                    </optgroup>
                                                    <optgroup label="Documents">
                                                        <option value="%current_account_url%">{{trans('billing.online_acc_checking_link')}}</option>
                                                        <option value="%document_list%">{{trans('billing.doc_list')}}</option>
                                                        <option value="%days_to_expire%">{{trans('billing.days_to_exp')}}</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-align: right;">
                                    <button type="submit" id="after_submit" class="mt-2 btn btn-success submitt1">{{trans('billing.save')}}</button>
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
        check_state_after();
        
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
        
       $("#send_message_after").change(function() {
        check_state_after();
        });
        $("#send_email_after").change(function() {
            check_state_after();
        });
        function check_state_after()
        {
            if ($('#send_message_after').is(':checked') || $('#send_email_after').is(':checked')){
                $('#after_submit').prop("disabled", false);
            }else
            {
                $('#after_submit').prop("disabled", true);
            }
        }
        /* FORM 1 BEFORE EXPIRE DATE */
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
            document.getElementById('email_message_dropdown').disabled = this.checked;
            document.getElementById('subject_dropdown').disabled = this.checked;
            document.getElementById('checkbox_send_me_before').disabled = this.checked;
        }else{
            document.getElementById('email_message_before').disabled = !this.checked;
            document.getElementById('subject_before').disabled = !this.checked;
            document.getElementById('email_message_dropdown').disabled = !this.checked;
            document.getElementById('subject_dropdown').disabled = !this.checked;
            document.getElementById('checkbox_send_me_before').disabled = !this.checked;
        }

        document.getElementById('send_email_before').onchange = function() {
            document.getElementById('email_message_before').disabled = !this.checked;
            document.getElementById('subject_before').disabled = !this.checked;
            document.getElementById('email_message_dropdown').disabled = !this.checked;
            document.getElementById('subject_dropdown').disabled = !this.checked;
            document.getElementById('checkbox_send_me_before').disabled = !this.checked;
        };


        if(document.getElementById('send_message_before').checked){
            document.getElementById('sms_message_before').disabled = this.checked;
            document.getElementById('message_dropdown').disabled = this.checked;
        }else{
            document.getElementById('sms_message_before').disabled = !this.checked;
            document.getElementById('message_dropdown').disabled = !this.checked;
        }

        document.getElementById('send_message_before').onchange = function() {
            document.getElementById('sms_message_before').disabled = !this.checked;
            document.getElementById('message_dropdown').disabled = !this.checked;
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

        /* FORM 2 AFTER EXPIRE DATE*/

        function show_email1(){
            document.getElementById('show-email1').style.display ='block';
            document.getElementById('show-message1').style.display ='none';
        }
        function show_message1(){
            document.getElementById('show-message1').style.display ='block';
            document.getElementById('show-email1').style.display ='none';
        }

        if(document.getElementById('send_email_after').checked){
            document.getElementById('email_message_after').disabled = this.checked;
            document.getElementById('subject_after').disabled = this.checked;
            document.getElementById('email_message_dropdown_1').disabled = this.checked;
            document.getElementById('subject_dropdown_1').disabled = this.checked;
            document.getElementById('checkbox_send_me_after').disabled = this.checked;
        }else{
            document.getElementById('email_message_after').disabled = !this.checked;
            document.getElementById('subject_after').disabled = !this.checked;
            document.getElementById('email_message_dropdown_1').disabled = !this.checked;
            document.getElementById('subject_dropdown_1').disabled = !this.checked;
            document.getElementById('checkbox_send_me_after').disabled = !this.checked;
        }

        document.getElementById('send_email_after').onchange = function() {
            document.getElementById('email_message_after').disabled = !this.checked;
            document.getElementById('subject_after').disabled = !this.checked;
            document.getElementById('email_message_dropdown_1').disabled = !this.checked;
            document.getElementById('subject_dropdown_1').disabled = !this.checked;
            document.getElementById('checkbox_send_me_after').disabled = !this.checked;
        };

        if(document.getElementById('send_message_after').checked){
            document.getElementById('sms_message_after').disabled = this.checked;
            document.getElementById('message_dropdown_1').disabled = this.checked;
        }else{
            document.getElementById('sms_message_after').disabled = !this.checked;
            document.getElementById('message_dropdown_1').disabled = !this.checked;
        }

        document.getElementById('send_message_after').onchange = function() {
            document.getElementById('sms_message_after').disabled = !this.checked;
            document.getElementById('message_dropdown_1').disabled = !this.checked;
        };

        function addTextSubject3(sel) {
            var text = sel.options[sel.selectedIndex].value;
            var x = document.getElementById("subject_after").value;
            document.getElementById("subject_after").value += text;
        }

        function addTextSubject4(sel){
            var text = sel.options[sel.selectedIndex].value;
            var x = document.getElementById("email_message_after").value;
            document.getElementById("email_message_after").value += text;
        }

        function addTextSubject5(sel){
            var text = sel.options[sel.selectedIndex].value;
            var x = document.getElementById("sms_message_after").value;
            document.getElementById("sms_message_after").value += text;
        }

    </script>

    @endsection
