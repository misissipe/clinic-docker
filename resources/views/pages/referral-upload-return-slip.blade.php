@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','MSMIS')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<style>
    table, th,td{
  border: 1px solid rgb(58, 57, 57);
  border-collapse: collapse;
  padding: 1px;
  text-align: center;
  }

    .container {
      display: flex;
      justify-content: space-between;
    }

    td.a{
      text-align: right;
      vertical-align: bottom;
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
    margin: 4px;
    accent-color: rgb(58, 57, 57);
    width: 50px;
  }
  textarea  {
      outline: 0;
    border-width: 0 0 1px;
    border-color: rgb(58, 57, 57)
    
    }
  label {
    text-transform: lowercase;
  }

  label::first-letter {
    text-transform: uppercase;
  }
  thead{
    background-color: rgb(110, 155, 222);
  }
  br.break {
  display: block;
  margin-bottom: 1px;
  line-height: 1px;
 }
 .card {
 
 margin-bottom: 50px;
 margin-left: auto;
 margin-right: auto;
  }
  .pending-status {
    color: rgb(99, 175, 211); /* light blue */
    text-shadow:  5px rgba(113, 207, 238, 0.5);
  }

  .approved-status {
    color:  rgb(99, 211, 108); /* green */
    text-shadow:  5px rgba(113, 238, 121, 0.5);
  }

  .disapproved-status {
    color: rgb(211, 99, 99); /* red */
    text-shadow:  5px rgba(238, 113, 113, 0.5);
  }
  .btn-sm {
    width: 70px; /* adjust the width as needed */
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
  <div class="row justify-content-center">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="table-responsive">
                    <h5 style="font-weight: bold; font-style: italic;color:royalblue); display: flex; align-items: center;">UPLOAD RETURN SLIP</h5> <br>
                    <input type="text" class="id" name="id" id="id" placeholder="id" hidden >
                    <div class="row col-12" style="font-size:17px;font-weight:400;color:rgb(58, 57, 57)">            
                      Name:
                      <input type="text" class=" col-sm-4 fullname" value="{{$name->first_name}} {{$name->middle_name}} {{$name->last_name}}" name="lastname"  id="fullname"  readonly>
                    </div><hr>   
                </div>
                <div class="table-responsive view-all">
                  <table class="table recordTable table-bordered table-striped col-sm zero-configuration" id="recordTable" >
                    <thead>
                      <tr>
                        <th style="color:white;">Date</th>
                        <th style="color:white;">Referred to</th>
                        <th style="color:white;">Reason for referral</th>  
                        <th style="color:white;">File</th>  
                        <th style="color:white;">Action</th>
                      </tr>
                    </thead>
                    <tbody id="viewHere">  
                    @foreach ($return as $data)
                      <tr>    
                        <td>{{ date('m-d-Y', strtotime ($data->date))}}</td>
                        <td> @if (strpos($data->referTo, 'Others') !== false)
                                {{ $data->others }}
                              @else
                                {{ implode(', ', json_decode($data->referTo)) }}
                              @endif
                        </td>
                        <td>{{$data->reason}}</td>
                        <td>{{implode(', ', json_decode($data->file))}}</td>
                        <td>
                            <button type="button" class="btn btn-default uploadReturnSlip" data-id="{{$data->id}}" data-cert-id="{{$data->id}}" data-toggle="modal" data-target="#uploadReturnSlip"><i class="fa fa-upload"></i></button>
                        </td>           
                      </tr>
                    @endforeach  
                    </tbody>
                  </table>
                </div>
                <div class="form-group">
                  <button type="button"  class="btn btn-secondary  float-right" id="backToSearch">Back</button>
                </div>
                @include('modal.uploadReturnSlip')
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script>
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});
//Back button
 $(document).ready(function(){
        $("#backToSearch").click(function(){
          window.history.back();
      })
    })
</script>
@endsection