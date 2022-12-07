@extends('partials.main')

@section('content')
    <style>

        /* Important part */
        .modal-dialog{
            overflow-y: initial !important
        }
        .modal-body{
            height: 20vh;
            overflow-y: auto;
        }
    </style>
    <div class="app-main__outer">
        <div class="app-main__inner">
            <div class="app-page-title">
                <div class="page-title-wrapper">
                    <div class="page-title-heading">
                        <div class="page-title-icon">
                            <i class="fas fa-file-download icon-gradient bg-tempting-azure">
                            </i>
                        </div>
                        <div>SAF-T PT
                        </div>
                    </div>
                    {{-- <div class="page-title-actions">
                        <div class=" dropdown ">
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                                <i class="fas fa-clock fa-lg"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Schedule
                            </button>
                        </div>
                    </div> --}}
                </div>
            </div>
            <div class="main-card mb-3 card">
                    <div class="card-body justify-content-center" >
                        <div class="mt-3 text-left content-checkbox">
                            <div class="card-body justify-content-center">
                                <a href="{{ asset('files/SAFT-PT.xml') }}" class="btn btn-success" download>Download</a>
                            </div>
                        </div>
                    </div>
            </div>

@endsection

<!-- Modal -->
<div class="modal fade" style="" id="exampleModal" tabindex="-2" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document" >
        <div class="modal-content" style="overflow:hidden;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">SAFT Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-body" >
                <form action="{{route('tax-authority.saft-schedule')}}" method="POST">
                    <label for="check_schedule">Schedule?&nbsp;<input type="checkbox" onclick="changeCheckbox()" id="check_schedule" name="check_schedule"></label><br>
                    <label for="date_schedule">Date:</label>
                    <input type="date" id="date_schedule" name="date_schedule" placeholder="">
                    <label for=time_schedule>Hours:</label>
                    <div style=" background-color: white;display: inline-flex;border: 1px solid #ccc;color: #555;">
                        <input type="number" name="hours_schedule" id="hours_schedule" min="0" max="23" style="border: none;color: #555;text-align: center;width: 35px;">:
                        <input type="number" name="minutes_schedule" id="minutes_schedule" min="0" max="59" style="border: none;color: #555;text-align: center;width: 35px;">
                    </div>
                    <!--<input type="time" id="time_schedule" name="time_schedule" required>--><br>
                    <button type="submit" class="btn btn-success">Save</button>
                </form>
            </div>
            <div class="modal-footer" >
                <span id="er_msg" class="align-self-center"></span>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <div id="imp"></div>
            </div>
        </div>
    </div>
</div>
