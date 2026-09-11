@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Issuance of Certificate')

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
</style>
<style>
  @media screen {
    #printSection {
        display: none;
    }
  }

  @media print {
    body * {
      visibility:hidden;
      font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }
    .printed-div{
  position: absolute;
  left: 120px;
    }
   
    #printSection, #printSection * {
      visibility:visible;
    }
    #printSection {
      position:relative;
      left:0;
      top:0;
    }
  }
  @page {
   margin: 5mm 10mm 5mm 10mm;  
   font-family: Cambria;
   size: Auto;
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
                <label style="font-size:18px">Issuance of Certificate Record for the month of</label>
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
                    <a class="nav-link" id="print-tab" data-toggle="tab" href="#printMe" aria-controls="print" role="tab" aria-selected="false" style="display : none">
                    <span class="align-middle">print</span>
                    </a>
                  </li>
                </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="home" aria-labelledby="home-tab" role="tabpanel">
                      <div class="table-responsive view-all active" id="todayDisapprove">
                        <label style="font-size:18px">Student</label>
                        <table class="table table-sm  cell-border " id="disToday">
                        <thead>
                            <tr>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:10%">date / time </th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:20%">name </th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:2%">age</th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:2%">sex</th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:5%">course & year level</th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:10%" colspan="4">Vital Sign</th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:10%">REQUIRED LABORATORY RESULT/S </th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:15%">REMARKS</th>
                            </tr>
                            <tr>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:10%"></th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:20%"></th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:2%"></th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:2%"></th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:5%"></th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:2%">Temp</th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:2%">Pulse</th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:2%">Respi</th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:4%">BP</th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:10%"></th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:15%"></th>
                            </tr>
                        </thead>
                        <tbody id="viewAllRecord">
                            @foreach ($totalS as $data)
                            <tr>
                                <td style="text-align: center">{{ date('m-d-Y', strtotime($data->date)) }} / {{ date('h:i A', strtotime($data->time)) }}</td>
                                <td>{{utf8_decode( $data->LastName) }}, {{ utf8_decode($data->FirstName) }} {{ utf8_decode($data->MiddleName) }}</td>
                                <td style="text-align: center">{{ $data->age  }}</td>
                                <td style="text-align: center">{{ $data->gender }}</td>
                                <td>{{ $data->positioncourse }}</td>
                                <td>{{ $data->temp }}</td>
                                <td>{{ $data->pulse }}</td>
                                <td>{{ $data->res_rate }}</td>
                                <td>{{ $data->bp }}</td>
                                <td>{{ $data->reqlabres }}</td>
                                <td>{{ $data->findings }}</td>
                                {{-- <td style="text-align: center">
                                    <button type="button" class="btn btn-default disable-button viewbutton" data-role="Student" data-id="{{ $data->id }}" >
                                      <i class="fa fa-edit"></i>
                                    </button>
                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <label style="font-size:18px">Employee</label>
                    <table class="table table-sm  cell-border " id="empToday">
                      <thead>
                        <tr>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:10%">date / time </th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:20%">name </th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:2%">age</th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:2%">sex</th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:8%">position/designation</th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:10%" colspan="4">Vital Sign</th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:10%">REQUIRED LABORATORY RESULT/S </th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:15%">REMARKS</th>
                        </tr>
                        <tr>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:10%"></th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:20%"></th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:2%"></th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:2%"></th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:8%"></th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:2%">Temp</th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:2%">Pulse</th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:2%">Respi</th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:4%">BP</th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:10%"></th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:15%"></th>
                        </tr>
                    </thead>
                      <tbody id="viewAllRecord">
                          @foreach ($totalE as $data)
                          <tr>
                              <td style="text-align: center">{{ date('m-d-Y', strtotime($data->date)) }} / {{ date('h:i A', strtotime($data->time)) }}</td>    
                              <td>{{utf8_decode( $data->LastName) ?? $data->LastName}}, {{ utf8_decode($data->FirstName) ?? $data->FirstName}} {{ utf8_decode($data->MiddleName) ?? $data->MiddleName}}</td>
                              <td style="text-align: center">{{ \Carbon\Carbon::parse($data->DateOfBirth)->age }}</td>
                              <td style="text-align: center">{{ $data->Sex }}</td>
                              <td>{{ $data->EmploymentStatus }}</td>
                              <td>{{ $data->temp }}</td>
                              <td>{{ $data->pulse }}</td>
                              <td>{{ $data->res_rate }}</td>
                              <td>{{ $data->bp }}</td>
                              <td>{{ $data->reqlabres }}</td>
                              <td>{{ $data->findings }}</td>
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
                          <form action="/generate-issuance-of-certificate" method="get" target="_blank" class="float-right">
                            <button type="submit" class="btn btn-primary" id="submitToGenerate" style="font-size: 15px; color: rgb(255, 255, 255);">
                                Print
                            </button>
                        </form>
                        </div>
                        <form action="/medical-record-of-visit" method="post" id="submitBtn">
                          @csrf
                          <div style="display:flex; justify-content:space-between;">
                              <div class="row col-md-9" style="font-size:17px;font-weight:400;color:rgb(58, 57, 57);width: fit-content;">
                                <select id="roleSelect" class="form-control"  style="width:15%;margin-right:10px" aria-label="Default select example">
                                  <option selected>-Select Type-</option>
                                  <option value="Student">Student</option>
                                  <option value="Employee">Employee</option>
                                </select> 
                                <select id="monthSearch" name="monthSearch" class="form-control" aria-label="Default select example" style="width:10%;margin-right:10px" required>
                                      <option value="" disabled selected>-Select-</option>
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
                                    <option  value="" selected disabled> Select</option>
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
                                <th style="color:white; text-align: center; border: 1px solid rgb(226, 222, 222); width:10%">Date / Time</th>
                                <th style="color:white; text-align: center; border: 1px solid rgb(226, 222, 222); width:20%">Name</th>
                                <th style="color:white; text-align: center; border: 1px solid rgb(226, 222, 222); width:2%">Age</th>
                                <th style="color:white; text-align: center; border: 1px solid rgb(226, 222, 222); width:2%">Sex</th>
                                <th style="color:white; text-align: center; border: 1px solid rgb(226, 222, 222); width:5%"> course & year level/position</th>
                                <th style="color:white; text-align: center; border: 1px solid rgb(226, 222, 222); width:2%">Temp</th>
                                <th style="color:white; text-align: center; border: 1px solid rgb(226, 222, 222); width:2%">Pulse</th>
                                <th style="color:white; text-align: center; border: 1px solid rgb(226, 222, 222); width:2%">Respi</th>
                                <th style="color:white; text-align: center; border: 1px solid rgb(226, 222, 222); width:4%">BP</th>
                                <th style="color:white; text-align: center; border: 1px solid rgb(226, 222, 222); width:10%">Required Laboratory Result/s</th>
                                <th style="color:white; text-align: center; border: 1px solid rgb(226, 222, 222); width:15%">Remarks</th>
                            </tr>
                           
                        </thead>
                        
                            <tbody >  
                            
                            </tbody>
                        </table>
                    </div>
                    </div>
                  @include('modal.payment')
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

//Search Input
$(document).ready(function() {
    var table = $('#preView').DataTable({
        "order": [[0, "desc"]],
    });

    // Handle form submission
    $('#submitBtn').submit(function(event) {
        event.preventDefault();
        var monthSearch = $('#monthSearch').val();
        var date_range = $('#date_range').val();
        var year = $('#year').val();
        var role =  $('#roleSelect').val();

        $.ajax({
            url: '/medical-issuance-of-certificate', 
            type: 'POST',
            data: {
                'date_range': date_range,
                'monthSearch': monthSearch,
                'year': year,
                'role': role
            },
            success: function(data) {
                table.clear();

                if (data.length > 0) {
                  $.each(data, function(index, record) {
              
                  var dateArr = record.date.split('-');
                  var year = dateArr[0];
                  var month = dateArr[1];
                  var day = dateArr[2];
                  var newDateStr = month + '-' + day + '-' + year;

                  var timeArr = record.time.split(':');
                  var hours = parseInt(timeArr[0], 10);
                  var minutes = timeArr[1];
                  var seconds = timeArr[2];

                  var period = hours >= 12 ? 'PM' : 'AM';
                  hours = hours % 12 || 12; 

                  var newTimeStr = hours + ':' + minutes + ' ' + period;

                  var fullname = (record.LastName ? record.LastName.replace(/Ã±/g, 'ñ') : '') + ', ' +
                                 (record.FirstName ? record.FirstName.replace(/Ã±/g, 'ñ') : '') + ' ' +
                                 (record.MiddleName ? record.MiddleName.charAt(0).replace(/Ã±/g, 'ñ') + '.' : '');
                                 
                 
                   table.row.add([
                            '<div class="text-center">' + newDateStr + " / " + newTimeStr + '</div>',
                            '<div  >' + fullname + '</div>',
                            '<div class="text-center" >' + record.age + '</div>',
                            '<div>' + record.gender + '</div>',
                            '<div>' + record.positioncourse + '</div>',
                            '<div>' + record.temp + '</div>',
                            '<div>' + record.pulse + '</div>',
                            '<div>' + record.res_rate + '</div>',
                            '<div>' + record.bp + '</div>',
                            '<div>' + record.reqlabres + '</div>',
                            '<div>' + record.findings + '</div>'
                        ]
                        ).draw();
              })
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

        window.location.href = `/generate-issuance-of-certificate?monthSearch=${monthSearch}&year=${year}&date_range=${date_range}&role=${role}`;
    });
});

 $(document).ready(function(){
        $("#backBTN").click(function(){
        loacation.reload();
      })
})

$(document).ready(function() {
    $('#disToday').DataTable({
        "order": [[0, "desc"]],
        'aLengthMenu' :[10,20,50,100,'All'],
    });
  });  

  $(document).ready(function() {
    $('#empToday').DataTable({
        "order": [[0, "desc"]],
    });
  });  

  $(document).ready(function() {
    $('#disAll').DataTable({
        "order": [[0, "desc"]],
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