 @extends('partials.main')

@section('content')
			<div class="app-main__outer">
                 <div class="app-main__inner">
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
                                 <a href="{{route('items')}}">{{trans('menu.items')}}</a>
                                 <i class="fa fa-angle-right">&nbsp;</i>
                             </li>
                             <li>
                                 <a class="breadcrumb-item active" href="">{{trans('items.edit_item')}}</a>
                             </li>
                         </div>
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-list icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('items.edit_item')}}
                                </div>
                            </div>
                           <!--  <div class="page-title-actions">
                                <div class="d-inline-block dropdown">
                                    <a href="{{route('clients.add')}}" class="btn-shadow btn btn-info" href="">Add Client</a>
                                </div>
                            </div>     -->
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                        	<!-- <h5 class="card-title">Grid Rows</h5> -->
                                    <form class="form-horizontal" method="POST" action="{{ route('items.update', $Item->id) }}">
                                     	{{ csrf_field() }}
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                        <label for="" class="">{{trans('items.Code')}}<font color="red"><b>*</b></font></label>
                                                    <input name="code" id="code" placeholder="Code" type="text" class="form-control"  value="{{$Item->code}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="" class="">{{trans('items.Type')}}<font color="red"><b>*</b></font></label>
                                                    <select class="form-control" name="type" type="number" required>
                                                        <option @if($Item->type == "P") selected @endif
                                                        value="P">{{trans('items.products')}}</option>
                                                        <option @if($Item->type == "S") selected @endif
                                                        value="S">{{trans('items.services')}}</option>
                                                        <option @if($Item->type == "O") selected @endif
                                                        value="O">{{trans('items.others')}}</option>
                                                        <option @if($Item->type == "E") selected @endif
                                                        value="E">{{tranh('items.excise_duties')}}</option>
                                                        <option @if($Item->type == "I") selected @endif
                                                        value="I">{{trans('items.taxes_fees_oth')}}</option>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                        <label for="" class="">{{trans('items.Price')}}<font color="red"><b>*</b></font></label>
                                                    <input name="price" id="price" placeholder="Price" type="number" class="form-control"  value="{{$Item->price}}" required step="any">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="" class="">{{trans('items.Unit')}}</label>
                                                        <select class="form-control" name="unit" type="number">
                                                         <option value="Hour" 
                                                            @if($Item->unit == "Hour") selected @endif >
                                                             {{trans('items.hour')}}</option>
                                                         <option value="Day" 
                                                            @if($Item->unit == "Day") selected @endif >
                                                             {{trans('items.day')}}</option>
                                                         <option value="Month" 
                                                            @if($Item->unit == "Month") selected @endif >
                                                             {{trans('items.month')}}</option>
                                                         <option value="Unit" 
                                                            @if($Item->unit == "Unit") selected @endif >
                                                             {{trans('items.unit')}}</option>
                                                         <option value="Service" 
                                                            @if($Item->unit == "Service") selected @endif >
                                                             {{trans('items.service')}}</option>
                                                         <option value="Other" 
                                                            @if($Item->unit == "Other") selected @endif >
                                                             {{trans('items.other')}}</option>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="description" class="">{{trans('items.description')}}<font color="red"><b>*</b></font></label>
                                                    <textarea name="description" id="description" placeholder="Description..." class="form-control" required>{{$Item->description}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="" class="">{{trans('items.Tax')}}</label>
                                                        <select class="form-control" name="tax">
                                                            @foreach($fee_list as $fee_list)
                                                            <option
                                                            @if($Item->tax == $fee_list[0]) selected @endif
                                                                value="{{ $fee_list[0] }}">{{$fee_list[0]}} - {{ $fee_list[1] }}
                                                            </option>
                                                            @endforeach
                                                            <!-- <option value="23">23.00% - IVA23</option> -->
                                                            {{-- <option value="23" 
                                                                @if($Item->tax == "23") selected @endif >
                                                                23.00% - IVA23</option>
                                                            <option value="18" 
                                                                    @if($Item->tax == "18") selected @endif 
                                                                    >18.00% - IVA18</option>
                                                            <option value="22" 
                                                                    @if($Item->tax == "22") selected @endif 
                                                                    >22.00% - IVA22</option>
                                                            <option value="0" 
                                                                    @if($Item->tax == "0") selected @endif 
                                                                    >0.00% - Isento</option> --}}
                                                        </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div style="text-align: right;">
                                       		<button type="submit" class="mt-2 btn btn-success">{{trans('items.Update')}}</button>
                                        </div>
                                    </form>
                                </div>
                    </div>
                </div>
                  
            </div>
@endsection