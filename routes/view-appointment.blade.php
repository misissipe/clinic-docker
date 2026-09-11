@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Schedule')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
table,td,tr{
  border: 1px solid rgb(226, 222, 222);
  border-collapse: collapse;
  padding: 1px;
  text-align: center;
}
thead{
  background-color: rgb(110, 155, 222);
}
input {
  outline: 0;
  border-width: 0;
  border-color: rgb(58, 57, 57)
}
textarea  {
  outline: 0;
  border-width: 0;
  border-color: rgb(58, 57, 57)
}
.ph-card-header
{
  background-color: #3a76c5;
}
.cell-border{
  border-color: rgb(138, 138, 138)
}

.inline-cursor {
  text-align: center;
  font-size: 12px;
  font-weight: 800;
  text-transform: capitalize;
  transition: font-size 0.3s, color 0.3s;
}
.inline-cursor:hover {
  font-size: 16px; 
  color: #000000;
  cursor: pointer;
}
.pending-status {
  color: rgb(99, 175, 211);
  text-shadow:  5px rgba(113, 207, 238, 0.5);
}
.approved-status {
  color:  rgb(99, 211, 108);
  text-shadow:  5px rgba(113, 238, 121, 0.5);
}
.disapproved-status {
  color: rgb(211, 99, 99);
  text-shadow:  5px rgba(238, 113, 113, 0.5);
}
.rescheduled-status {
  color: rgb(206, 187, 48);
  text-shadow:  5px rgba(238, 113, 113, 0.5);
}
</style>
@endsection
{{-- page-styles --}}

@section('content')
{{-- <div class="row">
    <div class="col-12">
        <p>Read full documnetation <a href="https://datatables.net/" target="_blank">here</a></p>
    </div>
</div> --}}
<!-- Zero configuration table -->
<section id="basic-datatable">
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" aria-controls="home" role="tab"
              aria-selected="true">
              <i class="bx bx-calendar align-middle"></i>
              <span class="align-middle"> Schedule</span>
              <span class="badge badge-danger">{{$schedToday}}</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile" role="tab"
              aria-selected="false">
              <i class="bx bx-calendar-edit align-middle"></i>
              <span class="align-middle">Reschedule</span>
              <span class="badge badge-danger">{{$reschedCount}}</span>
            </a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="home" aria-labelledby="home-tab" role="tabpanel">
            <div class="table-responsive">
              <label for="role" style="display: inline-block;font-size:15px;text-transform:capitalize;">&nbsp;VIEW SCHEDULE:&nbsp;</label>
              <select name="roleSched" class="form-control col-sm-1" id="Schedule" style="display: inline-block;">
                <option value="disable selected" disabled>-Select-</option>
                <?php
                  $patient = array("Today", 'All');
                  foreach ($patient as $pa) {
                    echo "<option value=\"$pa\">$pa</option>";
                  }
                ?>
              </select>
              <div class="table-responsive view-all active" id="todaySchedule">
                <table class="table table-sm record record cell-border  " id="scheduleToday" style="width:100%">
                  <thead>
                    <tr>
                      <th style="color:rgb(255, 255, 255);">Role</th>
                      <th style="color:rgb(255, 255, 255);">ID Number</th>
                      <th style="color:rgb(255, 255, 255);">Name</th>
                      <th style="color:rgb(255, 255, 255);">Purpose</th>
                      <th style="color:rgb(255, 255, 255);">contactNo</th>
                      <th style="color:rgb(255, 255, 255);">Date</th>
                      <th style="color:rgb(255, 255, 255);">Time</th>
                      <th style="color:rgb(255, 255, 255);">Status</th>
                    </tr>
                  </thead>
                  <tbody id="viewAllRecord">
                  @foreach ($viewToday as $data)
                    <tr>
                      <td>{{ $data->role }}</td>
                      <td>{{ $data->patientId }}</td>
                      <td>{{ $data->lastname}}, {{ $data->firstname}} {{ $data->middlename}}</td>
                      <td>{{ implode(', ', json_decode($data->purpose)) }} </td>                                                        
                      <td>{{ $data->contactNo }}</td>
                      <td>{{ date('m-d-Y', strtotime($data->date)) }}</td>
                      <td>{{ date('h:i A', strtotime($data->time)) }}</td>
                      <td class="@if($data->status == 'Pending') pending-status @elseif($data->status == 'Approved') approved-status @elseif($data->status == 'Disapproved') disapproved-status @elseif($data->status == 'Rescheduled') rescheduled-status @endif">{{ $data->status }}</td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <div class="table-responsive view-all" id="viewAllSched" style="display : none">
                <table class="table table-sm record cell-border  " id="scheduleAll">
                  <thead>
                    <tr>
                      <th style="color:rgb(255, 255, 255);">Role</th>
                      <th style="color:rgb(255, 255, 255);">ID Number</th>
                      <th style="color:rgb(255, 255, 255);">Name</th>
                      <th style="color:rgb(255, 255, 255);">Purpose</th>
                      <th style="color:rgb(255, 255, 255);">contactNo</th>
                      <th style="color:rgb(255, 255, 255);">Date</th>
                      <th style="color:rgb(255, 255, 255);">Time</th>
                      <th style="color:rgb(255, 255, 255);">Status</th>
                    </tr>
                  </thead>
                  <tbody id="viewAllRecord">
                  @foreach ($viewAll as $data)
                    <tr>
                      <td>{{ $data->role }}</td>
                      <td>{{ $data->patientId }}</td>
                      <td>{{ $data->lastname}}, {{ $data->firstname}} {{ $data->middlename}}</td>
                      <td>{{ implode(', ', json_decode($data->purpose)) }} </td>   
                      <td>{{ $data->contactNo }}</td>                                                       
                      @php
                        $currentDateTime = \Carbon\Carbon::now();
                        $appointmentDateTime = \Carbon\Carbon::parse($data->date . ' ' . $data->time);
                      @endphp
                        <td class="@if($appointmentDateTime->isPast()) text-danger @endif">{{ date('m-d-Y', strtotime($data->date)) }}</td>
                        <td class="@if($appointmentDateTime->isPast()) text-danger @endif">{{ date('h:i A', strtotime($data->time)) }}</td>
                        <td class="@if($data->status == 'Pending') pending-status @elseif($data->status == 'Approved') approved-status @elseif($data->status == 'Disapproved') disapproved-status @elseif($data->status == 'Rescheduled') rescheduled-status @endif">{{ $data->status }}</td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="tab-pane" id="profile" aria-labelledby="profile-tab" role="tabpanel">
            <div class="table-responsive">
              <label for="role" style="display: inline-block;font-size:15px;text-transform:capitaliz;">VIEW RESCHEDULED:&nbsp;</label>
              <select name="roleDisapprove" class="form-control col-sm-1" id="Disapprove" style="display: inline-block;">
                <option value="" disabled selected>-Select-</option>
                <?php
                $appointment = array("Today", "All");
                foreach ($appointment as $app) {
                    echo "<option value=\"$app\">$app</option>";
                }
                ?>
            </select>
            <div class="table-responsive view-all active" id="todayDisapprove">
              <table class="table table-sm data cell-border " id="disToday">
                  <thead>
                      <tr>
                        <th style="color:rgb(255, 255, 255);">Action</th>
                        <th style="color:rgb(255, 255, 255);">Role</th>
                          <th style="color:rgb(255, 255, 255);">ID Number</th>
                          <th style="color:rgb(255, 255, 255);">Name</th>
                          <th style="color:rgb(255, 255, 255);">Purpose</th>
                          <th style="color:rgb(255, 255, 255);">Contact Number</th>
                          <th style="color:rgb(255, 255, 255);">Date</th>
                          <th style="color:rgb(255, 255, 255);">Time</th>
                          <th style="color:rgb(255, 255, 255);">Status</th>
                          <th style="color:rgb(255, 255, 255);">Reason</th>
                        
                      </tr>
                  </thead>
                  <tbody id="viewAllRecord">
                      @foreach ($resched as $data)
                      <tr>
                        <td style="text-align:center">
                          <div class="dropdown">
                            <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                            <div class="dropdown-menu dropdown-menu-right">
                              <a class="dropdown-item deleteButton reschedule disable-button" href="#"  data-role="{{ $data->role }}" data-id="{{ $data->id }}" data-toggle="modal" data-target="#reschedule" name="status" value="Cancelled "><i class="fa fa-calendar" style="color: rgb(57, 50, 49)"></i>&nbsp; Reschedule</a>
                                <a class="dropdown-item deleteButton cancel disable-button" href="#"  data-role="{{ $data->role }}" data-id="{{ $data->id }}"  name="status" value="Cancelled "><i class="fa fa-close" style="color: rgb(57, 50, 49)"></i>&nbsp; Cancel</a>
                              </div>
                            </div>
                        </td>
                         <td>{{ $data->role }}</td>
                          <td>{{ $data->patientId }}</td>
                          <td>{{ $data->lastname}}, {{ $data->firstname}} {{ $data->middlename}}</td>
                          <td>{{ implode(', ', json_decode($data->purpose)) }} </td>                            
                          <td>{{ $data->contactNo }}</td>
                          <td>{{ date('m-d-Y', strtotime($data->date)) }}</td>
                          <td>{{ date('h:i A', strtotime($data->time)) }}</td>
                          <td class="@if($data->status == 'Pending') pending-status @elseif($data->status == 'Approved') approved-status @elseif($data->status == 'Disapproved') disapproved-status @elseif($data->status == 'Rescheduled') rescheduled-status @endif">{{ $data->status }}</td>
                          <td>{{ strtolower($data->remarks) }}</td>
                      
                      </tr>
                      @endforeach
                  </tbody>
              </table>
            </div>
            <div class="table-responsive view-all" id="viewDisapprove" style="display : none">
              <table class="table table-sm data cell-border" id="disAll">
                  <thead>
                      <tr>
                        <th style="color:rgb(255, 255, 255);">Action</th>
                         <th style="color:rgb(255, 255, 255);">Role</th>
                          <th style="color:rgb(255, 255, 255);">ID Number</th>
                          <th style="color:rgb(255, 255, 255);">Name</th>
                          <th style="color:rgb(255, 255, 255);">Purpose</th>
                          <th style="color:rgb(255, 255, 255);">Contact Number</th>
                          <th style="color:rgb(255, 255, 255);">Date</th>
                          <th style="color:rgb(255, 255, 255);">Time</th>
                          <th style="color:rgb(255, 255, 255);">Status</th>
                          <th style="color:rgb(255, 255, 255);">Reason</th>
                          {{-- <th style="color:rgb(255, 255, 255);">Reschedule</th> --}}
                      </tr>
                  </thead>
                  <tbody id="viewAllRecord">
                      @foreach ($viewResched as $data)
                      <tr>
                        <td style="text-align:center">
                          <div class="dropdown">
                            <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                            <div class="dropdown-menu dropdown-menu-right">
                              <a class="dropdown-item deleteButton reschedule disable-button" href="#"  data-role="{{ $data->role }}" data-id="{{ $data->id }}" data-toggle="modal" data-target="#reschedule" name="status" value="Cancelled "><i class="fa fa-calendar" style="color: rgb(57, 50, 49)"></i>&nbsp; Reschedule</a>
                                <a class="dropdown-item deleteButton cancel disable-button" href="#"  data-role="{{ $data->role }}" data-id="{{ $data->id }}"  name="status" value="Cancelled "><i class="fa fa-close" style="color: rgb(57, 50, 49)"></i>&nbsp; Cancel</a>
                              </div>
                            </div>
                        </td>
                         <td>{{ $data->role }}</td>
                          <td>{{ $data->patientId }}</td>
                          <td>{{ $data->lastname}}, {{ $data->firstname}} {{ $data->middlename}}</td>
                          <td>{{ implode(', ', json_decode($data->purpose)) }} </td>          
                          <td>{{ $data->contactNo }}</td>
                          <td>{{ date('m-d-Y', strtotime($data->date)) }}</td>
                          <td>{{ date('h:i A', strtotime($data->time)) }}</td>
                          <td class="@if($data->status == 'Pending') pending-status @elseif($data->status == 'Approved') approved-status @elseif($data->status == 'Disapproved') disapproved-status @elseif($data->status == 'Rescheduled') rescheduled-status @endif">{{ $data->status }}</td>
                          <td>{{ strtolower($data->remarks) }}</td>
                          {{-- <td>
                              <button type="button" class="btn btn-default disable-button" data-role="Student" data-id="{{ $data->id }}" >
                                  <i class="fa fa-calendar"></i>
                              </button>
                          </td> --}}
                      </tr>
                      @endforeach
                  </tbody>
              </table>
            </div>
            @include('modal.reschedule')
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
<script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
<script src="{{asset('vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>src="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css"</script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script>
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});

$(document).ready(function() {
  $('#paymentToday').DataTable({
    "order": [[0, "desc"]],
  });
}); 
$(document).ready(function() {
  $('#paymentAll').DataTable({
    "order": [[0, "desc"]],
  });
});

$(document).ready(function() {
  $('#disToday').DataTable({
      "order": [[4, "desc"]],
  });
});  
$(document).ready(function() {
  $('#disAll').DataTable({
      "order": [[4, "desc"]],
  });
});

$(document).ready(function() {
  $('#scheduleToday').DataTable({
    "order": [[2, "desc"], [3, "asc"]],
    "lengthMenu": [10,20, 25, 50,100]
  });
});
$(document).ready(function() {
  $('#scheduleAll').DataTable({
    "order": [[2, "desc"], [3, "asc"]],
    "lengthMenu": [10,20, 25, 50,100]
  });
});

$(document).ready(function() {
  $("#Schedule").change(function() {
    var selectedRole = $(this).val();

    if (selectedRole === "Today") {
      $("#viewAllSched").hide();
      $("#todaySchedule").show();
    } else if (selectedRole === "All") {
      $("#todaySchedule").hide();
      $("#viewAllSched").show();
    } else {
      alert("Please select a valid role");
    }
  });
});


$(document).ready(function() {
  $("#Payment").change(function() {
    var selectedRole = $("select[name='rolePayment']").val();

    if (selectedRole === "Today") {
        $("#viewPayment").hide();
        $("#todayPayment").removeAttr("style").hide();
        $("#todayPayment").show();
    } else if (selectedRole === "All") {
        $("#todayPayment").hide();
        $("#viewPayment").removeAttr("style").hide();
        $("#viewPayment").show();
    } else {
      alert("Please select a valid role");
    }
  });
});


$(document).ready(function() {
  $("#Disapprove").change(function() {
    var selectedRole = $(this).val();

    if (selectedRole === "Today") {
        $("#viewDisapprove").hide();
        $("#todayDisapprove").removeAttr("style").hide().show();
    } else if (selectedRole === "All") {
        $("#todayDisapprove").hide();
        $("#viewDisapprove").removeAttr("style").hide().show();
    } else {
        alert("Please select a valid role");
    }
  });
});

$("#rescheduleModal").submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var actionUrl = form.attr('action');
    $.ajax({
        type: "POST",
        url: actionUrl,
        data: form.serialize(), 
        success: function(data) {
          $('#rescheduleModal').modal('hide');
          Swal.fire({
              icon: 'success',
              title: 'Success!',
              text: data.success
          }).then(function() {
              location.reload();
          });
        }
    });
});

$(document).ready(function() {
  $('.cancel').click(function() {
      var id = $(this).data('id');
      var status = $(this).attr('value');

      $.ajax({
        url: "/setStatus",
        type: "POST",
        data: {
            id: id,
            status: status,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
          if (response.success) {
              Swal.fire({
                  title: "Success",
                  text: response.success,
                  icon: "success",
                  button: "OK"
              }).then(() => {
                  location.reload();
              });
          } else if (response.error) {
              alert(response.error);
          }
        },
        error: function(xhr) {
            alert("An error occurred: " + xhr.status + " " + xhr.statusText);
        }
      });
    });
});

$(document).on('click', '.reschedule', function(){
  var id = $(this).data('id');c   
  console.log(id);
  
  $.ajax({
    type: 'POST',
    url: '/rescheduleModal',
    data: { id: id},

    success: function(response) {
      $('#reschedule').modal('show');

      console.log(response.firstname);
      console.log(response.age);

      var today = new Date();
      var formattedDate = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');

      $('.date').val(formattedDate);
      $('.name').val(response.firstname + ' ' + response.middlename + ' ' + response.lastname);
      $('.age').val(response.age);
      $('.id').val(response.id);
      $('.or').val(response.ORnumber);
     }
  })
})
</script>
@endsection