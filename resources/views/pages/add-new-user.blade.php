@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Account')

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
      {{-- <div class="card-header"></div> --}}
            <div class="card-body">
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addUserModal"><i class='fa fa-user-plus'> Add New</i></button>
              <div class="table-responsive">
                <table class="table table-sm recordTable table-bordered table-striped zero-configuration" id="recordTable" style="text-align:center;">
                  <thead>
                    <tr>
                      <th style="color:white;">Action</th>
                      <th style="color:white;">Employee ID</th>
                      <th style="color:white;">Name</th>
                      {{-- <th style="color:white;">Email</th> --}}
                      <th style="color:white;">Role</th>
                    </tr>
                  </thead>
                  <tbody id="viewAllRecord">
                    @foreach($user as $data)  
                      <tr>  
                        <td style="text-align:center">
                          <div class="dropdown">
                            <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item viewModal" href="#"  data-id="{{"$data->employee_id"}}" data-toggle="modal" data-target="#viewUserModal"><i class="bx bx-edit mr-1"></i>edit</a>
                                <a class="dropdown-item deleteButton" href="#"  data-role="{{ $data->role }}" data-id="{{ $data->employee_id }}"><i class="bx bx-trash mr-1"></i>delete</a>
                              </div>
                            </div>
                        </td>  
                        <td>{{$data->employee_id}}</td>
                        <td>{{$data->lastname}}, {{$data->firstname}} {{$data->middlename}}</td>
                        <td>{{$data->role}}</td>
           
                        {{-- <td><button type="button" class="btn btn-default viewModal" data-id="{{"$data->employee_id"}}" data-toggle="modal" data-target="#viewUserModal"><i class="fa fa-edit" style="font-size:20px"></i></button></td>            --}}
                      </tr>
                    @endforeach 
                  </tbody>
                </table>
              </div>
            </div>
        </div>
    </div>
    @include('modal.addUser')
    @include('modal.viewUser')
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
    $.ajax({
        type: "POST",
        url: actionUrl,
        data: form.serialize(), 
        success: function(data) {
            $('#addUserModal').modal('hide');
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



$(document).on('click', '.viewModal', function() {
    $.ajax({
        url: '/viewUser',
        type: 'post',
        data: { employee_id: $(this).data('id') },
        success: function(response) {
            console.log(response.email);

            $('#employee_id').val(response.employee_id);
            $('.firstname').val(response.firstname);
            $('.middlename').val(response.middlename);
            $('.lastname').val(response.lastname);
            $('.email').val(response.email);

            $('#role-select').val(response.role);
        }
    });
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


 //Delete
 $(document).ready(function() {
    $('.deleteButton').click(function() {
        var recordId = $(this).data('id');

        Swal.fire({
            title: 'Delete Record',
            text: 'Are you sure you want to delete this user?',
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
                  url: '/delete-user',
                  success: function(response) {
                      if (response.message === 'Deleted successfully') {
                          Swal.fire('Deleted!', 'The user has been deleted.', 'success');
                          location.reload();
                      } else {
                          Swal.fire('Error!', 'Failed to delete the user.', 'error');
                      }
                  },
                  error: function() {
                      Swal.fire('Error!', 'Failed to delete the user.', 'error');
                  }
              });
            }
        });
    });
});
</script>
@endsection