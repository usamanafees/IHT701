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
                                <a href="{{route('clients')}}">{{trans('menu.clients')}}</a>
                                <i class="fa fa-angle-right">&nbsp;</i>
                            </li>
                            <li>
                                <a class="breadcrumb-item active" href="">{{trans('clients.edit_client')}}</a>
                            </li>
                        </div>
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-user-friends icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('clients.edit_client')}}
                                </div>
                            </div>
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
                         <div class="card-body" style="background-color: #cad3d8;">
                            <h3><b>{{trans('clients.edit_client')}}</b></h3>
                            <div style="text-align: right;">
                                <h8>{{trans('clients.require_filds')}}<font color="red">*</font></h8>
                            </div>
                        </div>
                        <form class="form-horizontal" method="POST" action="{{ route('clients.update', $client->id) }}">
                            {{ csrf_field() }}
                            <div class="card-body" style="background-color: #f7f9fa;">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                                <label for="" class="">{{trans('clients.Name')}}<font color="red"><b>*</b></font></label>
                                            <input name="name" id="" placeholder="{{trans('clients.Name')}}" type="text" class="form-control"  value="{{$client->name}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                                <label for="" class="">{{trans('clients.email')}}<font color="red"><b>*</b></font></label>
                                            <input name="email" id="" placeholder="{{trans('clients.email')}}" type="email" class="form-control"  value="{{$client->email}}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="" class="">{{trans('clients.VAT_Number')}}<font color="red"><b>*</b></font></label>
                                            <input name="vat_number" id="" placeholder="{{trans('clients.VAT_Number')}}" type="text" class="form-control"  value="{{$client->vat_number}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="" class="">{{trans('clients.Main_URL')}}</label>
                                            <input name="main_url" id="" placeholder="{{trans('clients.Main_URL')}}" type="url" class="form-control"  value="{{$client->main_url}}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="" class="">{{trans('clients.code')}}<font color="red"><b>*</b></font></label>
                                            <input name="code" id="" placeholder="{{trans('clients.code')}}" type="text" class="form-control"  value="{{$client->code}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="" class="">{{trans('clients.postal_code')}}<font color="red"><b>*</b></font></label>
                                            <input name="postal_code" id="" placeholder="{{trans('clients.postal_code')}}" type="text" class="form-control"  value="{{$client->postal_code}}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="" class="">{{trans('clients.address')}}<font color="red"><b>*</b></font></label>
                                            <input name="address" id="" placeholder="{{trans('clients.address')}}" type="text" class="form-control"  value="{{$client->address}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="" class="">{{trans('clients.city')}}<font color="red"><b>*</b></font></label>
                                            <input name="city" id="" placeholder="{{trans('clients.city')}}" type="text" class="form-control"  value="{{$client->city}}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="" class="">{{trans('clients.telephone')}}</label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <select class="select2 form-control" name="telephone_Code">
                                                        <option value="" selected disabled> Select Code </option>
                                                        @foreach($countries as $country)
                                                        <option 
                                                        @if($telephone['0'] == $country->isd_code) selected @endif value="{{$country->isd_code}}">+{{$country->isd_code}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="position-relative form-group">
                                                        <input style="height: 30px;" name="telephone" id="" placeholder="{{trans('clients.telephone')}}..." type="number" class="form-control"
                                                        value="{{$telephone['1']}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="" class="">{{trans('clients.mobile')}}</label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <select class="select2 form-control" name="mobile_Code">
                                                        <option value="" selected disabled> Select Code </option>
                                                        @foreach($countries as $country)
                                                        <option
                                                        @if($mobile['0'] == $country->isd_code) selected @endif  
                                                        value="{{$country->isd_code}}">+{{$country->isd_code}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="position-relative form-group">
                                                        <input style="height: 30px;" name="mobile" id="" placeholder="{{trans('clients.mobile')}}..." type="number" class="form-control"
                                                        value="{{$mobile['1']}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                        <div class="col-6">
                                            <div class="position-relative form-group">
                                                    <label for="" class="">{{trans('clients.Country')}}<font color="red">*</font></label>
                                                <select class="select2 form-control" name="country" required>
                                                    <option value="" selected disabled> {{trans('clients.Country')}} </option>
                                                    @foreach($countries as $country)
                                                    <option
                                                    @if($client->country == $country->iso_code) selected @endif
                                                    value ="{{$country->iso_code}}">{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    <div class="col-6">
                                        @if(isset($fee_list) && !empty($fee_list))
                                            
                                                <div class="position-relative form-group">
                                                        <label for="" class="">{{trans('clients.fee_list')}}</label>
                                                    <select class="select2 form-control" name="fee">
                                                        <option value="" selected disabled> {{trans('clients.select_fee')}} </option>
                                                        @foreach($fee_list as $fee_list)
                                                        <option
                                                        @if($client->default_fee == $fee_list[1]) selected @endif
                                                            value="{{ $fee_list[1] }}">{{$fee_list[0]}} - {{ $fee_list[1] }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row">
                          
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="" class="">Vat Exemption Reason</label>
                                                <select class="select2 form-control" name="vatexpn" id="vatexpn">
                                                    <option value="" selected disabled>Select Tax Exemption Reason</option>
                                                    <option value="M09" @if($client->vat_exemption == "M09") selected @endif>IVA ‐ não confere direito a dedução.</option>
                                                    <option value="M08" @if($client->vat_exemption == "M08") selected @endif>IVA – autoliquidação.</option>
                                                    <option value="M07" @if($client->vat_exemption == "M07") selected @endif>Isento Artigo 9º do CIVA.</option>
                                                    <option value="M06" @if($client->vat_exemption == "M06") selected @endif>Isento Artigo 15º do CIVA.</option>
                                                    <option value="M05" @if($client->vat_exemption == "M05") selected @endif>Isento Artigo 14º do CIVA.</option>
                                                    <option value="M04" @if($client->vat_exemption == "M04") selected @endif>Isento Artigo 13º do CIVA.</option>
                                                    <option value="M03" @if($client->vat_exemption == "M03") selected @endif>Exigibilidade de caixa.</option>
                                                    <option value="M02" @if($client->vat_exemption == "M02") selected @endif>Artigo 6º do Decreto‐Lei nº 198/90, de 19 de Junho.</option>
                                                    <option value="M01" @if($client->vat_exemption == "M01") selected @endif>Artigo 16º nº 6 do CIVA.</option>
                                                    <option value="M16" @if($client->vat_exemption == "M16") selected @endif>Isento Artigo 14º do RITI.</option>
                                                    <option value="M15" @if($client->vat_exemption == "M15") selected @endif>Regime da margem de lucro–Objetos de coleção e antiguidades.</option>
                                                    <option value="M14" @if($client->vat_exemption == "M14") selected @endif>Regime da margem de lucro – Objetos de arte.</option>
                                                    <option value="M13" @if($client->vat_exemption == "M13") selected @endif>Regime da margem de lucro – Bens em segunda mão.</option>
                                                    <option value="M12" @if($client->vat_exemption == "M12") selected @endif>Regime da margem de lucro – Agências de viagens.</option>
                                                    <option value="M11" @if($client->vat_exemption == "M11") selected @endif>Regime particular do tabaco.</option>
                                                    <option value="M10" @if($client->vat_exemption == "M10") selected @endif>IVA – Regime de isenção.</option>
                                                    <option value="M99" @if($client->vat_exemption == "M99") selected @endif>Não sujeito; não tributado (ou similar).</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <h4>{{trans('clients.primary_contact')}}</h4>
                                <hr>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="" class="">{{trans('clients.Name')}}</label>
                                            <input class="form-control" type="text" name="primary_name" placeholder="{{trans('clients.Name')}}" value="{{$client->primary_name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="" class="">{{trans('clients.mobile')}}</label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <select class="select2 form-control" name="primary_mobile_code">
                                                        <option value="" selected disabled> Select Code </option>
                                                        @foreach($countries as $country)
                                                        <option 
                                                         @if($primary_mobile['0'] == $country->isd_code) selected @endif  
                                                        value="{{$country->isd_code}}">+{{$country->isd_code}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="position-relative form-group">
                                                        <input style="height: 30px;" name="primary_mobile" id="" placeholder="{{trans('clients.mobile')}}..." type="text" class="form-control"  value="{{$primary_mobile['1']}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="" class="">{{trans('clients.email')}}</label>
                                            <input class="form-control" type="email" name="primary_email" placeholder="{{trans('clients.email')}}" value="{{$client->primary_email}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="" class="">{{trans('clients.telephone')}}</label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <select class="select2 form-control" name="primary_telephone_code">
                                                        <option value="" selected disabled> {{trans('clients.code')}} </option>
                                                        @foreach($countries as $country)
                                                        <option 
                                                        @if($primary_telephone['0'] == $country->isd_code) selected @endif  
                                                        value="{{$country->isd_code}}">+{{$country->isd_code}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="position-relative form-group">
                                                        <input style="height: 30px;" name="primary_telephone" id="" placeholder="{{trans('clients.telephone')}}..." type="text" class="form-control"  value="{{$primary_telephone['1']}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div style="text-align: right;">
                                       <button type="submit" class="mt-2 btn btn-primary">{{trans('clients.Update')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                  
            </div>
@endsection