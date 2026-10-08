@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Record of Visit')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<style>
 table,td,tr{
 border: 1px solid rgb(226, 222, 222);
 border-collapse: collapse;
 padding: 1px;
  }
  input {
  outline: 0;
  border-width: 0 0 0px;
  border-color: rgb(58, 57, 57)
  }
  </style>
  <style>
  textarea  {
    outline: 0;
  border-width: 0;
  border-color: rgb(58, 57, 57)
  }
  .ph-card-header
  {
      background-color: #3a76c5;
  }
  thead{
    background-color: rgb(110, 155, 222);
  }
  ul
  {  
      cursor:pointer;  
  }  
  li:hover {
  background-color: rgba(220, 225, 229, 0.953);
 }
 .cell-border{
    border-color: rgb(138, 138, 138);
  }
  .border{
    border-color: rgb(0, 0, 0);
  }
  #loading {
      display: none;
      text-align: center;
    }

    #loading img {
      width: 50px; 
      height: 50px;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
{{-- page-styles --}}
@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card active">
        <div class="card-content">
          <div class="card-body">
            <label style="font-size:18px">Records of Visits for the Month of</label>
            <br><br>
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" aria-controls="home" role="tab" aria-selected="true">
                  <i class="bx bx-calendar-event align-middle"></i>
                  <span class="align-middle">{{$month}}</span>
                  <span class="badge badge-danger"></span>
                  {{-- <span class="red-box" id="student-status"></span>  --}}
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile" role="tab" aria-selected="false">
                  <i class="bx bxs-file align-middle"></i>
                  <span class="align-middle">All Records</span>
                  <span class="badge badge-danger" ></span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="print-tab" data-toggle="tab" href="#printMe" aria-controls="print" role="tab" aria-selected="false" style="display : none" >
                <span class="align-middle">print</span>
                </a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="home" aria-labelledby="home-tab" role="tabpanel">
                <div class="table-responsive view-all active" id="todayDisapprove">
                  {{-- <label style="font-size:18px">Student</label> --}}
                  <table class="table table-sm  cell-border zero-configuration" id="disToday">
                      <thead>
                          <tr>
                              <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">date</th>
                              <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">Log in</th>
                               <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">Log out</th>
                              {{-- <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">id number</th> --}}
                              <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">name</th>
                              <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">age</th>
                              <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">sex</th>
                              <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:20px">position/course & year level</th>
                              <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">PERMANENT ADDRESS</th>
                              <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">Remarks</th>
                              {{-- <th style="color:white;text-align: center">action</th> --}}
                          </tr>
                      </thead>
                      <tbody id="studentRecord">
                          @foreach ($data as $datas)
                          <tr>
                              <td style="text-align: center">{{ date('m-d-Y', strtotime($datas->date)) }}</td>
                              <td style="text-align: center">{{ date('h:i A', strtotime($datas->time)) }}</td>
                                <td style="text-align: center">{{ date('h:i A', strtotime($datas->logged_out)) }}</td>
                              {{-- <td style="text-align: center">{{ $data->patientId }}</td> --}}
                              <td>   
                                @php
                                    $formatName = function($name) {
                                        if (strpos($name, 'Ã') !== false) {
                                            return utf8_decode($name);
                                        }
                                        return ucwords(strtolower($name));
                                    };

                                    $lastName = $datas->studentLastName ?? $datas->employeeLastName;
                                    $firstName = $datas->studentFirstName ?? $datas->employeeFirstName;
                                    $middleName = $datas->studentMiddleName ?? $datas->employeeMiddleName;
                                @endphp

                                {{ $formatName($lastName) }}, {{ $formatName($firstName) }} {{ $formatName($middleName) }}

                              </td>
                              <td style="text-align: center">{{ $datas->age  }}</td>
                              <td style="text-align: center">{{ $datas->gender }}</td>
                              <td>{{ $datas->positioncourse }}</td>
                              <td> 
                                @php
                                    $brgy = $datas->studentbrgy ?? $datas->employeeRBarangay;
                                    $city = $datas->studentcity ?? $datas->employeecitymunDesc;
                                    $province = $datas->studentprovince ?? $datas->employeeprovDesc;

                                    $formatText = function($value) {
                                        if (strpos($value, 'Ã') !== false) {
                                            return utf8_decode($value);
                                        }
                                        return ucwords(strtolower($value));
                                    };
                                @endphp

                                {{ $formatText($brgy) }}, {{ $formatText($city) }} {{ $formatText($province) }}

                              </td>
                             <td>
                                  @php
                                      $purposes = json_decode($datas->purpose, true);
                                  @endphp

                                  @if(in_array('Other Concerns', $purposes))
                                      Other Concerns - {{ $datas->specify }}
                                  @else
                                      {{ implode(', ', $purposes) }}
                                  @endif
                              </td>
                              {{-- <td style="text-align: center">
                                  <button type="button" class="btn btn-default disable-button viewbutton" data-role="Student" data-id="{{ $data->id }}" >
                                    <i class="fa fa-edit"></i>
                                  </button>
                              </td> --}}
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
              </div>
              <div class="tab-pane" id="profile" aria-labelledby="profile-tab" role="tabpanel">
                <div class="table-responsive view-all">
                  <div class="btnprint">
                    <form action="/generate-record-of-visit" method="get" target="_blank" class="float-right">
                      <button type="submit" class="btn btn-primary" id="submitToGenerate" style="font-size: 15px; color: rgb(255, 255, 255);">
                          Print
                      </button>
                  </form>
                  
                  </div>
                  <form action="/medical-record-of-visit" method="post" id="submitBtn">
                    @csrf
                    <div style="display:flex; justify-content:space-between;">
                        <div class="row col-md-9" style="font-size:17px;font-weight:400;color:rgb(58, 57, 57);width: fit-content;">
                          {{-- <select id="roleSelect" class="form-control"  style="width:15%;margin-right:10px" aria-label="Default select example">
                            <option disabled selected>-Select Type-</option>
                            <option value="Student">Student</option>
                            <option value="Employee">Employee</option>
                          </select> --}}
                            <select id="monthSearch" name="monthSearch" class="form-control" aria-label="Default select example" style="width:10%;margin-right:10px" required>
                                <option value="" disabled selected>-Month-</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                             <select name="date_range" class="form-control" style="width:12%;margin-right:10px" id="date_range">
                                <option value="" selected disabled>-Date Range-</option>
                                <option value="1-10">1 - 10</option>
                                <option value="11-20">11 - 20</option>
                                <option value="21-31">21 - 31</option>
                            </select>
                            <select name="year" class="form-control " style="width:10%;margin-right:10px" id="year">
                              <option  value="" selected disabled>-Year-</option>
                             <?php $currentYear = date('Y'); ?>
                              @for($year = 2022; $year <= $currentYear; $year++)
                             <option value="{{ $year }}">{{ $year }}</option>
                             @endfor
                           </select>

                            <div class="input-group-append">
                                <button class="btn btn-primary submitBtn" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
                  <table class="table table-sm recordTable  cell-border " id="preView">
                    <input type="hidden"name="firstname" id="roleSelect" value="Employee">
                      <thead>
                          <tr>
                            <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">date</th>
                            <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">log in</th>
                            <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">log out</th>
                            {{-- <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">id number</th> --}}
                            <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">Name</th>
                            <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">age</th>
                            <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">sex</th>
                            <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:10px">position/course & year level</th>
                            <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">Pemanent Address</th>
                            <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">Remarks</th>
                          </tr>
                      </thead>
                  </table>
                  <div id="loading" style="display: none;">
                    <img src="{{ asset('images/logo/loading.gif') }}" alt="Loading Animation" style="width: 7%; height: auto;">
                  </div>
              </div>
            </div>

          @include('modal.payment')
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
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script>
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});
  var patientId = 0;

//Search-Input
var table = $('#preView').DataTable({
    "order": [[0, 'desc'], [1, 'asc']] 
});

// var table = $('#studentRecord').DataTable({
//     "order": [[0, 'desc'], [1, 'asc']] 
// });


$(document).ready(function() {
    $(document).on('submit', '#submitBtn', function(event) {
        event.preventDefault();
        var date_range = $('#date_range').val();
        var monthSearch = $('#monthSearch').val();
        var year = $('#year').val();
        var role =  $('#roleSelect').val();
        $('#loading').show();
        
        $.ajax({
            url: '/medical-record-of-visit', 
            type: 'POST',
            data: {
                'date_range': date_range,
                'monthSearch': monthSearch,
                'year': year,
            },
            success: function(data) {
                $('#loading').hide();
                table.clear();
                if (data.length > 0) {
                    $.each(data, function(index, record) {
                        var dateArr = record.date.split('-');
                        var year = dateArr[0];
                        var month = dateArr[1];
                        var day = dateArr[2];
                        var newDateStr = month + '-' + day + '-' + year;

                        var jsonString = record.purpose;
                        var purpose = JSON.parse(jsonString);

                  
                       var timeParts = record.time.split(':'); 
                        var hour = parseInt(timeParts[0], 10);
                        var minute = timeParts[1];

                        var period = hour >= 12 ? 'PM' : 'AM';
                        hour = hour % 12 || 12;
                        var newTimeStr = hour + ':' + minute + ' ' + period;

                        var sortTime = record.time; 

                        var timePart = record.logged_out.split(':'); 
                        var hours = parseInt(timePart[0], 10);
                        var minutes = timePart[1];

                        var periods = hours >= 12 ? 'PM' : 'AM';
                        hours = hours % 12 || 12;
                        var newTimeStrs = hours + ':' + minutes + ' ' + periods;

                        var sortTimes = record.logged_out;  

                       var fullname = '';

                        if (record.studentLastName) {
                            fullname = 
                                 (record.studentLastName ? record.studentLastName.replace(/Ã±/g, 'ñ') : '') + ', ' +
                                (record.studentFirstName ? record.studentFirstName.replace(/Ã±/g, 'ñ') : '') + ' ' +
                                (record.studentMiddleName ? record.studentMiddleName.charAt(0).replace(/Ã±/g, 'ñ') + '.' : '');
                        } else {
                            fullname = 
                                (record.employeeLastName ? record.employeeLastName.replace(/Ã±/g, 'ñ') : '') + ', ' +
                                (record.employeeFirstName ? record.employeeFirstName.replace(/Ã±/g, 'ñ') : '') + ' ' +
                                (record.employeeMiddleName ? record.employeeMiddleName.charAt(0).replace(/Ã±/g, 'ñ') + '.' : '');
                        }

                        var address = '';

                        if (record.studentbrgy) {
                            address = 
                                 (record.studentbrgy ? record.studentbrgy.replace(/Ã±/g, 'ñ') : '') + ', ' +
                                (record.studentcity ? record.studentcity.replace(/Ã±/g, 'ñ') : '') + ', ' +
                                (record.studentprovince ? record.studentprovince.replace(/Ã±/g, 'ñ') : '');
                        } else {
                            address = 
                                (record.employeeRBarangay ? record.employeeRBarangay.replace(/Ã±/g, 'ñ') : '') + ', ' +
                                (record.employeecitymunDesc ? record.employeecitymunDesc.replace(/Ã±/g, 'ñ') : '') + ', ' +
                                (record.employeeprovDesc ? record.employeeprovDesc.replace(/Ã±/g, 'ñ') : '');
                        }

                        var jsonString = record.purpose;
                        var purpose = JSON.parse(jsonString);

                        if (Array.isArray(purpose)) {
                            purpose = purpose.join(", ");
                        }

                        if (purpose === "Other Concerns") {
                            purpose = purpose + " - " + record.specify;
                        }
                                              

                      table.row.add([
                          '<div class="text-center">' + newDateStr + '</div>',
                          '<div class="text-center" data-sort="' + sortTime + '">' + newTimeStr + '</div>',
                          '<div class="text-center" data-sort="' + sortTimes + '">' + newTimeStrs + '</div>',
                          '<div>' + fullname + '</div>',
                          '<div class="text-center">' + record.age + '</div>',
                          record.gender,
                          record.positioncourse,
                          address ,
                          purpose
                          
                      ]).draw();
                  });
                }

                table.draw();
                table.$('tr').addClass('tr');
            }
        });
    });
});



$(document).ready(function() {
    $('#submitToGenerate').click(function(event) {
        event.preventDefault(); 
        var role =  $('#roleSelect').val();
        var monthSearch = $('#monthSearch').val();
        var year = $('#year').val();
        var date_range = $('#date_range').val();
      
        window.location.href = `/generate-record-of-visit?monthSearch=${monthSearch}&year=${year}&date_range=${date_range}&role=${role}`;
    });
});


//  $(document).ready(function(){
//     $("#backBTN").click(function(){
//     loacation.reload();
//   })
// })

// $(document).ready(function() {
//     $('#disToday').DataTable({
//       "order": [0, 'desc']
//     });
//   });  

//   $(document).ready(function() {
//     $('#empToday').DataTable({
//         "order": [[0, "Asc"]],
//     });
//   });  

//   $(document).ready(function() {
//     $('#disAll').DataTable({
//         "order": [[0, "Asc"]],
//     });
//   });

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

// Save SWAL ALERT
 $("#saveTab").submit(function(e) {
  e.preventDefault();

  var form = $(this);
  var actionUrl = form.attr('action');
  var role = $('#roleSelect').val();

  $.ajax({
    type: "POST",
    url: actionUrl,
    data: form.serialize(), 
    success: function(response){
      if (response.status == 200) {
        Swal.fire({
          title: response['success'],
          icon: 'success',
          confirmButtonText: 'Okay',
      }).then((response1) => {
              
     if (response1.isConfirmed) {
      // var role = response.role;

      //   if (role === 'Student') {
      //     window.location.href = "/patient-record?StudentId=" + encodeURIComponent(response.newId) + "&role=Student";
      //   } else if (role === 'Employee') {
      //     window.location.href = "/patient-record?EmpployeeId=" + encodeURIComponent(response.newId) + "&role=Employee";
      //   }  
      location.reload(); 
      }
      })
      console.log(response); 	
      }
      else if(response.error== 'Duplicate'){
        Swal.fire({
        title: response['error'],
        icon: 'error',
        confirmButtonText: 'Okay',
      }).then((response) => {

      if (response.isConfirmed) {
        location.reload()
      }
    })
   }
  }
  });
});


$(document).on('click', '.viewbutton', function(){
  var id = $(this).data('id');
  console.log(id);
  
  $.ajax({
    type: 'POST',
    url: '/viewModalPayment',
    data: { id: id},

    success: function(response) {
      $('#payment').modal('show');

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