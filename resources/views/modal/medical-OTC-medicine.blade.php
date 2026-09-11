@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Over-The-Counter Medicine')

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
                      <table class="table data table-sm table-bordered table-striped" id="disToday">
                          <thead>
                              <tr>
                                  <th style="color:white;text-align: center">Date</th>
                                  <th style="color:white;text-align: center">ID number</th>
                                  <th style="color:white;text-align: center">name of patient</th>
                                  <th style="color:white;text-align: center">age</th>
                                  <th style="color:white;text-align: center">sex</th>
                                  <th style="color:white;text-align: center">position/course</th>
                                  <th style="color:white;text-align: center">Remarks</th>
                              </tr>
                          </thead>
                          <tbody id="viewAllRecord">
                              @foreach ($total_cert as $data)
                              <tr>
                                  <td style="text-align: center">{{ date('m-d-Y', strtotime($data->date)) }}</td>
                                  <td style="text-align: center">{{ $data->patientId }}</td>
                                  <td>{{utf8_decode( $data->LastName) }}, {{ utf8_decode($data->FirstName) }} {{ utf8_decode($data->MiddleName) }}</td>
                                  <td style="text-align: center">{{ $data->age }}</td>
                                  <td>{{ $data->gender }}</td>
                                  <td>{{ $data->positioncourse }}</td>
                                  <td>{{ $data->purpose }}</td>
                              </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
                  </div>
                  <div class="tab-pane" id="profile" aria-labelledby="profile-tab" role="tabpanel">
                    <div class="table-responsive view-all">
                      <div class="btnprint">
                        <button type="button" class="btn btn-primary float-right button" id="btnPrint"><a style="color: rgb(255, 255, 255); font-size: 15px;">Print</a></button>
                      </div>
                      <form action="/medical-record-of-visit" method="post" id="submitBtn">
                        @csrf
                        <div style="display:flex; justify-content:space-between;">
                            <div class="row col-md-9" style="font-size:17px;font-weight:400;color:rgb(58, 57, 57);width: fit-content;">
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
                                <select name="year" class="form-control " style="width:10%;margin-right:10px" id="year">
                                  <option  value="" selected disabled> Select</option>
                                 <?php $currentYear = date('Y'); ?>
                                  @for($year = 2018; $year <= $currentYear; $year++)
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
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">id number</th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">name of patient</th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">age</th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">sex</th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:20px">position/course</th>
                                <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">Remarks</th>
                              </tr>
                          </thead>
                          <tbody >  
                          
                          </tbody>
                      </table>
                  </div>
                  </div>
                  <div class="tab-pane" id="printMe" aria-labelledby="print-tab" role="tabpanel">
                    <div class="table-responsive view-all">
                      <div id="printPart">
                        <div class="col-12  d-flex justify-content-center" >
                          <img src="{{asset('images/logo/new-SLSU-letter-head.png')}}" style="width: 450px; height: 150px;margin-right:30px">
                          <img src="{{asset('images/logo/bagong_pilipinas.png')}}" style="width: 120px; height: 120px;">
                        </div>
                        <div class="row">
                          <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 12px; border-bottom: 1px solid black; text-align:center;color:black;">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                        </div>
                        <div class="row">
                          <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 17px; font-style: bold; text-align:center;color:black;">LOGBOOK (OVER THE COUNTER MEDICINES)</div>
                        </div><br><br>
                        <table class="table table-sm recordTable cell-border" id="print">
                          <input type="hidden" name="firstname" id="roleSelect" value="Employee">
                          <thead>
                              <tr>
                                  <th style="color:rgb(0, 0, 0); text-align: center; border: 1px solid rgb(0, 0, 0);">date</th>
                                  <th style="color:rgb(0, 0, 0); text-align: center; border: 1px solid rgb(0, 0, 0);">id number</th>
                                  <th style="color:rgb(0, 0, 0); text-align: center; border: 1px solid rgb(0, 0, 0);">Name of Patient</th>
                                  <th style="color:rgb(0, 0, 0); text-align: center; border: 1px solid rgb(0, 0, 0);">age</th>
                                  <th style="color:rgb(0, 0, 0); text-align: center; border: 1px solid rgb(0, 0, 0);">sex</th>
                                  <th style="color:rgb(0, 0, 0); text-align: center; border: 1px solid rgb(0, 0, 0); width:20px">position/course</th>
                                  <th style="color:rgb(0, 0, 0); text-align: center; border: 1px solid rgb(0, 0, 0);">Remarks</th>
                              </tr>
                          </thead>
                          <tbody>
                      
                          </tbody>
                      </table>
                    </div>
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
//Search-Input
$(document).ready(function() {
    var table = $('#preView').DataTable();

    // Handle form submission
    $('#submitBtn').submit(function(event) {
        event.preventDefault();
        var monthSearch = $('#monthSearch').val();
        var year = $('#year').val();

        $.ajax({
            url: '/medical-OTC-medicine', 
            type: 'POST',
            data: {
                'monthSearch': monthSearch,
                'year': year,
            },
            success: function(data) {
                // Clear the existing table data
                table.clear();

                if (data.length > 0) {
                    $.each(data, function(index, record) {
                        var dateArr = record.date.split('-');
                        var year = dateArr[0];
                        var month = dateArr[1];
                        var day = dateArr[2];
                        var newDateStr = month + '-' + day + '-' + year;
                        var fullname = decodeURIComponent(escape(record.LastName)) + ', ' + 
                                  decodeURIComponent(escape(record.FirstName)) + ' ' + 
                                  decodeURIComponent(escape(record.MiddleName));
                        
                        // Add data to the DataTable
                        table.row.add([
                            '<div class="text-center">' + newDateStr + '</div>',
                            '<div class="text-center">' + record.patientId + '</div>',
                            '<div>' + fullname + '</div>',
                            '<div class="text-center">' + record.age + '</div>',
                            record.gender,
                            record.positioncourse,
                            record.purpose
                        ]).draw();
                    });
                }  
                 table.draw();

                  table.$('tr').addClass('tr');
           
                  $("#print tbody").empty();

                if (data.length > 0) {
                    $.each(data, function (index, record) {
                        var dateArr = record.date.split('-');
                        var year = dateArr[0];
                        var month = dateArr[1];
                        var day = dateArr[2];
                        var newDateStr = month + '-' + day + '-' + year;
                        var fullname = decodeURIComponent(escape(record.LastName)) + ', ' + 
                                  decodeURIComponent(escape(record.FirstName)) + ' ' + 
                                  decodeURIComponent(escape(record.MiddleName));
                        // Create a new table row and append it to the table
                        var newRow = '<tr class="tr">' +
                            '<td class="text-center border" >' + newDateStr + '</td>' +
                            '<td class="text-center border" >' + record.patientId + '</td>' +
                            '<td class="border">' + fullname + '</td>' +
                            '<td class="text-center border">' + record.age + '</td>' +
                            '<td class="border">' + record.gender + '</td>' +
                            '<td class="border")">' + record.positioncourse + '</td>' +
                            '<td class="border">' + record.purpose + '</td>' +
                            '</tr>';

                        $("#print tbody").append(newRow);
                    });
                  }
                }
        });
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
            // Handle other cases or show an error message
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

//Print 
document.getElementById("btnPrint").onclick = function () {
printElement(document.getElementById("printPart"));
}

function printElement(elem) {
var domClone = elem.cloneNode(true);

var $printSection = document.getElementById("printSection");

if (!$printSection) {
    var $printSection = document.createElement("div");
    $printSection.id = "printSection";
    document.body.appendChild($printSection);
}

$printSection.innerHTML = "";
$printSection.appendChild(domClone);
window.print();
}  
</script>
@endsection