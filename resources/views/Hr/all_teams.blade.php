@extends('partials.main')
@section('style')
<style type="text/css">
   .avatar {
  border: 0.3rem solid rgba(#fff, 0.3);
  margin-top: -3rem;
  margin-bottom: 1rem;
  max-width: 5rem;
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
                    <div> Teams 
                    </div>
                </div>
            </div>

        </div>            
       <div class="container">
            <div class="row" style="margin-top:8%;" >
                @foreach ($teams as $team)
                    {{-- @if(isset($usr->Hr_account_settings) && !empty($usr->Hr_account_settings)) --}}
                        <div class="col-12 col-sm-8 col-md-6 col-lg-3" style="margin-bottom:12%;"  id="tid{{$team->id}}">
                            <div class="card" style="height:100%">
                                <div class="card-body text-center">
                                        <img class="avatar rounded-circle" src="{{asset('sample-team-photo.svg')}}" alt="Avatar">
                                        <h4 class="card-title mt-2">{{$team->name}}</h4>
                                        <h6 class="card-subtitle mb-2 text-muted"></h6>
                                        <p class="card-text">
                                            {{ count($team->User) }} Employees
                                        </p>             
                                        <a href="{{ route('hr.edit_team',[$team->id]) }}" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a> 
                                        <a href="#" class="btn btn-outline-danger" onclick="delete_team({{$team->id}})"><i class="fas fa-trash"></i></a>
                                    {{-- <a href="#" class="btn btn-outline-info"><i class="fas fa-trash"></i></a> --}}

                                </div>
                            </div>
                        </div>
                    {{-- @endif --}}
                @endforeach

            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
<script>
    function delete_team(val)
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
                        del_team(val);
                    }
                },
                close: function () {
                }
            }
        });
    }
    function del_team(id){
        console.log(id);
        CSRF_TOKEN  = "{{ csrf_token() }}";
        $.ajax({
            type: "POST",
            url: "{{route('hr.delete_team')}}",
            data: {tid: id, _token: CSRF_TOKEN},
            success: function (data) {
                if(data['success']==="true")
                {
                    $("#tid"+data['id']).remove();
                    notif({
                        msg: "<b>Success : </b>Team with Id "+data['id']+" deleted successfully",
                        type: "success"
                    });
                }
                else if(data['success']==="false")
                {
                    notif({
                        msg: "<b>{{trans('clients.error')}}!</b>Team with id: "+data['id']+"not found",
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