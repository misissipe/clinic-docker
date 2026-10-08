@extends('layouts.contentLayoutMaster')
@section('title', 'Assessment Record')

@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  .assessment-table{border:1px solid rgb(195,195,195);border-collapse:collapse;padding:3px;width:100%}
  .assessment-table thead{background-color:rgb(110,155,222)}
  .assessment-table thead th{color:#fff;text-align:center;text-transform:uppercase}
  .assessment-table td{vertical-align:middle}
  #loading{display:none;text-align:center;padding:18px}
  #loading img{width:50px;height:50px}
</style>
@endsection

@section('content')
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="table-responsive w-100">
            <form action="{{ route('assessment.records.search') }}" method="post" id="assessmentSearchForm">
              @csrf
              <div class="d-flex justify-content-end">
                <div class="input-group mb-1" style="width:fit-content">
                  <input type="text" class="form-control col-sm-10" placeholder="Search" id="searchInput" name="search" autocomplete="off" required>
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="submit" aria-label="Search student">
                      <i class="fa fa-search"></i>
                    </button>
                  </div>
                </div>
              </div>
            </form>

            <div class="table-responsive">
              <table class="table assessment-table table-sm table-bordered table-striped" id="assessmentStudentsTable">
                <thead>
                  <tr>
                    <th>Student ID</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
              <div id="loading">
                <img src="{{ asset('images/logo/loading.gif') }}" alt="Loading">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('vendor-scripts')
<script src="{{ asset('vendors/js/tables/datatable/datatables.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
@endsection

@section('page-scripts')
<script>
$(function () {
  var table = $('#assessmentStudentsTable').DataTable({
    order: [[1, 'asc']],
    lengthMenu: [10, 25, 50, 100],
    language: {
      emptyTable: '',
      zeroRecords: 'No student assessment records found.'
    },
    columnDefs: [{ targets: 4, orderable: false, searchable: false }]
  });

  $('#assessmentSearchForm').on('submit', function (event) {
    event.preventDefault();
    $('#loading').show();

    $.ajax({
      type: 'POST',
      url: $(this).attr('action'),
      data: $(this).serialize(),
      success: function (students) {
        table.clear();

        students.forEach(function (student) {
          table.row.add([
            $('<div>').text(student.patientId).html(),
            $('<div>').text(student.student_last_name || '').html(),
            $('<div>').text(student.student_first_name || '').html(),
            $('<div>').text(student.student_middle_name || '').html(),
            '<div class="text-center"><a class="btn btn-primary btn-sm" href="' + encodeURI(student.record_url) + '"><i class="fa fa-eye mr-25"></i> View Record</a></div>'
          ]);
        });

        table.draw();
      },
      error: function () {
        table.clear().draw();
      },
      complete: function () {
        $('#loading').hide();
      }
    });
  });
});
</script>
@endsection
