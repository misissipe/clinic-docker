@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Student')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
 table, th,td{
   border: 1px solid rgb(0, 0, 0);
   border-collapse: collapse;
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
</style>
@endsection
{{-- page-styles --}}
@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        {{-- <div class="card-header" style="font-weight: bold; color: white; background-color: rgb(110, 155, 222); height: 50px; display: flex; align-items: center;">RECORDS</div> --}}
          <div class ="card-body">
            <form  action="/search-student" method="post" id="submitBtn">
              <div style="display:flex; justify-content:space-between;">
                <div class="row col-9" style="font-size:17px;font-weight:400;color:rgb(58, 57, 57);">
                  <select id="roleSelect" class="form-control" aria-label="Default select example" style="width:20%" hidden>
                      <option value="" selected disabled>-Select Patient-</option>
                      <option value="Student">Student</option>
                      <option value="Employee">Employee</option>
                  </select>
                </div>              
                <div class="input-group mb-1" style="width: fit-content;">
                  <input class="form-control @error('searchInput') is-invalid @enderror" required autocomplete="off" type="text" placeholder="Search" id="searchInput">
                  <div class="input-group-append">
                    <button class="btn btn-primary submitBtn" type="submit"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>  
            </form>
            <div class="table-ressaveCertaddCertponsive" >
              <table class="table studentsTable table-sm table-bordered table-striped" id="myTable" style="width:100%">
                <thead>
                  <tr>
                      <th style="color:white;text-align:center">ID</th>
                      <th style="color:white;text-align:center">Last Name</th>
                      <th style="color:white;text-align:center">First Name</th>
                      <th style="color:white;text-align:center">Middle Name</th>
                      <th style="color:white;text-align:center">Action</th>
                  </tr>
              </thead>
              </table>
            </div>
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
//Search-Input
$(document).ready(function() {
    
  $('#submitBtn').submit(function (e) {
    e.preventDefault();

    $('#loading').show();

    var formData = {
      search: $('#searchInput').val(),
    };

    $.ajax({
      type: 'POST',
      url: '/search-student',
      data: formData,
        success: function (data) {
          $('#loading').hide();
          updateTable(data);
        },
        error: function (error) {
          console.log('Error:', error);

          $('#loading').hide();
        }
      });
    });
    
    function updateTable(data) {
      $('#myTable').DataTable().destroy();
      var table = $('#myTable').DataTable({
        "order": [[1, "asc"]],
      });
      table.clear();

      data.forEach(function(student) {
        let lastName = student.LastName ? student.LastName.replace(/ï¿½\?Â±|Ã±/g, 'ñ') : '';
        let firstName = student.FirstName ? student.FirstName.replace(/ï¿½\?Â±|Ã±/g, 'ñ') : '';
        let middleName = student.MiddleName ? student.MiddleName.replace(/ï¿½\?Â±|Ã±/g, 'ñ') : '';
      table.row.add([
        `<td style="text-align:center">${student.StudentNo}</td>`,
        `<td>${lastName}</td>`, 
        `<td>${firstName}</td>`,
        `<td>${middleName}</td>`,
        `<td style="text-align:center">
            <a class="dropdown-item history" href="#" id="" data-id="${student.encryptedStudentNo}"><i class="fa fa-folder"></i></a>
        </td>`
      ]).draw(false);
    });

    table.column(0).nodes().to$().css('text-align', 'center');
    table.column(4).nodes().to$().css('text-align', 'center');

    }
  });

  $(document).on('click', '.history', function(){
      var id = $(this).data('id');
      window.location.href = "/information-student?id=" + encodeURIComponent(id);
  })

</script>
@endsection