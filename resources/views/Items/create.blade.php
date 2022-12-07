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
                            <a href="{{route('items')}}">{{trans('menu.items')}}</a>
                            <i class="fa fa-angle-right">&nbsp;</i>
                        </li>
                        <li>
                            <a class="breadcrumb-item active" href="">{{trans('items.add_item')}}</a>
                        </li>
                    </div>
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-list icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('items.add_item')}}
                                </div>
                            </div>
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                        	<!-- <h5 class="card-title">Grid Rows</h5> -->
                                    <form class="form-horizontal" method="POST" action="{{ route('items.store') }}">
                                     	{{ csrf_field() }}
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                		<label for="" class="">{{trans('items.Code')}}<font color="red"><b>*</b></font></label>
                                                	<input name="code" id="code" placeholder="Code..." type="text" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                		<label for="" class="">{{trans('items.Type')}}<font color="red"><b>*</b></font></label>
                                                        <select class="form-control" name="type" type="number" required>
                                                         <option value="" selected disabled>{{trans('items.Type')}}</option>
                                                         <option value="P">{{trans('items.products')}}</option>
                                                         <option value="S">{{trans('items.services')}}</option>
                                                         <option value="O">{{trans('items.others')}}</option>
                                                         <option value="E">{{trans('items.excise_duties')}}</option>
                                                         <option value="I">{{trans('items.taxes_fees_oth')}}</option>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                		<label for="" class="">{{trans('items.Price')}}<font color="red"><b>*</b></font></label>
                                                	<input name="price" id="price" placeholder="0,00" type="number" class="form-control" required step="0.01">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="" class="">{{trans('items.Unit')}}<font color="red"><b>*</b></font></label>
                                                        <select class="form-control" name="unit" type="number" required>
                                                         <option value="Hour">{{trans('items.hour')}}</option>
                                                         <option value="Day">{{trans('items.day')}}</option>
                                                         <option value="Month">{{trans('items.month')}}</option>
                                                         <option value="Unit">{{trans('items.Unit')}}</option>
                                                         <option value="Service">{{trans('items.service')}}</option>
                                                         <option value="Other">{{trans('items.other')}}</option>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="position-relative form-group">
                                                <label for="description" class="">{{trans('items.description')}}<font color="red"><b>*</b></font></label>
                                                <textarea name="description" id="description" placeholder="Description..." class="form-control" required></textarea>
                                            </div>
                                        </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                    <label for="" class="">{{trans('items.Tax')}}<font color="red"><b>*</b></font></label>
                                                        <select class="form-control" name="tax" type="number" required>
                                                            @foreach($fee_list as $fee_list)
                                                            <option
                                                                value="{{ $fee_list[0] }}">{{$fee_list[0]}} - {{ $fee_list[1] }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="text-align: right;">
                                       		<button type="submit" class="mt-2 btn btn-primary">{{trans('items.Save')}}</button>
                                        </div>
                                    </form>
                                </div>
                    </div>
                </div>
                  
            </div>
@endsection