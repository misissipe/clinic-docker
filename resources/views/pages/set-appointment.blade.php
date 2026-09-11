@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Datatables')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
{{-- page-styles --}}
@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Zero configuration</h4>
                </div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Appointments</h3>
                                </div>
                                <div class="card-body">
                                    <head>
                                        <title>Appointments Calendar</title>
                                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
                                    </head>
                                    <body>
                                        <div id="calendar"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</section>
@endsection
{{-- vendor scripts --}}
@section('vendor-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script>
    $(document).ready(function() {

var date = new Date();

renderCalendar(date.getMonth(), date.getFullYear());

$('.prev').click(function() {
    var month = parseInt($('.month-name').text());
    var year = parseInt($('.year').text());
    if (month == 0) {
        month = 11;
        year -= 1;
    } else {
        month -= 1;
    }
    renderCalendar(month, year);
});

$('.next').click(function() {
    var month = parseInt($('.month-name').text());
    var year = parseInt($('.year').text());
    if (month == 11) {
        month = 0;
        year += 1;
    } else {
        month += 1;
    }
    renderCalendar(month, year);
});

function renderCalendar(month, year) {
    $.ajax({
        type: 'GET',
        url: '/appointments',
        data: {
            'month': month + 1,
            'year': year
        },
        success: function(data) {
            $('.calendar .calendar-header .month-name').text(data.month_name);
            $('.calendar .calendar-header .year').text(data.year);
            $('.calendar .calendar-body').html(data.calendar);
        },
        error: function(data) {
            console.log(data);
        }
    });
}
});

$(document).ready(function() {
            // Initialize the calendar
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultView: 'month',
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                events: [
                    @foreach($appointments as $appointment)
                        {
                          
                        },
                    @endforeach
                ],
                selectable: true,
                selectHelper: true,
                select: function(start, end) {
                    // Open a new modal to create a new appointment
                },
                eventClick: function(calEvent, jsEvent, view) {
                    // Open a modal to edit the selected appointment
                }
            });
        });
</script>
@endsection