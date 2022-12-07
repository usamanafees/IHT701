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
                            <a class="breadcrumb-item active" href="">{{trans('menu.clients')}}</a>
                        </li>
                    </div>
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-user-friends icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('clients.clients')}}
                                </div>
                            </div>
                            @can('Create Client')
                              <div class="page-title-actions">
                                  <div class="d-inline-block dropdown">
                                      <a href="{{route('clients.add')}}" class="btn-shadow btn btn-info" href="">
                                          <i class="fa fa-plus btn-icon-wrapper"> </i>&nbsp;
                                      {{trans('clients.add_client')}}</a>
                                  </div>
                              </div>  
                             @endif    
                          </div><br>
                          <div class="card-header-title font-size-sm font-weight-normal" style="float: left;color: grey;">
                         <i class="fas fa-info-circle"></i>
                            <h7> {{trans('tips.clients')}}</h7>
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                <thead>
                                <tr style="text-align: center">
                                    {{--<th>#</th>--}}
                                    <th>{{trans('clients.Name')}}</th>
                                    <th>{{trans('clients.VAT_Number')}}</th>
                                    <th>{{trans('clients.Country')}}</th>
                                    {{--<th>{{trans('clients.Main_URL')}}</th>--}}
                                    <th>{{trans('clients.action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($client as $clients)
                                        <tr  id={{'r'.$clients->id }} style="text-align:center">
                                           {{--<td>{{++$loop->index}}</td>--}}
                                           <td>{{$clients->name}}</td>
                                           <td>{{$clients->vat_number}}</td>
                                           <td>{{$clients->country}}</td>
                                           {{--<td>
                                                <a target="_blank" href="{{$clients->main_url}}">{{$clients->main_url}}</a> 
                                                
                                           </td>--}}
                                           <td>
                                            @can('Edit Client')
                                              <div class="btn-group">
                                                 <a href="{{route('clients.edit',$clients->id)}}" class="btn-shadow btn btn-warning btn-sm" href="">
                                                     <i class="fas fa-pen"></i>
                                                 </a>
                                                 <a  href="javascript:;" onclick="del_client_confirm({{$clients->id}});" class="btn-shadow btn btn-danger btn-sm" href="">
                                                     <i class="fas fa-trash"></i>
                                                 </a>
                                              </div>
                                           @endif  
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
    function del_client_confirm(val)
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

                        del_client(val);
                    }
                },
                close: function () {
                }
            }
        });
    }
    function del_client(id){

        CSRF_TOKEN  = "{{ csrf_token() }}";
        $.ajax({
            type: "POST",
            url: "{{route('clients.destroy')}}",
            data: {client_id: id, _token: CSRF_TOKEN},
            success: function (data) {

                if(data['success']==="true")
                {
                    $("#r"+data['id']).hide();
                    notif({
                        msg: "<b>Success : </b>{{trans('clients.client_with_id')}} "+data['id']+" {{trans('clients.deleted_sucess')}}",
                        type: "success"
                    });
                }
                else if(data['success']==="false")
                {
                    notif({
                        msg: "<b>{{trans('clients.error')}}!</b>{{trans('clients.client_with_id')}} "+data['id']+" {{trans('clients.not_exist')}}",
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