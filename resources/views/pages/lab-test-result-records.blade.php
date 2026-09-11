<?php
  use App\Http\Controllers\LabResultController;
  $lab = new LabResultController();
?>
@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Lab Result Records')

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
        <div class="card" id="addCard" style="display: none">
          <div class="card-header  " style="background-color:rgb(110, 155, 222);">
            <button type="button" class="btn btn-default float-right button" id="close" style="color: white;" >X</button>
              {{-- @if ($data->gender === 'F')
              <img class="img-fluid" src="{{asset('images/logo/42101748.png')}}" alt="branding logo" style="max-width: 80px; max-height: 80px;">
              @elseif ($data->gender === 'M')
              <img class="img-fluid" src="{{asset('images/logo/43514861.png')}}" alt="branding logo" style="max-width: 80px; max-height: 80px;">
              @endif --}}
          </div> 
          <div class="card-body" style="">
            <div class="alert bg-rgba-info  alert-dismissible fade show" role="alert">
              Please upload the following file types: .pdf, .jpeg, jpg, .png, .gif
              {{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button> --}}
            </div> 
            <form id="myForm" action="{{route('uploadFiles')}}" method="POST" role="form"  enctype="multipart/form-data">
             @csrf 
              <input  class="form-control id col-2" name="" type="hidden" value="{{$newID}}" id="id"> 
              <input  class="form-control id col-2" name="patientId" type="text" value="{{$patient->StudentNo ?? $patient->AgencyNumber}}" id="id" hidden> 
              <div class="form-group col-sm-12" style="font-size:12px;">
                <div class="row">   
                  <h6 class="col-1">CBC:</h6>
                  <div class="col-md-4">
                    <input id="file_cbc" type="file" class="form-control" name="file_cbc" onchange="checkSize(this)" value="">
                  </div>
                </div>
              </div>
              <div class="form-group col-sm-12" style="font-size:12px;">
                <div class="row">            
                  <h6 class="col-1">Urinalysis:</h6>
                  <div class="col-md-4">
                    <input id="file_urinalysis" type="file" class="form-control " name="file_urinalysis"  onchange="checkSize(this)" value="">
                  </div>
                </div>
              </div>
              <div class="form-group col-sm-12" style="font-size:12px;">
                <div class="row">           
                  <h6 class="col-1">Chest X-Ray:</h6>
                  <div class="col-md-4">
                    <input id="file_xray" type="file" class="form-control" name="file_xray" onchange="checkSize(this)" value="">
                  </div>
                </div>
              </div>
              <div class="form-group col-sm-12" style="font-size:12px;">
                <div class="row">            
                  <h6 class="col-1">ECG:</h6>
                  <div class="col-md-4">
                    <input id="file_ecg" type="file" class="form-control" name="file_ecg" onchange="checkSize(this)" value="">
                  </div>
                </div>
              </div>
              <div class="form-group col-sm-12" style="font-size:12px;">
                <div class="row">            
                  <h6 class="col-1">Drug Test:</h6>
                  <div class="col-md-4">
                    <input id="file_drug_test" type="file" class="form-control" name="file_drug_test" onchange="checkSize(this)" value="">
                  </div>
                </div>
              </div>
              <div class="form-group col-sm-12" style="font-size:12px;">
                <div class="row">            
                  <h6 class="col-1">Others:</h6>
                  <div class="col-md-4">
                    <input id="file_others" type="file" class="form-control" name="file_others" onchange="checkSize(this)" value="">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button id="submit-button" type="submit" class="btn btn-primary file">Submit</button>
              </div>
            </form>        
          </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="card border">
          <div class="card-header border " style="background-color:rgb(110, 155, 222);color:#ffffff;height:55px;font-size:15px;font-weight:800;height:50px; display:flex;align-items:center"><i class="fas fa-file-alt " style='font-size:15px;'></i>LABORATORY RESULTS  </div>
            <div class="card-body mt-0 p-1">
              <button type="button" class="btn btn-primary float-right button" id="addNew">Add New</button>
              <div class="table-responsive view-all">
                <table class="table table-sm recordTable table-bordered table-striped zero-configuration" id="recordTable">
                  <thead>
                    <tr>
                      <th style="color:white;text-align:center">Action</th>
                      <th style="color:white;text-align:center">Date</th>
                      <th style="color:white;text-align:center">CBC</th>
                      <th style="color:white;text-align:center">Urinalysis</th>
                      <th style="color:white;text-align:center">Chest X-Ray</th>
                      <th style="color:white;text-align:center">ECG</th>
                      <th style="color:white;text-align:center">Drug Test</th>
                      <th style="color:white;text-align:center">Others</th>
                    </tr>
                  </thead>
                  <tbody id="viewAllRecord">
                    @foreach ($uploaded as $data)
                      <tr>
                        <td style="text-align:center">
                          <div class="dropdown">
                            <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                            <div class="dropdown-menu dropdown-menu-right">
                                {{-- <a class="dropdown-item viewbutton" href="#" data-role="Student" data-id="{{ $data->id }}"><i class="bx bx-edit mr-1"></i>edit</a> --}}
                                <a class="dropdown-item deleteButton" href="#"  data-role="Student" data-id="{{ $data->id }}"><i class="bx bx-trash mr-1"></i>delete</a>
                            </div>
                            </div>
                        </td>
                        <td style="text-align:center">{{ date('m-d-Y', strtotime($data->created_at)) }}</td>
                          @php
                            $extension_cbc = pathinfo($data->file_cbc, PATHINFO_EXTENSION);
                            $extension_urinalysis = pathinfo($data->file_urinalysis, PATHINFO_EXTENSION);
                            $extension_xray = pathinfo($data->file_xray, PATHINFO_EXTENSION);
                            $extension_ecg = pathinfo($data->file_ecg, PATHINFO_EXTENSION);
                            $extension_drug_test = pathinfo($data->file_drug_test, PATHINFO_EXTENSION);
                            $extension_others = pathinfo($data->file_others, PATHINFO_EXTENSION);
                          @endphp
                        <td style="text-align:center">
                          @if ($data->file_cbc)
                            <form action="{{ route('deleteFile', [$data->id, 'file_cbc']) }}" method="POST">
                              <div class="row justify-content-center ">
                                <div class="column">
                                  @if (in_array(strtolower($extension_cbc), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp','jfif']))
                                    <a href="/storage/Laravel/laboratory_result/{{$data->file_cbc}}" target="_blank">
                                      <img src="/storage/Laravel/laboratory_result/{{$data->file_cbc}}" alt="img" width="100" height="70">
                                    </a>
                                  @elseif (strtolower($extension_cbc) === 'pdf')
                                    <a href="/storage/Laravel/laboratory_result/{{$data->file_cbc}}" target="_blank">
                                      <span><i class="bx bx-file" style="font-size:45px;"></i></span>
                                    </a>
                                  @endif
                                </div>
                                <div class="column">
                                  <a href="/storage/Laravel/laboratory_result/{{$data->file_cbc}}" download="{{$data->file_cbc}}">
                                    <span><i class="bx bx-download" style="color: green;"></i></span>
                                  </a><br>
                                  @csrf
                                  @method('DELETE')
                                  <button type="button" onclick="confirmDelete({{ $data->id }}, 'file_cbc')" style="background:none; border:none; cursor:pointer;">
                                    <i class="bx bx-trash" style="color: red;"></i>
                                  </button>
                                </div>
                              </div>
                            </form> 
                          @endif
                        </td>
                        <td style="text-align:center">
                          @if ($data->file_urinalysis)
                            <form action="{{ route('deleteFile', [$data->id, 'file_urinalysis']) }}" method="POST">
                              <div class="row justify-content-center">
                                <div class="column">
                                  @if (in_array(strtolower($extension_urinalysis), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp','jfif']))
                                    <a href="/storage/Laravel/laboratory_result/{{$data->file_urinalysis}}" target="_blank">
                                      <img src="/storage/Laravel/laboratory_result/{{$data->file_urinalysis}}" alt="img" width="100" height="70">
                                    </a>
                                  @elseif (strtolower($extension_urinalysis) === 'pdf')
                                    <a href="/storage/Laravel/laboratory_result/{{$data->file_urinalysis}}" target="_blank">
                                      <span><i class="bx bx-file" style="font-size:45px;"></i></span>
                                    </a>
                                  @endif
                                </div> 
                                <div class="column">
                                  <a href="/storage/Laravel/laboratory_result/{{$data->file_urinalysis}}" download="{{$data->file_urinalysis}}">
                                    <span><i class="bx bx-download" style="color: green;"></i></span>
                                  </a><br>
                                  @csrf
                                  @method('DELETE')
                                  <button type="button" onclick="confirmDelete({{ $data->id }}, 'file_urinalysis')" style="background:none; border:none; cursor:pointer;">
                                      <i class="bx bx-trash" style="color: red"></i>
                                  </button>
                                </div>
                              </div>
                            </form>
                          @endif
                        </td>
                        <td style="text-align:center">
                          @if ($data->file_xray)
                            <form action="{{ route('deleteFile', [$data->id, 'file_xray']) }}" method="POST"  enctype="multipart/form-data">
                              <div class="row justify-content-center">
                                <div class="column">
                                  @if (in_array(strtolower($extension_xray), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp','jfif']))
                                  <a href="/storage/Laravel/laboratory_result/{{$data->file_xray}}" target="_blank">
                                    <img src="/storage/Laravel/laboratory_result/{{$data->file_xray}}" alt="img" width="100" height="70">
                                  </a>
                                  @elseif (strtolower($extension_xray) === 'pdf')
                                    <a href="/storage/Laravel/laboratory_result/{{$data->file_xray}}" target="_blank">
                                    <span><i class="bx bx-file" style="font-size:45px;"></i></span>
                                    </a>
                                  @endif
                                </div>
                                <div class="column">
                                  <a href="/storage/Laravel/laboratory_result/{{$data->file_xray}}" download="{{$data->file_xray}}">
                                    <span><i class="bx bx-download" style="color: green;"></i></span>
                                  </a><br>
                                  @csrf
                                  @method('DELETE')
                                  <button type="button" onclick="confirmDelete({{ $data->id }}, 'file_xray')" style="background:none; border:none; cursor:pointer;">
                                      <i class="bx bx-trash" style="color: red"></i>
                                  </button>
                                </div>
                              </div>
                            </form>
                          @endif
                        </td>
                        <td style="text-align:center">
                          @if ($data->file_ecg)
                            <form action="{{ route('deleteFile', [$data->id, 'file_ecg']) }}" method="POST">
                              <div class="row justify-content-center">
                                <div class="column">
                                  @if (in_array(strtolower($extension_ecg), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp','jfif']))
                                  <a href="/storage/Laravel/laboratory_result/{{$data->file_ecg}}" target="_blank">
                                    <img src="/storage/Laravel/laboratory_result/{{$data->file_ecg}}" alt="img" width="100" height="70">
                                  </a>
                                  @elseif (strtolower($extension_ecg) === 'pdf')
                                    <a href="/storage/Laravel/laboratory_result/{{$data->file_ecg}}" target="_blank">
                                      <span><i class="bx bx-file" style="font-size:45px;"></i></span>
                                    </a>
                                  @endif
                                </div>
                                <div class="column">
                                  <a href="/storage/Laravel/laboratory_result/{{$data->file_ecg}}" download="{{$data->file_ecg}}">
                                    <span><i class="bx bx-download" style="color: green;"></i></span>
                                  </a><br>
                                  @csrf
                                  @method('DELETE')
                                  <button type="button" onclick="confirmDelete({{ $data->id }}, 'file_others')" style="background:none; border:none; cursor:pointer;">
                                    <i class="bx bx-trash" style="color: red"></i>
                                  </button>
                                </div>                              
                              </div>
                            </form>
                          @endif
                        </td>
                        <td style="text-align:center">
                          @if ($data->file_drug_test)
                            <form action="{{ route('deleteFile', [$data->id, 'file_drug_test']) }}" method="POST">
                              <div class="row justify-content-center">
                                <div class="column">
                                  @if (in_array(strtolower($extension_drug_test), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp','jfif']))
                                  <a href="/storage/Laravel/laboratory_result/{{$data->file_drug_test}}" target="_blank">
                                    <img src="/storage/Laravel/laboratory_result/{{$data->file_drug_test}}" alt="img" width="100" height="70">
                                  </a>
                                  @elseif (strtolower($extension_drug_test) === 'pdf')
                                    <a href="/storage/Laravel/laboratory_result/{{$data->file_drug_test}}" target="_blank">
                                      <span><i class="bx bx-file" style="font-size:45px;"></i></span>
                                    </a>
                                  @endif
                                </div>
                                <div class="column">
                                  <a href="/storage/Laravel/laboratory_result/{{$data->file_drug_test}}" download="{{$data->file_drug_test}}">
                                    <span><i class="bx bx-download" style="color: green;"></i></span>
                                  </a> <br>
                                  @csrf
                                  @method('DELETE')
                                  <button type="button" onclick="confirmDelete({{ $data->id }}, 'file_drug_test')" style="background:none; border:none; cursor:pointer;">
                                      <i class="bx bx-trash" style="color: red"></i>
                                  </button>
                                </div>
                              </div>
                            </form>
                          @endif
                        </td>
                        <td style="text-align:center">
                          @if ($data->file_others)
                            <form action="{{ route('deleteFile', [$data->id, 'file_others']) }}" method="POST">
                              <div class="row justify-content-center">
                                <div class="column">
                                  @if (in_array(strtolower($extension_others), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp','jfif']))
                                  <a href="/storage/Laravel/laboratory_result/{{$data->file_others}}" target="_blank">
                                    <img src="/storage/Laravel/laboratory_result/{{$data->file_others}}" alt="img" width="100" height="70">
                                  </a>
                                  @elseif (strtolower($extension_others) === 'pdf')
                                    <a href="/storage/Laravel/laboratory_result/{{$data->file_others}}" target="_blank">
                                      <span><i class="bx bx-file" style="font-size:45px;"></i></span>
                                    </a>
                                  @endif
                                </div>
                                <div class="column">
                                  <a href="/storage/Laravel/laboratory_result/{{$data->file_others}}" download="{{$data->file_others}}">
                                    <span><i class="bx bx-download" style="color: green;"></i></span>
                                  </a><br>
                                  @csrf
                                  @method('DELETE')
                                  <button type="button" onclick="confirmDelete({{ $data->id }}, 'file_others')" style="background:none; border:none; cursor:pointer;">
                                      <i class="bx bx-trash" style="color: red"></i>
                                  </button>
                                </div>
                              </div>
                            </form>
                          @endif
                        </td>
                      </tr> 
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer">
              <button type="button"  id="button" class="btn btn-secondary  float-right">Back</button>
            </div>
          </div>
        </div>
      </div>
    </div> 
    <div class="col-md-2">
      <div class="card">
          <div class="card-header align-center " style="background-color:rgb(110, 155, 222);display: flex; flex-direction: column; align-items: center; justify-content: center;height:170px;">
                <img class="img-fluid rounded-circle" src="{{ $lab->profilephoto(['StudentNo' => $patient->StudentNo,'campus' => session('campus')]) }}" alt="profile photo" style="width: 150px; height: 150px; object-fit: cover;"
                  onerror="this.onerror=null; this.src='{{ $patient->Sex === 'Female' || $patient->Sex === 'F' ? asset('images/logo/42101748.png') : asset('images/logo/43514861.png') }}'; this.classList.remove('rounded-circle'); this.style.width='150px'; this.style.height='150px';">
          </div>
        <div class="card-body" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 20px;">
          <label style="font-size: 18px;" id="id">
            {{ isset($patient->StudentNo) ? $patient->StudentNo : $patient->AgencyNumber }}
        </label>    
          <label class="inline-cursor" id="firstname">{{utf8_decode($patient->FirstName)}}</label>
        </div>
      </div>                
    </div>
    @if (session()->has('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
          setTimeout(function() {
            Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session()->get('success') }}'
            });
          }, 1000);
        </script>
    @endif
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

document.getElementById("firstname").addEventListener("mouseenter", function() {
  Swal.fire({
    title: "<small>Firstname: <b>{{utf8_decode($patient->FirstName)}}</b></small> <br>" +
          "<small>Middlename: <b>{{utf8_decode($patient->MiddleName)}}</b></small> <br>" +
          "<small>Lastname:  <b>{{utf8_decode($patient->LastName)}}</b></small>",
    icon: "info",
    showConfirmButton: false,
    allowOutsideClick: true,
    allowEscapeKey: true,
    timerProgressBar: true,
    toast: true,
    position: "top-end"
  });
});

document.getElementById("firstname").addEventListener("mouseleave", function() {Swal.close();});

$(document).ready(function(){
  $('#addNew').click(function(){
    $('#addCard').show();
  });
});

$(document).ready(function(){
  $('#close').click(function(){
    $('#addCard').hide();
  });
});

$(document).ready(function () {
  $('#myForm').submit(function (event) {
      
    var fileInputs = $('input[type="file"]');
    var filesSelected = false;
    fileInputs.each(function () {
      if ($(this).get(0).files.length > 0) {
        filesSelected = true;
        return false; 
      }
    });
    if (!filesSelected) {
      event.preventDefault(); 
      if (!filesSelected) {
      event.preventDefault();
      Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Please select at least one file to upload.',
      });
      }
    }
  });
});

function confirmDelete(id,type) {
  Swal.fire({
    title: 'Are you sure?',
    text: "This action cannot be undone.",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: `labresults/${id}/file/${type}`,
        type: 'DELETE',
        success: function(response) {
          Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: response.message,
            timer: 2000,
            showConfirmButton: false
          })

          $(`#row-${id}`).remove();
          location.reload();
        },
        error: function() {
          Swal.fire('Error', 'Could not delete record.', 'error');
        }
      })
    }
  })
};

function checkSize(input) {
  const maxSize = 2 * 1024 * 1024; 
  if (input.files[0].size > maxSize) {
    Swal.fire({
      icon: 'error',
      title: 'File to large exceed 2 MB',
      timer: 5000,
      showConfirmButton: false
    });

    input.value = '';
  }
}

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
          url: '/deleteRecordResult',
          success: function(response) {
            if (response.message === 'Lab result deleted successfully') {
                Swal.fire('Deleted!', 'The record has been deleted.', 'success');
                location.reload();
            } else if(response.message === 'Lab result not found'){
              Swal.fire('Error!', 'Lab result not found');
            } else {
                Swal.fire('Error!', 'Failed to delete the record.', 'error');
            }
          },
          error: function() {
              Swal.fire('Error!', 'Failed to delete the record.', 'error');
          }
        })
      }
    })
  })
});

$(document).ready(function(){
    $("#button").click(function(){
      window.history.back();
  })
 });
</script>
@endsection