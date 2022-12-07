 @extends('partials.main')

@section('content')
			<div class="app-main__outer">
                <div class="app-main__inner">
                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-clipboard-list icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('modules.add_module')}}
                                </div>
                            </div>
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                        	<!-- <h5 class="card-title">Grid Rows</h5> -->
                                    <form class="form-horizontal" method="POST" action="{{ route('modules.store') }}">
                                     	{{ csrf_field() }}
                                        <div class="form-row">
                                            <div class="col-md-8">
                                                <div class="position-relative form-group">
                                                		<label for="" class="">{{trans('modules.Module_Name')}}<font color="red"><b>*</b></font></label>
                                                	<input name="name" id="name" placeholder="Name" type="text" class="form-control" >
                                                    @if ($errors->has('name'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('name') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="position-relative form-group" style="top: 25%;">
                                                        <button type="submit" class="mt-2 btn btn-success">{{trans('modules.add_module')}}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                    </div>
                </div>
                  
            </div>
@endsection