@extends('layouts.contentLayoutMaster')
@php
use App\Http\Controllers\AESCipher;
@endphp  
@section('title','Student Insurance List')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<style>
  table,td,tr{
  border: 1px solid rgb(226, 222, 222);
  border-collapse: collapse;
  padding: 1px;
  }
  input {
  outline: 0;
  border-width: 0 0 0px;
  border-color: rgb(58, 57, 57)
  }
</style>
<style>
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
  ul
  {  
      cursor:pointer;  
  }  
  li:hover {
  background-color: rgba(220, 225, 229, 0.953);
 }
 .cell-border{
    border-color: rgb(138, 138, 138);
  }
  .border{
    border-color: rgb(0, 0, 0);
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
{{-- page-styles --}}
@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card active">
        <div class="card-content">
          <div class="card-body">
            <label style="font-size:18px">STUDENT LIST</label>
            <hr>
              <div class="table-responsive view-all">
                <div class="btnprint">
                  <form action="/generate-validated-form" method="get" target="_blank" class="float-right">
                    <button type="submit" class="btn btn-primary" id="submitToGenerate" style="font-size: 15px; color: rgb(255, 255, 255);">
                        Print
                    </button>
                </form>
                </div>
                <form action="/"  method="post" id="saveTab">
                  @csrf  
                  <div style="display:flex; justify-content:space-between;">
                    <div class="row col-md-9" style="font-size:17px;font-weight:400;color:rgb(58, 57, 57);width: fit-content;">
                      <label for="course" style="font-size:12px; font-weight:400; color:rgb(58, 57, 57);">Course:</label>
                      <select id="course" class="form-control" name="course" style="width:15%; margin-right:10px" aria-label="Default select example">
                        <option disabled selected>-Select-</option>
                        @foreach($courses as $course)
                            <option value="{{ (new AESCipher)->encrypt($course) }}">{{ $course }}</option>
                        @endforeach
                      </select>
                      <label for="year" style="font-size:12px; font-weight:400; color:rgb(58, 57, 57);">Year:</label>
                      <select id="year" name="year" class="form-control" aria-label="Default select example" style="width:15%;margin-right:10px" required>
                      <option disabled selected>-Select-</option>
                      @foreach($year as $y)
                          <option value="{{  (new AESCipher)->encrypt($y) }}">{{ $y }}</option>
                      @endforeach
                      </select>
                      <div class="input-group-append">
                          <button class="btn btn-primary submitBtn" type="submit"><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                </div>
                </form>
                <br>  
                <table class="table table-sm recordTable  cell-border " id="preView">
                  <input type="hidden"name="firstname" id="roleSelect" value="Employee">
                    <thead>
                        <tr>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">Student Number</th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">Course & year</th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">LastName</th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">FirstName</th>
                          <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">MiddleName</th>
                        </tr>
                    </thead>
                </table>
                <div id="loading" style="display: none;">
                  <img src="{{ asset('images/logo/loading.gif') }}" alt="Loading Animation" style="width: 7%; height: auto;">
                </div>
              </div>
            </div>

          @include('modal.payment')

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
  var patientId = 0;

//Search-Input
var table = $('#preView').DataTable({
    "order": [2, 'asc']
});

$(document).ready(function() {
    $(document).on('submit', '#saveTab', function(event) {
        event.preventDefault();
        var course = $('#course').val();
        var year = $('#year').val();
        // var role =  $('#roleSelect').val();
        $('#loading').show();
        
        $.ajax({
          url: '/validated-student', 
          type: 'POST',
          data: {
              course: course,
              year: year,
          },
          success: function(data) {
            $('#loading').hide();
            table.clear();
            if (data.length > 0) {
              $.each(data, function(index, record) {
              
                function capitalize(str) {
                    return str.toLowerCase().replace(/\b\w/g, char => char.toUpperCase());
                }

                var Lastname = capitalize(record.LastName.replace(/ï¿½\?Â±|Ã±/g, 'ñ'));
                var Firstname = capitalize(record.FirstName.replace(/ï¿½\?Â±|Ã±/g, 'ñ'));
                var Middlename = record.MiddleName ? ' ' + capitalize(record.MiddleName.replace(/ï¿½\?Â±|Ã±/g, 'ñ')) : '';
                var courseyear = record.accro + '-' + record.StudentYear;

                table.row.add([
                  '<div class="text-center">' + record.StudentNo + '</div>',
                  '<div>' + courseyear + '</div>',
                  '<div>' + Lastname + '</div>',
                  '<div>' + Firstname + '</div>',
                  '<div>' + Middlename + '</div>'
                ]).draw();
              });
            }

            table.draw();
            table.$('tr').addClass('tr');
          }
        });
    });
});

$(document).ready(function() {
    $('#submitToGenerate').click(function(event) {
        event.preventDefault(); 
        var course =  $('#course').val();
        var year = $('#year').val();
      
        window.location.href = `/generate-validated-list?course=${ encodeURIComponent(course)}&year=${ encodeURIComponent(year)}`;
    });
});
  
</script>
@endsection