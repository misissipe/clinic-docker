
@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Employee Information')
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
          <div class="card-body">
            <div class="btnprint">
              <button type="button" class="btn btn-danger float-right button btnEdit" style="margin-left:3%" id="btnDelete" data-id="{{(new AESCipher)->encrypt($data->AgencyNumber)}}">
                <a style="color: rgb(255, 255, 255); font-size: 15px;">Delete</a>
              </button>
              <button type="button" class="btn btn-primary float-right button btnEdit" id="btnEdit" data-id="{{(new AESCipher)->encrypt($data->AgencyNumber)}}">
                <a style="color: rgb(255, 255, 255); font-size: 15px;">Edit</a>
              </button>
              
            </div>
            <h5 style="font-weight: bold; font-style: italic;color:royalblue)">PERSONAL INFORMATION</h5><br>
              <div class="form-group">
                <div class="row">
                  <div class="col-2">
                    <h6>Name:</h6>
                  </div>
                  <div class="col">
                    <b>{{ $data->FirstName }} {{$data->MiddleName}} {{$data->LastName}}</b>
                  </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <h6>Sex:</h6>
                    </div>
                    <div class="col">
                        <b>{{$data->Sex}}</b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <h6>Age:</h6>
                    </div>
                    <div class="col">
                        <b>{{$age}}</b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <h6>BirthDate:</h6>
                    </div>
                    <div class="col">
                        <b>{{$data->DateOfBirth}}</b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <h6>Civil Status:</h6>
                    </div>
                    <div class="col">
                        <b>{{$data->CivilStatus}}</b>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <h6>Nationality:</h6>
                    </div>
                    <div class="col">
                        <b>{{$data->Citizenship}}</b>
                    </div>
                    <div class="col-2">
                        <h6>Contact No.:</h6>
                    </div>
                    <div class="col">
                        <b>{{$data->Cellphone}}</b>
                    </div>
                </div>
                <div class="row">
                  <div class="col-2">
                    <h6>Address:</h6>
                  </div>
                  <div class="col">
                    <b>{{$data->RBarangay}} {{$data->citymunDesc}} {{$data->provDesc}}</b>
                  </div>
                  <div class="col-2">
                    <h6>Email Address:</h6>
                  </div>
                  <div class="col">
                    <b>{{$data->EmailAddress}}</b>
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
        <div class="card-body">
          <h5 style="font-weight: bold; font-style: italic;color:royalblue)">EMPLOYMENT BACKGROUND</h5><br>
            <div class="form-group">
              <div class="row">
                <div class="col-2">
                  <h6>Employee ID:</h6>
                </div>
                <div class="col">
                  <b>{{$data->AgencyNumber}}</b>
                </div>
              </div>
              <div class="row">
                <div class="col-2">
                  <h6>Employment Status:</h6>
                </div>
                <div class="col">
                  <b>{{$data->EmploymentStatus}}</b>
                </div>
              </div>
              <div class="row">
                <div class="col-2">
                  <h6>Department:</h6>
                </div>
              <div class="col">
                <b>{{$data->DepartmentName}}</b>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('modal.edit-employeeInfo')
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
        $('#editEmployeeinfo').modal('show');

        $.ajax({
            url: '/edit-employee-personal',
            type: 'POST',
            data: { 
                id: id
            },
            success: function(response) {
                console.log(response);
                $('#editEmployeeinfo').modal('show');
                console.log(response.AgencyNumber);
                var DateOfBirth = new Date(response.DateOfBirth);
                var today = new Date();
                var Age = today.getFullYear() - DateOfBirth.getFullYear();
                var m = today.getMonth() - DateOfBirth.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < DateOfBirth.getDate())) {
                    Age--;
                }

                function ucwords(str) {
                    return str.toLowerCase().replace(/\b\w/g, function (match) {
                        return match.toUpperCase();
                    });
                }
                
                $('.id').val(response.AgencyNumber);
                $('.FirstName').val(ucwords(response.FirstName));
                $('.MiddleName').val(ucwords(response.MiddleName));
                $('.LastName').val(ucwords(response.LastName));
                $('.DateOfBirth').val(response.DateOfBirth);
                $('.Age').val(Age);
                $('.CivilStatus').val(response.CivilStatus);
                $('.Citizenship').val(response.Citizenship);
                $('.RBarangay').val(ucwords(response.RBarangay));
                $('.citymunDesc').val(ucwords(response.citymunDesc));
                $('.provDesc').val(ucwords(response.provDesc));
                $('.EmailAddress').val(response.EmailAddress);
                $('.Cellphone').val(response.Cellphone);

            
            } 
        });
        });
    });


//Update
$("#updatePersonalEmp").submit(function(e) {
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