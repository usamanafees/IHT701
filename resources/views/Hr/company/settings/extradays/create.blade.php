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
                        <div> Create Extra Days
                        </div>
                    </div>
                </div>

            </div>
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('hr.company.settings.extradays.add.create') }}">
                        {{ csrf_field() }}
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <label for="name" class="">Name<span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" value="" placeholder="Name..."
                                           class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">Recurrence</label>
                                    <select class="form-control" name="recurrence" id="recurrence" type="number">
                                        <option value="Annual">
                                            Annual
                                        </option>
                                        <option value="Current Year">
                                            Current Year
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <label for="" class="">Date<span class="text-danger">*</span></label>
                                    <input type="date" id="date" class="form-control" name="date" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <h5>Assignment of extra days</h5>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <input type="radio" value="all" name="checkboxes" id="checkboxes1"
                                           onclick="country_region()" checked>Assign to
                                    all employees
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group">
                                    <select class=" form-control"
                                            name="country" onchange="set_region()" id="sel_country" disabled>
                                        <option value="" disabled selected>Select Country</option>
                                        @foreach ($countries as $ctr)
                                            <option value="{{$ctr->id}}">{{$ctr->name}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('country'))
                                        <span class="help-block"><strong>{{ $errors->first('country') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <input type="radio" value="country_region" name="checkboxes" id="checkboxes2"
                                               onclick="country_region()">
                                        Assign by Country and Region
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="position-relative form-group">
                                        <label>Region</label>
                                        <select class=" form-control"
                                                name="region" id="ctr_regions" disabled>
                                            <option value="">Select Region</option>
                                            {{-- @foreach ($cntry as $ctr)
                                              <option value="{{$ctr->iso_code}}">{{$ctr->name}}</option>
                                            @endforeach --}}
                                        </select>
                                        @if ($errors->has('region'))
                                            <span class="help-block"><strong>{{ $errors->first('region') }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <button type="submit" class="mt-2 btn btn-success">{{trans('items.Update')}}</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script type="text/javascript">
    window.country_region = function () {
        if (document.getElementById("checkboxes2").checked) {
            document.getElementById("sel_country").disabled = false;
            document.getElementById("ctr_regions").disabled = false;
        } else {
            document.getElementById("sel_country").disabled = true;
            document.getElementById("ctr_regions").disabled = true;
        }
    }

    function set_region() {
        var c_id = $('#sel_country').val();
        CSRF_TOKEN = "{{ csrf_token() }}";
        $.ajax({
            type: "POST",
            url: "{{route('hr.set_region')}}",
            data: {cid: c_id, _token: CSRF_TOKEN},
            success: function (data) {
                if (data['success'] === "true") {
                    $('#ctr_regions')
                        .find('option')
                        .remove();

                    for (var i = 0; i < data['regions'].length; i++) {
                        $('#ctr_regions').append('<option value=' + data['regions'][i].id + '>' + data['regions'][i].name + '</option>');
                    }
                }
            },
            // else if(data['success']==="false")
            // {
            //     notif({
            //         msg: "<b>Error!</b> region does not exist",
            //         type: "error",
            //         position: "center"
            //     });
            //     }
            // },
            error: function (err) {
                notif({
                    type: "warning",
                    msg: "<b>Warning:</b> Something Went Wrong while selecting the country",
                    position: "left"
                });
            }
        });
    }

</script>