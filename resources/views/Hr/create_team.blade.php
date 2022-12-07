@extends('partials.main')
@section('style')
<link href="{{asset('checkbox.css')}}" rel="stylesheet">

<style type="text/css">
   .avatar {
  border: 0.3rem solid rgba(#fff, 0.3);
  margin-top: -6rem;
  margin-bottom: 1rem;
  max-width: 7rem;
},

</style>
@endsection
@section('content')
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="fas fa-users icon-gradient bg-tempting-azure">
                        </i>
                    </div>
                    <div> Create Teams 
                    </div>
              
                      
                </div>
            </div>

        </div>            
       <div class="container">
                <form class="form-horizontal" method="POST" action="{{ route('hr.store_team') }}" onsubmit="return validateForm();">
                    {{ csrf_field() }}
                    <div class="form-row" id="team_form">
                        <div class="col-md-6">
                            <div class="position-relative form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="exampleName" class="">Team Name</label>
                                <input name="name" value="{{ old('name') }}"  id="exampleName" placeholder="Name here..." type="text" class="form-control" >
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <input type="hidden" name="emp_obj" id="emp_obj" value=""/>
                            <input type="hidden" name="uid" id="uid" value="{{ Auth::user()->id }}"/>

                        </div>
                        <div class="col-md-6 ">
                            <br>
                            <button id="submit" type="submit" name="submit" class="mt-2 btn btn-lg btn-primary">Create Team</button>
                        </div>
                    </div>   
                </form>   
            <div class="row" style="margin-top:8%;" >
                @foreach ($users as $usr)
                    @if(isset($usr->Hr_account_settings) && !empty($usr->Hr_account_settings))
                            <div class="col-12 col-sm-8 col-md-6 col-lg-3" style="margin-bottom:12%;"  id="uid{{$usr->id}}">
                                <div class="card" style="height:100%">
                                    <div class="card-body text-center">
                                            <img class="avatar rounded-circle" src="{{asset('img_avatar.png')}}" alt="Avatar">
                                            <h4 class="card-title mt-2">{{$usr->name}}</h4>
                                            <h6 class="card-subtitle mb-2 text-muted"></h6>
                                            <p class="card-text">
                                                {{ str_replace(array( '[', ']','"' ), '',$usr->roles()->pluck('name')) }}
                                        </p>             
                                        <input type="checkbox" name="{{'sel'.$usr->id}}" onclick="append_sel(this.value)" value="{{$usr->id}}">
                                    </div>
                                </div>
                            </div>
                        @endif
                @endforeach
                {{-- </form> --}}
            </div>
        </div>
    </div>
         
  
</div>

@endsection
@section('javascript')
<script>
    var sel=[];
    var count = 0;
function validateForm()
{
    if($('#exampleName').val()=="")
    {
        notif({
            msg: "<b>{{trans('clients.error')}}!</b> Team Name is required",
            type: "error",
            position: "center"
        });
        return false;
    }     
    else if(sel.length == 0)
    {
        notif({
            msg: "<b>{{trans('clients.error')}}!</b> you need select atleast one employee for the team",
            type: "error",
            position: "center"
        });
        return false;
    }
    else
    {
        $('#emp_obj').val(sel);
        return true;
    }

}
function append_sel(val)
{
    count = 0;
    if(sel.length == 0)
    {
        sel.push(val);
    }else
    {
        for(var i=0;i<sel.length;i++)
        {
            if(sel[i] == val)
            {
                const index = sel.indexOf(val);
                if (index > -1) {
                    sel.splice(index, 1);
                }
                count = 1;
            }
        }
        if(count == 0)
        {
            sel.push(val);
        }
    }
}
</script>
@endsection