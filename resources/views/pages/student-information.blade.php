@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Student')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
   table, td {
  border: 1px solid rgb(195, 195, 195);
  border-collapse: collapse;
  padding: 3px;
  }
  thead{
    background-color: rgb(110, 155, 222);
  }
  .alert {
  padding: 20px;
  background-color: #ff7f76;
  color: white;
 }
 #loading {
      display: none;
      text-align: center;
    }

    #loading img {
      width: 50px;
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
                  <?php
                    $currentYear  = date('Y');
                    $currentMonth = date('n');            
                    if ($currentMonth >= 6 && $currentMonth <= 7) {
                        
                        $semester = 'Summer';
                        $syStart = $currentYear - 1;
                    } elseif ($currentMonth >= 8 && $currentMonth <= 12) {
                      
                        $semester = '1st Semester';
                        $syStart = $currentYear;
                    } else {
                        
                        $semester = '2nd Semester';
                        $syStart = $currentYear - 1;
                    }
                  ?>
                  <select id="semester" value="semester" class="form-control" aria-label="Default select example" style="width:15%">
                     <option value="1" <?= ($semester == '1st Semester') ? 'selected' : ''; ?>>
                        1st Semester
                    </option>
                    <option value="2" <?= ($semester == '2nd Semester') ? 'selected' : ''; ?>>
                        2nd Semester
                    </option>
                    <option value="9" <?= ($semester == 'Summer') ? 'selected' : ''; ?>>
                        Summer
                    </option>
                  </select>
                  <select id="sy" name="sy" class="form-control" aria-label="Default select example" style="width:15%;margin-left:2%">
                    <option value="" selected>-Select School Year-</option>
                    <?php
                    for ($year = $syStart - 3; $year <= $syStart + 3; $year++) {
                        $nextYear = $year + 1;
                        $selected = ($year == $syStart) ? 'selected' : '';
                        echo "<option value='$year' $selected>$year-$nextYear</option>";
                    }
                    ?>
                  </select>
                </div>
                <div class="input-group mb-1" style="width: fit-content;">
                  <input type="text" class="form-control col-sm-10" placeholder="Search" id="searchInput" autocomplete="off">
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
                    <th style="color:white;text-align:center;width:10%">ID</th>
                    <th style="color:white;text-align:center">Course & Year</th>
                     {{-- <th style="color:white;text-align:center">Status</th> --}}
                    <th style="color:white;text-align:center">Last Name</th>
                    <th style="color:white;text-align:center">First Name</th>
                    <th style="color:white;text-align:center">Middle Name</th>
                    <th style="color:white;text-align:center">Action</th>
                  </tr>
                </thead>
              </table>
              <div id="loading" style="display: none;">
                <img src="{{ asset('images/logo/loading.gif') }}" alt="Loading Animation" style="width: 7%; height: auto;">
              </div>
             
          </div>
        </div>
      </div>
    </div>
  </div>
   @include('modal.viewPatientRecord')   
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
  {{-- <script src="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css"></script> --}}
<script>
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});

$(document).ready(function() {
  $('#submitBtn').submit(function (e) {
    e.preventDefault();

    $('#loading').show();

    var formData = {
      search: $('#searchInput').val(),
      semester: $('#semester').val(),
      yr: $('#sy').val(),
    };

    $.ajax({
        type: 'POST',
        url: '/student-information',
        data: formData,
        success: function (data) {
          $('#loading').hide();
          if (!data || data.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Student not enrolled',
                text: 'No student matches your search criteria.',
                confirmButtonText: 'OK'
            });

            table.clear().draw();
            return;
          }
          updateTable(data);
        },
        error: function () {
          $('#loading').hide();

          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Something went wrong. Please try again.'
          });
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
        `<td ">${student.StudentNo}</td>`,
        `<td ">${student.accro} - ${student.StudentYear}</td>`,
        `<td>${lastName}</td>`, 
        `<td>${firstName}</td>`,
        `<td>${middleName}</td>`,
        `<td ">
            <a class="dropdown-item history" href="#" id="" data-id="${student.encryptedStudentNo}"><i class="fa fa-medkit" style="text-align:center"></i></a>
        </td>`
      ]).draw(false);
    });

    table.column(0).nodes().to$().css('text-align', 'center');
    table.column(1).nodes().to$().css('text-align', 'center');
    table.column(5).nodes().to$().css('text-align', 'center');

    }
  });

 $(document).on('click', '.history', function(){
  var id = $(this).data('id');
  var yr = $('#sy').val();
  var sem = $('#semester').val();

  window.location.href = "/medical-and-social-health-history?id=" + encodeURIComponent(id) + "&yr=" + encodeURIComponent(yr)+ "&sem=" + encodeURIComponent(sem);
})
</script>
@endsection