@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Borrow Slip')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  table,td{
  border: 1px solid rgb(58, 57, 57);
  border-collapse: collapse;
  padding: 1px;
  text-align: center;  
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
  ul
  {  
      cursor:pointer;  
  }  
  li:hover {
  background-color: rgba(220, 225, 229, 0.953);
  }
</style>
@endsection
{{-- page-styles --}}
@section('content')
{{-- <div class="row">
    <div class="col-12">
        <p>Read full documnetation <a href="https://datatables.net/" target="_blank">here</a></p>
    </div>
</div> --}}
<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row mx-auto">
    <div class="col-md-5" id="show">
      <div class="card-header" style="background-color:rgb(110, 155, 222);color:#ffffff;height:55px;font-size:15px;font-weight:800;display:flex;align-items:center;">
          <i class="fa fa-user-circle-o" style="font-size:20px"></i>
        <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
          <input type="text" class="cert col-sm-8 name" name="fullname" id="name_left" value="{{ $data->FirstName }} {{ $data->MiddleName }} {{ $data->LastName }}" style="background-color: transparent; color: #ffffff; font-size: 19px; font-weight: 500; border: none; text-align: left; width: 70%;" readonly >
        <div>
          @if($data->accro && $data->StudentYear)
              <i class="fa fa-id-card-o" style="color:#ffffff; font-size:20px; margin-right:6px;"></i>
          @else
              <i class="fa fa-id-card-o" style="color:#ffffff; font-size:20px; margin-right:6px;"></i>
          @endif
          <input type="text" class="cert name" name="positioncourse" id="name_right" value="{{ ($data->accro && $data->StudentYear) ? $data->accro . '-' . $data->StudentYear : $data->DepartmentName }}" style="background-color: transparent; color: #ffffff; font-size: 19px; font-weight: 500; border: none; text-align: right; width:40%;" readonly >
        </div>
      </div>
    </div>          
      <div class="card text-left">
        <div class="card-body">
          <form action="/saveBorrow"  method="post" id="borrowForm">
            @csrf  
              <input class="form-control" type="hidden" name="patientId" id="id"  value="{{$id}}">
              <input class="form-control" type="hidden" name="status" id="Pending" value="Pending">
              <div class="d-flex justify-content-end">
                <input class="form-control col-sm-3 @error('date') is-invalid @enderror" name="borrowed_date" value="{{ old('date', \Carbon\Carbon::now()->setTimezone('Asia/Manila')->format('Y-m-d')) }}" required autocomplete="date" type="date" id="date" max="{{ \Carbon\Carbon::now()->setTimezone('Asia/Manila')->format('Y-m-d') }}" style="display: inline-block; margin-right: 5px;">
                <input class="form-control col-sm-3 @error('time') is-invalid @enderror" name="borrowed_time" type="time" id="time" value="{{ old('time', \Carbon\Carbon::now()->setTimezone('Asia/Manila')->format('H:i')) }}" style="display: inline-block;">
              </div>
              <label for="purpose" style="display: inline-block;">Contact Number: </label><br>
              <div style="font-weight: 400; font-size: 20px;">
                  <input type="text" id="contactNo" style="display: inline-block;" class="form-control col-sm-5 @error('contactNo') is-invalid @enderror" name="contact" value="{{$data->ContactNo ?? $data->Cellphone}}" required autocomplete="contactNo" />
              </div>
              <br>
              
              <div class="form-outline" id="medicineOTC">
              <button class="btn btn-success" id="addNewinput" type="button">Add</button><br>
              <label class="form-label" style="display: inline-block;" for="textAreaExample">ITEM/S BORROWED::<span class="text-danger">*</span></label>
              <div id="inputs-container">
                <div class="input-group">
                  <input type="text" class="form-control col-sm-12 itemDescription" style="display: inline-block;" name="item[]" aria-describedby="" placeholder="description" autocomplete="off">
                  <ul class="list-group results" style="display: none;font-size:12px;font-weight:400;"></ul>
                  <br><br>
                </div>
              </div>  
            </div>
            <div class="card-footer form-group">
              <button type="button" id="cancelBtn" class="btn btn-default btn-custom float-right">Cancel</button>
              <button type="submit" class="btn btn-primary btn-custom float-right">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <div class="card text-left">
        <div class="card-body" style="font-size:12px">
          <label for="purpose" style="display: inline-block;font-size:20px;font-weight:700">BORROWED ITEMS</label>
          <div class=" view-all">
            <table class="table table-sm recordTable table-bordered table-striped zero-configuration" id="recordTable">
              <thead> 
                <tr>
                  <th style="color:white;">Action</th>
                  <th style="color:white;text-align:center"> Borrowed Date - Time</th> 
                  <th style="color:white;text-align:center"> Item Borrowed</th>
                  <th style="color:white;text-align:center"> Returned Date - Time</th> 
                  <th style="color:white;text-align:center"> Received By</th> 
                </tr>
              </thead>
              <tbody id="viewAllRecord">
                @foreach ($items as $data)
                <tr>
                   <td style="text-align:center">
                      <div class="dropdown">
                        <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item returnedModal" href="#"  data-id="{{($data->id)}}"><i class="bx bx-redo mr-1"></i>returned</a>
                            <a class="dropdown-item editModal" href="#"  data-id="{{($data->id)}}"><i class="bx bx-edit mr-1"></i>edit</a>
                            <a class="dropdown-item deleteButton" href="#"  data-id="{{($data->id)}}"><i class="bx bx-trash mr-1"></i>delete</a>
                        </div>
                        </div>
                    </td>
                  <td style="text-align:center">{{ date('m-d-Y', strtotime($data->borrowed_date)) }} - {{date('h:i A', strtotime($data->borrowed_time))}}</td>
                  <td>{{ implode(', ', json_decode($data->item)) }}</td> 
                  <td style="text-align:center">
                      @if($data->returned_date && $data->returned_time)
                          {{ date('m-d-Y', strtotime($data->returned_date)) }} - {{ date('h:i A', strtotime($data->returned_time)) }}
                      @endif
                  </td>
                  <td>{{ $data->received_by }}</td> 
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    @include('modal.borrowReturn')
    @include('modal.borrowEdit')
    @include('modal.borrowDelete')
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script>
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});

$(document).ready(function() {
$("#addNewinput").click(function() {
    var inputGroup = `
      <div class="input-group">
          <input type="text" class="form-control col-sm-12 OTCmedDescript" style="display: inline-block;" name="item[]" aria-describedby="" placeholder="description" autocomplete="off">
          <button class="btn btn-default remove-input" type="button"><i class="fa fa-close" style="display: inline-block;font-size:20px;color:red"></i></button>
          <span class="text-info stockLeft" style="display: inline-block; margin-left: 10px;"></span>
          <span class="expirationWarning" style="display:none;"></span>
          <ul class="list-group results" style="display: none;font-size:12px;font-weight:400;"></ul>
      </div>
    `;
    $("#inputs-container").append(inputGroup);
    })

     $(document).on("click", ".remove-input", function() {
        $(this).parent().remove();
    });
});


// Save SWAL ALERT
 $("#borrowForm").submit(function(e) {
  e.preventDefault();

  var form = $(this);
  var actionUrl = form.attr('action');
  
  $.ajax({
    type: "POST",
    url: actionUrl,
    data: form.serialize(), 
    success: function(response){
      if (response.status == 200) {
        Swal.fire({
          title: response['success'],
          icon: 'success',
          confirmButtonText: 'Okay',
      }).then((response1) => {
              
     if (response1.isConfirmed) {
      location.reload(); 
      }
      })
      console.log(response); 	
      }
      else if(response.error== 'Duplicate'){
        Swal.fire({
        title: response['error'],
        icon: 'error',
        confirmButtonText: 'Okay',
      }).then((response) => {

      if (response.isConfirmed) {
        location.reload()
      }
    })
   }
  }
  });
});


$(document).on('click', '.returnedModal', function(){
   $('#returnedBorrowModal').modal('show');
  
    var id = $(this).data('id'); 
    // var today = new Date();
    // var formattedDate = today.getFullYear()+'-'+(today.getMonth()+1).toString().padStart(2, '0')+'-'+today.getDate().toString().padStart(2, '0');

    $('#returnedBorrowModal').find('.id').val(id);
    // $('#date').val(formattedDate);
});

$(document).ready(function () {
  $(document).on('click', '.editModal', function () {
    var id = $(this).data('id');
    console.log(id);
    $('#editBorrowModal').modal('show');

    $.ajax({
      url: '/editModal',
      type: 'POST',
      data: { id: id },
      success: function (response) {
        console.log(response);
        
        const items = Array.isArray(response.item) ? response.item : JSON.parse(response.item || "[]");

        $('.dateB').val(response.borrowed_date);
        $('.timeB').val(response.borrowed_time);
        $('.dateR').val(response.returned_date);
        $('.timeR').val(response.returned_time);
        $('.id').val(response.id);

        $('#inputs-container1').empty();

        if (items.length > 0) {
          items.forEach(function(value) {
            const newInput = `
              <div class="input-group mb-2">
                <input type="text" class="form-control col-sm-12" name="item[]" value="${value}" placeholder="" autocomplete="off">
              </div>
            `;
            $('#inputs-container1').append(newInput);
          });
        } else {
          const emptyInput = `
            <div class="input-group mb-2">
              <input type="text" class="form-control col-sm-12" name="item[]" placeholder="" autocomplete="off">
            </div>
          `;
          $('#inputs-container1').append(emptyInput);
        }
      }
    });
  });

  $(document).on("click", "#addNewinput1", function() {
    var inputGroup = `
      <div class="input-group mb-2">
        <input type="text" class="form-control col-sm-12" name="item[]" placeholder="" autocomplete="off">
        <button class="btn btn-default remove-input" type="button">
          <i class="fa fa-close" style="font-size:20px;color:red"></i>
        </button>
      </div>
    `;
    $("#inputs-container1").append(inputGroup);
  });

  $(document).on("click", ".remove-input1", function() {
    $(this).closest(".input-group1").remove();
  });
});




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
                  url: '/deleteBorrow',
                  success: function(response) {
                    if (response.message === 'Deleted successfully') {
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'The record has been deleted.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed || result.isDismissed) {
                                location.reload();
                            }
                        });
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