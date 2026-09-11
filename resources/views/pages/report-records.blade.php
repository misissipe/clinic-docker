@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Medical Report')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  table,td{
   border: 1px solid rgb(0, 0, 0);
   border-collapse: collapse;
   text-align: center;
 }

 .cert {
  outline: 0;
  border-width: 0 0 1px;
  border-color: rgb(58, 57, 57)
  }

  input {
  outline: 0;
  border-width: 0;
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
  thead,tfoot{
    background-color: rgb(110, 155, 222);
  }

</style>
<style>
  @media screen {
    #printSection {
        display: none;
    }
  }

  @media print {
    body * {
      visibility:hidden;
      font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }

    table,th,td{
      border: 1px solid rgb(0, 0, 0);
      border-collapse: collapse;
      text-align: center;
    }

    .printed-div{
    position: absolute;
    left: 120px;
      }
   
    #printSection, #printSection * {
      visibility:visible;
    }
    #printSection {
      position:absolute;
      left:0;
      top:0;
    }
  }
  @page {
   margin: 10mm 10mm 10mm 10mm;  
   font-family: Cambria;
   size: Auto;
 }
</style>
@endsection
@section('content')
<section id="basic-datatable">
  <div class="row" >
    <div class="col-md-11">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
        {{-- <div class="card-header" style="font-weight: bold;color:white;background-color: rgb(110, 155, 222);">VIEW RECORDS</div> --}}
          <div class ="card-body">
            <div style="text-align: center;text-transform: capitalize;color:black;">
              <h5 style="color:black;">MONTHLY ACCOMPLISHMENT REPORT</h5>
              <h6  style="color:black;">(MEDICAL SERVICES)</h6><br>
              <h6  style="color:black;">{{$monthName }} {{$year}}</h6>
            </div>            
            <div class="table-responsive">
              <table class="table studentsTable table-bordered table-striped table-sm" id="miTable" style="width:100%;color:black;"> 
                <thead>
                  <tr>
                    <th style="color:white;">Medical Services</th>
                    <th colspan="2" style="color:white;">Student</th>
                    <th colspan="2" style="color:white;">Faculty & Staff</th>
                    <th colspan="2" style="color:white;">Total</th>
                    <th style="color:white;">Frequency of Delivery</th>
                    <th style="color:white;">%</th>
                  </tr>
                
                  <tr>
                    <th ></th>
                    <th style="color:white;">Male</th>
                    <th style="color:white;">Female</th>
                    <th style="color:white;">Male</th>
                    <th style="color:white;">Female</th>
                    <th style="color:white;">Male</th>
                    <th style="color:white;">Female</th>
                    <th ></th>
                    <th ></th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $roles = ['Student', 'Employee'];
                    $genders = ['Male', 'Female'];
                    $grandTotalServices = 0;
                    $grandCounts = [
                      'Student' => ['Male' => 0, 'Female' => 0],
                      'Employee' => ['Male' => 0, 'Female' => 0],
                      'Total' => ['Male' => 0, 'Female' => 0],
                    ];
                    $serviceData = [];
                  @endphp

                  @foreach ($medical_services as $service)
                    @php
                      $serviceRemark = $service['Condition'];
                      $counts = [
                        'Student' => ['Male' => 0, 'Female' => 0],
                        'Employee' => ['Male' => 0, 'Female' => 0],
                      ];

                      foreach ($roles as $role) {
                        foreach ($genders as $gender) {
                          $count = DB::connection('mysql')
                            ->table('medicalrecord')
                            ->whereJsonContains('purpose', [$serviceRemark])
                            ->where('role', $role)
                            ->where('gender', $gender)
                            ->whereYear('date', $year)
                            ->whereMonth('date', $month)
                            ->whereNull('deleted_at')
                             ->where('campus', session('campus'))
                            ->count();

                          $counts[$role][$gender] = $count;
                          $grandCounts[$role][$gender] += $count;
                          $grandCounts['Total'][$gender] += $count;
                        }
                      }

                      $frequency = array_sum($counts['Student']) + array_sum($counts['Employee']);
                      $grandTotalServices += $frequency;

                      $serviceData[] = [
                        'label' => $service['Label'],
                        'counts' => $counts,
                        'frequency' => $frequency,
                      ];
                    @endphp
                  @endforeach

                  <!-- Now display the table -->
                  <tbody>
                    @foreach ($serviceData as $data)
                      @php
                        $counts = $data['counts'];
                        $freq = $data['frequency'];
                        $percentage = $grandTotalServices > 0 ? round(($freq / $grandTotalServices) * 100, 2) : 0;
                      @endphp
                      <tr>
                        <td style="text-align:left;">{{ $data['label'] }}</td>
                        <td>{{ $counts['Student']['Male'] }}</td>
                        <td>{{ $counts['Student']['Female'] }}</td>
                        <td>{{ $counts['Employee']['Male'] }}</td>
                        <td>{{ $counts['Employee']['Female'] }}</td>
                        <td>{{ $counts['Student']['Male'] + $counts['Employee']['Male'] }}</td>
                        <td>{{ $counts['Student']['Female'] + $counts['Employee']['Female'] }}</td>
                        <td>{{ $freq }}</td>
                        <td>{{ $percentage }}%</td>
                      </tr>
                    @endforeach

                    <!-- Totals row -->
                    <tr style="font-weight:bold; background:#d9e1f2;">
                      <td>TOTAL</td>
                      <td>{{ $grandCounts['Student']['Male'] }}</td>
                      <td>{{ $grandCounts['Student']['Female'] }}</td>
                      <td>{{ $grandCounts['Employee']['Male'] }}</td>
                      <td>{{ $grandCounts['Employee']['Female'] }}</td>
                      <td>{{ $grandCounts['Total']['Male'] }}</td>
                      <td>{{ $grandCounts['Total']['Female'] }}</td>
                      <td>{{ $grandTotalServices }}</td>
                      <td>100%</td>
                    </tr>
                  </tbody>
              </table>   
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    <div class="col-md-1">
      {{-- <div class="card" style="display: flex; align-items: center; justify-content: center; background-color: rgb(119, 241, 119); height: 40px; margin-bottom: 10px;">
        <div class="card-body">
          <form action="/generatedSlip"  method="post" id="generatedSlip">
            @csrf
            <input  class="col-11 id" type="text" name="id" value="{{$generate->id}}" id="id" hidden> 
            <input  class="col-11 " type="text" name="purpose" value="Issuance of Slip" id="" hidden> 
            <button type="submit" class="btn btn-default button" id="generate"><a style="color: rgb(255, 255, 255); font-size: 15px;">Generated</a></button>
          </form>
        </div>
      </div> --}}
      <div class="card" style="display: flex; align-items: center; justify-content: center; background-color: rgb(84, 145, 236); height: 40px; margin-bottom: 10px;">
        <div class="card-body">
          <button type="button" class="btn btn-default button" id="btnPrint"><a style="color: rgb(255, 255, 255); font-size: 15px;">Print</a></button>
        </div>
      </div>
      <div class="card" style="display: flex; align-items: center; justify-content: center; background-color: rgb(75, 95, 130); height: 40px; margin-top: 0;">
        <div class="card-body">
          <button type="button" id="cancelBtnprint" class="btn btn-default button"><a style="color: rgb(255, 255, 255); font-size: 15px;">Cancel</a></button>
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center" style="display:none" >
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
        {{-- <div class="card-header" style="font-weight: bold;color:white;background-color: rgb(110, 155, 222);">VIEW RECORDS</div> --}}
          <div class ="card-body">
            <div id="printThis">
              <div class="col-12  d-flex justify-content-center" >
                <img src="{{asset('images/logo/new-SLSU-letter-head.png')}}" style="width: 420px; height: 140px;margin-right:30px">
                <img src="{{asset('images/logo/bagong_pilipinas.png')}}" style="width: 110px; height: 110px;">
            </div>
              <div class="row">
                <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 13px; border-bottom: 1px solid black; text-align:center;color:black;">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
              </div><br>
              <div class="row" style="color:black;">
                <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 600; font-size: 23px; font-style: bold; text-align:center">MONTHLY ACCOMPLISHMENT REPORT</div>
                <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 600; font-size: 20px; font-style: bold; text-align:center">(MEDICAL SERVICES)</div>
              </div>   
              <br> 
              <div class="row" style="color:black;">
                <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 600; font-size: 20px; font-style: bold; text-align:center;text-transform:capitalize">{{$monthName }} {{$year}}</div>
              </div> 
              <br>        
            <div class="table-responsive">
              <table class="table table-sm studentsTable table-bordered table-striped" id="miTable" style="font-size: 20px;width:100%;border-spacing: 10px;color:black;border-color:black">
                <thead>
                  <tr>
                    <th class="border" style="font-weight: 400;font-size: 18px;color:rgb(0, 0, 0);">Medical Services</th>
                    <th colspan="2" style="font-weight: 400;font-size: 18px;color:rgb(0, 0, 0);">Student</th>
                    <th colspan="2" style="font-weight: 400;font-size: 18px;color:rgb(0, 0, 0);">Faculty & Staff</th>
                    <th colspan="2" style="font-weight: 400;font-size: 18px;color:rgb(0, 0, 0);">Total</th>
                    <th style="text-transform:capitalize;font-weight: 400;font-size: 18px;width:10%;color:rgb(0, 0, 0);">Frequency of Delivery</th>
                    <th style="font-weight: 400;font-size: 18px;color:rgb(0, 0, 0);">%</th>
                  </tr>
               
                  <tr>
                    <th style="font-weight: 400; font-size: 18px; color: rgb(0, 0, 0); border-top: none; padding: 15px;"></th>
                    <th style="text-transform:capitalize;font-weight: 400;font-size: 18px;width:5%;color:rgb(0, 0, 0);padding: 15px;">Male</th>
                    <th style="text-transform:capitalize;font-weight: 400;font-size: 18px;width:5%;color:rgb(0, 0, 0);padding: 15px;">Female</th>
                    <th style="text-transform:capitalize;font-weight: 400;font-size: 18px;width:5%;color:rgb(0, 0, 0);padding: 15px;">Male</th>
                    <th style="text-transform:capitalize;font-weight: 400;font-size: 18px;width:5%;color:rgb(0, 0, 0);padding: 15px;">Female</th>
                    <th style="text-transform:capitalize;font-weight: 400;font-size: 18px;width:5%;color:rgb(0, 0, 0);padding: 15px;">Male</th>
                    <th style="text-transform:capitalize;font-weight: 400;font-size: 18px;width:5%;color:rgb(0, 0, 0);padding: 15px;">Female</th>
                    <th style="font-weight: 400;font-size: 18px;color:rgb(0, 0, 0); border-top: none;padding: 15px;"></th>
                    <th style="font-weight: 400;font-size: 20px;color:rgb(0, 0, 0); border-top: none;padding: 15px;"></th>
                  </tr>
                </thead>                
                <tbody>
                   @php
                    $roles = ['Student', 'Employee'];
                    $genders = ['Male', 'Female'];
                    $grandTotalServices = 0;
                    $grandCounts = [
                      'Student' => ['Male' => 0, 'Female' => 0],
                      'Employee' => ['Male' => 0, 'Female' => 0],
                      'Total' => ['Male' => 0, 'Female' => 0],
                    ];
                    $serviceData = [];
                  @endphp

                  @foreach ($medical_services as $service)
                    @php
                      $serviceRemark = $service['Condition'];
                      $counts = [
                        'Student' => ['Male' => 0, 'Female' => 0],
                        'Employee' => ['Male' => 0, 'Female' => 0],
                      ];

                      foreach ($roles as $role) {
                        foreach ($genders as $gender) {
                          $count = DB::connection('mysql')
                            ->table('medicalrecord')
                            ->whereJsonContains('purpose', [$serviceRemark])
                            ->where('role', $role)
                            ->where('gender', $gender)
                            ->whereYear('date', $year)
                            ->whereMonth('date', $month)
                            ->whereNull('deleted_at')
                             ->where('campus', session('campus'))
                            ->count();

                          $counts[$role][$gender] = $count;
                          $grandCounts[$role][$gender] += $count;
                          $grandCounts['Total'][$gender] += $count;
                        }
                      }

                      $frequency = array_sum($counts['Student']) + array_sum($counts['Employee']);
                      $grandTotalServices += $frequency;

                      $serviceData[] = [
                        'label' => $service['Label'],
                        'counts' => $counts,
                        'frequency' => $frequency,
                      ];
                    @endphp
                  @endforeach

                  <!-- Now display the table -->
                  <tbody>
                    @foreach ($serviceData as $data)
                      @php
                        $counts = $data['counts'];
                        $freq = $data['frequency'];
                        $percentage = $grandTotalServices > 0 ? round(($freq / $grandTotalServices) * 100, 2) : 0;
                      @endphp
                      <tr>
                        <td style="text-align:left;">{{ $data['label'] }}</td>
                        <td>{{ $counts['Student']['Male'] }}</td>
                        <td>{{ $counts['Student']['Female'] }}</td>
                        <td>{{ $counts['Employee']['Male'] }}</td>
                        <td>{{ $counts['Employee']['Female'] }}</td>
                        <td>{{ $counts['Student']['Male'] + $counts['Employee']['Male'] }}</td>
                        <td>{{ $counts['Student']['Female'] + $counts['Employee']['Female'] }}</td>
                        <td>{{ $freq }}</td>
                        <td>{{ $percentage }}%</td>
                      </tr>
                    @endforeach

                    <!-- Totals row -->
                    <tr style="font-weight:bold; background:#d9e1f2;">
                      <td>TOTAL</td>
                      <td>{{ $grandCounts['Student']['Male'] }}</td>
                      <td>{{ $grandCounts['Student']['Female'] }}</td>
                      <td>{{ $grandCounts['Employee']['Male'] }}</td>
                      <td>{{ $grandCounts['Employee']['Female'] }}</td>
                      <td>{{ $grandCounts['Total']['Male'] }}</td>
                      <td>{{ $grandCounts['Total']['Female'] }}</td>
                      <td>{{ $grandTotalServices }}</td>
                      <td>100%</td>
                    </tr>
                  </tbody>
              </table>   
            </div>
            <div style="font-weight: 600; font-style: italic; font-size: 22px; text-align: center; padding: 0; margin-top: 0;">
              Frequency of Delivery of Medical Services
            </div>          
            <br><br><br><br><br><br><br>
            <div style="font-weight: 600; font-size: 20px; text-align: left">
              Prepared: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Noted: <br><br><br><br><br>
              <div style=" flex-direction: column;">
                  <input class="" name="" type="text" value="{{$preparedby->FirstName ?? ''}} {{$preparedby->MiddleName ?? ''}} {{$preparedby->LastName ?? ''}} " placeholder="please input signatories"> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="" name="" type="text" value="{{$noted->FirstName ?? ''}} {{$noted->MiddleName ?? ''}} {{$noted->LastName ?? ''}}" placeholder="please input signatories">
                  <input class="" name="" type="text" value="{{$preparedby->Role ?? ''}}" placeholder="please input signatories"> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="" name="" type="text" value="{{$noted->Designation ?? ''}}, {{$noted->Office ?? ''}}" placeholder="please input signatories">
                  <div class="row col-md-12">
                    Date: <input class="col-2 cert" name="" type="text" value="">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Date:<input class="col-2 cert" name="" type="text" value=""> 
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
    <div class="col-md-1">
      {{-- <div class="card" style="display: flex; align-items: center; justify-content: center; background-color: rgb(119, 241, 119); height: 40px; margin-bottom: 10px;">
        <div class="card-body">
          <form action="/generatedSlip"  method="post" id="generatedSlip">
            @csrf
            <input  class="col-11 id" type="text" name="id" value="{{$generate->id}}" id="id" hidden> 
            <input  class="col-11 " type="text" name="purpose" value="Issuance of Slip" id="" hidden> 
            <button type="submit" class="btn btn-default button" id="generate"><a style="color: rgb(255, 255, 255); font-size: 15px;">Generated</a></button>
          </form>
        </div>
      </div> --}}
      <div class="card" style="display: flex; align-items: center; justify-content: center; background-color: rgb(84, 145, 236); height: 40px; margin-bottom: 10px;">
        <div class="card-body">
          <button type="button" class="btn btn-default button" id="btnPrint"><a style="color: rgb(255, 255, 255); font-size: 15px;">Print</a></button>
        </div>
      </div>
      <div class="card" style="display: flex; align-items: center; justify-content: center; background-color: rgb(75, 95, 130); height: 40px; margin-top: 0;">
        <div class="card-body">
          <button type="button" id="cancelBtnprint" class="btn btn-default button"><a style="color: rgb(255, 255, 255); font-size: 15px;">Cancel</a></button>
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
//Search-Input
 $(document).ready(function() {
  $("#submitSearch").submit(function(event) {
     event.preventDefault();
     var role = $('#roleSelect').val();
     var search = $('#searchHere').val();
         $.ajax({
            type:'post',
            url:'/patient-view-record',
            data:{search:search,role:role},

            success:function(data){
              if (data){
                $('#miTable').html(data);   
              } else {
                Swal.fire({
                icon: 'warning',
                title: data.empty
              })
              }
            } 
         })
       })
     });

//view all Record
$(document).on('click', '.viewPR', function() {
    var id = $(this).data('id');
    var role = $(this).data('role');

     console.log(role);
     console.log(id);

     if (role === 'Student'){
      window.location.href = "/patient-record?StudentId=" + encodeURIComponent(id);
     } else if (role === 'Employee'){
      window.location.href = "/patient-record?EmployeeId=" + encodeURIComponent(id);
     }
});

//Print 
document.getElementById("btnPrint").onclick = function () {
      printElement(document.getElementById("printThis"));
  }

  function printElement(elem) {
      var domClone = elem.cloneNode(true);
      
      var $printSection = document.getElementById("printSection");
      
      if (!$printSection) {
          var $printSection = document.createElement("div");
          $printSection.id = "printSection";
          document.body.appendChild($printSection);
      }
      
      $printSection.innerHTML = "";
      $printSection.appendChild(domClone);
      window.print();
  }  
  
  $(document).ready(function(){
    $("#cancelBtnprint").click(function(){
      window.history.back();
  })
 });
</script>
@endsection