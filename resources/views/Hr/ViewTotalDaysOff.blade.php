@extends('partials.main')
@section('content')
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

    <style>
        .tooltip {
        position: relative;
        display: inline-block;
        border-bottom: 1px dotted black;
        }

        .tooltip .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: black;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px 0;

        /* Position the tooltip */
        position: absolute;
        z-index: 1;
        }

        .tooltip:hover .tooltiptext {
        visibility: visible;
        }
    </style>
</head>

<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i  class="fas fa-users icon-gradient bg-tempting-azure">
                        </i>
                    </div>
                    <div> Calender Days Off 
                    </div>
                </div>
            </div>
        </div>   
       <div class="container">
           <div id= "calendar2" class="mb-5"></div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script> --}}
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function(){
    $.noConflict();
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });
    var calendar = $('#calendar2').fullCalendar({
        editable:true,
        themeSystem: 'bootstrap4',
        header:{
            left:'prev,next today',
            center:'title',
            right:'month,agendaWeek,agendaDay'
        },
        // eventClick: function(info,element) {
        //     console.log(element);
        //     $(element.target).addClass("tooltip");
        //     $(element.target).append('<span class="tooltiptext">Tooltip text</span>');
        //     //.tooltip({title: info.title});
        // },
        events:'{{ route("hr.calender_days_off") }}',
        selectable:true,
        selectHelper: true,
        eventDrop: function(event, delta)
        {
            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD');
            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD');
            var title = event.title;
            var id = event.id;
            $.ajax({
                url:'{{ route("hr.calender_event_action") }}',
                type:"POST",
                data:{
                    title: title,
                    start: start,
                    end: end,
                    id: id,
                    type: 'update'
                },
                success:function(response)
                {
                    calendar.fullCalendar('refetchEvents');
                    if(response['flag']==1)
                    {
                        notif({
                                msg: "<b>Success : Event updated Successfully",
                                type: "success"
                        });
                    }
                    if(response['flag']==0)
                    {
                        notif({
                        msg: "<b>Error!</b> Event does not exist",
                        type: "error",
                        position: "center"
			            });
                    }
                },
                error: function(err) {
                    notif({
                    type: "warning",
                    msg: "<b>Warning:</b> Something Went Wrong",
                    position: "left"
                    });
                }
            });
        },
        eventResize: function(event, delta)
        {
            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD');
            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD');
            var title = event.title;
            var id = event.id;
            $.ajax({
                url:'{{ route("hr.calender_event_action") }}',
                type:"POST",
                data:{
                    title: title,
                    start: start,
                    end: end,
                    id: id,
                    type: 'update'
                },
                success:function(response)
                {
                    calendar.fullCalendar('refetchEvents');
                    if(response['flag']==1)
                    {
                        notif({
                                msg: "<b>Success : Event updated Successfully",
                                type: "success"
                        });
                    }
                    if(response['flag']==0)
                    {
                        notif({
                        msg: "<b>Error!</b> Event does not exist",
                        type: "error",
                        position: "center"
			            });
                    }
                },
                error: function(err) {
                    notif({
                    type: "warning",
                    msg: "<b>Warning:</b> Something Went Wrong",
                    position: "left"
                    });
                }
            })
        },
        eventClick:function(event)
        {

            if(confirm("Are you sure you want to remove it?"))
            {   
                            var id = event.id;
                            $.ajax({
                                url:'{{ route("hr.calender_event_action") }}',
                                type:"POST",
                                data:{
                                    id:id,
                                    type:"delete"
                                },
                                success:function(response)
                                {
                                    calendar.fullCalendar('refetchEvents');
                                    if(response['flag']==1)
                                    {
                                        notif({
                                                msg: "<b>Success : Event Deleted Successfully",
                                                type: "success"
                                        });
                                    }
                                    if(response['flag']==0)
                                    {
                                        notif({
                                            msg: "<b>Error!</b> Event does not exist",
                                            type: "error",
                                            position: "center"
                                        });
                                    }
                                },
                                error: function(err) {
                                    notif({
                                        type: "warning",
                                        msg: "<b>Warning:</b> Something Went Wrong",
                                        position: "left"
                                    });
                                }
                            });
                        }
                    }
                });
            });
</script>
@endsection