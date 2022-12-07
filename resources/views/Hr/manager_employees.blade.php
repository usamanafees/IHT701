@extends('partials.main')
@section('style')
<style type="text/css">
   .avatar {
  border: 0.3rem solid rgba(#fff, 0.3);
  margin-top: -6rem;
  margin-bottom: 1rem;
  max-width: 7rem;
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
                    <div> Manager Employees 
                    </div>
                </div>
            </div>

        </div>            
       <div class="container">
            <div class="row" style="margin-top:8%;" >
                @if(count($users) > 0)
                    @foreach ($users as $usr)
                    
                        @if(isset($usr->Hr_account_settings) && !empty($usr->Hr_account_settings))
                            <div class="col-12 col-sm-8 col-md-6 col-lg-3" id="uid{{$usr->id}}">
                                <div class="card">
                                    <div class="card-body text-center">
                                            <img class="avatar rounded-circle" src="{{asset('img_avatar.png')}}" alt="Avatar">
                                            <h4 class="card-title mt-2">{{$usr->name}}</h4>
                                            <h6 class="card-subtitle mb-2 text-muted"></h6>
                                            <p class="card-text">
                                        </p>             
                                        @if ($usr->Hr_account_settings->accepted == 0)
                                            <a href="#" class="btn btn-outline-info ">Pending</a>
                                        @endif
                                            <a href="#" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                            <a href="#" class="btn btn-outline-danger" onclick="delete_employee({{$usr->id}})"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    No employees to show
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script>
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