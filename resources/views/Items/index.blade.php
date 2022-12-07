@extends('partials.main')

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
                    <a class="breadcrumb-item active" href="">{{trans('menu.items')}}</a>
                </li>
            </div>
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="fas fa-list icon-gradient bg-tempting-azure">
                            </i>
                        </div>
                        <div>{{trans('items.Items')}}
                        </div>
                    </div>
                    @can('Create Items')
                        <div class="page-title-actions">
                            <div class="d-inline-block dropdown">
                                <a href="{{route('items.add')}}" class="btn-shadow btn btn-info" href="">
                                    <i class="fa fa-plus btn-icon-wrapper"></i> &nbsp; {{trans('items.add_item')}}</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>            <div class="main-card mb-3 card">
                <div class="card-body">
                    <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                        <thead>
                        <tr style="text-align:center">
                            {{--<th>#</th>--}}
                            <th>{{trans('items.Code')}}</th>
                            <th>{{trans('items.description')}}</th>
                            <th>{{trans('items.Type')}}</th>
                            <th>{{trans('items.Unit')}}</th>
                            <th>{{trans('items.Price')}}</th>
                            <th>{{trans('items.Tax')}}</th>
                            <th>{{trans('items.Action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($item as $items)
                            <tr  id={{'r'.$items->id }} style="text-align:center">
                                {{--<td>{{++$loop->index}}</td>--}}
                                <td>{{$items->code}}</td>
                                <td>{{$items->description}}</td>
                                <td>@if($items->type =='P')
                                        Product
                                    @elseif($items->type =='S')
                                        Service
                                    @elseif($items->type == 'O')
                                        Others
                                    @elseif($items->type == 'E')
                                        Excise duties
                                    @elseif($items->type == 'I')
                                        Taxes, fees and parafiscal charges
                                    @endif
                                </td>
                                <td>{{$items->unit}}</td>
                                <td style="text-align: left;">@php
                                            if(Session::get('locale')=='pt'){
                                                echo number_format($items->price,2,","," ")."€";
                                                    }
                                                    else{
                                                        echo number_format($items->price,2,".","")."€";
                                                    }
                                    @endphp</td>
                                <td>@php
                                        echo number_format($items->tax,2)."%";
                                    @endphp</td>
                                <td>
                                    @can('Edit Items')
                                        <div class="btn-group">
                                            <a href="{{route('items.edit',$items->id)}}" class="btn-sm btn-shadow btn btn-warning" href="">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <a href="javascript:;" onclick="del_items_confirm({{$items->id}});" class="btn-sm btn-shadow btn btn-danger" href="">
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
        function del_items_confirm(val)
        {
            $.confirm({
                title: '{{trans('items.confirm_delete')}}',
                content: '{{trans('items.confirm_delete_2')}}',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    confirm:{
                        text: '{{trans('items.yes')}}',
                        btnClass: 'btn-red',
                        action: function(){

                            del_items(val);
                        }
                    },
                    close: function () {
                    }
                }
            });
        }
        function del_items(id){

            CSRF_TOKEN  = "{{ csrf_token() }}";
            $.ajax({
                type: "POST",
                url: "{{route('items.destroy')}}",
                data: {item_id: id, _token: CSRF_TOKEN},
                success: function (data) {

                    if(data['success']==="true")
                    {
                        $("#r"+data['id']).hide();
                        notif({
                            msg: "<b>{{trans('items.sucess')}} </b>{{trans('items.item_with_id')}}  "+data['id']+" {{trans('items.sucess_deleted')}}",
                            type: "success"
                        });
                    }
                    else if(data['success']==="false")
                    {
                        notif({
                            msg: "<b>{{trans('items.error')}}! </b>{{trans('items.item_with_id')}} "+data['id']+" {{trans('items.not_exist')}}",
                            type: "error",
                            position: "center"
                        });
                    }
                },
                error:function(err){
                    notif({
                        type: "warning",
                        msg: "<b>{{trans('items.warning')}} </b>{{trans('items.went_wrong')}}!",
                        position: "left"
                    });
                }
            });
        }
    </script>
@endsection