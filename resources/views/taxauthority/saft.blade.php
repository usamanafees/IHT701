@extends('partials.main')

@section('content')
    <style>

        /* Important part */
        .modal-dialog{
            overflow-y: initial !important
        }
        .modal-body{
            height: 20vh;
            overflow-y: auto;
        }
    </style>
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
                    <a class="breadcrumb-item active" href="">SAFT-T PT</a>
                </li>
            </div>

            <div class="app-page-title">
                @if (\Session::has('success'))
                <div class="alert alert-success">
                    <p>
                        {!! \Session::get('success') !!}
                    </p>
                </div>
                 @endif
                <div class="page-title-wrapper">
                    
                    <div class="page-title-heading">
                      
                        <div class="page-title-icon">
                            <i class="fas fa-file-download icon-gradient bg-tempting-azure">
                            </i>
                        </div>
                        <div>SAF-T PT
                        </div>
                    </div>
                    
                    <div class="page-title-actions">
                        <div class=" dropdown ">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                                <i class="fas fa-clock fa-lg"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{trans('saft.schedule')}}
                            </button>
                        </div>
                    </div>
                </div><br>
                <div class="card-header-title font-size-sm font-weight-normal" style="float: left;color: grey;">
                         <i class="fas fa-info-circle"></i>
                            <h7> {{trans('tips.saf_t_pt')}}</h7>
                        </div>
            </div>
            <div class="main-card mb-3 card">
                <form method="get" action="{{route('tax-authority.saf-t-download')}}">
                <div class="card-body justify-content-center" >
                    <div class="mt-5 text-left content-checkbox">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="option1" name="options" value="month" class="custom-control-input" onclick="changeCheckboxDate()" checked>
                            <label class="custom-control-label" for="option1">{{trans('saft.month')}}:&nbsp;</label>
                            <select name="dropdownMonth" id="dropdownMonth">
                                <option value='1'>{{trans('saft.january')}}</option>
                                <option value='2'>{{trans('saft.february')}}</option>
                                <option value='3'>{{trans('saft.march')}}</option>
                                <option value='4'>{{trans('saft.april')}}</option>
                                <option value='5'>{{trans('saft.may')}}</option>
                                <option value='6'>{{trans('saft.june')}}</option>
                                <option value='7'>{{trans('saft.july')}}</option>
                                <option value='8'>{{trans('saft.august')}}</option>
                                <option value='9'>{{trans('saft.september')}}</option>
                                <option value='10'>{{trans('saft.october')}}</option>
                                <option value='11'>{{trans('saft.november')}}</option>
                                <option value='12'>{{trans('saft.december')}}</option>
                            </select>
                            <?php
                            $currently_selected = date('Y');
                            $earliest_year = 2020;
                            $latest_year = date('Y');
                            print '<select id="dropdownYear" Name="dropdownYear">';
                            foreach ( range( $latest_year, $earliest_year ) as $i ) {
                                print '<option value="'.$i.'"'.($i === $currently_selected ? ' selected="selected"' : '').'>'.$i.'</option>';
                            }
                            print '</select>';
                            ?>
                        </div>
                        <br>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="option2" name="options" value="date" class="custom-control-input" onclick="changeCheckboxDate()">
                            <label class="custom-control-label" for="option2"></label>
                            <label for="start_date">{{trans('saft.start_date')}}:&nbsp;</label>
                            <input type="date" id="start_date" name="start_date" disabled>
                            <label for="end_date">{{trans('saft.end_date')}}:&nbsp;</label>
                            <input type="date" id="end_date" name="end_date" disabled>
                            <!--<div class="card-body justify-content-center">
                                <a href="{{ asset('files/SAFT-PT.xml') }}" class="btn btn-success" download>Download</a>
                            </div>-->
                            <div class="card-body justify-content-left">
                                <div style="text-align: right">
                                <button type="submit" class="btn btn-success">{{trans('saft.export')}}</button>
                            </div>
                        </div>

                    </div>
                </div>
                </div>
                </form>
            </div>
        </div>
    </div>

            @endsection

            <!-- Modal -->
                <div class="modal fade" style="" id="exampleModal" tabindex="-2" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" >
                        <div class="modal-content" style="overflow:hidden;">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">SAFT Schedule</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="modal-body" >
                                <form action="{{route('tax-authority.saft-schedule')}}" method="POST">
                                    {{ csrf_field() }}
                                    <label for="check_schedule">Schedule &nbsp;<input type="checkbox"  id="check_schedule" name="check_schedule"
                                        @if(Auth::user()->saft_schedule == 1)
                                            checked = "checked"
                                        @endif
                                        ></label><br>
                                    <input type="hidden" name="uid" value="{{ Auth::user()->id}}"/>
                                    {{-- <label for="date_schedule">Date:</label>
                                    <input type="date" id="date_schedule" name="date_schedule" placeholder="">
                                    <label for=time_schedule>Hours:</label>
                                    <div style=" background-color: white;display: inline-flex;border: 1px solid #ccc;color: #555;">
                                        <input type="number" name="hours_schedule" id="hours_schedule" min="0" max="23" style="border: none;color: #555;text-align: center;width: 35px;">:
                                        <input type="number" name="minutes_schedule" id="minutes_schedule" min="0" max="59" style="border: none;color: #555;text-align: center;width: 35px;">
                                    </div> --}}
                                    <!--<input type="time" id="time_schedule" name="time_schedule" required>--><br>
                                    <button type="submit" class="btn btn-success">Save</button>
                                </form>
                            </div>
                            <div class="modal-footer" >
                                <span id="er_msg" class="align-self-center"></span>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <div id="imp"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    var today = new Date();
                    var dd = today.getDate();
                    var mm = today.getMonth()+1;
                    var yyyy = today.getFullYear();
                    if(dd<10){
                        dd='0'+dd
                    }
                    if(mm<10){
                        mm='0'+mm
                    }
                    today = yyyy+'-'+mm+'-'+dd;
                    //document.getElementById("date_schedule").setAttribute("min", today);

                    document.querySelectorAll('input[type=number]')
                        .forEach(e => e.oninput = () => {
                            if (e.value.length >= 2) e.value = e.value.slice(0, 2);
                            if (e.value.length === 1) e.value = '0' + e.value;
                            if (!e.value) e.value = '00';
                        });

                    // document.getElementById("date_schedule").addEventListener("change", function() {
                    //     var input = this.value;
                    //     var dateEntered = new Date(input);
                    //     var today_date = new Date();
                    //     var today_hours = today_date.getHours();
                    //     if(dateEntered.setHours(0,0,0,0) === today_date.setHours(0,0,0,0)){
                    //         document.getElementById("hours_schedule").setAttribute("min", today_hours);
                    //     }
                    //     else {
                    //         document.getElementById("hours_schedule").setAttribute("min",0);
                    //     }
                    // });

                    // document.getElementById("hours_schedule").addEventListener("change", function() {
                    //     var input = this.value;
                    //     var today_date = new Date();
                    //     var today_hours = today_date.getHours();
                    //     var today_minutes = today_date.getMinutes();
                    //     if(input == today_hours){
                    //         document.getElementById("minutes_schedule").setAttribute("min", today_minutes);
                    //     }else{
                    //         document.getElementById("minutes_schedule").setAttribute("min", 0);
                    //     }
                    // });

                    // if(document.getElementById("check_schedule").checked){
                    //     document.getElementById("date_schedule").disabled=this.checked;
                    //     document.getElementById("hours_schedule").disabled=this.checked;
                    //     document.getElementById("minutes_schedule").disabled=this.checked;
                    // }else{
                    //     document.getElementById("date_schedule").disabled=!this.checked;
                    //     document.getElementById("hours_schedule").disabled=!this.checked;
                    //     document.getElementById("minutes_schedule").disabled=!this.checked;
                    // }

                    function changeCheckbox(){
                        if(document.getElementById("check_schedule").checked){
                            document.getElementById("date_schedule").disabled=this.checked;
                            document.getElementById("hours_schedule").disabled=this.checked;
                            document.getElementById("minutes_schedule").disabled=this.checked;
                        }else{
                            document.getElementById("date_schedule").disabled=!this.checked;
                            document.getElementById("hours_schedule").disabled=!this.checked;
                            document.getElementById("minutes_schedule").disabled=!this.checked;
                        }
                    }

                    function changeCheckboxDate(){
                        if(document.getElementById("option1").checked){
                            document.getElementById("start_date").disabled=!this.checked;
                            document.getElementById("end_date").disabled=!this.checked;
                            document.getElementById("dropdownYear").disabled=this.checked;
                            document.getElementById("dropdownMonth").disabled=this.checked;
                        }
                        if(document.getElementById("option2").checked){
                            document.getElementById("start_date").disabled=this.checked;
                            document.getElementById("end_date").disabled=this.checked;
                            document.getElementById("dropdownYear").disabled=!this.checked;
                            document.getElementById("dropdownMonth").disabled=!this.checked;
                        }
                    }


    function changeCheckboxDate(){
        if(document.getElementById("option1").checked){
            document.getElementById("start_date").disabled=!this.checked;
            document.getElementById("end_date").disabled=!this.checked;
            document.getElementById("dropdownYear").disabled=this.checked;
            document.getElementById("dropdownMonth").disabled=this.checked;
        }
        if(document.getElementById("option2").checked){
            document.getElementById("start_date").disabled=this.checked;
            document.getElementById("end_date").disabled=this.checked;
            document.getElementById("dropdownYear").disabled=!this.checked;
            document.getElementById("dropdownMonth").disabled=!this.checked;
        }
    }

</script>
