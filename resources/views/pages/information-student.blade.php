@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Student Information')
@php
use App\Http\Controllers\AESCipher;
@endphp 
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    table, th,td{
   border: 1px solid rgb(0, 0, 0);
   border-collapse: collapse;
   text-align: center;
 }

 input {
  outline: 0;
  border-width: 0;
  }
 .cert{
    outline: 0;
    border-width: 0 0 0px;
    border-color: rgb(58, 57, 57)
  }
  .textbox {
      transform: scale(1.5);
      margin: 10px;
      accent-color: rgb(58, 57, 57)
  }
  thead{
  background-color: rgb(110, 155, 222);
 }
 textarea  {
      outline: 0;
    border-width: 0 0 1px;
    border-color: rgb(58, 57, 57)
    }
    .card {
 
  margin-bottom: 50px;
  margin-left: auto;
  margin-right: auto;
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
  .blur {
        filter: blur(1px);
    }
</style>
@endsection
{{-- page-styles --}}
@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
            <div class="card border">
            {{-- <div class="card-header">
                    
            </div> --}}
            <div class="card-body">
                    {{-- <form action="/addCert"  method="post" id="saveCert">
                      @csrf --}}
                      <div class="btnprint">
                        <button type="button" class="btn btn-primary float-right button btnEdit" id="btnEdit" data-id="{{(new AESCipher)->encrypt($data->StudentNo)}}">
                            <a style="color: rgb(255, 255, 255); font-size: 15px;">Edit</a>
                        </button>
                    </div>
                      <h5 style="font-weight: bold; font-style: italic;color:royalblue)">PERSONAL INFORMATION</h5><br>
                        {{-- <input  class="form-control id col-2" name="patientId" type="hidden" value="" id="id" > 
                        <input  class="form-control " name="role" type="hidden" value="" id="" > 
                        <input  class="form-control " name="course" type="hidden" value="" id="" > 
                        <input  class="form-control " name="accro" type="hidden" value="" id="" > 
                        <input  class="form-control " name="major" type="hidden" value="" id="" > 
                        <input  class="form-control " name="yr" type="hidden" value="" id="">  --}}
                        {{-- <input  class="form-control " name="findings" type="hidden" value="Medical Certificate" id="">  --}}
                        {{-- <input  class="form-control " name="purpose" type="hidden" value="Issuance of Certificate" id=""> 
                        <input  class="form-control " name="status" type="hidden" value="Approved" id="">  --}}
                        {{-- <input  class="form-control col-2 id" name="" type="text" value="" id="" hidden>  --}}
          
                        <div class="form-group">
                            <div class="row">
                                <div class="col-2">
                                    <h6>Name:</h6>
                                </div>
                                <div class="col">
                                    <b>{{ ucwords(strtolower(utf8_decode($data->FirstName))) }} {{ucwords(strtolower(utf8_decode($data->MiddleName)))}} {{ucwords(strtolower(utf8_decode($data->LastName)))}}</b>
                                </div>
                                <div class="col-2">
                                    <h6>Course:</h6>
                                </div>
                                <div class="col">
                                    <b>{{ $data->courses }}</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <h6>Age:</h6>
                                </div>
                                <div class="col">
                                    <b>{{$age}}</b>
                                </div>
                                <div class="col-2">
                                    <h6>Major:</h6>
                                </div>
                                <div class="col">
                                    <b>{{ $data->major }}</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <h6>BirthDate:</h6>
                                </div>
                                <div class="col">
                                    <b>{{$newbday}}</b>
                                </div>
                                <div class="col-2">
                                    <h6>Accro:</h6>
                                </div>
                                <div class="col">
                                    <b>{{ $data->accro}}</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <h6>Civil Status:</h6>
                                </div>
                                <div class="col">
                                    <b>{{$data->civil_status}}</b>
                                </div>
                                <div class="col-2">
                                    <h6>Year:</h6>
                                </div>
                                <div class="col">
                                    <b>{{ $data->StudentYear }}</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <h6>Nationality:</h6>
                                </div>
                                <div class="col">
                                    <b>{{$data->nationality}}</b>
                                </div>
                               
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <h6>Religion:</h6>
                                </div>
                                <div class="col">
                                    <b>{{$data->religion}}</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <h6>Address:</h6>
                                </div>
                                <div class="col">
                                    <b>{{ ucwords(strtolower(utf8_decode($data->brgy)))}} {{ ucwords(strtolower(utf8_decode($data->city))) }} {{ ucwords(strtolower(utf8_decode($data->province)))}}</b>
                                </div>
                                <div class="col-2">
                                    <h6>Contact No.:</h6>
                                </div>
                                <div class="col">
                                    <b>{{ $data->ContactNo }}</b>
                                </div>
                            </div>
                        </div>
                  </div>
                </div>

             </div>
          </div>
      </div>
      <div class="col-md-12">
        <div class="card" >
            
            {{-- <div class="card-header">
                    
            </div> --}}
            <div class="card-body">
                <div class="btnprint">
                    <button type="button" class="btn btn-primary float-right button btnEditFam" id="btnEditFam" data-id="{{(new AESCipher)->encrypt($data->StudentNo)}}">Edit</a></button>
                  </div>
                    {{-- <form action="/addCert"  method="post" id="saveCert">
                      @csrf --}}
                      <h5 style="font-weight: bold; font-style: italic;color:royalblue)">FAMILY BACKGROUND</h5><br>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-2">
                                    <h6>Father's Name:</h6>
                                </div>
                                <div class="col">
                                    <b>{{ ucwords(strtolower(utf8_decode($data->FatherName)))}}</b>
                                </div>
                                <div class="col-2">
                                    <h6>Mother's Name:</h6>
                                </div>
                                <div class="col">
                                    <b>{{ucwords(strtolower(utf8_decode($data->MotherName)))}}</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <h6>Father's Occupation:</h6>
                                </div>
                                <div class="col">
                                    <b>{{$data->f_occupation}}</b>
                                </div>
                                <div class="col-2">
                                    <h6>Mother's Occupation:</h6>
                                </div>
                                <div class="col">
                                    <b>{{$data->m_occupation}}</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <h6>Father's Address:</h6>
                                </div>
                                <div class="col">
                                    <b>{{$data->f_officeadd}}</b>
                                </div>
                                <div class="col-2">
                                    <h6>Mother's Address:</h6>
                                </div>
                                <div class="col">
                                    <b>{{$data->m_officeadd}}</b>
                                </div>
                            </div>
                        </div>
                    {{-- <div id="spinner-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.2); z-index: 9999;">
                      <div class="d-flex justify-content-center align-items-center h-100">
                          <div class="spinner-border spinner-border-lg text-primary" role="status">
                              <span class="sr-only">Loading...</span>
                          </div>
                      </div>
                    </div> --}}
                    {{-- <br> --}}
                    {{-- <div class="col-12">
                          <button type="button" class="btn btn-default btn-custom float-right" id="cancelBtn">Cancel</button>
                          <button type="submit" class="btn btn-primary btn-custom float-right " id="saveCert">Save</button><br>
                        </div> --}}
                      {{-- </form> --}}
                  </div>
          </div>
    
      </div>
      <div class="col-md-12">
        <div class="card" >
            <div class="card-body">
                <div class="btnprint">
                    <button type="button" class="btn btn-primary float-right button btnEditEmer" id="btnEditEmer" data-id="{{(new AESCipher)->encrypt($data->StudentNo)}}">Edit</a></button>
                  </div>
                    {{-- <form action="/addCert"  method="post" id="saveCert">
                      @csrf --}}
                      <h5 style="font-weight: bold; font-style: italic;color:royalblue)">EMERGENCY CONTACT</h5><br>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-2">
                                    <h6>Name:</h6>
                                </div>
                                <div class="col">
                                    <b>{{ ucwords(strtolower(utf8_decode($data->EC_name))) }}</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <h6>Contact No.:</h6>
                                </div>
                                <div class="col">
                                    <b>{{$data->EC_contactNo}}</b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-2">
                                    <h6>Address:</h6>
                                </div>
                                <div class="col">
                                   <b>{{ ucwords(strtolower(utf8_decode($data->EC_brgy)))}} {{ ucwords(strtolower(utf8_decode($data->EC_city)))}} {{ucwords(strtolower(utf8_decode($data->EC_province)))}}</b>
                                </div>
                            </div>
                        </div>
                    {{-- <div id="spinner-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.2); z-index: 9999;">
                      <div class="d-flex justify-content-center align-items-center h-100">
                          <div class="spinner-border spinner-border-lg text-primary" role="status">
                              <span class="sr-only">Loading...</span>
                          </div>
                      </div>
                    </div> --}}
                    {{-- <br> --}}
                    {{-- <div class="col-12">
                          <button type="button" class="btn btn-default btn-custom float-right" id="cancelBtn">Cancel</button>
                          <button type="submit" class="btn btn-primary btn-custom float-right " id="saveCert">Save</button><br>
                        </div> --}}
                      {{-- </form> --}}
                  </div>
          </div>
    
      </div>
      @include('modal.edit-studentInfo')
      @include('modal.edit-studentFamily')
      @include('modal.edit-studentEmergency')
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


$(document).ready(function() {
        $('.capitalize').each(function() {
            var capitalizedValue = $(this).val().replace(/\w\S*/g, function(txt) {
                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
            });
            $(this).val(capitalizedValue);
        });
});

$(document).ready(function() {
        $(document).on('click', '.btnEdit', function() {
            var id = $(this).data('id');
        console.log(id);
        $('#editStudentinfo').modal('show');

        $.ajax({
            url: '/edit-student-personal',
            type: 'POST',
            data: { 
                id: id
            },
            success: function(response) {
                console.log(response);
                $('#editStudentinfo').modal('show');
                console.log(response.accro);
                var birthDate = response.BirthDate.split(' ');
                var formattedDate = `${birthDate[2]}-${birthDate[0].padStart(2, '0')}-${birthDate[1].padStart(2, '0')}`;
                var Age = new Date().getFullYear() - new Date(formattedDate).getFullYear();

                function ucwords(str) {
                    return str.toLowerCase().replace(/\b\w/g, function (match) {
                        return match.toUpperCase();
                    });
                }

                $('.id').val(response.StudentNo);
                $('.FirstName').val(ucwords(response.FirstName));
                $('.MiddleName').val(ucwords(response.MiddleName));
                $('.LastName').val(ucwords(response.LastName));
                $('.BirthDate').val(formattedDate);
                $('.Age').val(Age);
                $('.civil_status').val(response.civil_status);
                $('.nationality').val(response.nationality);
                $('.religion').val(response.religion);
                $('.brgy').val(ucwords(response.brgy));
                $('.city').val(ucwords(response.city));
                $('.province').val(ucwords(response.province));
                $('.courses').val(response.courses);
                $('.accro').val(response.accro);
                $('.major').val(response.major);
                $('.StudentYear').val(response.StudentYear);
                $('.ContactNo').val(response.ContactNo);

            
            } 
        });
        });
    });

$(document).ready(function() {
        $(document).on('click', '.btnEditFam', function() {
            var id = $(this).data('id');
        console.log(id);
        $('#editStudentFamily').modal('show');

        $.ajax({
            url: '/edit-student-family',
            type: 'POST',
            data: { 
                id: id
            },
            success: function(response) {
                console.log(response);
                $('#editStudentFamily').modal('show');
                console.log(response.FatherName);
              
                $('.id').val(response.StudentNo);
                $('.FatherName').val(response.FatherName);
                $('.MotherName').val(response.MotherName);
                $('.f_occupation').val(response.f_occupation);
                $('.m_occupation').val(response.m_occupation);
                $('.f_officeadd').val(response.f_officeadd);
                $('.m_officeadd').val(response.m_officeadd);

            } 
        });
        });
    });

$(document).ready(function() {
    $(document).on('click', '.btnEditEmer', function() {
        var id = $(this).data('id');
        console.log(id);
        $('#editStudentEmergency').modal('show');

        $.ajax({
            url: '/edit-student-emergency',
            type: 'POST',
            data: { 
                id: id
            },
            success: function(response) {
                console.log(response);
                $('#editStudentEmergency').modal('show');
                console.log(response.EC_name);
              
                $('.id').val(response.StudentNo);
                $('.EC_name').val(response.EC_name);
                $('.EC_contactNo').val(response.EC_contactNo);
                $('.EC_brgy').val(response.EC_brgy);
                $('.EC_city').val(response.EC_city);
                $('.EC_province').val(response.EC_province);
               
            } 
        });
        });
    });
//Update
$("#updatePesonal").submit(function(e) {
    e.preventDefault();

    var form = $(this);
    var actionUrl = form.attr('action');

    $.ajax({
        type: "POST",
        url: actionUrl,
        data: form.serialize(), 
        success: function(response) {
        
                Swal.fire({
                    title: "Success",
                    text: response.success,
                    icon: "success",
                    button: "OK",
                }).then(() => {
                    location.reload();
                });
        },
        error: function(xhr) {
            Swal.fire({
                title: "An error occurred",
                text: "Status: " + xhr.status + " " + xhr.statusText,
                icon: "error",
                button: "OK",
            });
        }
    });
});

$("#updateFamily").submit(function(e) {
    e.preventDefault();

    var form = $(this);
    var actionUrl = form.attr('action');

    $.ajax({
        type: "POST",
        url: actionUrl,
        data: form.serialize(), 
        success: function(response) {
        
                Swal.fire({
                    title: "Success",
                    text: response.success,
                    icon: "success",
                    button: "OK",
                }).then(() => {
                    location.reload();
                });
        },
        error: function(xhr) {
            Swal.fire({
                title: "An error occurred",
                text: "Status: " + xhr.status + " " + xhr.statusText,
                icon: "error",
                button: "OK",
            });
        }
    });
});

$("#updateEmergency").submit(function(e) {
    e.preventDefault();

    var form = $(this);
    var actionUrl = form.attr('action');

    $.ajax({
        type: "POST",
        url: actionUrl,
        data: form.serialize(), 
        success: function(response) {
        
                Swal.fire({
                    title: "Success",
                    text: response.success,
                    icon: "success",
                    button: "OK",
                }).then(() => {
                    location.reload();
                });
        },
        error: function(xhr) {
            Swal.fire({
                title: "An error occurred",
                text: "Status: " + xhr.status + " " + xhr.statusText,
                icon: "error",
                button: "OK",
            });
        }
    });
});

$(document).ready(function() {
    $("#cancelBtn").click(function() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'Information not saved. Do you want to continue?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Canceled!',
                    text: 'Your action has been canceled.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((response) => {
                    if (response.isConfirmed) {
                        window.history.back();
                    }
                });
            }
        });
    });
});
</script>
@endsection