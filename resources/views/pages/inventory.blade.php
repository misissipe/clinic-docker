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
      <div class="card">
        <div class="card-body">
        <h3><strong>MEDICINE INVENTORY</strong></h3>
        <h4>({{$monthName }})</h4>
          <div class="table-responsive">
            <table class="table table-sm recordTable table-bordered table-striped zero-configuration" id="recordTable" style="text-align:center;">
              <thead>
                <tr>
                  <th style="color:white;">Date</th>
                  <th style="color:white;">Medicine Name</th>
                  <th style="color:white;">Add</th>
                  <th style="color:white;">Stock</th> 
                  <th style="color:white;">Less</th>
                  <th style="color:white;">Remaining</th>
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
          <div>
          </div>
        </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <h3><strong>MEDICINE STOCK</strong></h3>
          <div class="table-responsive">
            <table class="table table-sm recordTable table-bordered table-striped zero-configuration" id="recordTable" style="text-align:center;">
              <thead>
                <tr>
                  <th style="color:white;">Medicine Name</th>
                  <th style="color:white;">Quantity</th>
                  <th style="color:white;">Stock</th>
                  <th style="color:white;">Measurement</th> 
                </tr>
              </thead>
              <tbody id="viewAllRecord">
              @foreach($stock as $data)  
                <tr>    
                  <td style="text-transform:capitalize;text-align:left;">{{ucwords(strtolower($data->item_name))}}  </td>
                  <td  style="text-align:right;">{{$data->total_stock}}</td>
                  <td  style="text-align:right;">{{$data->item_quantity}}</td>
                  <td style="text-transform:capitalize;text-align:left;">{{ucwords(strtoLower($data->measurement))}}</td>
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
</script>
@endsection
