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
                            <a href="{{route('sms.home')}}">SMS</a>
                            <i class="fa fa-angle-right">&nbsp;</i>
                        </li>
                        <li>
                            <a class="breadcrumb-item active" href="">{{trans('sms.new_template')}}</a>
                        </li>
                    </div>
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-align-left icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('sms.edit_template')}}
                                </div>
                            </div>
                        </div>
                        <br>
                          <div class="card-header-title font-size-sm font-weight-normal" style="float: left;color: grey;">
                         <i class="fas fa-info-circle"></i>
                            <h7> {{trans('tips.templates')}}</h7>
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body" style="background-color: #CCCCCC;">
                            <h2><b>{{trans('sms.new_template')}}</b></h2>
                        </div>
                        <div class="card-body">
                                    <form class="form-horizontal" method="POST" action="{{ route('template.store') }}">
                                     	{{ csrf_field() }}
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="position-relative form-group">
                                                		<label for="" class="">{{trans('sms.name')}}</label>

                                                	<input name="name" id="name" placeholder="Name" type="text" class="form-control inp"
                                                    value="{{old('name')}}">

                                                    @if ($errors->has('name'))
                                                        <span class="help-block" style="color: red;">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                        <label for="" class="">{{trans('sms.template')}}</label>
                                                    <textarea name="template" class="form-control">
                                                        {{old('name')}}
                                                    </textarea>
                                                    @if ($errors->has('template'))
                                                        <span class="help-block" style="color: red;">
                                                            <strong>{{ $errors->first('template') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="" style="text-align: right;">
                                            <button type="submit" class="mt-2 btn btn-success">
                                               {{trans('sms.add_template')}}
                                            </button>
                                        </div>
                                    </form>
                                </div>
                    </div>
                </div>
                  
            </div>
@endsection

