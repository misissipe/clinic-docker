@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Patient Record')
@php
use App\Http\Controllers\AESCipher;
@endphp 
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  table,td{
 border: 1px solid rgb(58, 57, 57);
 border-collapse: collapse;
 padding: 1px;
  }

  input {
  outline: 0;
  border-width: 0;
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
  .inline-cursor {
    text-align: center;
    font-size: 12px;
    font-weight: 800;
    text-transform: capitalize;
    transition: font-size 0.3s, color 0.3s;
  }

  .inline-cursor:hover {
    font-size: 15px; 
    color: #000000;
    cursor: pointer;
  }
  .cert{
    outline: 0;
    border-width: 0 0 1px;
    border-color: rgb(58, 57, 57);
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
      position:absolute;
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
@endsection
{{-- page-styles --}}
@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
<div class="row">
    <div class="col-md-10">
      <div class="row">
        <div class="col-md-12">
          <div class="card border">
            <div class="card-header border " style="background-color:rgb(110, 155, 222);color:#ffffff;height:55px;font-size:15px;font-weight:800;height:50px; display:flex;align-items:center"><i class="fas fa-file-alt " style='font-size:15px;'></i> PATIENT RECORD</div>
            <div class="card-body mt-0 p-1">
              <ul class="nav nav-tabs border-0" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" aria-controls="home" role="tab" aria-selected="true" style="display : none">
                    <i class="bx bx-calendar-event align-middle"></i>
                    <span class="align-middle"></span>
                    <span class="badge badge-danger"></span>
                    {{-- <span class="red-box" id="student-status"></span>  --}}
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile" role="tab" aria-selected="false" style="display : none">
                    <i class="bx bxs-file align-middle"></i>
                    <span class="align-middle">All Records</span>
                    <span class="badge badge-danger" ></span>
                  </a>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="home" aria-labelledby="home-tab" role="tabpanel">
                  <div class="d-flex justify-content-between">
                    <div class="btnprint">
                      <button type="button" class="btn btn-primary button btnAdd" data-id="{{ $data->id }}" id="btnAdd">
                        <a style="color: rgb(255, 255, 255); font-size: 15px;">Add</a>
                      </button>
                    </div>
                    <div class="btnprint">
                        <form action="/generate-tereatmentrecord" method="get" target="_blank" class="float-right">
                          <input type="hidden" name="id" value="{{ (new AESCipher)->encrypt($data->patientId) }}">
                          <button type="submit" class="btn btn-primary" style="font-size: 15px; color: rgb(255, 255, 255);"> Print</button>
                        </form>
                      {{-- <button type="button" class="btn btn-primary button" id="btnPrint">
                        <a style="color: rgb(255, 255, 255); font-size: 15px;">Print</a>
                      </button> --}}
                    </div>
                  </div>
                  
                <div class="table-responsive view-all">
                  <table class="table table-sm recordTable table-bordered table-striped zero-configuration" id="recordTable">
                    <thead>
                        <tr>
                          <th style="color:white;text-align:center">Action</th>
                          <th style="color:white;text-align:center">Date</th>
                          <th style="color:white;text-align:center">Diagnosis</th>
                          <th style="color:white;text-align:center">Treatment</th>
                          <th style="color:white;text-align:center">Remarks</th>
                          <th style="color:white;text-align:center">OR Number</th>
                        </tr>
                      </thead>
                      <tbody id="viewAllRecord">
                        @foreach ($view as $data)
                          <tr>
                            <td style="text-align:center">
                              <div class="dropdown">
                                <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item viewOR" href="#" data-role="{{ $data->role }}" data-id="{{($data->id)}}"><i class="bx bx-receipt mr-1"></i>OR Number</a>
                                    <a class="dropdown-item viewbutton" href="#" data-role="{{ $data->role }}" data-id="{{(new AESCipher)->encrypt($data->id)}}"><i class="bx bx-edit mr-1"></i>edit</a>
                                    <a class="dropdown-item deleteButton" href="#"  data-role="{{ $data->role }}" data-id="{{ $data->id }}"><i class="bx bx-trash mr-1"></i>delete</a>
                                  </div>
                                </div>
                            </td>
                            <td style="text-align:center">{{ date('m-d-Y', strtotime($data->date)) }}</td>
                            <td>{{ $data->diagnosis }}</td>
                            <td>{{ $data->treatment }}</td>
                           <td>{{ implode(', ', json_decode($data->remarks)) }}</td>
                            <td>{{ $data->ORnumber }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
                <div class="back">
                  <button type="button"  id="button" class="btn btn-secondary  float-right">Back</button>
                </div>
                </div>
                <div class="tab-pane" id="profile" aria-labelledby="profile-tab" role="tabpanel">
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
                      <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 17px; font-style: bold; text-align:center;color:black;">Treatment Record</div>
                    </div><br><br>
                    <div class="form-group col-sm-12">
                      <div class="row">
                          Name:
                          <input  class=" cert lastname" type="text" value="{{ utf8_decode($name->lastname)}}" id="example-text-input" style="width:23%;text-align:center;text-transform:capitalize">&nbsp;
                          <input  class=" cert firstname" type="text" value="{{ utf8_decode($name->firstname)}}" id="example-text-input" style="width:22%;text-align:center;text-transform:capitalize">&nbsp;
                          <input  class=" cert middlename" type="text" value="{{ utf8_decode($name->middlename)}}" id="example-text-input" style="width:21%;text-align:center;text-transform:capitalize">
                          Age:
                          <input  class="cert age" type="text" value="{{$age}}" id="example-text-input" style="width:6%;text-align:center">
                          
                          Gender:
                          <input  class=" cert gender" type="text" value="{{$name->gender}}" id="example-text-input" style="width:10%;text-align:center">
                          <input  class=" cert role" type="hidden" value="{{$name->role}}" id="example-text-input" style="width:10%;text-align:center">
                          <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 13px; font-style: italic;padding:0;">
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Last)
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;(First)
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;(Middle)
                          </div>
                      </div>
                    </div>
                    <table class="table table-sm recordTable table-bordered table-striped" id="recordTable">
                      <thead>
                          <tr>
                            <th style="color:rgb(0, 0, 0);text-align:center">Date</th>
                            <th style="color:rgb(0, 0, 0);text-align:center">Diagnosis</th>
                            <th style="color:rgb(0, 0, 0);text-align:center">Treatment</th>
                            <th style="color:rgb(0, 0, 0);text-align:center">Remarks</th>
                            <th style="color:rgb(0, 0, 0);text-align:center">OR Number</th>
                          </tr>
                        </thead>
                        <tbody id="viewAllRecord">
                          @foreach ($view as $data)
                            <tr>
                              <td style="text-align:center">{{ date('m-d-Y', strtotime($data->date)) }}</td>
                              <td>{{ $data->diagnosis }}</td>
                              <td>{{ $data->treatment }}</td>
                              <td>{{ implode(', ', json_decode($data->remarks)) }}</td>
                              <td>{{ $data->ORnumber }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
               </div>
              </div>
          </div>
        </div>
      </div>
    </div> 
    <div class="col-md-2">
      <div class="card">
        <div class="card-header align-center " style="background-color:rgb(110, 155, 222);display: flex; flex-direction: column; align-items: center; justify-content: center;height:100px;">
          @if ($name->gender === 'F' || $name->gender === 'Female')
            <img class="img-fluid" src="{{asset('images/logo/42101748.png')}}" alt="branding logo" style="max-width: 80px; max-height: 80px;">
            @elseif ($name->gender === 'M' || $name->gender === 'Male')
            <img class="img-fluid" src="{{asset('images/logo/43514861.png')}}" alt="branding logo" style="max-width: 80px; max-height: 80px;">
            @endif
        </div> 
        <div class="card-body" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 20px;">
          <label class="patientId" style="font-size: 18px;" id="id">{{$data->patientId}}</label>
          <label class="inline-cursor" id="firstname">{{utf8_decode($name->firstname)}}</label>
        </div>
      </div>                
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
          document.getElementById("firstname").addEventListener("mouseenter", function() {
          Swal.fire({
            title: "<small>Firstname: <b>{{utf8_decode($name->firstname)}}</b></small> <br>" +
                  "<small>Middlename: <b>{{utf8_decode($name->middlename)}}</b></small> <br>" +
                  "<small>Lastname:  <b>{{utf8_decode($name->lastname)}}</b></small>",
            icon: "info",
            showConfirmButton: false,
            allowOutsideClick: true,
            allowEscapeKey: true,
            timerProgressBar: true,
            toast: true,
            position: "top-end"
          });
        });

        document.getElementById("firstname").addEventListener("mouseleave", function() {
          Swal.close();
        });
        
    </script>
    @if (session('error'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
          Swal.fire({
              icon: 'error',
              title: '{{ session("patient") }}',
              text: '{{ session("error") }}'
          });
      </script>
  @endif  
  @include('modal.add-treatment-record')
    @include('modal.Treatment-Record')
    @include('modal.payment')
    
  
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

  $(document).ready(function() {
    $(document).on('click', '.viewbutton', function() {
        var id = $(this).data('id');
        console.log(id);
        $('#editTreatmentRecord').modal('show');

        $.ajax({
            url: '/edit-treatmentRecord',
            type: 'POST',
            data: { 
                id: id
            },
            success: function(response) {
                console.log(response);
                $('#treatmentRecord').modal('show');
                console.log(response.id);

                var today = new Date();
                var formattedDate = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');

                $('.date').val(formattedDate);
                $('.id').val(response.id);
                $('.diagnosis').val(response.diagnosis);
                $('.treatment').val(response.treatment);

      
                $(document).ready(function() {
                $('input[name="remarks[]"]').prop('checked', false);

                var remarks = response.remarks;
                console.log(remarks);

                $("input:checkbox[name='remarks[]']").each(function() {
                  if (remarks.includes($(this).val())) {
                    $(this).prop("checked", true);
                  }
                });
              });
            } 
        });
    });
});


$(document).ready(function () {
  $(document).on('click', '.btnAdd', function () {
    var patientId = $('.patientId').text();
    var role = $('.cert.role').val();
    var gender = $('.cert.gender').val();
    var age = $('.cert.age').val();

    console.log('ID:', patientId);
    console.log('Role:', role);
    console.log('Gender:', gender);
    console.log('Age:', age);

    $('#addTreatmentRecord').modal('show');

    var today = new Date();
    var formattedDate = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');

    $('.date').val(formattedDate);
    $('.patientId').val(patientId);
    $('.gender').val(gender);
    $('.role').val(role);
    $('.age').val(age);
  });
});

//Add Treatment
$("#addTreatmentRecord").submit(function(e) {
e.preventDefault();

var form = $(this);
var actionUrl = form.attr('action');


$("#submitBtn").prop("disabled", true);
    $("#spinner-overlay").show();
    $(".blur").addClass("blur");

    $.ajax({
      type: "POST",
      url: actionUrl,
      data: form.serialize(), 
        success: function(response){
          $("#spinner-overlay").hide();
                $(".blur").removeClass("blur");
            if (response.status == 200) {
              Swal.fire({
              title: response['success'],
              icon: 'success',
              confirmButtonText: 'Okay',
            }).then((response) => {
                
            if (response.isConfirmed) {
              $('#addDoctors').modal('hide')
              console.log(response); 
              location.reload();			
            }
          })
        }
    else if (response && response.Error === 1) {
      Swal.fire({
        icon: "error",
        title: response.Message,
      }).then((result1) => {
        if (result1.isConfirmed) {
            location.reload();
            $("#submitBtn").prop("disabled", false);
                    }
        });
      }
   }
});
})

 //Delete
 $(document).ready(function() {
    $('.deleteButton').click(function() {
        var id = $(this).data('id');

        Swal.fire({
            title: 'Delete Record',
            text: 'Are you sure you want to delete this record?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel',
            confirmButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                
            $.ajax({
                type: 'POST', 
                data: { id: id},
                url: '/deleteRecord',
                success: function(response) {
                  if (response.message === 'Deleted successfully') {
                      Swal.fire('Deleted!', 'The record has been deleted.', 'success');
                      location.reload();
                  } else {
                      Swal.fire('Error!', 'Failed to delete the record.', 'error');
                  }
                },
                error: function() {
                    Swal.fire('Error!', 'Failed to delete the record.', 'error');
                }
            });
            }
        });
    });
});


//Update Form
$("#updateTreatmentRecordForm").submit(function(e) {
  e.preventDefault();

  var form = $(this);
  var actionUrl = form.attr('action');

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
          }).then((response) => {
              
          if (response.isConfirmed) {
            $('#editTreatmentRecord').modal('hide')
              console.log(response); 
              location.reload();			
          }
        })
      }
    }
  });
});

//Payment (OR)
$(document).on('click', '.viewOR', function(){
  var id = $(this).data('id');
  console.log(id);
  
  $.ajax({
    type: 'POST',
    url: '/viewModalPayment',
    data: { id: id},

    success: function(response) { 
      $('#payment').modal('show');

      console.log(response.firstname);
    
      var birthDateString = response.birthdate; 
      var birthDate = new Date(birthDateString);
      var currentDate = new Date();
      var age = currentDate.getFullYear() - birthDate.getFullYear();
      if (currentDate.getMonth() < birthDate.getMonth() || (currentDate.getMonth() === birthDate.getMonth() && currentDate.getDate() < birthDate.getDate())) {
          age--;
      }

console.log(age);

      var today = new Date();
      var formattedDate = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');
      var jsonResponse = response.remarks;
      var parsedResponse = JSON.parse(jsonResponse);

      
      $('.date').val(formattedDate);
      $('.name').val(decodeURIComponent(response.firstname) + ' ' + decodeURIComponent(response.middlename) + ' ' + decodeURIComponent(response.lastname));
      $('.age').val(age);
      $('.id').val(response.id);
      $('.or').val(response.ORnumber);
      $('.remarks').val(parsedResponse);
     }
  })
})




//Payment Modal for OR 
$("#paymentOR").submit(function(e) {
  e.preventDefault();

var form = $(this);
var actionUrl = form.attr('action');

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
        }).then((response) => {
            
        if (response.isConfirmed) {
          $('#payment').modal('hide')
            console.log(response); 
            location.reload();			
        }
      })
    }
  }
});
})

//Back button in View
 $(document).ready(function(){
    $("#button").click(function(){
      window.history.back();
  })
 });

 var button = document.querySelector('.disable-button');
    setTimeout(function() {
      button.disabled = true;
    }, 30 * 60 * 1000); 

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