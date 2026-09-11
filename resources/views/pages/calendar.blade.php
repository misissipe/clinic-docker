@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Datatables')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
{{-- page-styles --}}
{{-- @extends('layouts.app') --}}
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
              
          
            </div>
        </div>
    </div>
</div>
@endsection
{{-- vendor scripts --}}
@section('vendor-scripts')
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
</script>
@endsection