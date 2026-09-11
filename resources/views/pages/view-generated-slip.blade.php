@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Pending Referral')
@php
use App\Http\Controllers\AESCipher;
@endphp
{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
    table,td,tr{
  border: 1px solid rgb(226, 222, 222);
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
    border-width: 0 0 0px;
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
  .cell-border{
    border-color: rgb(138, 138, 138)
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
 ul
  {  
      cursor:pointer;  
  }  
  li:hover {
  background-color: rgba(220, 225, 229, 0.953);
  }

  .zero-configuration td:nth-child(3):contains('pending') {
      background-color: rgb(121, 144, 221);
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
  .red-box {
  background-color: rgb(200, 6, 6);
  padding: 3px; 
  display: inline-block; 
  border-radius: 2px; 
  color: white; 
}
</style>
@endsection
{{-- page-styles --}}
@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row mx-auto">
    <div class="col-md-12">
      <div class="card">
        {{-- <div class="card-header">
          
          
        </div> --}}
        <div class="card-body">
          <label style="font-size:18px">Pending Approval for Referral Slip</label>
          <br><br>
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" aria-controls="home" role="tab" aria-selected="true">
                <i class="bx bx-user align-middle"></i>
                <span class="align-middle"> Students</span>
                <span class="badge badge-danger" >{{$total_Studcents}}</span>
                {{-- <span class="red-box" id="student-status"></span>  --}}
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile" role="tab" aria-selected="false">
                <i class="bx bxs-user-detail align-middle"></i>
                <span class="align-middle">Employee</span>
                <span class="badge badge-danger" >{{$total_Employees}}</span>
              </a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="home" aria-labelledby="home-tab" role="tabpanel">
              <div class="table-responsive view-all">
                <table class="table table-bordered recordTable table-sm cell-border zero-configuration" id="recordTable">
                  <input type="hidden"name="firstname" id="roleSelect" value="Student">
                    <thead>
                        <tr>
                            <th style="text-align:center;color:white;">Date</th>
                            <th style="text-align:center;color:white;">Student No</th>
                            <th style="text-align:center;color:white;">Name</th>  
                            <th style="text-align:center;color:white;">Refer To</th>
                            <th style="text-align:center;color:white;">Reason</th>
                            <th style="text-align:center;color:white;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="preView">  
                      @foreach ($referralS as $data)
                        <tr>
                          <td style="text-align:center;">{{ date('m-d-Y', strtotime($data->date)) }}</td>
                          <td style="text-align:center;">{{ $data->patientId}}</td>
                          <td>{{ $data->lastname }}, {{ $data->firstname }} {{ $data->middlename }} </td>
                          <td> @if (strpos($data->referTo, 'Others') !== false)
                            {{ $data->others }}
                          @else
                            {{ $data->referTo }}
                          @endif</td>
                          <td>{{ $data->reason }}</td> 
                          <td style="text-align:center;"><button type="button" class="btn btn-default view" data-role="Student" data-id="{{(new AESCipher)->encrypt($data->id)}}"><i class="fa fa-file"></i></button></td>
                       </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
            </div>
            <div class="tab-pane" id="profile" aria-labelledby="profile-tab" role="tabpanel">
              <div class="table-responsive view-all">
                <table class="table table-bordered recordTable table-sm cell-border zero-configuration" id="recordTable">
                  <input type="hidden"name="firstname" id="roleSelect" value="Employee">
                    <thead>
                        <tr>
                            <th style="text-align:center;color:white;">Date</th>
                            <th style="text-align:center;color:white;">Employee No</th>
                            <th style="text-align:center;color:white;">Name</th>  
                            <th style="text-align:center;color:white;">Refer To</th>
                            <th style="text-align:center;color:white;">Reason</th>
                            <th style="text-align:center;color:white;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="preView">  
                      @foreach ($referralE as $data)
                        <tr>
                          <td style="text-align:center;">{{ date('m-d-Y', strtotime($data->date)) }}</td>
                          <td style="text-align:center;">{{ $data->patientId}}</td>
                          <td>{{ $data->lastname }}, {{ $data->firstname }} {{ $data->middlename }} </td>
                          <td> @if (strpos($data->referTo, 'Others') !== false)
                            {{ $data->others }}
                          @else
                            {{ $data->referTo}}
                          @endif</td> 
                          <td>{{ $data->reason }}</td> 
                          <td style="text-align:center;"><button type="button" class="btn btn-default view" data-role="Student" data-id="{{(new AESCipher)->encrypt($data->id)}}"><i class="fa fa-file"></i></button></td>
                       </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script>
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});
//Search-Input 
  $(document).ready(function() {
    $("#submitBtn").submit(function(e) {
      e.preventDefault();
      var search = $('#searchInput').val();
          $.ajax({
              type:'post',
              url:'/referral',
              data:{search:search},

              success:function(data){
                $('#myTable').html(data);   
              } 
          })
        })
  });


  $(document).on('click', '.view', function(){
  var id = $(this).data('id'); 
  var role = $('#roleSelect').val();
    console.log(role);
    console.log(id);

  if (role === 'Student') {
    window.location.href = "/viewGeneratedSlip?id=" +  encodeURIComponent(id)  + "&role=Student";
  } else if (role === 'Employee') {
    window.location.href ="/viewGeneratedSlip?id=" + encodeURIComponent(id)  + "&role=Employee";
  }
 });


//Back button
 $(document).ready(function(){
        $("#backBtn").click(function(){
          window.history.back();
      })
    })
     
</script>
@endsection