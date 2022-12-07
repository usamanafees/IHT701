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
                            <a class="breadcrumb-item active" href="">{{trans('sms.sender')}}</a>

                        </li>

                    </div>


                    <div class="app-page-title">
                        <div class="page-title-wrapper">
                            <div class="page-title-heading">
                                <div class="page-title-icon">
                                    <i class="fas fa-users icon-gradient bg-tempting-azure">
                                    </i>
                                </div>
                                <div>{{trans('sms.Sender')}}
                                </div>
                            </div>
                              <!-- <div class="page-title-actions">
                                  <div class="d-inline-block dropdown">
                                      <a href="{{route('modules.add')}}" class="btn-shadow btn btn-info" href="">
                                          <i class="fa fa-plus btn-icon-wrapper"></i> &nbsp; {{trans('modules.add_module')}}</a>
                                  </div>
                              </div>  -->
                          </div>
                          <br>
                          <div class="card-header-title font-size-sm font-weight-normal" style="float: left;color: grey;">
                         <i class="fas fa-info-circle"></i>
                            <h7> {{trans('tips.sender_list')}}</h7>
                        </div>
                    </div>            
                    <div class="main-card mb-3 card">
					 @if (\Session::has('success'))
                        <div class="alert alert-success">
                           <p>
                              {!! \Session::get('success') !!}
                           </p>
                        </div>
                    @endif
					@if (\Session::has('error'))
						<div class="alert alert-warning">
						   <p>
							  {!! \Session::get('error') !!}
						   </p>
						</div>
                    @endif
                        <div class="card-body">
                            <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                                <thead>
                                  <tr>
                                      <th> {{trans('sms.sender_id')}}</th>
                                      <th>{{trans('sms.Sender')}}</th>
                                      <th>{{trans('sms.State')}}</th>
                                      <th>{{trans('sms.client_id')}}</th>
                                       <th>{{trans('sms.client')}}</th>
                                      <th>{{trans('sms.Entry_Date')}}</th>
                                      <th>{{trans('sms.Expiration_Date')}}</th>
									                   @can('Approve Sender')
                                      <th>{{trans('sms.approve_disapprove')}}</th>
                                     @endcan
                                      @if(in_array("Administrator" , Auth::user()->roles()->pluck('name')->toArray()))
                                      <th>{{trans('sms.action')}}</th>
                                      @endif
                                     
                                  </tr>
                                </thead>
                                <tbody>
                                  <span style="display:none">  {{ $i=-1 }}</span>
                                    @foreach($sms_sender as $sender)
                                    @php $i++ @endphp 
                                    <tr>
                                      <td>{{$sender->id}}</td>
                                      <td id="se{{$i}}">{{$sender->sender}}</td>
                                      <td>{{$sender->state}}</td>
                                      <td>{{$sender->user_id}}</td>
									  <td>{{isset($sender->User->name) ? $sender->User->name : "" }}</td>
                                      <td>{{\Carbon\Carbon::parse($sender->created_at)->format('d/m/Y')}}</td>
                                      <td id="ed{{$i}}">{{$sender->expiration_date}}</td>
									  @can('Approve Sender')
										  @if(in_array($sender->state,['pending','disapproved']))
											<td><a href="{{route('sender.approve',$sender->id)}}" style="text-align:center;">{{trans('sms.approve')}}</a></td>
										  @else
											<td><a href="{{route('sender.disapprove',$sender->id)}}" style="text-align:center;">{{trans('sms.disapprove')}}</a></td>
										  @endcan
                                      @endrole	 
                                      <td>  
                                        <a href="#" onclick="xyz(this.id)" id="abc{{$i}}" class="btn-sm btn-shadow btn btn-warning" data-toggle="modal" data-target="#exampleModal">
                                            <i class="fas fa-pen">
                                                
                                            </i>
                                        </a>
                                        {{-- <a type="button" class="fa fa-pencil"  data-toggle="modal" data-target="#exampleModal">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                      </a> --}}
                                    </td> 
                                    </tr>
                                    @endforeach
                                </tbody>
                                 <tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
@endsection
<div class="modal fade" style="" id="exampleModal" tabindex="-2" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" >
      <div class="modal-content" style="overflow:hidden;">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{trans('sms.edit_sender')}}</h5>
          <button type="button" class="close"  data-dismiss="modal" onclick="old()"  aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div id="load" style="display:none; z-index:8; position:absolute;margin-left:43%; margin-top:25%;text-align:center;">
            <img  src="{{asset("img/ajax-loader.gif")  }}" alt="this slowpoke moves"  width=50/>
            <p>{{trans('sms.wait')}}</p>
        </div>
        <div class="modal-body" id="aaa" >
            {{-- {{ route('import_wizard.upload_clients') }} --}}
            {{-- up_clients --}}
            <div id ="ccc" style="">
                <h3 class=>{{trans('sms.edit_sender')}}</h3>
            
                <form action="" id="ed_sender"  >
                    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
                    {{csrf_field()}}
                    <div class="form-row">
                        <div class="col-md-6 ">
                            <div class="position-relative form-group">
                                <input name="sender" id="sender" onkeyup="cap()" placeholder="Sender" type="text" class="form-control"  maxlength="11" minlength="1"  value="" required>
                                <span id="err" style="color:red"></span>
                            </div>
                        </div>
                      {{-- <span id="p_date"></span> --}}
                        <div class="col-md-6">
                         {{-- Previous date : <span id="spn" style="color:red"> </span> --}}
                            <div class="position-relative form-group ">
                                <input name="exp_date" id="exp_date" placeholder="Expiration date" type="date" class="form-control"  value="" >
                            </div>
                        </div>
                    </div>
                <input class="btn btn-success" type="submit" value="update" name="submit">
                </form>
            </div>
            <div id="smsg"></div>
        </div>
        <div class="modal-footer" >
            <span id="er_msg" class="align-self-center"></span>
          <button type="button" class="btn btn-danger" onclick="old()" data-dismiss="modal">{{trans('sms.close')}}</button>
          <div id="imp"></div>
        </div>
      </div>
    </div>
  </div> 

  @section('javascript')
<script>
var APP_URL = {!! json_encode(url('/')) !!}
var id;
var j;
var old_html;
var obj= <?php echo $sms_sender ?>;
function xyz(index)
{   
    var s_id = index.replace("abc","");
    $('#sender').val(obj[s_id]['sender']);
    $('#exp_date').val(obj[s_id]['expiration_date']);
     id  = obj[s_id]['id'];
     j=s_id;
}

function cap()
{
    var eleVal = document.getElementById('sender');
    eleVal.value= eleVal.value.toUpperCase().replace(/ /g,'');
}

  $('#ed_sender').submit(function (e) {
    $('#smsg').html('');

                var sender = $('#sender').val();
                var date = $('#exp_date').val();
                
      e.preventDefault();
        $.ajax({
            headers:
              {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
            url: APP_URL+'/sms/sender/update_sender',
            data:{'sender':sender,'date':date,'id':id},
            type: 'POST',
        success: function(data)
        {  
            if(data['result'] == "error")
            {
                $("#err").html("invalid sender");
            }
            else
            {
                $('#ed'+j).html(data['data']['expiration_date']);
                $('#se'+j).html(data['data']['sender']);
                $('#smsg').html('<h3 style="color:green; text-align:center;">Sender has been updated successfully</h3>');
                obj[j]['sender']=data['data']['sender'];
                obj[j]['expiration_date']= data['data']['expiration_date'];
            }
        },
        error:function (err)
        {
          console.log(err);
        }
        }); 
    });
function old()
{
  $('#smsg').html("");
  $("#err").html("");

}
</script>
@endsection
