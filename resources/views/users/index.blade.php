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
                            <a >{{trans('menu.admin')}}</a>
                            <i class="fa fa-angle-right">&nbsp;</i>
                        </li>
                        <li>
                            <a class="breadcrumb-item active" href="">{{trans('menu.users')}}</a>
                        </li>
                    </div>
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-users icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('users.Users')}}
                                </div>
                            </div>
                            <div class="page-title-actions">
                                <div class="d-inline-block dropdown">
                                    <a href="{{route('users.add')}}" class="btn-shadow btn btn-info" href="">
                                        <i class="fa fa-plus btn-icon-wrapper"></i> &nbsp; {{trans('users.add_user')}}</a>
                                </div>
                            </div>    </div>
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                        	<!-- <h5 class="card-title">Grid Rows</h5> -->
                                    <form class="form-horizontal" method="POST" action="{{ route('users') }}">
                                     	{{ csrf_field() }}
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-3">
                                                            <div class=" position-relative form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                                <label for="" class="">CID</label>
                                                                <input name="cid" value="{{ $request->cid }}"  id="cid" placeholder="" type="text" class="form-control" >
                                                                @if ($errors->has('cid'))
                                                                    <span class="help-block">
                                                                        <strong>{{ $errors->first('cid') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                    </div>
                                                    <div class="col-3">
                                                    <div class="position-relative form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                    <label for="" class="">WID</label>
                                                    <input name="wid" value="{{$request->wid}}"  id="exampleName" placeholder="" type="text" class="form-control" >
                                                    @if ($errors->has('wid'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('wid') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="position-relative form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                    <label for="" class="">
                                                        <!--<span class="text-danger">*</span> -->Email</label>
                                                        <input name="email" id="email" placeholder="Email here..." 
                                                        value="{{ $request->email }}"  class="form-control">
                                                        @if ($errors->has('email'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('email') }}</strong>
                                                            </span>
                                                        @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class=" position-relative form-group mt-3">
                                                    <label for="" class="">{{trans('users.mobile_phone')}}</label>
                                                    <input name="phn" value="{{ $request->phn }}"  id="phn" placeholder="" type="text" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class=" position-relative form-group mt-3">
                                                    <label for="" class="">{{trans('users.taxpayer')}}</label>
                                                    <input name="taxpayer_no" value="{{$request->taxpayer_no}}"  id="tpn" placeholder="" type="text" class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row" >
                                            <div class=" position-relative form-group mt-3 col-6">
                                                <label for="" class="">{{trans('users.name')}}</label>
                                                <input name="name" value="{{ $request->name }}"  id="name" placeholder="" type="text" class="form-control" >
                                            </div>
                                            <div class=" position-relative form-group mt-3 col-6">
                                                <label for="" class="">{{trans('users.Users')}}</label>
                                                <input name="company_name" value="{{ $request->company_name }}"  id="company_name" placeholder="" type="text" class="form-control" >                                     
                                             </div>
                                        </div>
                                            <div class="form-row" >
                                                <div class=" position-relative form-group mt-3 col-12">
                                                    <label for="" class="">{{trans('users.address')}}</label>
                                                    <input name="address" value="{{$request->address}}"  id="adress" placeholder="" type="text" class="form-control" >
                                                </div>
                                              

                                            </div>

                                        
                                        <div class="form-row">
                                            <div class="col-md-4">
                                                <div class=" position-relative form-group mt-3">
                                                    <label for="" class="">{{trans('users.postal_code')}}</label>
                                                    <input name="postal_code" value="{{$request->postal_code}}"  id="pstc" placeholder="" type="text" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" position-relative form-group mt-3">
                                                    <label for="" class="">{{trans('users.location')}}</label>
                                                    <input name="location" value="{{$request->location}}"  id="loc" placeholder="" type="text" class="form-control" >
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class=" position-relative form-group mt-3">
                                                    <label for="" class="">{{trans('users.country')}}</label>
                                                    <select name="country"  id="country" placeholder=""  class="form-control" >
													<option value="">{{trans('users.select_country')}}</option>
													@foreach($countries as $country)
													@if(isset($request->country))
														@if($request->country == $country->iso_code)
															<option value="{{$country->iso_code}}" selected>{{$country->name}}</option>
														@endif
													@else								
														<option value="{{$country->iso_code}}">{{$country->name}}</option>
													@endif
													@endforeach
        
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    <hr>


<!--
                                    <div class="form-row">
                                        <div class="col-md-6">
                                        <div class="row">
                                          <div class="col-3">
                                            <div class=" position-relative form-group mt-2">
                                                <label for="" class="">Site</label>
                                                <select name="st1"  id="st1" placeholder=""  class="form-control" >
    
                                        <option value="">totds</option>
                                        <option value="2"> two</option>
                                        <option value="3">three</option>
    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class=" position-relative form-group mt-3">
                                                <label for="" class=""></label>
                                                <select name="st1"  id="st1" placeholder=""  class="form-control" >
    
                                        <option value="">qalquer</option>
                                        <option value="2"> two</option>
                                        <option value="3">three</option>
    
                                                </select>
                                            </div>
                                        </div>
                                      </div>
                                      </div>
                            
                                        <div class="col-md-6">
                                            <div class=" position-relative form-group mt-2">
                                                <label for="" class="">Payment method</label>
                                                <select name="p_m"  id="p_m" placeholder=""  class="form-control" >
    
                                        <option value="">select</option>
                                        <option value="2"> two</option>
                                        <option value="3">three</option>
    
                                                </select>
                                            </div>
                                        </div>
                                    </div>





                                    <div class="form-row" >
                                        <div class="col-4">
                                            <div class=" position-relative form-group mt-2">
                                                <label for="" class="">Last state Enc</label>
                                                <select name="lse"  id="lse" placeholder=""  class="form-control" >
    
                                        <option value="">select</option>
                                        <option value="2"> two</option>
                                        <option value="3">three</option>
    
                                                </select>
                                            </div>
                                       </div>
                                       <div class="col-4">
                                        <div class=" position-relative form-group mt-3">
                                            <label for="" class=""></label>
                                            <select name="sunk"  id="sunk" placeholder=""  class="form-control" >

                                    <option value="">select</option>
                                    <option value="2"> two</option>
                                    <option value="3">three</option>

                                            </select>
                                        </div>
                                         </div>

                                          <div class="col-4">
                                            <div class=" position-relative form-group mt-3">
                                                <label for="" class=""></label>
                                                <input name="unk" value=""  id="unk" placeholder="" type="text" class="form-control" >
                                            </div>
                                     </div>

                                </div>


                                <div class="form-row" >
                                    <div class="col-4">
                                        <div class=" position-relative form-group">
                                            <label for="" class="">Shipping status</label>
                                            <select name="shipping_st"  id="shipping_st" placeholder="Name here..."  class="form-control" >

                                    <option value="">select</option>
                                    <option value="2"> two</option>
                                    <option value="3">three</option>

                                            </select>
                                        </div>
                                   </div>
                                   <div class="col-2 ml-5">
                                    <div class=" position-relative form-group">
                                        <label for="" class="">Refrences</label>
                                        <input name="ref_1" value=""  id="ref_1" placeholder="" type="text" class="form-control" >
                                    </div>
                                     </div>
                                     

                                     <div class="col-2">
                                         <br>
                                        <div class=" mt-2 position-relative form-group">
                        
                                            <input name="ref_2" value=""  id="ref_2" placeholder="" type="text" class="form-control" >
                                        </div>
                                         </div>

                            </div>


                    <div class="form-row">
                        <div class="col-md-9">
                        <div class="row">
                            <div class="col-3">
                                <div class="position-relative form-group">
                                    <label for="" class="">
                                        <span class="text-danger"></span> Registration shipping</label>
                                    <input name="reg_shipping" id="reg_shipping"   type="text" class="form-control">
                                </div>
                            </div>
                        <div class="col-3">
                            <div class="position-relative form-group">
                                <label for="" class="">
                                    <span class="text-danger"></span> Fid included</label>
                                <input name="fid_included" id="fid_included"   type="text" class="form-control">
                            </div>
                        </div>
            
                      </div>
                      </div>
            
                      <div class="col-md-3">
                        <div class="position-relative form-group">
                            <br>
                            <input id="exact_seacrh" type="radio" class="ml-3" name="exact_seacrh" >
                                <label for="" class="mt-3 ml-3"><span class="text-danger"></span>partial search</label>
                            
                        </div>
                    </div>
                    </div>





                    

                    <div class="form-row">
                        <div class="col-md-9">
                        <div class="row">
                          <div class="col-3">
                            <div class="position-relative form-group">
                                <br>
                                <br>
                                <label for="" class="">
                                    <input name="password" id="examplePassword" placeholder="Password here..."  type="checkbox" class="" >
                                    <span class="text-danger"></span> group orders</label>

                            </div>
                        </div>
                        <div class="col-3">
                            <div class="position-relative form-group">
                                <br>
                                <br>
                                <label for="" class="">
                                    <input name="order_by_name" id="order_by_name" placeholder="Password here..."  type="checkbox" class="" >
                                    <span class="text-danger"></span> order by name</label>

                            </div>
                        </div>
                        <div class="col-3">
                            <div class="position-relative form-group">
                                <br>
                                <br>
                                <label for="" class="">
                                    <input name="show_on_page" id="show_on_page" placeholder="Password here..."  type="checkbox" class="" >
                                    <span class="text-danger"></span> show on a page</label>

                            </div>
                        </div>
                      </div>
                      </div>
            
                        <div class="col-md-3">
                            <div class="position-relative form-group">
                                <br>
                                <input id="exact_seacrh" type="radio" class="ml-3" name="exact_seacrh" >
                                    <label for="" class="mt-3 ml-3"><span class="text-danger"></span>Exact search</label>
                                
                            </div>
                        </div>
                    </div>

-->




                        
                                        
                                        <div style="text-align: right;">
                                       		<button type="submit" class="mt-2 btn btn-primary">{{trans('users.search')}}</button>
                                        </div>
                                    </form>
                                </div>
                    </div>
                    
                    
                    
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>{{trans('users.name')}}</th>
                                    <th>{{trans('users.company_name')}}</th>
                                    <th>{{trans('users.email')}}</th>
                                    <th>{{trans('users.user_roles')}}</th>
                                    <th>{{trans('users.account')}}</th>
                                    <th>{{trans('users.sms_percentage')}}</th>
                                    <th>{{trans('users.account_balance')}}</th>
                                    <th style="text-align: center;">{{trans('users.action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($user!= "")
                                
                                  
                                    @foreach($user as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}} 
										@if(!in_array("Administrator" , $user->roles()->pluck('name')->toArray()) && in_array("Administrator",Auth::user()->roles()->pluck('name')->toArray()))
										<span><a href="{{ URL('users/user_based_login/'.$user->id)}}"><i class="fas fa-key"></i></a></span>
										@endif
										</td>
                                        <td>{{$user->company_name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{  $user->roles()->pluck('name')->implode(' ') }}</td>
                                        <td>
                                            @if( $user->deleted_at != Null )
                                                <button class="btn-sm btn btn-danger">
                                                    <i       class=" fa fa-user-times"></i>&nbsp;&nbsp;{{trans('users.deleted')}}
                                                </button>
                                            @else
                                                <button class="btn-sm btn btn-success">
                                                    <i style="color: green;" class="fa fa-user"></i>
                                                    {{trans('users.not_deleted')}}
                                                </button>    
                                            @endif
                                        </td>
                                        <td>{{$user->sms_cost_percentage}}</td>
                                            
                                        <td>{{isset($user->AccountSettings->in_app_credit) ? number_format($user->AccountSettings->in_app_credit,3,",",",") : "" }}</td>
                                        <td style="text-align: center;">
                                            @if( $user->deleted_at != Null )
                                                
                                            @else
                                            <div class="btn-group">
                                               <a href="{{route('users.destroy',$user->id)}}"
                                                class="btn-sm btn-shadow btn btn-danger" 
                                                href="">
                                                   <i class="fas fa-trash"></i>
                                               </a>
                                               <a href="{{route('users.edit',$user->id)}}" 
                                                class="btn-sm btn-shadow btn btn-warning" href="">
                                                   <i class="fas fa-pen"></i>
                                               </a>
                                            </div>   
                                            @endif
                                             
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
@endsection
@section('javascript')
<script>
</script>
@endsection
