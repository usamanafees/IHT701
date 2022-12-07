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
                    <a class="breadcrumb-item active" href="">{{trans('clients.add_client')}}</a>
                </li>
            </div>
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="fas fa-user-friends icon-gradient bg-tempting-azure">
                            </i>
                        </div>
                        <div>{{trans('clients.add_client')}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-card mb-3 card">
                <div class="card-body" style="background-color: #cad3d8;">
                    <h3><b>{{trans('clients.new_client')}}</b></h3>
                    <div style="text-align: right;">
                        <h8>{{trans('clients.require_filds')}}<font color="red">*</font></h8>
                    </div>
                </div>
                <?php
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://apinforma.informadb.pt/v1/login",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => "{\n\t\"userId\": \"546484\",\n\t\"password\": \"MXU4AG2QTN\"\n}",
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/json",
                        "Content-Type: application/json"
                    ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);
                $resposta = json_decode($response, true);
                $acess_token = $resposta['access_token'];
                ?>
                <form class="form-horizontal" method="POST" action="">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <div class="position-relative form-group">
                                        <label for="" class="">Add predefined data via VAT Number</label>
                                        <input name="vat_number_automate" id="vat_number_automate" placeholder="VAT number" type="text" class="form-control">
                                    </div>
                                        <button type="submit" class="btn btn-info" style="float:right">Add</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
                <form class="form-horizontal" method="POST" action="{{ route('clients.store') }}">
                    {{ csrf_field() }}

                    <div class="card-body" style="background-color: #f7f9fa;">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">{{trans('clients.Name')}}<font color="red"><b>*</b></font></label>
                                    <input name="name" id="name" placeholder="{{trans('clients.Name')}}" type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">{{trans('clients.email')}}<font color="red"><b>*</b></font></label>
                                    <input name="email" id="email" placeholder="{{trans('clients.email')}}" type="email" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">{{trans('clients.VAT_Number')}}<font color="red"><b>*</b></font></label>
                                    <input name="vat_number" id="vat_number" placeholder="{{trans('clients.VAT_Number')}}" type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">{{trans('clients.Main_URL')}}</label>
                                    <input name="main_url" id="main_url" placeholder="{{trans('clients.Main_URL')}}" type="url" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">{{trans('clients.code')}}<font color="red"><b>*</b></font></label>
                                    <input name="code" id="code" placeholder="{{trans('clients.code')}}" type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">{{trans('clients.postal_code')}}<font color="red"><b>*</b></font></label>
                                    <input name="postal_code" id="postal_code" placeholder="{{trans('clients.postal_code')}}" type="text" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">{{trans('clients.address')}}<font color="red"><b>*</b></font></label>
                                    <input name="address" id="address" placeholder="{{trans('clients.address')}}" type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">{{trans('clients.city')}}<font color="red"><b>*</b></font></label>
                                    <input name="city" id="city" placeholder="{{trans('clients.city')}}" type="text" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">{{trans('clients.telephone')}}</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="select2 form-control" id="select_code_telephone" name="telephone_Code" >
                                                <option value="" selected disabled> Select Code </option>
                                                @foreach($countries as $country)
                                                    <option value="{{$country->isd_code}}">+{{$country->isd_code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative form-group">
                                                <input style="height: 30px;" name="telephone" id="telephone" placeholder="{{trans('clients.telephone')}}..." type="number" class="form-control" >
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
                                            <select class="select2 form-control" name="mobile_Code" >
                                                <option value="" selected disabled> Select Code </option>
                                                @foreach($countries as $country)
                                                    <option value="{{$country->isd_code}}">+{{$country->isd_code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative form-group">
                                                <input style="height: 30px;" name="mobile" id="mobile" placeholder="{{trans('clients.mobile')}}..." type="number" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">Fee List</label>
                                    <select class="select2 form-control" name="fee">
                                        <option value="" selected disabled> {{trans('clients.select_fee')}} </option>
                                        @foreach($fee_list as $fee_list)
                                            <option

                                                    value="{{ $fee_list[1] }}">{{$fee_list[0]}} - {{ $fee_list[1] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">{{trans('clients.Country')}}<font color="red">*</font></label>
                                    <select class="select2 form-control" name="country" required>
                                        <option value="" selected disabled> {{trans('clients.Country')}} </option>
                                        @foreach($countries as $country)
                                            <option value="{{$country->iso_code}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                          
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">Vat Exemption Reason</label>
                                        <select class="select2 form-control" name="vatexpn" id="vatexpn">
                                            <option value="" selected disabled>Select Tax Exemption Reason</option>
                                            <option value="M09">IVA ‐ não confere direito a dedução.</option>
                                            <option value="M08">IVA – autoliquidação.</option>
                                            <option value="M07">Isento Artigo 9º do CIVA.</option>
                                            <option value="M06">Isento Artigo 15º do CIVA.</option>
                                            <option value="M05">Isento Artigo 14º do CIVA.</option>
                                            <option value="M04">Isento Artigo 13º do CIVA.</option>
                                            <option value="M03">Exigibilidade de caixa.</option>
                                            <option value="M02">Artigo 6º do Decreto‐Lei nº 198/90, de 19 de Junho.</option>
                                            <option value="M01">Artigo 16º nº 6 do CIVA.</option>
                                            <option value="M16">Isento Artigo 14º do RITI.</option>
                                            <option value="M15">Regime da margem de lucro–Objetos de coleção e antiguidades.</option>
                                            <option value="M14">Regime da margem de lucro – Objetos de arte.</option>
                                            <option value="M13">Regime da margem de lucro – Bens em segunda mão.</option>
                                            <option value="M12">Regime da margem de lucro – Agências de viagens.</option>
                                            <option value="M11">Regime particular do tabaco.</option>
                                            <option value="M10">IVA – Regime de isenção.</option>
                                            <option value="M99">Não sujeito; não tributado (ou similar).</option>
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
                                    <input class="form-control" type="text" name="primary_name" placeholder="{{trans('clients.Name')}}" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">{{trans('clients.mobile')}}</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="select2 form-control" name="primary_mobile_code" >
                                                <option value="" selected disabled> Select Code </option>
                                                @foreach($countries as $country)
                                                    <option value="{{$country->isd_code}}">+{{$country->isd_code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative form-group">
                                                <input style="height: 30px;" name="primary_mobile" id="primary_mobile" placeholder="{{trans('clients.mobile')}}..." type="text" class="form-control" >
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
                                    <input class="form-control" type="email" name="primary_email" placeholder="{{trans('clients.email')}}" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">{{trans('clients.telephone')}}</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <select class="select2 form-control" name="primary_telephone_code" >
                                                <option value="" selected disabled> Select Code </option>
                                                @foreach($countries as $country)
                                                    <option value="{{$country->isd_code}}">+{{$country->isd_code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="position-relative form-group">
                                                <input style="height: 30px;" name="primary_telephone" id="primary_telephone" placeholder="{{trans('clients.telephone')}}..." type="text" class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="text-align: right;">
                            <button type="submit" class="mt-2 btn btn-primary">{{trans('clients.Save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
<?php
    if(!empty($_POST['vat_number_automate'])) {

        $nif = $_POST['vat_number_automate'];
        $curl = curl_init();


        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://apinforma.informadb.pt/v1/reports/Vat/$nif/PLPROS?reference=",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Accept: application/xml",
                "Authorization: Bearer $acess_token",

            ),
        ));

        $response = curl_exec($curl);
        $decode_response= json_decode($response);
    if(isset($decode_response->detail)){
        echo '<script type="text/javascript">
     alert("That VAT number is not associated with any company!")
     </script>';
            //return false;
        }
    else{
        $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $dados_empresa = json_decode($json, TRUE);
        echo '<script type="text/javascript">';
        echo 'var x = ' . json_encode($dados_empresa) . ';';
        echo '</script>';
    }
    }
?>
@section('javascript')
    <script type="text/javascript">
        console.log(x['FichaEmpresaX1']);
        document.getElementById('name').value=x['FichaEmpresaX1']['Nome'];
        document.getElementById('email').value=x['FichaEmpresaX1']['Email'];
        document.getElementById('postal_code').value=x['FichaEmpresaX1']['CodigoPostal'];
        document.getElementById('city').value=x['FichaEmpresaX1']['Localidade'];
        document.getElementById('address').value=x['FichaEmpresaX1']['NomeVia'];
        document.getElementById('vat_number').value=x['FichaEmpresaX1']['NumeroContribuinte'];
        document.getElementById('telephone').value=x['FichaEmpresaX1']['Telefone'];
        document.getElementById('main_url').value=x['FichaEmpresaX1']['Website'];
        document.getElementById("select_code_telephone").value = "351";
        document.getElementById("country").value = "PT";
</script>
@endsection