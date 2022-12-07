@extends('partials.main')
<style>
    .span3{
        width: 23.076923076923077%;
    }
    .infographic-box.colored {
        border: 0 none !important;
        color: #fff;

    }
    .main-box {
        background: none repeat scroll 0 0 padding-box #ffffff;
        border-radius: 3px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
        margin-bottom: 16px;
    }
    .infographic-box {
        padding: 15px;
    }
    .red-bg {
        background-color: #3f6ad8 !important;
    }
    .boldTitle{
        font-weight: bold;
    }
    .openmodal{
        text-decoration:underline;
        color:blue;
    }
    p.gfg {
        word-break: break-all;
        padding-top: 10px;
    }
</style>
@section('content')
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="fas fa-envelope-open-text icon-gradient bg-tempting-azure">
                            </i>
                        </div>
                        <div>{{trans('sms.sms_listAll')}}
                        </div>
                    </div>
                </div>
            </div>
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
            <div class="main-card mb-3 card">
                <div class="row" style="margin:10px;">
                    <div class="span3"  style="margin:10px;">
                        <div class="main-box infographic-box colored red-bg">
                            <i class="fa fa-bullseye" style="font-size:65px;"></i>
                            <span class="headline" style="float:right;"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">SMS's Sent </font></font><br><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Yesterday / Today</font></font></span></br>
                            <span class="value" style="float:right;"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><strong>{{$yesterday}}/{{$today}} </strong></font></font></span>
                            <br><br>
                        </div>
                    </div>

                    <div class="span3" style="margin:10px;">
                        <div class="main-box infographic-box colored red-bg">
                            <i class="fa fa-money-bill" style="font-size:65px;"></i>
                            <span class="headline" style="float:right;"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Cost SMS Rate</font></font></span>
                            <br>
                            <span class="value" style="float:right;"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">€ 0.04000</font></font></span>
                            <br><br>
                        </div>
                    </div>
                    <div class="span3" style="margin:10px;">
                        <div class="main-box infographic-box colored red-bg">
                            <i class="fa fa-credit-card" style="font-size:65px;"></i>
                            <span class="headline" style="float:right;"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Balance</font></font><br>&nbsp;</span></br>
                            <span class="value" style="float:right;"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><strong>€ {{isset(Auth::user()->AccountSettings->in_app_credit) ? Auth::user()->AccountSettings->in_app_credit : "0.0"}}</strong></font></font></span>
                            <br>
                            <!--<a href="https://sms4you.pt/painel.php?q=carregamento-conta" style="color:#FFFFFF;float:right;"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">[Account upload]</font></font></a>-->
                            <br>
                        </div>
                    </div>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <form class="form-horizontal" method="POST" action="{{ route('sms.listAll') }}">
                            {{ csrf_field() }}
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="position-relative form-group"><label for="invoice_due" class="">{{trans('sms.filter')}}</label></div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="input-group mb-3">
                                            <select class="form-control-sm form-control" name="filter" id="filter">
                                                <option @if($filter == "today") selected @endif value="today">{{trans('sms.today')}} ( {{  now()->format('d-m-Y') }} )</option>
                                                <option @if($filter == "yesterday") selected @endif value="yesterday">{{trans('sms.yesterday')}} ( {{ Carbon\Carbon::yesterday()->format('d-m-Y') }} )</option>
                                                <option @if($filter == "this_week") selected @endif value="this_week">{{trans('sms.this_week')}} ( {{ Carbon\Carbon::now()->startOfWeek()->format('d-m-Y') }} to {{Carbon\Carbon::now()->endOfWeek()->format('d-m-Y' )}})</option>
                                                <option @if($filter == "last_week") selected @endif value="last_week">{{trans('sms.last_week')}} ( {{  Carbon\Carbon::today()->startOfWeek()->subWeek()->format('d-m-Y') }} to {{Carbon\Carbon::today()->startOfWeek()->format('d-m-Y')}} )</option>
                                                <option @if($filter == "this_month") selected @endif value="this_month">{{trans('sms.this_month')}} ( {{  Carbon\Carbon::now('m')->startOfMonth()->format('m-Y') }} )</option>
                                                <option @if($filter == "last_month") selected @endif value="last_month">{{trans('sms.last_month')}} ( {{  Carbon\Carbon::now('m')->subMonth()->startOfMonth()->format('m-Y') }} )</option>
                                                <option @if($filter == "before_last_month") selected @endif value="before_last_month">{{trans('sms.before_last_month')}} ( {{  Carbon\Carbon::now('m')->subMonth(2)->startOfMonth()->format('m-Y') }} )</option>
                                                <option @if($filter == "last_qarter") selected @endif value="last_qarter">{{trans('sms.last_qarter')}} ( {{  Carbon\Carbon::now('m')->subMonth(3)->startOfMonth()->format('d-m-Y') }} to {{Carbon\Carbon::now('m')->endOfMonth()->format('d-m-Y')}} )</option>
                                                <option @if($filter == "last_half") selected @endif value="last_half">{{trans('sms.last_half')}} ( {{  Carbon\Carbon::now('m')->subMonth(6)->startOfMonth()->format('d-m-Y') }} to {{Carbon\Carbon::now('m')->endOfMonth()->format('d-m-Y')}} )</option>
                                                <option @if($filter == "this_year") selected @endif value="this_year">{{trans('sms.this_year')}} ( {{  Carbon\Carbon::now('m')->startOfYear()->format('Y') }} )</option>
                                                <option @if($filter == "last_year") selected @endif value="last_year">{{trans('sms.last_year')}} ( {{  Carbon\Carbon::now('m')->subYear()->startOfYear()->format('Y') }} )</option>
                                                <option @if($filter == "select_date") selected @endif value="select_date">{{trans('sms.select_date')}}</option>
                                                <option @if($filter == "all") selected @endif value="all">{{trans('sms.all')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="select_date" @if($filter != "select_date")style="display: none;" @endif>
                                    <div class="col-md-10">
                                        <label>{{trans('sms.start_date')}}</label>
                                        <input type="date" name="start_date" style="width: 100%;" value="{{$start_date}}">
                                    </div>
                                    <div class="col-md-10">
                                        <label>{{trans('sms.end_date')}}</label>
                                        <input type="date" name="end_date" style="width: 100%;" value="{{$end_date}}">
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-4">
                                        <button type="submit" class="mt-2 btn btn-success">{{trans('sms.Update_filter')}}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table style="width: 100%;" id="example-ter" class="table table-hover table-striped table-bordered" >
                        <thead>
                        <tr>
                            <th>{{trans('sms.sms_id')}}</th>
                            @if ( in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                                <th>{{trans('sms.client_id')}}</th>
                            @endif
                            @if ( in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                                <th>{{trans('sms.client')}}</th>
                            @endif
                            @if ( in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                                <th>{{trans('sms.provider')}}</th>
                            @endif
                            @if ( in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                                <th>{{trans('sms.channel')}}</th>
                            @endif
                            <th>{{trans('sms.sender')}}</th>
                            <th>{{trans('sms.mobile_num')}}</th>
                            <th>{{trans('sms.state')}}</th>
                            <th>{{trans('sms.date')}}</th>
                            <th>{{trans('sms.hours')}}</th>
                            <th>{{trans('sms.cost_charged')}}</th>
                            @if ( in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                                <th>{{trans('sms.commission_cost')}}</th>
                            @endif
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

<head>
    <style type="text/css" href="//cdn.datatables.net/v/bs4/dt-1.10.21/af-2.3.5/b-1.6.3/datatables.min.css"/></style>
</head>
@section('javascript')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/v/bs4/dt-1.10.21/af-2.3.5/b-1.6.3/datatables.min.js"></script>
    <script>

        $(document).ready(function(){

            $('#patchedDiv').css("display","unset");

            $("#filter").change(function() {
                if($(this).val() == 'select_date'){

                    $("#select_date").css('display', 'block');

                }else{
                    $("#select_date").css('display', 'none');
                }
            });
            var APP_URL = {!! json_encode(url('/')) !!}
            $('#example-ter').DataTable(
                {
                    "order": [],
                    "dom": "<'top'<'row'<'col-sm-6'l><'col-sm-6'f>>>rt<'bottom'<'row'<'col-sm-6'i><'col-sm-6'p>>>",
                    "processing": true,

                    "serverSide": true,

                    "ajax":{

                        "url": "{{ route( 'sms.listAllajax') }}",

                        "dataType": "json",

                        "type": "POST",

                        "data":{ _token: "{{csrf_token()}}",route:'listAllajax' , filter : $("#filter :selected").val(),		start_date : $("input[name='start_date']").val(), end_date : $("input[name='end_date']").val()}

                    },

                    "columns": [

                        { "data": 'id' },
                            @if ( in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                        { "data": 'clientid' },
                            @endif
                        { "data": 'name' },
                        { "data": 'provider_name'},
                        { "data": 'channel'},
                        { "data": 'sender'},
                        { "data": 'mobile_num'},
                        { "data": 'state',
                            "render": function(data, type, row, meta){
                                if(type === 'display'){
                                    if (row['delivery'] === 'pending')
                                    {
                                        data = row['state'] +' &nbsp; <i style="color:orange;" class="fas fa-clock"></i>';
                                    }
                                }
                                return data;
                            }
                        },
                        { "data": 'date'},
                        { "data": 'hours'},
                        { "data": 'cost_charged'},
                        { "data": 'cost_commission'}

                    ],

                    aoColumnDefs: [

                        {
                            bSortable: false,

                            aTargets: [ -1,-2,-3 ]

                        }

                    ]
                });
        });
    </script>


    <script>

        $(document).ready(function(){
            $('.userinfo').click(function(){
                var mobileNum = $(this).val();
                var sms_id = $("#current_sms_id_in_modal").val();
                // var userid = $(this).data('id');
                $.ajax({
                    url: 'ez4u/'+sms_id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response){
                        var returnedData = JSON.stringify(response, null, 2);
                        $('#status_values_modal').html("<pre style = 'margin-right:10em'>"+"<span>"+returnedData+"<span>");
                    }
                });
            });
        });


        function loadData(sms_id){
            var request = new XMLHttpRequest();

            request.open("GET", "getModel?id="+sms_id);

            request.onreadystatechange = function() {
                if(this.readyState === 4 && this.status === 200) {
                    var jsonResponse = JSON.parse(this.responseText);
                    //var sms = JSON.parse(this.responseText);
                    $("#sms_sender_modal").text(jsonResponse.data[0].sendername);
                    $("#sms_mobile_num").text(jsonResponse.data[0].mobile_num);
                    $("#sms_message").html("<p class='gfg'>"+jsonResponse.data[0].message+"</p>");
                    $("#sms_date").text(jsonResponse.data[0].sms_date);
                    $("#sms_admin_comment").text(jsonResponse.data[0].add_comment);
                    $("#sms_provider").text(jsonResponse.data[0].provider_name);
                    $("#sms_send_date").text(jsonResponse.data[0].send_date);
                    $("#sms_operator").text(jsonResponse.data[0].provider_sms_id);
                    $("#current_sms_id_in_modal").val(jsonResponse.data[0].provider_sms_id);
                    $("#status_values_modal").html("");
                    $("#myModaltest").modal("toggle");
                    $("#sms_state").html(jsonResponse.data[0].state);
                    if(jsonResponse.data[0].paid_check === "pending")
                    {
                        $("#sms_state").append(' &nbsp; <i style="color:orange;" class="fas fa-clock"></i>');
                    }
                    console.log(jsonResponse);
                }
            };

            request.send();
        }

    </script>



    <div class="modal " id="myModaltest">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{trans('sms.sms_details')}}</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="body_id">
                    <table style="width: 100%" cellpadding="3">
                        <tr>
                            <td class="boldTitle">{{trans('sms.sender')}}</td>
                            <td id="sms_sender_modal"></td>
                        </tr>
                        <tr>
                            <td class="boldTitle">{{trans('sms.mobile_num')}}</td>
                            <td id="sms_mobile_num"></td>
                        </tr>
                        <tr>
                            <td class="boldTitle">{{trans('sms.Message')}}</td>
                            <td id="sms_message"></td>
                        </tr>
                        <tr>
                            <td class="boldTitle">{{trans('sms.date')}}</td>
                            <td id="sms_date"></td>
                        </tr>
                        <tr>

                            <td class="boldTitle">{{trans('sms.admin_comment')}}</td>
                            <td id="sms_admin_comment"> </td>

                        </tr>
                        <tr>

                            <td class="boldTitle">{{trans('sms.sms_provider')}}</td>
                            <td id="sms_provider"></td>

                        </tr>
                        <tr>

                            <td class="boldTitle"></td>
                            <td></td>

                        </tr>
                        <tr>

                            <td class="boldTitle">{{trans('sms.state')}}</td>
                            <td id="sms_state"></td>

                        </tr>
                        <tr>

                        <tr>

                            <td class="boldTitle">{{trans('sms.send_date')}}</td>
                            <td id="sms_send_date"></td>

                        </tr>
                        <tr>

                            <td class="boldTitle">{{trans('sms.id_sms_operator')}}</td>
                            <td id="sms_operator"></td>
                            <td>
                                <button type="submit"  class="mt-2 btn btn-success userinfo">{{trans('sms.check_status')}}</button>
                                <input type="hidden" id="current_sms_id_in_modal">
                            </td>

                        </tr>
                    </table>
                </div>
                <div class="modal-footer" id="status_values_modal">

                </div>

                <div class="modal-footer" >
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection