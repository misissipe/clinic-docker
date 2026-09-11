@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Add items')

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
  #results {
    position: absolute;
    z-index: 1;
    background-color: white;
    border: 1px solid #ccc;
    margin-top: 5px;
    width: 100%; 
}
#results1 {
    position: absolute;
    z-index: 1;
    background-color: white;
    border: 1px solid #ccc;
    margin-top: 5px;
    width: 100%; 
}
#itemname {
}
.result-item:hover {
    background-color: #dee2e6;
    color: white;
    cursor: pointer;
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
        {{-- <div class="card-header" style="font-weight: bold;color:white;background-color: rgb(110, 155, 222);">VIEW RECORDS</div> --}}
        <div class="card-body">
          <form action="/addStock"  method="post" id="addStockTab">
            @csrf  
              <div class="form-group row d-flex">
                <div class="col-lg-2">
                  <label for="recipient-name" class="col-form-label">Batch/Lot No.:</label>
                  <span class="text-warning">*</span>
                  <input type="text" class="form-control" id="batchNo" name="batchNo" autocomplete="off">
                  </div>   
                  <div class="col-lg-4">
                      <label for="recipient-name" class="col-form-label">Medicine Name:</label>
                      <span class="text-warning">*</span>
                      <input type="text" class="form-control" id="itemname" name="itemname" autocomplete="off">
                      <ul id="results" class="list-group" style="display: none;font-size:12px;font-weight:400;" ></ul>
                  </div>
                  <div class="col-lg-2">
                      <label for="recipient-name" class="col-form-label">Quantity:</label>
                      <span class="text-warning">*</span>
                      <input type="number" class="form-control" id="quantity" name="quantity" autocomplete="off">
                  </div>     
                  <div class="col-lg-2">
                    <label for="recipient-name" class="col-form-label">Unit of Measure:</label>
                    <span class="text-warning">*</span>
                    <input type="text" class="form-control" id="measure" name="measure" autocomplete="off">
                    <ul id="results1" class="list-group" style="display: none;font-size:12px;font-weight:400;"></ul>
                </div>    
                <div class="col-lg-2">
                    <label for="recipient-name" class="col-form-label">Expiration Date</label>
                    <span class="text-warning">*</span>
                    <input type="date" class="form-control" id="expirationdate" name="expirationdate">
                </div>                               
              </div>
            <div id="spinner-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.2); z-index: 9999;">
              <div class="d-flex justify-content-center align-items-center h-100">
                  <div class="spinner-border spinner-border-lg text-primary" role="status">
                      <span class="sr-only">Loading...</span>
                  </div>
              </div>
            </div>
            <br>
            <div class="form-group">
              <button type="button" id="cancelBtn" class="btn btn-default btn-custom float-right">Cancel</button>
              <button type="submit" id="saveBtn" class="btn btn-primary btn-custom float-right">Save</button>
            </div>
          </form>
        </div>
      </div>
      <div class="card">
        {{-- <div class="card-header" style="font-weight: bold;color:white;background-color: rgb(110, 155, 222);">VIEW RECORDS</div> --}}
        <div class="card-body">
          <h3><strong>ITEMS</strong></h3>
          <table class="table table-sm recordTable table-bordered table-striped " id="recordTable" style="text-align:center;">
            <thead>
                <tr>
                  <th style="color:white;text-align:center">Action</th>
                  {{-- <th style="color:white;text-align:center">Date</th> --}}
                  <th style="color:white;text-align:center">Batch/Lot No.</th>
                  <th style="color:white;text-align:center">Name</th>
                  <th style="color:white;text-align:center">Measurement</th>
                  <th style="color:white;text-align:center">Quantity</th>
                  <th style="color:white;text-align:center">Expiration Date</th>
                </tr>
              </thead>
              <tbody id="viewAllRecord">
                @foreach ($data as $datas)
                  <tr>
                    <td style="text-align:center">
                      <div class="dropdown">
                        <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item viewbutton" href="#" data-role="Student" data-id="{{ $datas->id }}"><i class="bx bx-edit mr-1"></i>edit</a> 
                            <a class="dropdown-item deleteButton" href="#" data-role="Student" data-id="{{ $datas->id }}"><i class="bx bx-trash mr-1"></i>delete</a>                           
                        </div>
                        </div>
                    </td>
                    {{-- <td style="text-align:center">{{ date('m-d-Y', strtotime($datas->date)) }}</td> --}}
                    {{-- <td>{{ date('m-d-Y', strtotime($datas->created_at)) }}</td> --}}
                    <td>{{ $datas->lotno }}</td>
                    <td style="text-align:left;">{{ ucwords(strtolower($datas->item_name)) }}</td>
                    <td style="text-transform:capitalize;text-align:left;">{{ $datas->measurement }}</td>
                    <td style="text-align:right;">{{ $datas->item_quantity }}</td>
                    <td style="text-align:center;">{{  date('m-d-Y', strtotime($datas->expiration_date)) }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
        </div>
      </div>
         @include('modal.editStock')
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
  var patientId = 0;

  $('#recordTable').DataTable().destroy();
    var table = $('#recordTable').DataTable({
        "order": [[2, "asc"]],
  });

  $(document).ready(function(){
    $("#cancelBtn").click(function(){
      window.history.back();
  })
 });

$(document).ready(function () {
    $('#itemname').keyup(function () {
        var itemname = $(this).val();
        
        if (itemname !== '') {
            $.ajax({
                url: "{{ route('searchitem') }}",
                method: "post",
                data: { itemname: itemname },
                dataType: "json",
                success: function (data) {
                    $('#results').fadeIn();
                    $('#results').html('');

                    if (data.length === 0) {
                        $('#results').append('<li class="list-group-item">No records found</li>');
                    } else {
                      $.each(data, function (index, item) {
                      if (item.brand_name) {
                         
                          $('#results').append('<li class="list-group-item" data-id="' + item.id + '" data-generic_name="' + item.generic_name + '" data-brand_name="' + item.brand_name + '">' + item.generic_name + ' - ' + item.brand_name + '</li>');
                      } else {
                        
                          $('#results').append('<li class="list-group-item" data-id="' + item.id + '" data-generic_name="' + item.generic_name + '">' + item.generic_name + '</li>');
                      }
                      });
                    }
                }
            });
        } else {
            $('#results').fadeOut();
        }
   
    });

    $('#results').on('click', 'li', function () {
    var genericName = $(this).data('generic_name');
    var brandName = $(this).data('brand_name');

    if (brandName) {
        $('#itemname').val(genericName + ' - ' + brandName);
    } else {
        $('#itemname').val(genericName);
    }

    $('#results').fadeOut();
});

$('#results').on('mouseenter', 'li', function () {
        $(this).addClass('active'); 
    });

    $('#results').on('mouseleave', 'li', function () {
        $(this).removeClass('active');
    });

    $('#measure').keyup(function () {
        var measure = $(this).val();
        
        if (measure !== '') {
            $.ajax({
                url: "{{ route('searchUnit') }}",
                method: "post",
                data: { measure: measure },
                dataType: "json",
                success: function (data) {
                    $('#results1').fadeIn();
                    $('#results1').html('');

                    if (data.length === 0) {
                        $('#results1').append('<li class="list-group-item">No records found</li>');
                    } else {
                        $.each(data, function (index, item) {
                            $('#results1').append('<li class="list-group-item" data-id="' + item.id + '" data-unit_of_measurement="' + item.unit_of_measurement + '">' + item.unit_of_measurement + '</li>');
                        });
                    }
                }
            });
        } else {
          $('#results1').fadeOut();
        }
    });

    $('#results1').on('click', 'li', function () {
        var measure = $(this).data('unit_of_measurement');

        $('#measure').val(measure);

        $('#results1').fadeOut();
    });
    $('#results1').on('mouseenter', 'li', function () {
        $(this).addClass('active'); 
    });

    $('#results1').on('mouseleave', 'li', function () {
        $(this).removeClass('active');
    });
});
//
$("#addStockTab").submit(function(e) {
  e.preventDefault(); 

var form = $(this);
var actionUrl = form.attr('action');


$("#saveBtn").prop("disabled", true);
    $("#spinner-overlay").show();
    $(".blur").addClass("blur");

  $.ajax({
    type: "POST",
    url: actionUrl,
    data: form.serialize(), 
      success: function(response){
        $("#spinner-overlay").hide();
              $(".blur").removeClass("blur");
          if (response.success == 200) {
            Swal.fire({
            title: response.Message,
            icon: 'success',
            confirmButtonText: 'Okay',
          }).then((response) => {
              
          if (response.isConfirmed) {
            console.log(response); 
            location.reload();			
          }
        })
      } else if (response && response.Error === 1) {
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
    }
  });
})

//
$(document).on('click', '.viewbutton', function() {
    var id = $(this).data('id');

    $.ajax({
        type: 'POST',
        url: '/viewModalStock',
        data: { id: id },
        success: function(response) {
            $('#updateStock').modal('show');
 function ucwords(str) {
            return str.replace(/\b\w/g, function(char) {
                return char.toUpperCase();
            });
        }

            var modal = response.modal;
            var id = modal.id;
            var lotno = modal.lotno;
            var item_name = ucwords(modal.item_name.toLowerCase());
            var total_stock = modal.total_stock;
            var measurement = modal.measurement;
            var item_quantity = modal.item_quantity;
            var expiration_date = modal.expiration_date;
            var unit_of_measurement = response.measure;

            $('#id').val(id);
            $('#lotno').val(lotno);
            $('#itemname1').val(item_name);
            $('#quantity1').val(item_quantity);
            $('#expirationdate1').val(expiration_date);

            $('#measure1').empty();
            $('#measure1').append('<option value="" disabled selected>Select Unit of Measure</option>');

              
            $.each(unit_of_measurement, function(index, value) {
                let formattedText = ucwords(value.unit_of_measurement.toLowerCase());
                $('#measure1').append('<option value="' + value.unit_of_measurement + '">' + formattedText + '</option>');
            });

            $('#measure1').val(measurement);
        }
    });
});


//UPDATE 
$('#updateStockForm').submit(function(e) {
    e.preventDefault();

    $.ajax({
        type: 'POST',
        url: '/updateStock',
        data: $(this).serialize(),
        success: function(response) {
          console.log(response);
          if(response.status === 200) {
              Swal.fire({
                  icon: 'success',
                  title: 'Updated Successfully!',
                  text: response.success,
                  showConfirmButton: false,
                  timer: 1500
              });
              $('#updateStock').modal('hide');
              location.reload();
          }
        },
        error: function(error) {
          console.error(error);
          Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'There was an error updating the stock.',
          });
        }
    });
});


 //Delete
 $(document).ready(function() {
    $('.deleteButton').click(function() {
      var id = $(this).data('id');

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
              data: { id: id},
              url: '/deleteMed',
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
