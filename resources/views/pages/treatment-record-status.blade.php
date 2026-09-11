@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Record')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    table, th,td{
   border: 1px solid rgb(0, 0, 0);
   border-collapse: collapse;
   text-align: center;
 }
 input {
  outline: 0;
  border-width: 0;
  }
  .textbox {
      transform: scale(1.5);
      margin: 10px;
      accent-color: rgb(58, 57, 57)
  }
  thead{
  background-color: rgb(110, 155, 222);
  }
  textarea  {
        outline: 0;
      border-width: 0 0 1px;
      border-color: rgb(58, 57, 57)
      }
  .card {
    margin-bottom: 50px;
    margin-left: auto;
    margin-right: auto;
    }
    .pending-status {
    color: rgb(99, 175, 211);
    text-shadow:  5px rgba(113, 207, 238, 0.5);
    }

    .approved-status {
      color:  rgb(99, 211, 108);
      text-shadow:  5px rgba(113, 238, 121, 0.5);
    }

    .disapproved-status {
      color: rgb(211, 99, 99);
      text-shadow:  5px rgba(238, 113, 113, 0.5);
    }
    .inline-cursor {
      text-align: center;
      font-size: 12px;
      font-weight: 800;
      text-transform: capitalize;
      transition: font-size 0.3s, color 0.3s;
    }

    .inline-cursor:hover {
      font-size: 16px; 
      color: #000000;
      cursor: pointer;
    }
</style>
@endsection
{{-- page-styles --}}
@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row">
    @if (isset($name))
    @if ($request->has('id'))
    <div class="col-md-10">
      <div class="row">
        <div class="col-md-12">
          <div class="card border">
            <div class="card-header border " style="background-color:rgb(110, 155, 222);color:#ffffff;height:50px;font-size:15px;font-weight:800; display: flex; align-items: center;"><i class="fas fa-file-alt" style='font-size:15px'></i> PATIENT RECORD</div>
              <div class="card-body mt-0 p-1">
                <div class="table-responsive" >
                  <table class="table  table-sm myTable table-bordered table-striped zero-configuration" id="myTable" style="width:100%">
                    <thead>
                      <tr>
                        <th style="color:white;">Date</th>
                        <th style="color:white;">Diagnosis</th>
                        <th style="color:white;">Treatment</th>
                        <th style="color:white;">Remarks</th>
                      </tr>
                    </thead>
                    <tbody id="viewStatus">  
                      @foreach ($status as $data)
                        <tr>    
                          <td>{{ date('m-d-Y', strtotime ($data->created_at))}}</td>
                          <td> {{$data->diagnosis}}</td>
                          <td>{{$data->treatment}}</td>
                          <td>   @if ($data->remarks)
                            {{ implode(', ', json_decode($data->remarks)) }}
                        @endif</td>                       
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>   
              </div>
              <div class="card-footer">
                <button type="button" class="btn btn-primary btn-custom float-right" id="home">Back</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-2">
        <div class="card">
          <div class="card-header align-center " style="background-color:rgb(110, 155, 222);display: flex; flex-direction: column; align-items: center; justify-content: center;height:100px;">
            @if ($name->gender === 'Female')
              <img class="img-fluid" src="{{asset('images/logo/42101748.png')}}" alt="branding logo" style="max-width: 80px; max-height: 80px;">
            @elseif ($name->gender === 'Male')
              <img class="img-fluid" src="{{asset('images/logo/43514861.png')}}" alt="branding logo" style="max-width: 80px; max-height: 80px;">
            @endif
          </div> 
          <div class="card-body" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 20px;">
            <label style="font-size: 18px;" id="id">{{$name->patientId}}</label>
            <label class="inline-cursor" id="firstname">{{$name->firstname}}</label>
          </div>
        </div>                
      </div>
      @elseif ($request->has('to_id'))
      <div class="col-md-10">
        <div class="row">
          <div class="col-md-12">
            <div class="card border">
              <div class="card-header border " style="background-color:rgb(110, 155, 222);color:#ffffff;height:50px;font-size:15px;font-weight:800; display: flex; align-items: center;"><i class="fas fa-file-alt" style='font-size:15px'></i> PATIENT RECORD</div>
                <div class="card-body mt-0 p-1">
                  <div class="table-responsive" >
                    <table class="table myTable table-sm table-bordered table-striped zero-configuration" id="myTable" style="width:100%">
                      <thead>
                        <tr>
                          <th style="color:white;">Date</th>
                          <th style="color:white;">Diagnosis</th>
                          <th style="color:white;">Treatment</th>
                          <th style="color:white;">Remarks</th>
                        </tr>
                      </thead>
                      <tbody id="viewStatus">  
                        @foreach ($status as $data)
                          <tr>    
                            <td>{{ date('m-d-Y', strtotime ($data->created_at))}}</td>
                            <td> {{$data->diagnosis}}</td>
                            <td>{{$data->treatment}}</td>
                            <td>   @if ($data->remarks)
                              {{ implode(', ', json_decode($data->remarks)) }}
                          @endif</td>                       
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>   
                </div>
                <div class="card-footer">
                  <button type="button" class="btn btn-primary btn-custom float-right" id="home">Back</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="card">
            <div class="card-header align-center " style="background-color:rgb(110, 155, 222);display: flex; flex-direction: column; align-items: center; justify-content: center;height:100px;">
              @if ($name->gender === 'Female')
                <img class="img-fluid" src="{{asset('images/logo/42101748.png')}}" alt="branding logo" style="max-width: 80px; max-height: 80px;">
              @elseif ($name->gender === 'Male')
                <img class="img-fluid" src="{{asset('images/logo/43514861.png')}}" alt="branding logo" style="max-width: 80px; max-height: 80px;">
              @endif
            </div> 
            <div class="card-body" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 20px;">
              <label style="font-size: 18px;" id="id">{{$name->patientId}}</label>
              <label class="inline-cursor" id="firstname">{{$name->firstname}}</label>
            </div>
          </div>                
        </div>
        @endif
        @else
        <div class="card-panel red lighten-3">
                             
        </div>
        @endif
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


//Back button in View
 $(document).ready(function(){
    $("#home").click(function(){
      window.location.href = '/student-dental-record'
  })
 });
 
</script>
@endsection