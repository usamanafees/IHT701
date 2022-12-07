@extends('partials.main')
@section('style')
<style type="text/css">
   .avatar {
  border: 0.3rem solid rgba(#fff, 0.3);
  margin-top: -6rem;
  margin-bottom: 1rem;
  max-width: 7rem;
}
.message_env:hover .message_envchild
{
    background:rgb(255, 255, 255);
}

</style>
@endsection
@section('content')
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fas fa-users icon-gradient bg-tempting-azure">
                        </i>
                    </div>
                    <div> Employees 
                    </div>
                </div>
            </div>

        </div>            
       <div class="container">
            <div class="row" style="margin-top:8%;" >
                @foreach ($users as $usr)
                    @if(isset($usr->Hr_account_settings) && !empty($usr->Hr_account_settings))
                        <div class="col-12 col-sm-8 col-md-6 col-lg-3" style="margin-bottom:12%;"  id="uid{{$usr->id}}">
                            <div class="card" style="height:100%">
                                <div class="card-body text-center">
                                        <img class="avatar rounded-circle" src="{{asset('img_avatar.png')}}" alt="Avatar">
                                        <h4 class="card-title mt-2">{{$usr->name}}</h4>
                                        <h6 class="card-subtitle mb-2 text-muted"></h6>
                                        <p class="card-text">
                                            {{ str_replace(array( '[', ']','"' ), '',$usr->roles()->pluck('name')) }}
                                    </p>             
                                    @if ($usr->Hr_account_settings->accepted == 0)
                                        <a style="margin-top:3px" href="{{ route('hr.resend_email.confirmation',$usr->id) }}" class="btn btn-outline-info ">Pending</a>
                                    @endif
                                        <a style="margin-top:3px" href="{{route('employee_edit.personal_data',[$usr->id])}}" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        <a style="margin-top:3px" href="#" class="btn btn-outline-danger" onclick="delete_employee({{$usr->id}})"><i class="fas fa-trash"></i></a>
                                    @if((Auth::user()->is_hr_admin == 'admin') && (in_array("Manager" , $usr->roles()->pluck('name')->toArray())))
                                        <a style="margin-top:3px" href="{{ route('hr.manager_emp',[$usr->id]) }}" class="btn btn-outline-danger" onclick=""><i class="fas fa-eye"></i></a>
                                    @endif
                                    <a style="margin-top:3px" href="{{ route('hr.employee_month_days_off',[$usr->id]) }}" class="btn btn-outline-danger" onclick=""><i class="far fa-calendar"></i></a>
                                    {{-- <a href="#" class="btn btn-outline-info"><i class="fas fa-trash"></i></a> --}}
                                    <a style="margin-top:3px" class="btn btn-outline-success message_env" onclick="send_message({{ $usr->id }})"><i  class="far fa-comment-alt text-success message_envchild "></i></i></a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script>

function send_message(uid)
{
    $.confirm({
            title: 'Send Message',
            content: '<div class="col-md-12">'+
            '<div class="position-relative form-group">'+
                '<label for="exampleName" class="">Message</label>'+
                '<textarea name="user_message"   id="user_message"  class="form-control" required></textarea>'+
                '</div>'+
            '</div>',
            type: 'green',
            typeAnimated: true,
            buttons: {
                confirm:{
                    text: 'Send',
                    btnClass: 'btn-success',
                    action: function(){
                        var message = $("#user_message").val();
                        if(message == '')
                        {
                            notif({
                            msg: "Message can not be empty",
                            type: "error",
                            position: "center"
                            }); 
                            
                        }else
                        {
                            broadcastMessage(message,uid);
                        }
                    }
                },
                close: function () {
                    
                }
            }
        });
}
function broadcastMessage(msg,uid)
{
    console.log(msg,uid);
    CSRF_TOKEN  = "{{ csrf_token() }}";
        $.ajax({
            type: "POST",
            url: "{{route('hr.broadcast_message')}}",
            data: {uid: uid,msg: msg, _token: CSRF_TOKEN},
            success: function (data) {
                if(data['success']==="true")
                {
                    notif({
                        msg: "<b>Success : </b>Message sent successfully",
                        type: "success"
                    });
                }
                else if(data['success']==="false")
                {
                    notif({
                        msg: "<b>{{trans('clients.error')}}!</b> unexpected error occured",
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

    function delete_employee(val)
    {
        $.confirm({
            title: 'Confirm delete',
            content: 'Are you sure you want to delete?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                confirm:{
                    text: 'Yes',
                    btnClass: 'btn-red',
                    action: function(){
                        del_emp(val);
                    }
                },
                close: function () {
                }
            }
        });
    }
    function del_emp(id){
        console.log(id);
        CSRF_TOKEN  = "{{ csrf_token() }}";
        $.ajax({
            type: "POST",
            url: "{{route('hr.delete_employee')}}",
            data: {uid: id, _token: CSRF_TOKEN},
            success: function (data) {
                if(data['success']==="true")
                {
                    $("#uid"+data['id']).remove();
                    notif({
                        msg: "<b>Success : </b>User with Id "+data['id']+" deleted successfully",
                        type: "success"
                    });
                }
                else if(data['success']==="false")
                {
                    notif({
                        msg: "<b>{{trans('clients.error')}}!</b>User with id "+data['id']+" {{trans('clients.not_exist')}}",
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