@extends('partials.main')
@section('style')
<style type="text/css">
   .avatar {
  border: 0.3rem solid rgba(#fff, 0.3);
  margin-top: -6rem;
  margin-bottom: 1rem;
  max-width: 7rem;
}
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
                    <div> 
                        Monthly Days Off  
                    </div>
                </div>
            </div>
        </div>            
        <div class="main-card mb-3 card">
            <div class="card-body">
                <!-- <h5 class="card-title">Grid Rows</h5> -->
                        <form class="form-horizontal" method="POST" action="{{ route('hr.monthly_days_off_store') }}">
                            <input type="hidden" name="is_manager"  value="true" >
                            {{ csrf_field() }}
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="employee" class="">Employee</label>
                                        <select class=" form-control" name="employee" id="employee">
                                        @if(in_array("Manager" , Auth::user()->roles()->pluck('name')->toArray()) || in_array("Admin" , Auth::user()->roles()->pluck('name')->toArray()))
                                            <option value=""  selected disabled >select an employee</option>
                                            @foreach ($users as $user)
                                                <option value="{{$user->id}}"  >{{$user->name}}</option>
                                            @endforeach
                                        @else
                                        <option value="{{Auth::user()->id}}"   selected >{{Auth::user()->name}}</option>
                                        @endif
                                        </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="type" class="">Period</label>
                                        <select class=" form-control" name="period" id="period" onchange="chnage_period(this.value)" required>
                                            <option value="days" selected>days</option>
                                            <option value="1/2day">1/2 day</option>
                                        </select>
                                    </div>
                                </div>
                                @if(in_array("Manager" , Auth::user()->roles()->pluck('name')->toArray()) || in_array("Admin" , Auth::user()->roles()->pluck('name')->toArray()))

                                <div class="col-md-6 d-flex">
                                    <div class="position-relative form-group justify-content-center align-self-center">
                                        <div class="form-check mt-3 ml-2">
                                            <input class="form-check-input"    style="height:18px; /*Desired height*/ width:18px; /*Desired width*/" type="checkbox" name="self_days_off" id="self_days_off" onchange="self_request(this)">
                                            <label class="form-check-label ml-2 mt-1" for="flexCheckDefault">
                                             Self Days Off
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="" style="" id="days">
                                <div class="text-right"><button type="button" class="btn btn-success" onclick="add_days_off()">Add days</button></div>
                            
                            </div>

                            <div class="" id="half_day" style="display: none;">
                                <div class="text-right"><button type="button" class="btn btn-success" onclick="half_day_off()">Add day</button></div>
                                
                            </div>
                            <div class="form-row" >
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label for="observation" class="">Observation</label>
                                        <textarea  name="observation" id="observation"  class="form-control" value=""> </textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="position-relative form-group" id="attachments">
                                    <label for="observation" class="">Attachments</label>
                                      <div class="needsclick dropzone " id="atdrop">

                                      </div>
                                    </div>
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
</div>
@endsection
@section('javascript')
<script src="{{ asset('js/dropzone.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
var days_count = 0;
var date = new Date();
var firstDay = new Date();
var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    return [year, month, day].join('-');
}
function add_days_off()
{
    var day = '<div class="form-row mt-1 mb-3" id="r'+days_count+'" style="">'+
        '<div class="col-md-6">'+
            '<div class="position-relative form-group">'+
                '<label for="s_date" class="">Start Date</label>'+
                '<input type="date" name="days_off['+days_count+'][0]" min="'+formatDate(firstDay)+'" max="'+formatDate(lastDay)+'" id="s_date" placeholder="yyyy/mm/dd" class="form-control" value="" >'+
            '</div>'+
        '</div>'+
        '<div class="col-md-6">'+
            '<div class="position-relative form-group">'+
                '<label for="e_date" class="">End Date</label>'+
                '<input type="date" name="days_off['+days_count+'][1]" min="'+formatDate(firstDay)+'" max="'+formatDate(lastDay)+'" id="e_date" placeholder="yyyy/mm/dd" class="form-control" value="" >'+
            '</div>'+
        '</div>'+
        '<div class="col-md-6">'+
        '<div class="position-relative form-group">'+
            '<label for="type" class="">Days off type</label>'+
            '<select class=" form-control" name="days_off['+days_count+'][2]" id="type" required>'+
                '<option value="Vacations">Vacations</option>'+
                '<option value="Paternity leave">Paternity leave</option>'+
                '<option value="Maternity leave">Maternity leave</option>'+
                '<option value="Death in the family">Death in the family</option>'+
                '<option value="Medical absence">Medical absence</option>'+
                '<option value="Family absence">Family absence</option>'+
                '<option value="Education absence">Education absence</option>'+
                '<option value="Justified absence">Justified absence</option>'+
                '<option value="Unjustified absence">Unjustified absence</option>'+
            '</select>'+
        '</div>'+
        '</div>'+
        '<div class="col-md-6">'+
        '<div class="position-relative form-group">'+
            '<label for="type" class="">Remove This Period</label></br>'+
        '<button style="height:35px;" type="button" class="btn btn-sm btn-danger ml-3 " onclick="del_days_off_row('+days_count+')"><i class="fa fa-trash" aria-hidden="true"></i></button>'+
        '</div>'+
        '</div>'+
        '</br><br>'+
        '</div>';
    $('#days').append(day);
    days_count ++;
}

function del_days_off_row(count)
{
    $('#r'+count).remove();
}

var half_days_count = 0;

function half_day_off()
{
    var half_day = '<div class="row mb-5" id="d'+half_days_count+'">'+
            '<div class="col-md-6">'+
                '<div class="position-relative form-group">'+
                    '<label for="_date" class="">Date</label>'+
                    '<input type="date" name="half_dyas['+half_days_count+'][0]" min="'+formatDate(firstDay)+'" max="'+formatDate(lastDay)+'" id="_date" placeholder="dd/mm/yyyy" class="form-control" value="">'+
                '</div>'+
            '</div>'+
            '<div class="col-md-6">'+
                '<div class="position-relative form-group">'+
                    '<label for="type" class="">Period of Day</label>'+
                    '<select class=" form-control" name="half_dyas['+half_days_count+'][1]" id="period_of_day" required>'+
                        '<option value="days">Morning</option>'+
                        '<option value="evening">Evening</option>'+
                    '</select>'+
                '</div>'+
            '</div>'+

            '<div class="col-md-6">'+
        '<div class="position-relative form-group">'+
            '<label for="type" class="">Days off type</label>'+
            '<select class=" form-control" name="half_dyas['+half_days_count+'][2]" id="type" required>'+
                '<option value="Vacations">Vacations</option>'+
                '<option value="Paternity leave">Paternity leave</option>'+
                '<option value="Maternity leave">Maternity leave</option>'+
                '<option value="Death in the family">Death in the family</option>'+
                '<option value="Medical absence">Medical absence</option>'+
                '<option value="Family absence">Family absence</option>'+
                '<option value="Education absence">Education absence</option>'+
                '<option value="Justified absence">Justified absence</option>'+
                '<option value="Unjustified absence">Unjustified absence</option>'+
            '</select>'+
        '</div>'+
        '</div>'+
        '<div class="col-md-6">'+
        '<div class="position-relative form-group">'+
            '<label for="type" class="">Remove This Period</label></br>'+
            '<button type="button" style="height:35px;" class="btn btn-sm btn-danger ml-3" onclick="del_half_days_off_row('+half_days_count+')"><i class="fa fa-trash" aria-hidden="true"></i></button>'+
        '</div>'+
        '</div>'+
        '<hr>'+
        '</div>';
        $('#half_day').append(half_day);
        half_days_count ++;
        
}
function del_half_days_off_row(id)
{
    $('#d'+id).remove();
}
function self_request(obj)
{
    if($(obj).is(":checked")){
        $('#employee').val('');
        $('#employee').attr('disabled',true);
        $('#employee').attr('required',false);
  }else{
    $('#employee').attr('disabled',false);
    $('#employee').attr('required',true);
  }
}
function chnage_period(val)
{
    if(val=="days")
    {
        $('#half_day').hide();
        $('#days').show();
    }
    if(val=="1/2day")
    {
        $('#half_day').show();
        $('#days').hide();
    }
}

 Dropzone.autoDiscover = false;
    var gallerymap ={}
   $(document).ready(function() {

  $("#atdrop").dropzone({
                maxFiles: 5000,
                addRemoveLinks: true,
                url: "{{route('hr.store_dayoff_attachments')}}",
                headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function (file, response) {
                    gallerymap[file.name] = response.name;
                    $('#attachments').append('<input type="hidden" class="form-control"'+ 
                    'name="attachments[]" value="'+response.name+'" style="padding:1px">');
                },
                removedfile: function (file) {
                        file.previewElement.remove()
                        name = gallerymap[file.name];
                        if(name != ''){
                        $.ajax({
                            headers: {
                                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                    },
                            type: 'POST',
                            url: '{{ route("hr.delete_dayoff_attachments") }}',
                            data: {filename: name},
                            success: function (data){
                            $('#attachments').find('input[name="attachments[]"][value="' + name + '"]').remove();
                            },
                            error: function(e) {
                                console.log(e);
                            }
                        });
                    }   
                }
            }); 
        });
</script>
@endsection