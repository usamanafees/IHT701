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
                        <div> Company Settings
                        </div>
                    </div>
                    <div class="page-title-actions">
                        <div class="d-inline-block dropdown">
                            <a href="{{ route('hr.company.settings.holidays.add') }}" class="btn-shadow btn btn-info" href="">
                                <i class="fa fa-plus btn-icon-wrapper"> </i>&nbsp;
                                Add Holidays</a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="container">
                <div class="nav nav-pills">
                    <a href="{{ route('hr.company.settings.alerts')}}" class="nav-link"><span>Alerts</span></a>
                    <a href="{{ route('hr.company.settings.vacations')}}"
                       class="nav-link"><span>Vacations/Absences</span></a>
                    <a href="{{ route('hr.company.settings.extradays')}}" class="nav-link"><span>Extra Days</span></a>
                    <a href="{{ route('hr.company.settings.holidays')}}"
                       class="nav-link active"><span>Holidays</span></a>
                    <a href="{{ route('hr.company.settings.workdays')}}" class="nav-link"><span>Work Days</span></a>
                    <a href="{{ route('hr.company.settings.general')}}" class="nav-link"><span>General</span></a>
                </div>
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                            <thead>
                            <tr style="text-align: center">
                                <th>Name</th>
                                <th>Date</th>
                                <th>Recurrence</th>
                                <th>Country</th>
                                <th>Region</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($company_holidays as $holidays)
                                <tr style="text-align:center" id={{'r'.$holidays->id }}>
                                    <td>{{$holidays->name}}</td>
                                    <td>{{$holidays->date}}</td>
                                    <td>{{$holidays->recurrence}}</td>
                                    <td>{{$holidays->country}}</td>
                                    <td>{{$holidays->region}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="javascript:;" onclick="del_holidays_confirm({{$holidays->id}})" class="btn-shadow btn btn-danger btn-sm" href="">
                                                <i class="fas fa-ban"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function del_holidays_confirm(val) {
        $.confirm({
            title: 'Confirm delete',
            content: 'Are you sure you want to delete?',
            type: 'red',
            typeAnimated: true,
            buttons: {
                confirm: {
                    text: 'Yes',
                    btnClass: 'btn-red',
                    action: function () {

                        del_holiday(val);
                    }
                },
                close: function () {
                }
            }
        });
    }

    function del_holiday(id) {

        CSRF_TOKEN = "{{ csrf_token() }}";
        $.ajax({
            type: "POST",
            url: "{{route('hr.company.settings.holidays.delete')}}",
            data: {holidays_id: id, _token: CSRF_TOKEN},
            success: function (data) {

                if (data['success'] === "true") {
                    $("#r" + data['id']).hide();
                    notif({
                        msg: "<b>Success : Holidays deleted with success!",
                        type: "success"
                    });
                } else if (data['success'] === "false") {
                    notif({
                        msg: "<b>Error: Holiday don't exist!</b>",
                        type: "error",
                        position: "center"
                    });
                }
            },
            error: function (err) {
                notif({
                    type: "warning",
                    msg: "<b>Error: Holiday don't deleted!<b>",
                    position: "left"
                });
            }
        });
    }
</script>