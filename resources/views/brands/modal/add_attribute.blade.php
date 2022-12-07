                <div class="row">
                   <div class="col-md-6">
                        <input type="hidden" name="module_type" value="">
                        <label>{{trans('brands.module')}}</label>
                        <select class="form-control module" name="invoice">
                          
                            <option value="" selected disabled>{{trans('brands.select_module')}}</option>
                            <option value="brand"> {{trans('brands.brands')}} </option>
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
                </div><br>
                <div class="row">
                    <div class="col-md-12">

                        <label>{{trans('brands.template_name')}}</label>
                        <input type="text" class="form-control" name="template_name_new">
                    </div>

                </div><br>
                <div class="row">
                    <div class="col-md-6">
                        <label>{{trans('brands.insert_into')}}:</label>
                    </div>
                </div>
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
                        <button  id="insert" type="button" class="btn btn-warning" >{{trans('brands.btn_insert')}}</button>
                    </div>
                </div>