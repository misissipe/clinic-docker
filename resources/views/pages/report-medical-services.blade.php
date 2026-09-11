@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Report Medical Services')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
{{-- page-styles --}}

@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row justify-content-center">
    <div class="col-md-7">
      <div class="card">
        <div class="card-body ">
          <div class="" style="font-weight: 600; font-size: 20px; text-align: center;">
            <h4>GENERATE MONTHLY REPORT</h4>
            <br>
            <div class="form-group row d-flex justify-content-center align-items-center">
              <label for="year" class="col-form-label">Year:</label>
              <div class="col-md-2">
                <select id="year" name="year" class="form-control">
                  <option value="disable selected">-Select-</option>
                  <?php $currentYear = date('Y'); ?>
                  <?php for ($year = 2018; $year <= $currentYear; $year++) { ?>
                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                  <?php } ?>
                </select>
              </div>
              <label for="month" class="col-form-label">Month:</label>
              <div class="col-md-2">
                <select name="month" id="month" class="form-control">
                  <option value="disable selected">-Select-</option>
                  <option value="01">January</option>
                  <option value="02">February</option>
                  <option value="03">March</option>
                  <option value="04">April</option>
                  <option value="05">May</option>
                  <option value="06">June</option>
                  <option value="07">July</option>
                  <option value="08">August</option>
                  <option value="09">September</option>
                  <option value="10">October</option>
                  <option value="11">November</option>
                  <option value="12">December</option>
                </select>
              </div> 
              <button type="button" id="submitBtn" class="btn btn-primary submitBtn">Generate</button>
            </div>
          </div>
          @if (session('error'))
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
          <script>
              Swal.fire({
              icon: 'error',
              title: 'NO RECORD FOUND'
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
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script>
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});

$(document).on('click', '.submitBtn', function(){
  var year = $('#year').val();
  var month = $('#month').val();

  window.location.href = "/report-records?Month=" + month + "&year=" + year;
});

</script>
@endsection