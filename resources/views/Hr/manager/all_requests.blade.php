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
                                    <i class="fas fa-user-friends icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>Requests
                                </div>
                            </div>   
                            
                            <div class="page-title-actions">
                                <div class="d-inline-block dropdown">
                                    <a href="{{route('hr.manager.add_days_off')}}" class="btn-shadow btn btn-info" href="">
                                        <i class="fa fa-plus btn-icon-wrapper"></i> &nbsp; Add days off request</a>
                                </div>
                            </div>
                          </div>
                    </div>            <div class="main-card mb-3 card">
                        <div class="card-body">
                            <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr style="text-align: center">
                                        {{--<th>#</th>--}}
                                        <th>Type</th>
                                        <th>Employee</th>
                                        <th>Start date</th>
                                        <th>End date</th>
                                        <th>Date</th>
                                        <th>Period of Day</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($requests as $request)
                                        <tr  style="text-align:center">
                                           <td>{{$request->off_type}}</td>
                                           <td>
                                               @if(isset($request->users) && !empty(isset($request->users)))
                                                    {{$request->users->name}}
                                                @else
                                                   {{ 'Not found'}}
                                               @endif
                                            </td>
                                            <td>{{$request->start_date}}</td>
                                            <td>{{$request->end_date}}</td>
                                            <td>{{$request->date}}</td>
                                            <td>{{$request->period_of_day}}</td>
                                            <td id={{'td'.$request->id }}>
                                                @if($request->approved == 1)
                                                    <span class="text-success"> Approved </span>
                                                @endif
                                                @if($request->approved == 0)
                                                    <span class="text-warning"> Pending </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#" onclick="approve_request('{{$request->id}}','{{ $request->observation}}','{{$request->approved}}')" class="btn-shadow btn btn-warning btn-sm" href="#">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
@endsection
@section('javascript')
<script>

    function approve_request(val,obs,status)
    {
        var con = "<h5 class='mt-3'>Observation</h5>"+
                  "<p>"+obs+"</p>";
        $.confirm({
            title: 'Approve Request',
            content: con,
            type: 'orange',
            typeAnimated: true,
            buttons: {
                confirm:{
                    text: 'Approve',
                    btnClass: 'btn-warning',
                    display:'none',
                    action: function(confirm){
                        if(status == 1)
                        {
                            this.buttons.confirm.disable();
                        }else
                        {
                            approve_request_final(val);
                        }
                    }
                },
                    close: function () {
                },
            }
        });
    }
    function approve_request_final(id){

        CSRF_TOKEN  = "{{ csrf_token() }}";
        $.ajax({
            type: "POST",
            url: "{{route('hr.approve_request')}}",
            data: {rid: id, _token: CSRF_TOKEN},
            success: function (data) {

                if(data['success']==="true")
                {
                    $('#td'+id).html('<span class="text-success"> Approved </span>');
                    notif({
                        msg: "<b>Success : </b>Request with id "+data['id']+" approved successfully",
                        type: "success"
                    });
                }
                else if(data['success']==="false")
                {
                    notif({
                        msg: "<b>Request with id!</b> "+data['id']+" does not exist",
                        type: "error",
                        position: "center"
                    });
                }
            },
            error:function(err){
                notif({
                    type: "warning",
                    msg: "<b>{{trans('clients.warning')}}:</b> {{trans('clients.something_wrong')}}!",
                    position: "left"
                });
            }
        });
    }
</script>
@endsection