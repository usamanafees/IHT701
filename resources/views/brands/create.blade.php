@extends('partials.main')
@section('style')
    <style type="text/css">
        .body_sec > .note-editor > .note-editing-area > .note-editable {
            height: 150px;
        }

        .note-toolbar {
            background-color: #caccce;
            border-color: #ddd;
        }

        .note-btn-group {
            background-color: white;
            border-color: black;
        }

        hr.line {
            border: 2px solid black;
            border-radius: 2px;
        }

        hr.line_slim {
            border: 1px solid black;
            border-radius: 2px;
        }

        p {
            font-size: 12px;
        }

        .loader {
            position: fixed;
            top: 30%;
            left: 43%;
            display: none;
            z-index: 9999;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: lightgrey;
        }

        .titles_for_editor {
            font-weight: 700;
            font-size: large;
        }
    </style>
@endsection
@section('content')
    <div style="position: relative; left: 0; top: 0;">
        <img class="center loader" src="{{asset('admin/assets/images/loader_6.gif')}}">
    </div>
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="breadcrumb mb-5" style="margin-top: -12px">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="{{route('/')}}">{{trans('menu.home')}}</a>
                    <i class="fa fa-angle-right">&nbsp;</i>
                </li>
                <li>
                    <a class="breadcrumb-item" href="{{route('brands')}}">{{trans('menu.brands')}}</a>
                    <i class="fa fa-angle-right">&nbsp;</i>
                </li>
                <li>
                    <a class="breadcrumb-item active" href="">{{trans('brands.add_brand')}}</a>
                </li>
            </div>
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="fas fa-cog icon-gradient bg-tempting-azure">
                            </i>
                        </div>
                        <div>{{trans('brands.add_brand')}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-card mb-3 card">
                <div class="card-body" style="background-color: #cad3d8;">
                    <h3><b>{{trans('brands.new_brand')}}</b></h3>
                    <div style="text-align: right;">
                        <h8>{{trans('brands.required')}}<font color="red">*</font></h8>
                    </div>
                </div>

                <form class="form-horizontal brand_form">
                <!-- {{ csrf_field() }} -->

                    <div class="card-body" style="background-color: #f7f9fa;">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">{{trans('brands.Name')}}</label>
                                    <input name="name" id="name" placeholder="Brand Name" type="text"
                                           class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">{{trans('brands.URL')}}</label>
                                    <input name="url" id="url" placeholder="URL" type="url" class="form-control"
                                           required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">{{trans('brands.logo')}}</label>
                                    <input class="form-control-file" type="file" name="logo" value="" id="logo"
                                           class="required">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">

                                    <div>
                                        <!-- <img  id="previewLogo"style="width:100px; height:100px;margin-left: 25%;" > -->
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <h4>{{trans('brands.Company_Details')}}</h4>
                        <hr>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">{{trans('brands.Company_Name')}}</label>
                                    <input name="company_name" id="company_name" placeholder="Company name" type="text"
                                           class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">{{trans('brands.Company_VAT')}}</label>
                                    <input name="company_vat" id="company_vat" placeholder="Company VAT" type="text"
                                           class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">{{trans('brands.Company_Address')}}</label>
                                    <textarea class="form-control" name="Company_Address"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">{{trans('brands.serie')}}</label>
                                    <input name="series" id="series" placeholder="Serie" type="text"
                                           class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h4>{{trans('brands.Templates')}}</h4>
                            <table class="table table-bordered template_table selected_templates">
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th style="width: 65%">{{trans('brands.Templates')}}</th>
                                    <th style="width: 15%; text-align: center;">
                                        <a href="#" id="open_template_Adder" type="button" class="btn btn-success"
                                           style="width: 80%;" data-toggle="modal"
                                           data-target=".templates_create"> {{trans('brands.btn_create')}} </a>
                                    </th>
                                    <th style="width: 15%; text-align: center;">
                                        <a href="#" id="get_templates" class="btn btn-info" style="width: 80%;"
                                           data-toggle="modal"
                                           data-target="#templates_modal"> {{trans('brands.btn_select')}} </a>
                                    </th>
                                </tr>
                                <tbody class=""></tbody>
                            </table>
                            <div style="text-align: right;">
                                <input type="hidden" name="brand_id" value="0">
                                <button
                                        id="save_brand"
                                        type="button"
                                        class="mt-2 btn btn-primary">{{trans('brands.Save')}}</button>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
        </div>

    </div>
    <!-- Large modal -->

    <div data-backdrop="static" data-keyboard="false" class="modal fade templates_create" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true" style="overflow-y: auto;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{trans('brands.create_template')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3>{{trans('brands.add_attributes')}}</h3><br>
                    @include('brands.modal.add_attribute')

                    <br>
                    <div class="row">
                        <div class="col-1">
                            <p class="titles_for_editor">{{trans('brands.header')}}</p>
                        </div>
                        <div class="col-11">
                        <textarea name="header" class="header" id="header">
                            <img id="previewLogo" style="width:170px; height:100px;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<b>Invoice: BET A/$invoice_id
                            </b>
                        </textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-1">
                            <p class="titles_for_editor">{{trans('brands.body')}}</p>
                        </div>
                        <div class="col-11 body_sec">
                        <textarea name="contents" class="contents body">
                        </textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-1">
                            <p class="titles_for_editor">{{trans('brands.footer')}}</p>
                        </div>
                        <div class="col-11">
                        <textarea name="footer" class="footer footer1">
                        </textarea>
                        </div>
                    </div>
                    <div class="row" id="show_error_create" name="show_error_create" style="display:none;">
                        &nbsp;&nbsp;&nbsp;<b id="show_error_message_create" style="color:red"></b>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
                    <a data-toggle="modal" data-title=preview_brand_template data-target=".template_preview"
                       class="btn btn-success preview_row_at_creation">{{trans('brands.btn_preview')}}</a>
                    <!-- <a data-toggle="modal" data-title=preview_brand_template data-target=".template_preview" class="btn btn-success preview_row" >Preview</a> -->
                    <button type="button" class="btn btn-primary" data-title="save_template"
                            data-dismiss="modal">{{trans('brands.btn_add')}}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="templates_modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">{{trans('brands.Templates')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 75%">{{trans('brands.Name')}}</th>
                            <th style="width: 20%">{{trans('brands.action')}}</th>
                        </tr>
                        <!--  <tr>
                             <td style="width: 5%">#</td>
                             <td style="width: 75%">Sample Template</td>
                             <td style="width: 20%"><input type="checkbox" name="tempaltes_checked" class="form-control tempaltes_checked" value='1'></td>
                         </tr> -->
                    </table>
                    <table class="table table-bordered previous_templates">
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 75%">{{trans('brands.Name')}}</th>
                            <th style="width: 20%">{{trans('brands.action')}}</th>
                        </tr>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" data-title="add_selected_templates"
                            class="btn btn-primary">{{trans('brands.add_selected_templates')}}</button>
                </div>
            </div>
        </div>
    </div>
    <div data-backdrop="static" data-keyboard="false" class="modal fade templates_edit" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true" style="overflow-y: auto;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">{{trans('brands.edit_template')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body edit_template_modal">
                    <h3>{{trans('brands.add_attributes')}}</h3><br>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="module_type" value="">
                            <label>Module</label>
                            <select class="form-control module" name="invoice">

                                <option value="" selected disabled>{{trans('brands.select_module')}}</option>
                                <option value="invoice"> {{trans('brands.invoice')}} </option>
                                <option value="client"> {{trans('brands.client')}} </option>
                                <option value="items"> {{trans('brands.line_items')}} </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>{{trans('brands.fields')}}</label>
                            <select class="form-control module_nm" name="fields">

                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <span>{{trans('brands.template_name')}}e</span>
                            <input type="text" class="form-control name" name="template_name_editMode">
                            <input type="hidden" class="form-control template_id" name="template_id" value="">
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="1">{{trans('brands.header')}}</label>
                            <input type="radio" name="attribute" value="header" id="1">
                        </div>
                        <div class="col-md-2">
                            <label for="2">{{trans('brands.body')}}</label>
                            <input type="radio" name="attribute" value="body" id="2">
                        </div>
                        <div class="col-md-2">
                            <label for="3">{{trans('brands.footer')}}</label>
                            <input type="radio" name="attribute" value="footer" id="3">
                        </div>
                        <div class="col-md-12" style="text-align: right;">
                            <br>
                            <button id="insert_on_edit" type="button"
                                    class="btn btn-warning">{{trans('brands.btn_insert')}}</button>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-1">
                            <p class="titles_for_editor">{{trans('brands.header')}}</p>
                        </div>
                        <div class="col-11">
                        <textarea name="header" class="header_editMode header">
                        </textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-1">
                            <p class="titles_for_editor">{{trans('brands.body')}}</p>
                        </div>
                        <div class="col-11">
                        <textarea name="contents" class="contents_editMode body">
                        </textarea>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-1">
                            <p class="titles_for_editor">{{trans('brands.footer')}}</p>
                        </div>
                        <div class="col-11">
                        <textarea name="footer" class="footer_editMode footer">
                        </textarea>
                        </div>
                    </div>
                    <div class="row" id="show_error_update" name="show_error_update" style="display:none;">
                        &nbsp;&nbsp;&nbsp;<b id="show_error_message_update" style="color:red"></b>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="preview_template" val="">

                    <a data-toggle="modal" data-title=preview_brand_template data-target=".template_preview"
                       class="btn btn-success preview_row">{{trans('brands.btn_preview')}}</a>

                    <button type="button" class="btn btn-primary" data-title="update_template"
                            data-dismiss="modal">{{trans('brands.btn_update')}}</button>
                </div>
            </div>
        </div>

        @endsection
        @section('javascript')

            <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <script src="{{asset('admin/assets/summernote/summernote.js')}}"></script>

            <script type="text/javascript">
                $('#myModal').modal({backdrop: 'static', keyboard: false})

                $('.contents_editMode, .header_editMode, .footer_editMode, .footer1, .body, .contents, .contents_1, .contents_2, .header, .footer').summernote({
                    toolbar: [
                        ['fontsize', ['fontsize']],
                        ['height', ['height']]
                            ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear', 'italic']],
                        ['fontname', ['fontname']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['view', ['codeview']],
                    ],
                });

                $("#logo").change(function () {
                    showLogo(this);
                });

                function showLogo(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            $('#previewLogo').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }

                $('#template_1').on('click', function () {
                    $('.sample_1').slideToggle();
                    $('.sample_2').slideUp();
                })
                $('#template_2').on('click', function () {
                    $('.sample_1').slideUp();
                    $('.sample_2').slideToggle();
                })
                $('button[id=save_brand]').click(function () {
                    var name = $('input[name=name]').val();
                    var url = $('input[name=url]').val();
                    var logo = $('input[name=logo]').val();
                    var company_name = $('input[name=company_name]').val();
                    var company_vat = $('input[name=company_vat]').val();
                    var Company_Address = $('textarea[name=Company_Address]').val();
                    var series = $('input[name=series]').val();

                    var brand_id = $('input[name=brand_id]').val();
                    // console.log(name);
                    // console.log(url);
                    // console.log(logo);
                    // console.log(company_name);
                    // console.log(company_vat);
                    // console.log(Company_Address);
                    // console.log(brand_id);

                    // return false;


                    CSRF_TOKEN = "{{ csrf_token() }}";

                    $('.loader').css('display', 'block');
                    $('.page-container').css('opacity', '75%');

                    $.ajax({
                        type: "POST",
                        url: "{{route('brands.store')}}",
                        data: {
                            brand_id: brand_id,
                            name: name,
                            url: url,
                            logo: logo,
                            company_name: company_name,
                            company_vat: company_vat,
                            Company_Address: Company_Address,
                            series : series,
                            _token: CSRF_TOKEN
                        },
                        success: function (data) {
                            $('.loader').css('display', 'none');
                            $('.page-container').css('opacity', '');
                            console.log(data);
                            var url = '{{ route("brands") }}';
                            document.location.href = url;

                        }
                    });
                });
                $('#get_templates').on('click', function () {
                    CSRF_TOKEN = "{{ csrf_token() }}";
                    $('.loader').css('display', 'block');

                    var brand_id = $('input[name=brand_id]').val();
                    $('table.previous_templates').empty();
                    $.ajax({
                        type: "GET",
                        url: "{{route('brands.templates.get')}}",
                        data: {brand_id: brand_id, _token: CSRF_TOKEN},
                        success: function (data) {
                            $('.loader').css('display', 'none');
                            $('.page-container').css('opacity', '');
                            var temps = JSON.parse(data);
                            // console.log(temps);
                            for (var i = 0; i < temps.length; i++) {
                                var output = '<tr id=' + temps[i].id + '>';
                                output += '<td>' + temps[i].id + '</td>';
                                output += '<td>' + temps[i].name + '</td>';
                                output += '<td><input type="checkbox" name="tempaltes_checked" class="form-control tempaltes_checked" value=' + temps[i].id + '></td>';
                                output += '</tr>';
                                $('table.previous_templates').append(output);

                            }
                        }
                    });
                })

                function remove_row(obj) {
                    var id = obj;
                    $('tr#' + id).remove();

                    $.ajax({
                        type: "POST",
                        url: "{{route('remove_template')}}",
                        data: {id: id, _token: CSRF_TOKEN},
                        success: function (data) {
                        }
                    });
                }

                $('button[data-title=save_template]').click(function () {
                    var name = $('input[name=name]').val();
                    var url = $('input[name=url]').val();
                    var logo = $('input[name=logo]').val();
                    var company_name = $('input[name=company_name]').val();
                    var company_vat = $('input[name=company_vat]').val();
                    var Company_Address = $('textarea[name=Company_Address]').val();
                    var series = $('input[name=series]').val();

                    var body = $(".contents").summernote('code');
                    var header = $(".header").summernote('code');
                    var footer = $(".footer").summernote('code');
                    var template_name_new = $('input[name=template_name_new]').val();
                    var brand_id = $('input[name=brand_id]').val();

                    var ccode_hash_b = body.search("invoice_code_hash");
                    var ccode_hash_h = header.search("invoice_code_hash");
                    var ccode_hash_f = footer.search("invoice_code_hash");
                    var x = document.getElementById('show_error_create');
                    x.style.display = "none";

                    if (ccode_hash_b == -1 && ccode_hash_f == -1 && ccode_hash_h == -1) {
                        var x = document.getElementById('show_error_create');
                        var y = document.getElementById('show_error_message_create');
                        y.innerText = "*The invoice -> code_hash field is mandatory to be present in the template!";
                        x.style.display = "block";
                        return false;
                    } else {

                        CSRF_TOKEN = "{{ csrf_token() }}";
                        if ($('input[name=brand_id]').val() == 0) {
                            $.ajax({
                                type: "POST",
                                url: "{{route('brands.store_with_template')}}",
                                data: {
                                    template_name_new: template_name_new,
                                    body: body,
                                    header: header,
                                    footer: footer,
                                    name: name,
                                    url: url,
                                    logo: logo,
                                    company_name: company_name,
                                    company_vat: company_vat,
                                    Company_Address: Company_Address,
                                    series:series,
                                    _token: CSRF_TOKEN
                                },
                                success: function (data) {
                                    append_rows_template(data);

                                }
                            });
                        } else {
                            $.ajax({
                                type: "POST",
                                url: "{{route('brands.store_template_with_brand')}}",
                                data: {
                                    template_name_new: template_name_new, body: body, header: header, footer: footer
                                    , brand_id: brand_id, _token: CSRF_TOKEN
                                },
                                success: function (data) {
                                    append_rows_template(data);
                                }
                            });
                        }
                    }
                });


                function append_rows_template(data) {
                    var template = JSON.parse(data);
                    var header = template.header;
                    var footer = template.footer;
                    var body = template.body;
                    var name = template.name;

                    var output_temps = '<tr id=' + template.id + ' templatye_id=' + template.id + '>';
                    output_temps += '<td style="text-align: center">#</td>';
                    output_temps += '<td>' + name + '</td>';
                    output_temps += '<td style="text-align: center"><a data-toggle="modal" data-target=".templates_edit" style="text-align:center;" id="edit_row" data-id="' + template.id + '" onclick="edit_row(' + template.id + ');" class="edit_row btn btn-warning"><i class="fa fa-pen"></i></a></td>';
                    output_temps += '<td style="text-align: center"><a style="text-align:center;" onclick="remove_row(' + template.id + ')" class="btn btn-danger"><i class="fa fa-trash"></i></a></td>';
                    output_temps += '</tr>';
                    $('table.selected_templates').append(output_temps);
                    $('.brand_form').append($('input[name=brand_id]').val(template.brands_id));
                }

                function edit_row(obj) {
                    var id = obj;
                    // console.log(id);
                    CSRF_TOKEN = "{{ csrf_token() }}";

                    $('.loader').css('display', 'block');
                    $.ajax({
                        type: "GET",
                        url: "{{route('edit_template')}}",
                        data: {id: id, _token: CSRF_TOKEN},
                        success: function (data) {
                            $('.loader').css('display', 'none');
                            var template = JSON.parse(data);
                            console.log(template);
                            $('input[name=template_name_editMode]').val();

                            var header = JSON.parse(template.header);
                            var footer = JSON.parse(template.footer);
                            var body = JSON.parse(template.body);
                            var name = template.name;

                            $('input[name=template_name_editMode]').val(name);
                            $('input[name=template_id]').val(id);

                            $('input[name=preview_template]').val(id);

                            $('.contents_editMode').summernote('code', '');
                            $('.contents_editMode').summernote('pasteHTML', body);

                            $('.header_editMode').summernote('code', '');
                            $('.header_editMode').summernote('pasteHTML', header);

                            $('.footer_editMode').summernote('code', '');
                            $('.footer_editMode').summernote('pasteHTML', footer);
                        }
                    });
                }

                $('button[data-title=update_template]').click(function () {
                    var body = $(".contents_editMode").summernote('code');
                    var header = $(".header_editMode").summernote('code');
                    var footer = $(".footer_editMode").summernote('code');
                    var template_name_new = $('input[name=template_name_editMode]').val();
                    var template_id = $('input[name=template_id]').val();
                    var brand_id = $('input[name=brand_id]').val();

                    var ccode_hash_b = body.search("invoice_code_hash");
                    var ccode_hash_h = header.search("invoice_code_hash");
                    var ccode_hash_f = footer.search("invoice_code_hash");

                    var x = document.getElementById('show_error_update');
                    x.style.display = "none";

                    if (ccode_hash_b == -1 && ccode_hash_f == -1 && ccode_hash_h == -1) {
                        var x = document.getElementById('show_error_update');
                        var y = document.getElementById('show_error_message_update');
                        y.innerText = "*The invoice -> code_hash field is mandatory to be present in the template!";
                        x.style.display = "block";
                        return false;
                    } else {

                        CSRF_TOKEN = "{{ csrf_token() }}";

                        $.ajax({
                            type: "POST",
                            url: "{{route('brands.template.update')}}",
                            data: {
                                template_name_new: template_name_new, body: body, header: header, footer: footer,
                                template_id: template_id, brand_id: brand_id, _token: CSRF_TOKEN
                            },
                            success: function (data) {
                                console.log(data);
                            }
                        });
                    }
                });

                $('button[data-title=add_selected_templates]').click(function () {
                    var name = $('input[name=name]').val();
                    var url = $('input[name=url]').val();
                    var logo = $('input[name=logo]').val();
                    var company_name = $('input[name=company_name]').val();
                    var company_vat = $('input[name=company_vat]').val();
                    var Company_Address = $('textarea[name=Company_Address]').val();
                    var series = $('input[name=series]').val();

                    var brand_id = $('input[name=brand_id]').val();

                    var templates_ids = [];
                    $.each($("input[name='tempaltes_checked']:checked"), function () {
                        templates_ids.push($(this).val());
                    });
                    CSRF_TOKEN = "{{ csrf_token() }}";
                    $.ajax({
                        type: "POST",
                        url: "{{route('brands.template.selected')}}",
                        data: {templates_ids: templates_ids, _token: CSRF_TOKEN},
                        success: function (data) {
                            var previous_data = JSON.parse(data);
                            var brands_id = 0;

                            if ($('input[name=brand_id]').val() == 0) {
                                $.ajax({
                                    type: "POST",
                                    url: "{{route('store_with_template_previous_selected')}}",
                                    data: {
                                        brand_id: brand_id,
                                        templates_ids: templates_ids,
                                        name: name,
                                        url: url,
                                        logo: logo,
                                        company_name: company_name,
                                        company_vat: company_vat,
                                        Company_Address: Company_Address,
                                        series: series,
                                        _token: CSRF_TOKEN
                                    },
                                    success: function (data) {
                                        // console.log(data);
                                        var newly_added_temps = JSON.parse(data);
                                        // console.log(newly_added_temps.brands_id);
                                        for (var i = 0; i < previous_data.length; i++) {
                                            template = previous_data[i];
                                            var header = template.header;
                                            var footer = template.footer;
                                            var body = template.body;
                                            var name = template.name;

                                            var output_temps = '<tr id=' + template.id + ' templatye_id=' + template.id + '>';
                                            output_temps += '<td style="text-align: center">#</td>';
                                            output_temps += '<td>' + name + '</td>';
                                            output_temps += '<td style="text-align: center"><a data-toggle="modal" data-target=".templates_edit" style="text-align:center;" id="edit_row" data-id="' + template.id + '" onclick="edit_row(' + template.id + ');" class="edit_row btn btn-warning"><i class="fa fa-pen"></i></a></td>';
                                            output_temps += '<td style="text-align: center"><a style="text-align:center;" onclick="remove_row(' + template.id + ')" class="btn btn-danger"><i class="fa fa-trash"></i></a></td>';
                                            output_temps += '</tr>';
                                            $('table.selected_templates').append(output_temps);

                                        }
                                        $('input[name=brand_id]').val(newly_added_temps.brands_id);

                                    }
                                });
                            } else {
                                $.ajax({
                                    type: "POST",
                                    url: "{{route('store_template_with_brand_previous_selected')}}",
                                    data: {templates_ids: templates_ids, brand_id: brand_id, _token: CSRF_TOKEN},
                                    success: function (data) {
                                        // console.log(data);
                                        var newly_added_temps = JSON.parse(data);
                                        // console.log(newly_added_temps.brands_id);
                                        for (var i = 0; i < previous_data.length; i++) {
                                            template = previous_data[i];
                                            var header = template.header;
                                            var footer = template.footer;
                                            var body = template.body;
                                            var name = template.name;

                                            var output_temps = '<tr id=' + template.id + ' templatye_id=' + template.id + '>';
                                            output_temps += '<td style="text-align: center">#</td>';
                                            output_temps += '<td>' + name + '</td>';
                                            output_temps += '<td style="text-align: center"><a data-toggle="modal" data-target=".templates_edit" style="text-align:center;" id="edit_row" data-id="' + template.id + '" onclick="edit_row(' + template.id + ');" class="edit_row btn btn-warning"><i class="fa fa-pen"></i></a></td>';
                                            output_temps += '<td style="text-align: center"><a style="text-align:center;" onclick="remove_row(' + template.id + ')" class="btn btn-danger"><i class="fa fa-trash"></i></a></td>';
                                            output_temps += '</tr>';
                                            $('table.selected_templates').append(output_temps);

                                        }
                                        $('input[name=brand_id]').val(newly_added_temps.brands_id);
                                    }
                                });
                            }
                        }
                    });
                });


                //Insert Data at the Cursor position
                var lastCaretPos = 0;
                var parentNode;
                var range;
                var selection;

                $('.note-editable').on('keyup mouseup', function (e) {
                    selection = window.getSelection();
                    range = selection.getRangeAt(0);
                    parentNode = range.commonAncestorContainer.parentNode;
                });

                $('#insert_on_edit').click(function (e) {
                    // console.log(parentNode)
                    // if($(parentNode).parents().is('.note-editable') || $(parentNode).is('.note-editable') ){
                    var span = document.createElement('span');
                    span.setAttribute('style', 'font-style:italic');

                    var module_name = jQuery(".module option:selected").val();
                    var field_name = jQuery(".module_nm option:selected").val();
                    if ($.isNumeric(module_name) == true) {
                        module_name = "$shipment_requests";
                    } else {
                        module_name = '$' + module_name;
                    }
                    if (field_name != undefined) {
                        var field = module_name + '_' + field_name;
                        span.innerHTML = field;
                    }
                    range.deleteContents();
                    range.insertNode(span);
                    range.collapse(false);
                    selection.removeAllRanges();
                    selection.addRange(range);

                    // }else{
                    // return;
                    // }
                });
                $('#insert').click(function (e) {
                    // console.log(parentNode);
                    // if($(parentNode).parents().is('.note-editable') || $(parentNode).is('.note-editable') ){
                    var span = document.createElement('span');
                    span.setAttribute('style', 'font-style:italic');

                    var module_name = jQuery(".module option:selected").val();
                    var field_name = jQuery(".module_nm option:selected").val();
                    if ($.isNumeric(module_name) == true) {
                        module_name = "$shipment_requests";
                    } else {
                        module_name = '$' + module_name;
                    }
                    if (field_name != undefined) {
                        var field = module_name + '_' + field_name;
                        span.innerHTML = field;
                    }
                    range.deleteContents();
                    range.insertNode(span);
                    range.collapse(false);
                    selection.removeAllRanges();
                    selection.addRange(range);

                    // }else{
                    // console.log("didnt find editable node");
                    // return;
                    // }
                });

                $('.module').on('change', function () {
                    var module_id = $(this).children("option:selected").val();
                    $('.module_nm').empty();
                    var token = "{{ csrf_token() }}";
                    var url = "{{route('brand.template.module_list')}}";
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {module_id: module_id, _token: token},
                        success: function (data) {
                            // var module_list = JSON.parse(data);
                            var Fields = JSON.parse(data);
                            // var Modules = module_list['Modules'];

                            for (var i = 0; i < Fields.length; i++) {
                                var field_data = Fields[i].split(";");
                                $('.module_nm').append('<option value="' + field_data[0] + '">' + field_data[1] + '</option>')
                            }
                        }
                    });
                })

                $('.invoice').on('change', function () {
                    $('input[name=module_type]').val('invoice');
                })
                $('.client').on('change', function () {
                    $('input[name=module_type]').val('client');
                })

                // preview_template
                $('.preview_row').on('click', function () {
                    $('#header').html('');
                    $('#body').html('');
                    $('#footer').html('');

                    var header = $('.header_editMode').summernote('code');
                    var body = $('.contents_editMode').summernote('code');
                    var footer = $('.footer_editMode').summernote('code');

                    $('#header').html(header);
                    $('#body').html(body);
                    $('#footer').html(footer);

                });

                $('.preview_row_at_creation').on('click', function () {
                    $('#header').html('');
                    $('#body').html('');
                    $('#footer').html('');

                    var header = $('.header').summernote('code');
                    var body = $('.contents').summernote('code');
                    var footer = $('.footer').summernote('code');

                    $('#header').html(header);
                    $('#body').html(body);
                    $('#footer').html(footer);

                });


                $("input[type='radio']").change(function () {
                    var val = $(this).val();
                    if (val == "header") {
                        $('.header').summernote({focus: true});
                        selection = window.getSelection();
                        range = selection.getRangeAt(0);
                        parentNode = range.commonAncestorContainer.parentNode;
                    } else if (val == "body") {
                        $('.body').summernote({focus: true});
                        selection = window.getSelection();
                        range = selection.getRangeAt(0);
                        parentNode = range.commonAncestorContainer.parentNode;
                        console.log(["is note editable", $(parentNode).parents().is('.note-editable')]);
                    } else if (val == "footer") {
                        $('.footer').summernote({focus: true});
                        selection = window.getSelection();
                        range = selection.getRangeAt(0);
                        parentNode = range.commonAncestorContainer.parentNode;
                    }
                });


                $('.header').on('summernote.focus', function () {
                    $('#1').prop('checked', true);
                    selection = window.getSelection();
                    range = selection.getRangeAt(0);
                    parentNode = range.commonAncestorContainer.parentNode;
                });

                $('.body').on('summernote.focus', function () {
                    $('#2').prop('checked', true);
                    selection = window.getSelection();
                    range = selection.getRangeAt(0);
                    parentNode = range.commonAncestorContainer.parentNode;
                });

                $('.footer').on('summernote.focus', function () {
                    $('#3').prop('checked', true);
                    selection = window.getSelection();
                    range = selection.getRangeAt(0);
                    parentNode = range.commonAncestorContainer.parentNode;
                });


            </script>
@endsection
