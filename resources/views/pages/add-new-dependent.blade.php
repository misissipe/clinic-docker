@extends('layouts.contentLayoutMaster')
@php
use App\Http\Controllers\AESCipher;
@endphp  
@section('title','Dependent')
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
 
thead{
  background-color: rgb(110, 155, 222);
 }
</style>
@endsection
{{-- page-styles --}}
@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <button type="button" class="btn btn-primary addModal float-right" data-toggle="modal" data-id="{{$empId}}" data-target="#addDependentModal"><i class='fa fa-user-plus'> Add Dependent</i></button>
            <div class="table-responsive">
              <table class="table table-sm recordTable table-bordered table-striped zero-configuration" id="recordTable" style="text-align:center;">
                <thead>
                  <tr>
                    <th style="color:white;">Action</th>
                    <th style="color:white;">Date</th>
                    <th style="color:white;">Name</th>
                    <th style="color:white;">Gender</th>
                    <th style="color:white;">Create</th>
                  </tr>
                </thead>
                <tbody id="viewAllRecord">
                @foreach($user as $data)  
                  <tr>    
                    <td style="text-align:center">
                      <div class="dropdown">
                        <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item editModal" href="#" data-role="Student" data-id="{{($data->id)}}"><i class="bx bx-edit mr-1"></i>edit</a>
                            <a class="dropdown-item deleteButton" href="#"  data-role="Student" data-id="{{($data->id)}}"><i class="bx bx-trash mr-1"></i>delete</a>
                        </div>
                        </div>
                    </td> 
                    <td>{{ date('m-d-Y', strtotime ($data->date))}}</td>
                    <td>{{ucwords(strtolower(utf8_decode($data->LastName)))}}, {{ucwords(strtolower(utf8_decode($data->FirstName)))}} {{ucwords(strtolower(utf8_decode($data->MiddleName)))}}</td>
                    <td>{{$data->Gender}}</td>
                    <td><button type="button" class="btn btn-default create" data-id="{{(new AESCipher)->encrypt($data->id)}}"><i class="fa fa-user" style="font-size:20px"></i></button></td>           
                  </tr>
                @endforeach 
                </tbody>
              </table>
            <div>
                <br>
              <button type="button" id="backBtn" class="col-md-1 btn btn-secondary float-right">Back</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('modal.addDependent')
    @include('modal.viewUser')
    @include('modal.editDependent')
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
  
$("#addModal").submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var actionUrl = form.attr('action');

    $("#submitBtn").prop("disabled", true);

    $.ajax({
        type: "POST",
        url: actionUrl,
        data: form.serialize(), 
        success: function(data) {
            $('#addDependentModal').modal('hide');
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.success
            }).then(function() {
              $("#submitBtn").prop("disabled", false);
                location.reload();
            });
        }
    });
});


$(document).on('click', '.create', function() {
  var id = $(this).data('id');
  window.location.href = "/new-dependent-dental-record?id=" + encodeURIComponent(id);
});

$(document).on('click', '.addModal', function(){
    var id = $(this).data('id'); 
    var today = new Date();
    var formattedDate = today.getFullYear()+'-'+(today.getMonth()+1).toString().padStart(2, '0')+'-'+today.getDate().toString().padStart(2, '0');

    $('#addDependentModal').find('.id').val(id);
    $('#date').val(formattedDate);
});

$(document).ready(function () {
    $(document).on('click', '.editModal', function () {
        var id = $(this).data('id');
        console.log(id);
        $('#editDependentModal').modal('show');

        $.ajax({
            url: '/edit-Dependent',
            type: 'POST',
            data: {
                id: id
            },
            success: function (response) {
                console.log(response);
                $('#editDependentModal').modal('show');
                console.log(response.id);

                var today = new Date();
                var formattedDate = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');

                console.log(response.BirthDate);

                $('.date').val(formattedDate);
                $('.id').val(response.id);
                $('.firstname').val(response.FirstName.replace(/ï¿½\?Â±|Ã±/g, 'ñ'));
                $('.middlename').val(response.MiddleName.replace(/ï¿½\?Â±|Ã±/g, 'ñ'));
                $('.lastname').val(response.LastName.replace(/ï¿½\?Â±|Ã±/g, 'ñ'));
                $('.bday').val(response.BirthDate);
                $('.gender').val(response.Gender);
            }
        });
    });
});


$(document).ready(function() {
    $('.deleteButton').click(function() {
        var recordId = $(this).data('id');

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
                    data: { id: recordId}, 
                    url: '/deleteDependent',
                    success: function(response) {
                        if (response.message === 'Deleted successfully') {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'The record has been deleted.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed || result.isDismissed) {
                                    location.reload();
                                }
                            });
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


$("#updateDependent").submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var actionUrl = form.attr('action');
    $.ajax({
        type: "POST",
        url: actionUrl,
        data: form.serialize(), 
        success: function(data) {
            $('#editDependentModal').modal('hide');
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


//Cancel button in Add
$(document).ready(function(){
    $("#backBtn").click(function(){
      window.location.href = "/employee-dental-record";
  })
 });


$("#updateModal").submit(function(e) {
    e.preventDefault();
    var form = $(this);
    var actionUrl = form.attr('action');
    $.ajax({
        type: "POST",
        url: actionUrl,
        data: form.serialize(), 
        success: function(data) {
            $('#viewUserModal').modal('hide');
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
</script>
@endsection