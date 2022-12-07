@extends('partials.main')
@section('style')
<style type="text/css">
    .help-block{
        color: #ba4a48;
    }
</style>
@endsection
@section('content')
			<div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="main-card mb-3 card">

                        <div class="card-body" style="background-color: #ccc;">
                            <h2><b>{{trans('users.company_details')}}</b></h2>
                            <div style="text-align: right;">
                                <h8>Required Fields<font color="red">*</font></h8>
                            </div>
                        </div>

                        <div class="card-body">
                            <p>Company info for documents</p>
                            <hr>
                            <span>Complete your company's invoicing data that will be displayed on your documents.</span>
                            <form class="form-horizontal" method="POST" action="{{ route('users.store') }}">
                                     	{{ csrf_field() }}
                                <br>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="exampleName" class=""><b>Company:</b>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input name="company_name"  id="company_name" placeholder="Company Name" type="text" class="form-control" value="{{$user->company_name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="exampleEmail" class=""><b>Taxpayer:</b></label>
                                             <input name="taxpayer" id="taxpayer" placeholder="Tax Payer" class="form-control" value="{{$user->Subsidiaries->taxpayer}}">
                                                    
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="exampleName" class=""><b>Name:</b></label>
                                            <input name="name"  id="name" placeholder="Company Name" type="text" class="form-control"  value="{{$user->name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="exampleEmail" class=""><b>Moile:</b></label>
                                                <input name="phone_no" id="Mobile" placeholder="Mobile" class="form-control" value="{{$user->phone_no}}">
                                                   
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="exampleName" class=""><b>City:</b><span class="text-danger">*</span></label>
                                            <input name="city"  id="city" placeholder="City" type="text" class="form-control" value="{{$user->Subsidiaries->city}}">
                                               

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="exampleEmail" class=""><b>Postal Code:</b><span class="text-danger">*</span></label>
                                                <input name="postal_code" id="postal_code" placeholder="Postal code" class="form-control" value="{{$user->Subsidiaries->postal_code}}">
                                                  
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-row">
                                    
                                    <div class="col-md-12">
                                        <div class="position-relative form-group">
                                            <label for="exampleName" class=""><b>Address:</b><span class="text-danger">*</span></label>
                                          
                                           <textarea name="address" class="form-control">         
                                                {{$user->Subsidiaries->address}}
                                           </textarea>
                                               

                                        </div>
                                    </div>
                                </div>
                                        
                                        <!-- <div style="text-align: right;">
                                       		<button type="submit" class="mt-2 btn btn-primary">{{trans('users.Save')}}</button>
                                        </div> -->
                                    </form>
                                </div>
                    </div>
                </div>
                  
            </div>
@endsection