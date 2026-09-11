@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Lab Results')

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
  #loading {
      display: none;
      text-align: center;
    }

    #loading img {
      width: 50px; /* Adjust the size as needed */
      height: 50px;
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
        {{-- <div class="card-header" style="font-weight: bold;color:white;background-color: rgb(110, 155, 222);height:50px">PATIENT RECORDS</div> --}}
          <div class ="card-body">
            <form  action="/add-patient" method="post" id="submitBtn">
              <div style="display:flex; justify-content:space-between;">
                <div class="row col-9" style="font-size:17px;font-weight:400;color:rgb(58, 57, 57);">
                  <select id="roleSelect" class="form-control" aria-label="Default select example" style="width:20%" required>
                      <option selected>-Select Patient-</option>
                      <option value="Student">Student</option>
                      <option value="Employee">Employee</option>
                  </select>
                </div>
                <div class="input-group mb-1" style="width: fit-content;">
                    <input type="text" class="form-control col-sm-10" placeholder="Search" id="searchInput" autocomplete="off" required>
                  <div class="input-group-append">
                    <button class="btn btn-primary submitBtn" type="submit"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>  
            </form>
            <div class="table-responsive">
              <table class="table studentsTable table-sm table-bordered table-striped " id="myTable" style="width:100%">
                <thead>
                  <tr>
                    <th style="color:white;text-align:center">Student ID</th>
                    <th style="color:white;text-align:center">Last Name</th>
                    <th style="color:white;text-align:center">First Name</th>
                    <th style="color:white;text-align:center">Middle Name</th>
                    <th style="color:white;text-align:center">Action</th>
              </thead>
            </table>
            <div id="loading" style="display: none;">
              <img src="{{ asset('images/logo/loading.gif') }}" alt="Loading Animation" style="width: 7%; height: auto;">
            </div>
            @include('modal.viewPatientRecord')   
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
//Search-InputF

// $(document).ready(function() {
//   $("#submitBtn").submit(function(event) {
//     event.preventDefault();
//     var search = $('#searchInput').val();

//     if (search.trim() === '') {
//             Swal.fire({
//                 icon: 'error',
//                 title: 'Please enter a search keyword',
//             });
//             return;
//         }
//          $.ajax({
//             type:'post',
//             url:'/lab-results',
//             data:{search:search},

//             success:function(data){
//               $('#myTable').html(data);   
//             } 
//          })
//        })
//  });



$(document).ready(function() {
    $('#submitBtn').submit(function(e) {
        e.preventDefault();

        $('#loading').show();

        var formData = {
            role: $('#roleSelect').val(),
            search: $('#searchInput').val(),
        };

        $.ajax({
            type: 'POST',
            url: '/lab-results',
            data: formData,
            success: function(data) {
                updateTable(data, formData.role); 
                $('#loading').hide();
            },
            error: function(error) {
                console.log('Error:', error);
            }
        });
    });

    function updateTable(data, role) {
    $('#myTable').DataTable().destroy();
    var table = $('#myTable').DataTable({
        "order": [[1, "asc"]],
        // "paging": false,
        // "searching": false
    });
    table.clear();

    if (data && data.data) {
    if (role === 'Student') {
        data.data.forEach(function(student) {
          let lastName = student.LastName ? student.LastName.replace(/Ã±/g, 'ñ') : '';
          let firstName = student.FirstName ? student.FirstName.replace(/Ã±/g, 'ñ') : '';
          let middleName = student.MiddleName ? student.MiddleName.replace(/Ã±/g, 'ñ') : '';
            table.row.add([
                `<td style="text-align:center">${student.StudentNo}</td>`,
                `<td>${lastName}</td>`,
                `<td>${firstName}</td>`,
                `<td>${middleName}</td>`,
                `<td style="text-align:center">
              <a class="dropdown-item results" href="#" id="" data-id="${student.encryptedStudentNo}"><i class="fa fa-folder"></i></a>
          </td>`
            ]).draw(false);
        });
    } else if (role === 'Employee') {
      data.data.forEach(function(employee) {
        let lastName = employee.LastName ? employee.LastName.replace(/Ã±/g, 'ñ') : '';
        let firstName = employee.FirstName ? employee.FirstName.replace(/Ã±/g, 'ñ') : '';
        let middleName = employee.MiddleName ? employee.MiddleName.replace(/Ã±/g, 'ñ') : '';
          table.row.add([
              `<td style="text-align:center">${employee.AgencyNumber}</td>`,
              `<td>${lastName}</td>`,
              `<td>${firstName}</td>`,
              `<td>${middleName}</td>`,
              `<td style="text-align:center">
            <a class="dropdown-item results" href="#" id="" data-id="${employee.encryptedEmployeeNo}"><i class="fa fa-folder"></i></a>
        </td>`

          ]).draw(false);  
      })    
    }
  }

      table.column(0).nodes().to$().css('text-align', 'center');
      table.column(4).nodes().to$().css('text-align', 'center');
  }
});



 $(document).on('click', '.results', function(){
  var id = $(this).data('id'); 
  var role = $('#roleSelect').val();
    console.log(role);
    console.log(id);

  if (role === 'Student') {
    window.location.href = "/lab-test-result-records?id=" + encodeURIComponent(id)  + "&role=Student";
  } else if (role === 'Employee') {
    window.location.href ="/lab-test-result-records?id=" + encodeURIComponent(id)  + "&role=Employee";
  }
 });
</script>
@endsection