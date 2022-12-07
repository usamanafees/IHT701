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
                            <a class="breadcrumb-item active" href="">{{trans('menu.contact_client')}}</a>
                        </li>
                    </div>


                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-users icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('users.add_change_modules')}}
                                </div>
                            </div>
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                        	<!-- <h5 class="card-title">Grid Rows</h5> -->
                            <form  method="POST" action="{{ route('choose_module') }}">
                                {{ csrf_field() }}
                                <div class="form-row">
                                    <div class="col-12">
                                        <input type="hidden" name="uid" value="{{ Auth::user()->id }}"/>
                                        <select style="width:70%" class="select2 form-control" name="modules[]"  id="modules"  multiple="multiple" required>
                                            <option value=""  disabled > {{trans('users.select_module')}} </option> 
                                                @foreach($all_modules as $module)
                                                @if($module->name == "SMS")
                                        
                                                    <option value="{{$module->id}}"
                                                        @if(in_array($module->id,$selected_modules))
                                                        selected
                                                        @endif
                                                        >{{$module->name}}</option>
                                                @endif
                                                @if($module->name == "Invoicing")
                                               <!-- <option  value="{{$module->id}}" @if(in_array($module->id,$selected_modules))
                                                selected
                                                        @endif>{{$module->name}}</option> -->
                                            @endif
                                                @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                        <button type="submit" class="mt-2 btn btn-primary">{{trans('users.Save')}}</button>
                                </div>
                            </form>
                                </div>
                    </div>
                </div>
            </div>
@endsection

@section('javascript')
<script>
function settax(cntry)
{
    if(cntry.value==="PT")
{
  
    document.getElementById('tax_percentage').value=23
}
    
}

</script>

@endsection