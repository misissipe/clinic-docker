@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Inventory')
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
      <div class="card active">
        <div class="card-content">
          <div class="card-body">
            <label style="font-size:18px">Records of Visits for the Month of</label>
            <br><br>
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" aria-controls="home" role="tab" aria-selected="true">
                  <i class="bx bx-calendar-event align-middle"></i>
                  <span class="align-middle">{{$monthName}}</span>
                  <span class="badge badge-danger"></span>
                  {{-- <span class="red-box" id="student-status"></span>  --}}
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile" role="tab" aria-selected="false">
                  <i class="bx bxs-file align-middle"></i>
                  <span class="align-middle">All Records</span>
                  <span class="badge badge-danger" ></span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="print-tab" data-toggle="tab" href="#printMe" aria-controls="print" role="tab" aria-selected="false" style="display : none" >
                <span class="align-middle">print</span>
                </a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="home" aria-labelledby="home-tab" role="tabpanel">
                <div class="table-responsive view-all active" id="todayDisapprove">
                  <table class="table table-sm recordTable table-bordered table-striped zero-configuration" id="recordTable" style="text-align:center;">
                    <thead>
                      <tr>
                        <th style="color:white;">Date</th>
                        <th style="color:white;">Medicine Name</th>
                        <th style="color:white;">Additional</th>
                        <th style="color:white;">Stock</th> 
                        <th style="color:white;">Dispensed</th>
                        <th style="color:white;">Balance</th>
                      </tr>
                    </thead>
                    <tbody id="viewAllRecord">
                    @foreach($view as $data)  
                      <tr>    
                        <td style="text-align:center;">{{  date('m-d-Y', strtotime($data->date))}}</td>
                        <td style="text-transform:capitalize;text-align:left;">{{ucwords(strtolower($data->item_name))}}  </td>
                        <td  style="text-align:right;">{{$data->added_stock}}</td>
                        <td style="text-align:right;">{{$data->item_stock}}</td>
                        <td  style="text-align:right;">{{$data->stock_less}}</td>
                        <td  style="text-align:right;">{{$data->remaining_stock}}</td>
                      </tr>
                    @endforeach 
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane" id="profile" aria-labelledby="profile-tab" role="tabpanel">
                <div class="table-responsive view-all">
                  <div class="btnprint">
                    <form action="/" method="get" target="_blank" class="float-right">
                      <button type="submit" class="btn btn-primary" id="submitToGenerate" style="font-size: 15px; color: rgb(255, 255, 255);">
                          Print
                      </button>
                  </form>
                  </div>
                  <form action="/inventory-records" method="post" id="submitBtn">
                    @csrf
                    <div style="display:flex; justify-content:space-between;">
                        <div class="row col-md-9" style="font-size:17px;font-weight:400;color:rgb(58, 57, 57);width: fit-content;">
                            <select id="monthSearch" name="monthSearch" class="form-control" aria-label="Default select example" style="width:10%;margin-right:10px" required>
                                <option value="" disabled selected>-Select-</option>
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
                            <select name="year" class="form-control " style="width:10%;margin-right:10px" id="year">
                              <option  value="" selected disabled> Select</option>
                             <?php $currentYear = date('Y'); ?>
                              @for($year = 2024; $year <= $currentYear; $year++)
                             <option value="{{ $year }}">{{ $year }}</option>
                             @endfor
                           </select>
                            <select id="medicineSearch" name="medicine" class="form-control" aria-label="Medicine" style="width:220px;margin-right:10px">
                              <option value="">All medicines</option>
                              @foreach($medicines as $medicine)
                                <option value="{{ $medicine }}">{{ $medicine }}</option>
                              @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary submitBtn" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </form><br>
                 <table class="table table-sm recordTable table-bordered table-striped " id="preView" style="text-align:center;">
                {{-- <table class="table table-sm recordTable  cell-border " id="preView"> --}}
                  <input type="hidden"name="firstname" id="roleSelect" value="Employee">
                  <thead>
                    <tr>
                      <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">Date</th>
                      <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">Medicine Name</th>
                      <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">Add</th>
                      <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">Stock</th>
                      <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">Dispensed</th>
                      <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);">Remaining</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>  
          </div>
        </div>
       </div>
      </div>
    </div> 
  </div>
  <div class="row justify-content-center">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h3><strong>MEDICINE STOCK</strong></h3>
          <div class="table-responsive">
            <table class="table table-sm stockTable table-bordered table-striped" id="stockTable" style="text-align:center;">
              <thead>
                <tr>
                  <th style="color:white;">Medicine Name</th>
                  <th style="color:white;">Quantity</th>
                  <th style="color:white;">Stock</th>
                  <th style="color:white;">Measurement</th> 
                  <th style="color:white;">Expiration Date</th> 
                </tr>
              </thead>
              <tbody id="viewAllRecord">
              @foreach($stock as $data)  
                <tr>    
                  <td style="text-transform:capitalize;text-align:left;">{{ucwords(strtolower($data->item_name))}}  </td>
                  <td style="text-align:right;">{{$data->total_stock}}</td>
                  <td style="text-align:right;">{{$data->item_quantity}}</td>
                  <td style="text-transform:capitalize;text-align:left;">{{ucwords(strtoLower($data->measurement))}}</td>
                  <td style="text-align:center;">{{ date('m-d-Y', strtotime($data->expiration_date))}}</td>
                </tr>
              @endforeach 
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('modal.addProduct')
  @include('modal.editProduct')
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


$('#stockTable').DataTable().destroy();
  var table = $('#stockTable').DataTable({
      "order": [[0, "asc"]],
});

  
$("#addProductModal").submit(function(e) {
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
          $('#addProduct').modal('hide')
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
  })
});

$(document).ready(function() {
  $(document).on('click', '.editModal', function() {
    var id = $(this).data('id');
    console.log(id);
    $('#editProduct').modal('show');

    $.ajax({
      url: '/editProduct',
      type: 'POST',
      data: { 
          id: id
      },
      success: function(response) {
          console.log(response);
          $('#editProduct').modal('show');
          console.log(response.id);

          // var today = new Date();
          // var formattedDate = today.getFullYear() + '-' + (today.getMonth() + 1).toString().padStart(2, '0') + '-' + today.getDate().toString().padStart(2, '0');
          $('.id').val(id);
          $('.genericname').val(response.generic_name); 
      } 
    });
  });
});


$(document).ready(function() {
  $('#editProductModal').submit(function(e) {
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
              $('#editTreatmentRecord').modal('hide')
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
        else if (response.Error == 1){
          Swal.fire({
            icon: "error",
            title: response.Message,
          })
        }
      },
      error: function(error) {
          console.error(error);
      }
    });
  });
});

//Search-Input
var table = $('#preView').DataTable({
        "order": [[0, "desc"]],
    });
    $(document).ready(function() {
    $('#medicineSearch').on('change', function () {
        if ($('#monthSearch').val() && $('#year').val()) {
            $('#submitBtn').trigger('submit');
        }
    });

    $(document).on('submit', '#submitBtn', function(event) {
        event.preventDefault();

        var monthSearch = $('#monthSearch').val();
        var year = $('#year').val();
        var medicine = $('#medicineSearch').val();
       
        $.ajax({
            url: '/inventory-records', 
            type: 'POST',
            data: {
                'monthSearch': monthSearch,
                'year': year,
                'medicine': medicine,
            },
            success: function(data) {
                table.clear();

                if (data.length > 0) {
                $.each(data, function(index, record) {
                    
                    var jsonString = record.remarks;
  
                    table.row.add([
                        '<div class="text-center">' + record.date + '</div>',
                        '<div style="text-align:left">' + record.item_name + '</div>',
                        '<div class="text-center">' + record.added_stock + '</div>',
                        '<div class="text-center">' + record.item_stock + '</div>',
                        '<div class="text-center">' + record.stock_less + '</div>',
                        '<div class="text-center">' + record.remaining_stock + '</div>',
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

    var monthSearch = $('#monthSearch').val();
    var year = $('#year').val();
    var medicine = $('#medicineSearch').val();
  
    window.location.href = `/inventory-report-form?monthSearch=${encodeURIComponent(monthSearch)}&year=${encodeURIComponent(year)}&medicine=${encodeURIComponent(medicine)}`;
  });
});

</script>
@endsection
