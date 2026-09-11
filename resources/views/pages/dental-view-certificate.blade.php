@php
use App\Http\Controllers\AESCipher;
@endphp  
@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Generated Certificate Records')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
   table, th,td,tr{
  border: 1px solid rgb(225, 225, 225);
  border-collapse: collapse;
  padding: 1px;
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
  .vl {
    border-left: 2px solid rgb(58, 57, 57);
    height: 50px;
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
          <div class="card">
            {{-- <div class="card-header" style="font-weight: bold;color:white;background-color: rgb(110, 155, 222); display: flex; align-items: center;">GENERATED CERTIFICATE RECORDS</div> --}}
              <div class="card-body">
                <div class="table-responsive">
                  <h4>Patient Record</h4>
                  <table class="table table-sm recordTable table-bordered table-striped datatables" id="recordTable">
                    <thead>
                      <tr>
                        <th style="color:white;">Action</th>
                        <th style="color:white;">Date</th>
                        <th style="color:white;">Treated By</th>
                        <th style="color:white;">No. of day/s</th>
                        <th style="color:white;">Purpose</th>
                        {{-- <th style="color:white;">Status</th> --}}
                        
                      </tr>
                    </thead>
                    <tbody id="viewAllRecord">
                      @foreach ($list as $data)
                      <tr> 
                        <td>
                          <div class="dropdown">
                            <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                            <div class="dropdown-menu dropdown-menu-right" >
                               <a class="dropdown-item preview" data-role="{{$role}}" href="#" data-id={{(new AESCipher)->encrypt($data->id)}} data-target="#viewDentalcert" data-toggle="modal"><i class="bx bx-edit mr-1"></i>Edit</a>
                               <a class="dropdown-item print " data-id="{{ (new AESCipher)->encrypt($data->id)}}" data-role="{{$role}}"><i class="bx bx-printer mr-1"></i> Print</a>
                              <a class="dropdown-item deleteButton" href="#"  data-role="{{ $data->role }}" data-id="{{ (new AESCipher)->encrypt($data->id)}}"><i class="bx bx-trash mr-1"></i>delete</a>
                            </div>
                            </div>
                        </td>   
                        <td>{{ date('m-d-Y', strtotime($data->date)) }}</td>
                        <td>{{ $data->treated_by }}</td>
                        <td>{{ $data->no_days }}</td>
                        <td>{{ $data->purpose }}</td>
                        {{-- <td class="@if($data->status == 'Pending') pending-status @elseif($data->status == 'Approved') approved-status @elseif($data->status == 'Disapproved') disapproved-status @endif">{{$data->status}}</td> --}}          
                        </tr>
                      @endforeach 
                    </tbody>
                  </table>
                </div> 
              </div>
              <div class="card-footer">
                <button type="button" class="btn btn-secondary btn-custom float-right" id="home">Back</button>
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-2">
      <div class="card">
        <div class="card-header align-center " style="background-color:rgb(110, 155, 222);display: flex; flex-direction: column; align-items: center; justify-content: center;height:100px;">
            @if ($newencryptedId->gender === 'Female')
            <img class="img-fluid" src="{{asset('images/logo/42101748.png')}}" alt="branding logo" style="max-width: 80px; max-height: 80px;">
            @elseif ($newencryptedId->gender === 'Male')
            <img class="img-fluid" src="{{asset('images/logo/43514861.png')}}" alt="branding logo" style="max-width: 80px; max-height: 80px;">
            @endif
        </div> 
        <div class="card-body" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 20px;">
          <label style="font-size: 18px;" id="id">{{$newencryptedId->patientId}}</label>
          <label class="inline-cursor" id="firstname">{{utf8_decode($newencryptedId->firstname)}}</label>
        </div>
      </div>                
    </div>
      @include('modal.editDental-certificate')
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
var id = $(this).data('id');
//Back button in View
 $(document).ready(function(){
    $("#home").click(function(){
      window.history.back();
  })
 });

 
 $("#viewDentalcert").on("hide.bs.modal", function(e){
      // $("input:checkbox").each(function() {
      //     $(this).prop("checked", false);  
      // });
  })

  $("#viewDentalcert").on("shown.bs.modal", function(e){ 
    const id = $(e.relatedTarget).data('id');
    console.log(id)
    $.ajax({
    type: 'post',
    url: '/modalEdit',
    data:{ id: id},
    dataType: 'json',
   
    success: function(response) {
      console.log(response.id)

        $('.date').val(response.date);
        $('.id').val(response.id);
        $('.treatedby').val(response.treated_by);
        $('.no_days').val(response.no_days);
        $('.role').val(response.role);
            
      }
    })
  })

//Update
$("#updateDentalCert").submit(function(e) {
            e.preventDefault();

          var form = $(this);
          var actionUrl = form.attr('action'); 
          var id = $('#id').val();
          var role = form.find('[name="role"]').val();

          console.log(id);

          $.ajax({
              type: "POST",
              url: actionUrl,
              data: form.serialize(), 
              success: function(response){
                if (response.status == 200) {
                  Swal.fire({
                title: response['success'],
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Proceed',
                cancelButtonText: 'Update Only'
              }).then((response2) => {
                if (response2.isConfirmed) {
                  var role = response.role;
                  console.log(role);
                if (role === 'Student') {
                  window.location.href = "/dental-preview-certificate?id=" + encodeURIComponent(response.id)  + "&role=Student";
                } else if (role === 'Employee') {
                  window.location.href = "/dental-preview-certificate?id=" + encodeURIComponent(response.id)  + "&role=Employee";
                }
                } else if (response2.dismiss === Swal.DismissReason.cancel) {
                  Swal.fire({
                  title: "Updated Successfully",
                  text: "The record has been updated successfully.",
                  icon: "success",
                  buttons: {
                    confirm: {
                      text: "OK",
                      value: true,
                      visible: true,
                      className: "",
                      closeModal: true
                 }
              }
            }).then((response3) => {
                    if (response3.isConfirmed) {
                      location.reload();
                    }
                  })
                }
                }) 
            console.log(response);
            }
          }
        });
      });

//label cursor
document.getElementById("firstname").addEventListener("mouseenter", function() {
  Swal.fire({
    title: "<small>Firstname: <b>{{utf8_decode($newencryptedId->firstname)}}</b></small> <br>" +
           "<small>Middlename: <b>{{utf8_decode($newencryptedId->middlename)}}</b></small> <br>" +
           "<small>Lastname:  <b>{{utf8_decode($newencryptedId->lastname)}}</b></small>",
    icon: "info",
    showConfirmButton: false,
    allowEscapeKey: true,
    timerProgressBar: true,
    toast: true,
    position: "top-end"
  });
});

document.getElementById("firstname").addEventListener("mouseleave", function() {
  Swal.close();
});
//print
$(document).ready(function(){
    $(".print").click(function(){
      if ($(this).hasClass("disabled")) {
      return false;
    }

  var id = $(this).data('id'); 
  var role = $(this).data('role');


  if (role === 'Student') {
    window.location.href = "/dental-preview-certificate?id=" + encodeURIComponent(id)  + "&role=Student";
  } else if (role === 'Employee') {
    window.location.href = "/dental-preview-certificate?id=" + encodeURIComponent(id)  + "&role=Employee";
  }
 });
});

$(document).ready(function() {
  $('.datatables').DataTable({
      'aLengthMenu' :[[10,20,50,100,-1],[10,20,50,100,'All']],

      "order": [ 0, "asc" ]
    })
  });  


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
                    url: '/deleteDentalcert',
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

</script>
@endsection