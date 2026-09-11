@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Dental Management Information System')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
   .table {
  border: 1px solid rgb(195, 195, 195);
  border-collapse: collapse;
  padding: 3px;
  text-align: center;
  }
  .x-cell::before {
  content: "✕";
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
  }
  .border {
    border: 1px;
    color:black;
  }
  .align{
      text-align: center;
  }
  .move{
      text-align: left;
  }
  input {
        outline: 0;
        border-width: 0;
        border-color: rgb(58, 57, 57);
      }
  .cert{
    outline: 0;
    border-width: 0 0 1px;
    border-color: rgb(58, 57, 57);
  }
  .textbox {
      transform: scale(1.5);
      margin: 10px;
      accent-color: rgb(58, 57, 57)
  }
  thead{
  background-color: rgb(110, 155, 222);
 }
 .head{
  background-color:rgba(110, 155, 222, 0);
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
    <div class="row">
        <div class="col-12">
            <div class="card">
              <div class="card-header">
                          <div class="table-responsive">
                            {{-- <h5 style="font-weight: bold; font-style: italic;color:royalblue)">PATIENT RECORDS</h5><br> --}}
                            {{-- <div class="alert bg-rgba-info   alert-dismissible fade show" role="alert">
                              <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div> --}}
                            <form  action="/patient-information" method="post" id="submitBtn">
                              <div style="display:flex; justify-content:space-between;">
                                <div class="row col-9" style="font-size:17px;font-weight:400;color:rgb(58, 57, 57);">
                                  <select id="roleSelect" class="form-control" aria-label="Default select example" style="width:20%">
                                      <option selected>-Select Patient-</option>
                                      <option value="Student">Student</option>
                                      <option value="Employee">Employee</option>
                                      <option value="Employee">Employee</option>
                                  </select>
                                </div>
                                <div class="input-group mb-1" style="width: fit-content;">
                                    <input type="text" class="form-control col-sm-10" placeholder="Search" id="searchInput" autocomplete="off">
                                  <div class="input-group-append">
                                    <button class="btn btn-primary submitBtn" type="submit"><i class="fa fa-search"></i></button>
                                  </div>
                                </div>
                              </div>  
                             {{--  <div class="input-group mb-3">
                                <input type="text" class="form-control col-sm-2" placeholder="Search" id="searchInput">
                                <div class="input-group-append">
                                  <button class="btn btn-primary submitBtn" type="submit"><i class="fa fa-search"></i></button>
                                </div>
                              </div> --}}
                              </form>  
                              <div class="table-ressaveCertaddCertponsive" >
                                <table class="table studentsTable table-bordered table-striped col-sm" id="chartTable" style="width:100%">
                                  <thead >
                                    <tr>
                                        <th style="color:white;">Patient ID</th>
                                        <th style="color:white;">Last Name</th>
                                        <th style="color:white;">First Name</th>
                                        <th style="color:white;">Middle Name</th>
                                        <th style="color:white;">Action</th>
                                    
                                    </tr>
                                </thead>
                                </table><br><br>   
                              </div>   
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
<script>
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});

$(document).ready(function() {
  $("#submitBtn").submit(function(event) {

    event.preventDefault();
    var search = $('#searchInput').val();
         $.ajax({
            type:'post',
            url:'/student-dental-record',
            data:{search:search},

            success:function(data){
              $('#chartTable').html(data);   
            } 
         })
       })
 });

 
 $(document).on('click', '.chart', function(){
  var id = $(this).data('id');
  // console.log(id);
  window.location.href = "/student-dental-chart?id=" + id;
});




</script>
@endsection