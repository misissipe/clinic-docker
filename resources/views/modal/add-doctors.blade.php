@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Doctors')
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
</style>
@endsection
{{-- page-styles --}}
@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="card">
        {{-- <div class="card-header" style="font-weight: bold;color:white;background-color: rgb(110, 155, 222);">VIEW RECORDS</div> --}}
        <div class="card-body">
          <button type="button" class="btn btn-primary float-right button" data-toggle="modal" data-target="#addDoctors" id="adddoctor"><a style="color: rgb(255, 255, 255); font-size: 15px;">Add Doctor</a></button>
          <div class="table-responsive">
            <table class="table table-sm recordTable table-bordered table-striped zero-configuration" id="recordTable" style="text-align:center;">
              <thead>
                <tr>
                  <th style="color:white;">Action</th>
                  <th style="color:white;">License</th>
                  <th style="color:white;">Name</th>
                  <th style="color:white;">Specialization</th>
                </tr>
              </thead>
              <tbody id="viewAllRecord">
              @foreach($view as $data)  
                <tr>    
                  <td style="text-align:center">
                    <div class="dropdown">
                      <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                      <div class="dropdown-menu dropdown-menu-right">
                          <a class="dropdown-item editModal" href="#" data-role="Student" data-id="{{(new AESCipher)->encrypt($data->id)}}"><i class="bx bx-edit mr-1"></i>edit</a>
                          <a class="dropdown-item deleteButton" href="#"  data-role="Student" data-id="{{(new AESCipher)->encrypt($data->id)}}"><i class="bx bx-trash mr-1"></i>delete</a>
                      </div>
                      </div>
                  </td> 
                  <td style="text-transform:capitalize;">{{$data->license}}</td>
                  <td style="text-transform:capitalize;">{{$data->FirstName}} {{$data->MiddleName}}. {{$data->LastName}} </td>
                  <td style="text-transform:capitalize;">{{$data->specialization}}</td>
                  {{-- <td><button type="button" class="btn btn-default create" data-id="{{(new AESCipher)->encrypt($data->id)}}"><i class="	fa fa-user" style="font-size:20px"></i></button></td>            --}}
                </tr>
              @endforeach 
              </tbody>
            </table>
          <div>
          </div>
        </div>
        </div>
      </div>
        </div>
      </div>
        </div>
      </div>
    </div> 
  </div>
  @include('modal.addDoctors')
  @include('modal.editDoctors')
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


  
$("#addDoctorsModal").submit(function(e) {
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

$(document).ready(function() {
    $(document).on('click', '.editModal', function() {
        var id = $(this).data('id');
        console.log(id);
        $('#editDoctors').modal('show');

        $.ajax({
            url: '/editDoctors',
            type: 'POST',
            data: { 
                id: id
            },
            success: function(response) {
                console.log(response);
                $('#editDoctors').modal('show');
                console.log(response.id);

                $('.id').val(id);
                $('.LastName').val(response.LastName);
                $('.FirstName').val(response.FirstName);
                $('.MiddleName').val(response.MiddleName);
                $('.license').val(response.license);
                $('.specialization').val(response.specialization);
              
            } 
        });
    });
});


$(document).ready(function() {
    $('#editDoctorsModal').submit(function(e) {
        e.preventDefault();

      var form = $(this);
      var actionUrl = form.attr('action');

      $.ajax({
          type: 'POST',
          url: actionUrl,
          data: form.serialize(), 
          success: function(response) {
            if (response.status == 200) {
             Swal.fire({
             title: response['success'],
             icon: 'success',
             confirmButtonText: 'Okay',
                  }).then((response) => {
                      
                  if (response.isConfirmed) {
                    $('#editDoctorsModal').modal('hide')
                      console.log(response); 
                      location.reload();			
                  }
                })
              }
              else if (response.status == 500){
                Swal.fire({
                  icon: "error",
                  title: response.error,
                })
              }
              else if (response && response.Error === 1) {
              Swal.fire({
                icon: "error",
                title: response.Message,
              }).then((result1) => {
                if (result1.isConfirmed) {
                    location.reload();
                    $("#saveBtn").prop("disabled", false);
                }
              });
            }
            },
            error: function(error) {
                console.error(error);
            }
        });
    });
});

 //Delete
 $(document).ready(function() {
        // Use event delegation
        $(document).on('click', '.deleteButton', function() {
            var id = $(this).data('id');
            console.log('Delete button clicked, ID:', id);  // Debugging statement

            if (!id) {
                console.error('No ID found for the delete action');
                return;
            }

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
                        url: '/deleteProduct',
                        data: { id: id },
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