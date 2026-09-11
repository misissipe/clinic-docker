@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Calendar')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
<style>
.box {
  height: 20px;
  width: 20px;
  margin-bottom: 15px;
  border: 1px solid black;
}
.white {
  background-color: white;
}
.red {
  background-color: #ff5b5c;
}

.green {
  background-color: #39da8a;
}

.blue {
  background-color: #5a8dee;
}
.gray {
  background-color: #475f7b;
}
.light {
  background-color: #a3afbd;
}
 .lightrd {
    background-color: #fafafa;
    border: 2px solid #ff5b5c;
    display: inline-block;
  }
.orange {
  background-color: #fdac41;
}
</style>
{{-- page-styles --}}
{{-- @extends('layouts.app') --}}
@section('content')
<section id="basic-datatable">
    <div class="row">
        <div class="col-xl-2 ">
            <div class="card p-2">
                <h5>STATUS</h5>
               <div class="col-md-12" id="status">
                <div class="row"> <div class='col-md-1 box blue'></div>&emsp;<span ><strong style="color:#5a8dee;font-size:16px">Pending</strong></span></div>
                <div class="row"><div  class='col-md-1 box green'></div>&emsp; <span ><strong style="color:#39da8a;font-size:16px">Approved</strong></span></div>
                <div class="row"><div class='col-md-1 box red'></div> &emsp;<span  ><strong style="color:#ff5b5c;font-size:16px">Dissaproved</strong></span></div>
                <div class="row"><div class='col-md-1 box orange'></div> &emsp;<span  ><strong style="color:#fdac41;font-size:16px">Reserved</strong></span></div>
                {{-- <div class="row"><div class='col-md-1 box gray'></div> &emsp;<span  ><strong style="color:#475f7b;font-size:16px">Cancelled</strong></span></div> --}}
                {{-- <hr> --}}
                {{-- <div class="row"><div  class='col-md-1 box light'></div>&emsp; <span ><strong style="color:#a3afbd;font-size:16px">Done</strong></span></div> --}}
                {{-- <div class="row"><div class="col-md-1 box lightrd"></div>  &emsp;<span><strong style="color:#ff5b5c; font-size:16px;">Rescheduled</strong></span></div> --}}
               </div>
           </div>
         </div>
        <div class="col-xl-10 m-auto">
           <div class="card p-2">
              <div id="calendar"></div>
          </div>
        </div>
    </div>
    <div class="modal fade" id="ReserveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h3 class="modal-title w-100" id="exampleModalLabel">Appointment Reservation</h3>
                    <button type="button" class="close" data-dismiss="modal" id="cancelBtn" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
<!-- Step 1: Select Available Slot -->
                    <div id="step1">
                        <h5 class="text-center">Select Available Slot</h5>
                        <div class="row form-group">    
                            <label for="time">Select Time:</label>&nbsp;
                            <input type="time" id="time" name="time" class="form-control col-5 @error('time') is-invalid @enderror" value="{{ old('time') }}" required autocomplete="time" />&emsp;
                            <button type="button" id="proceedToStep2" class="btn btn-primary">Next</button>
                        </div> 
                    </div>
<!-- Step 2: Input Appointment Details -->
                    <div id="step2" style="display: none;">
                        <div class="form-group">
                            <form action="/setReservation" method="post" id="appointmentForm">
                                @csrf
                                <input class="form-control" type="hidden" name="role" id="role">
                                <input class="form-control" type="hidden" name="patientId" id="id" value="">
                                <input class="form-control" type="hidden" name="status" id="Reserved" value="Reserved">
                                <input class="form-control lastname" type="text" name="lastname" id="lastname">
                                <input class="form-control firstname" type="text" name="firstname" id="firstname">
                                <input class="form-control middlename" type="text" name="middlename" id="middlename">
                                <input class="form-control" type="hidden" name="date" id="selectedDate">
                                <input class="form-control" type="hidden" name="time" id="selectedTime">
                                {{-- <input class="form-control" type="hidden" name="date" id="selectedDate"> --}}
                                <div style="font-weight: 400; font-size: 20px;">
                                    <div class="col-md-12">
                                        <label for="purpose" style="display: inline-block;width:50%">Contact Number: </label>
                                        <input type="text" id="contactNo" style="display: inline-block;" class="form-control @error('contactNo') is-invalid @enderror" name="contactNo" value="{{ old('contactNo') }}" required autocomplete="contactNo" />
                                    </div>
                                    <br>
                                    <div class="col-md-12">
                                        <label for="purpose" style="display: inline-block;width:20%">Purpose:</label>
                                        <div class="form-check" style="margin-left:50px">
                                            <input type="checkbox" name="purpose[]" value="Consultation">
                                            <label style="text-transform: capitalize;font-size:12px;">Dental Check-up/ Consultation</label>
                                        </div>
                                        <div class="form-check" style="margin-left:50px">
                                            <input type="checkbox" name="purpose[]" value="Oral Restoration">
                                            <label style="text-transform: capitalize;font-size:12px;">Cavity Filling/ Oral Restoration</label>
                                        </div>
                                        <div class="form-check" style="margin-left:50px">
                                            <input type="checkbox" name="purpose[]" value="Oral Prophylaxis">
                                            <label style="text-transform: capitalize;font-size:12px;">Oral Prophylaxis</label>
                                        </div>
                                        <div class="form-check" style="margin-left:50px ">
                                            <input type="checkbox" name="purpose[]" value="Tooth Extraction">
                                            <label style="text-transform: capitalize;font-size:12px;">Tooth Extraction</label>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <button type="button" id="backtoStep1" class="btn btn-secondary btn-custom float-left">Back</button>
                                        <button type="submit" class="btn btn-primary btn-custom float-right">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="DetailsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="DetailsModalLabel">Appointment Details</h5>
                    <button type="button" class="close" data-dismiss="modal" id="cancelBtn" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post" id="appointmentForm">
                    @csrf
                    <input class="form-control id" type="hidden" name="id" id="id">
                    <input class="form-control date" type="hidden" name="date" id="date">
                    <input class="form-control time" type="hidden" name="time" id="time">
                    <div class="modal-body" id="modalDetailsContent">
<!-- Event details will be dynamically added here -->
                    </div>
                    <div class="modal-footer">
                        <button type="submit" form="acceptappointment" class="btn btn-success AcceptAppointmentBtn" id="AcceptAppointmentBtn">Accept</button>
                        <button type="submit" form="cancelappointment" class="btn btn-danger cancelAppointmentBtn" id="cancelAppointmentBtn">Cancel</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@3.2.0/dist/fullcalendar.min.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

$(document).ready(function() {

    var reserve = @json($reserve);

    // FILTER OUT INVALID EVENTS
    reserve = reserve.filter(function(event) {
        return event.date && moment(event.date).isValid();
    });

    var occupiedDates = reserve.map(function(event) {
        return moment(event.date).format('YYYY-MM-DD');
    });

    var myModal = new bootstrap.Modal(document.getElementById('ReserveModal'));

    // Auto-cancel / update past reservations

    reserve.forEach(function(event) {
        if (!event.date || !moment(event.date).isValid()) return;

        if (moment(event.date).isBefore(moment(), 'day')) {
            if (event.status === 'Reserved' || event.status === 'Pending') {
                $.post('/cancelAppointment', { id: event.id, date: event.date, time: event.time }, function(response){
                    if(response.status === 200){
                        console.log(`Past reservation on ${event.date} (${event.status}) canceled.`);
                    }
                });
            } else if (event.status === 'Approved') {
                $.post('/updateStatus', { id: event.id, status: 'Done' }, function(response){
                    if(response.status === 200){
                        console.log(`Past reservation on ${event.date} marked as 'Done'.`);
                    }
                });
            } else if (event.status === 'Disapproved') {
                $.post('/updateStatus', { id: event.id, status: 'Reschedule' }, function(response){
                    if(response.status === 200){
                        console.log(`Past reservation on ${event.date} marked as 'Reschedule'.`);
                    }
                });
            }
        }
    });

    // Initialize FullCalendar

    $('#calendar').fullCalendar({
        header: {
            left: '',
            center: 'title',
            right: 'today,prev,next'
        },
        height: 750,
        events: reserve,
        selectable: true,
        eventRender: function(event, element) {
            // Skip if invalid date
            if (!event.date || !moment(event.date).isValid()) return;

            element.find('.fc-title').html(`
                <button class="btn btn-sm view-details w-100" data-id="${event.id}">
                    View Details
                </button>
            `);

            let button = element.find('.view-details');
            element.css("background-color", "transparent");
            button.removeClass('btn-info btn-primary btn-success btn-danger btn-warning btn-secondary');

            if (moment(event.date).isBefore(moment(), 'day')) {
                element.css("background-color", "#dcdcdc");
                button.addClass('btn-light');
            } else if (occupiedDates.includes(moment(event.date).format('YYYY-MM-DD'))) {
                switch(event.status) {
                    case 'Reserved': button.addClass('btn-warning'); break;
                    case 'Cancelled': button.addClass('btn-secondary'); break;
                    case 'Pending': button.addClass('btn-primary'); break;
                    case 'Approved': button.addClass('btn-success'); break;
                    case 'Disapproved': button.addClass('btn-danger'); break;
                }
            }
        },

        selectAllow: function(selectInfo) {
            var dayOfWeek = selectInfo.start.day();
            var today = moment().startOf('day');
            return dayOfWeek !== 0 && dayOfWeek !== 6 && selectInfo.start.isSameOrAfter(today);
        },

        select: function(start) {
        var selectedDate = start.format('YYYY-MM-DD');
        $('#selectedDate').val(selectedDate);

        $.ajax({
            type: 'GET',
            url: '/getAvailableSlots/' + selectedDate,
            success: function(response) {
                var reservedSlots = response.reservedSlots;
                var availableSlotsHtml = '';

                var reservedSlots = reservedSlots || [];

                var reservedSlotsFormatted = reservedSlots.map(function(slot) {
                    return moment(slot, 'HH:mm:ss').format('HH:mm');
                });

                reservedSlotsFormatted.forEach(function(slot) {
                    availableSlotsHtml += `
                        <div class="col-4 mb-2">
                            <button class="btn btn-danger reserved-slot w-100" disabled>
                                ${moment(slot, 'HH:mm').format('h:mm A')}
                            </button>
                        </div>
                    `;
                });

                $('#availableSlots').html(`
                    <div class="row">
                        ${availableSlotsHtml}
                    </div>
                `);

                myModal.show();
            },
            error: function() {
                alert('Error fetching available slots.');
            }
        });
    },
    });

 
    // Step navigation

    $('#backtoStep1').click(function(){
        $('#step2').hide();
        $('#step1').show();
    });

    $('#proceedToStep2').click(function(){
        var selectedTime = $('#time').val();
        if(selectedTime){
            $('#selectedTime').val(moment(selectedTime, 'HH:mm').format('h:mm A'));
            $('#step1').hide();
            $('#step2').show();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Time Selection',
                text: 'Please select a time slot before proceeding.'
            });
        }
    });


    // View Details Modal

    $('#calendar').on('click', '.view-details', function() {
        const eventId = $(this).data('id');
        const eventDetails = reserve.find(e => e.id === eventId);
        if (!eventDetails) return;

        $('#modalDetailsContent').html(`
            <p><strong>Date:</strong> ${moment(eventDetails.date).format('MMMM DD, YYYY')}</p>
            <p><strong>Time:</strong> ${moment(eventDetails.time, 'HH:mm:ss').format('h:mm A')}</p>
            <p><strong>Status:</strong> ${eventDetails.status}</p>
            <p><strong>Purpose:</strong> ${JSON.parse(eventDetails.purpose).join(', ')}</p>
        `);

        var myModalDetails = new bootstrap.Modal(document.getElementById('DetailsModal'));

        $('.cancelAppointmentBtn').toggle(eventDetails.status === 'Reserved')
            .data('id', eventDetails.id)
            .data('date', eventDetails.date)
            .data('time', eventDetails.time);

        $('.AcceptAppointmentBtn').toggle(eventDetails.status === 'Reserved')
            .data('id', eventDetails.id)
            .data('date', eventDetails.date)
            .data('time', eventDetails.time);

        myModalDetails.show();
    });


    // Appointment Form Submit

    $('#appointmentForm').submit(function(e){
        e.preventDefault();
        $.post('/setReservation', $(this).serialize(), function(response){
            if(response.status === 200){
                Swal.fire({
                    title: "Success!",
                    text: "Appointment booked successfully!",
                    icon: "success"
                }).then(()=>{
                    myModal.hide();
                    $('#appointmentForm')[0].reset();
                    location.reload();
                });
            } else {
                Swal.fire({
                    title: "Error!",
                    text: response.error,
                    icon: "error"
                });
            }
        }).fail(function(){
            Swal.fire({ title:"Oops!", text:"An error occurred.", icon:"error" });
        });
    });

    // Cancel Appointment

    $('#cancelAppointmentBtn').click(function(){
        var id = $(this).data('id');
        var date = $(this).data('date');
        var time = $(this).data('time');
        var myModalDetails = new bootstrap.Modal(document.getElementById('DetailsModal'));

        if (!id || !date || !time) {
            return Swal.fire({ icon:'error', title:'Error', text:'Required data is missing.' });
        }

        Swal.fire({
            title: 'Cancel Appointment',
            text: 'Are you sure you want to cancel your appointment?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No, cancel',
            confirmButtonColor: '#d33',
        }).then((result)=>{
            if(result.isConfirmed){
                $.post('/cancelAppointmentCalendar', { id: id, date: date, time: time }, function(response){
                    if(response.status === 200){
                        Swal.fire({ icon:'success', title:'Appointment Canceled', text:'Your appointment has been canceled.' })
                            .then(()=>{ myModalDetails.hide(); location.reload(); });
                    } else {
                        Swal.fire({ icon:'error', title:'Error', text:response.error });
                    }
                }).fail(()=>{ Swal.fire({ icon:'error', title:'Error', text:'An error occurred.' }); });
            }
        });
    });
    // Accept Appointment
    $('#AcceptAppointmentBtn').click(function(){
        var id = $(this).data('id');
        var date = $(this).data('date');
        var time = $(this).data('time');
        var myModalDetails = new bootstrap.Modal(document.getElementById('DetailsModal'));

        if (!id || !date || !time) {
            return Swal.fire({ icon:'error', title:'Error', text:'Required data is missing.' });
        }

        $.post('/AcceptAppointment', { id: id, date: date, time: time }, function(response){
            if(response.status === 200){
                Swal.fire({ title:"Success!", text:"Appointment booked successfully!", icon:"success" })
                    .then(()=>{ myModalDetails.hide(); location.reload(); });
            } else {
                Swal.fire({ title:"Error!", text:response.error, icon:"error" });
            }
        }).fail(()=>{ Swal.fire({ title:"Oops!", text:"An error occurred.", icon:"error" }); });
    });

});


</script>
@endsection