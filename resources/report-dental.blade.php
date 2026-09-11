@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Dental Report')

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

 .cert111 {
  outline: 0;
  border-width: 0 0 0px;
  border-color: rgb(255, 255, 255)
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
            <div class ="card-body">
              <div style="text-transform: capitalize; font-style: italic;">
                <h6 style="color:black;">Office of Health Services</h6>
              </div>
              <div style="text-align: center;">
                <h5 style="color:black;">PROFILE OF PATIENTS GIVEN DENTAL SERVICES</h5>
                <h6 style="color:black;">(DENTAL SERVICES)</h6><br>
                <h6 style="color:black;">{{$monthName }} {{$year}}</h6>
              </div>            
              <div class="table-responsive">
                <table class="table studentsTable table-bordered table-striped table-sm" id="miTable" style="width:100%;color:black;">
                  <thead>
                    <tr>
                      <th style="color:white;">Dental Services</th>
                      <th style="color:white;">Student</th>
                      <th style="color:white;">Employee</th>
                      <th style="color:white;">Dependent</th>
                      <th style="color:white;">Total</th>
                    </tr>
                  </thead>
                  <?php
                    $remarksMap = [
                      'TOOTH EXTRACTION' => 'Tooth Extraction',
                      'CAVITY FILLING' => 'Oral Restoration',
                      'ORAL PROPHYLAXIS' => 'Oral Prophylaxis',
                      'DENTAL CHECK-UP' => 'Consultation',
                      'PROVISION OF OTC MEDICINE' => 'OTC Medicine',
                      'ISSUANCE OF DENTAL CERTIFICATE' => 'Dental Certificate'
                    ];
                
                    $roles = ['Student', 'Employee', 'Dependent'];
                    $totals = ['Student' => 0, 'Employee' => 0, 'Dependent' => 0];
                  ?>
                  <tbody>
                    @foreach ($dental_services as $service)
                    <?php
                      $serviceRemark = $remarksMap[$service];
                      $counts = [];
                
                      foreach ($roles as $role) {
                        $count = DB::connection('mysql')
                          ->table('treatmentrecord')
                          ->whereJsonContains('remarks', [$serviceRemark])
                          ->where('role', '=', $role)
                          ->where('campus', session('campus'))
                          ->whereYear('date', '=', $year)
                          ->whereMonth('date', '=', $month)
                          ->whereNull('deleted_at')
                          ->count();

                          
                        
                        $counts[$role] = $count;
                        $totals[$role] += $count;
                      }
                
                      $totalService = array_sum($counts);
                    ?>
                    <tr>
                      <td style="text-align:left;">{{$service}}</td>
                      <td>{{$counts['Student']}}</td>
                      <td>{{$counts['Employee']}}</td>
                      <td>{{$counts['Dependent']}}</td>
                      <td>{{$totalService}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <td style="color:white;">Total</td>
                      <td style="color:white;">{{ $totals['Student'] }}</td>
                      <td style="color:white;">{{ $totals['Employee'] }}</td>
                      <td style="color:white;">{{ $totals['Dependent'] }}</td>
                      <td style="color:white;">{{ array_sum($totals) }}</td>
                    </tr>
                  </tfoot>
                </table>  
                {{-- dental services --}}
                <table class="table studentsTable table-bordered table-striped table-sm" id="miTable" style="width:100%;color:black;">
                    <thead>
                      <tr>
                        <th style="color:white;">Dental Services</th>
                        <th style="color:white;">Male</th>
                        <th style="color:white;">Female</th>
                        <th style="color:white;">Total</th>
                      </tr>
                    </thead>
                    <?php
                      $remarksMap = [
                          'TOOTH EXTRACTION' => 'Tooth Extraction',
                          'CAVITY FILLING' => 'Oral Restoration',
                          'ORAL PROPHYLAXIS' => 'Oral Prophylaxis',
                          'DENTAL CHECK-UP' => 'Consultation',
                          'PROVISION OF OTC MEDICINE' => 'OTC Medicine',
                          'ISSUANCE OF DENTAL CERTIFICATE' => 'Dental Certificate'
                      ];
                      
                      $genders = ['Male', 'Female'];
                      $totals = ['Male' => 0, 'Female' => 0];
                    ?>
                  <tbody>
                    @foreach ($dental_services as $service)
                    <?php
                    $serviceRemark = $remarksMap[$service];
                    $counts = [];
                  
                    foreach ($genders as $gender) {
                      $count = DB::connection('mysql')
                        ->table('treatmentrecord')
                        ->whereJsonContains('remarks', [$serviceRemark])
                        ->where('gender', '=', $gender)
                        ->where('campus', session('campus'))
                        ->whereYear('date', '=', $year)
                        ->whereMonth('date', '=', $month)
                        ->whereNull('deleted_at')
                        ->count();
                  
                      $counts[$gender] = $count;
                      $totals[$gender] += $count;
                    }
                  
                    $totalService = array_sum($counts);
                    ?>
                    <tr>
                      <td style="text-align:left;">{{$service}}</td>
                      <td>{{$counts['Male']}}</td>
                      <td>{{$counts['Female']}}</td>
                      <td>{{$totalService}}</td>
                    </tr>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                    <td style="color:white;">Total</td>
                    <td style="color:white;">{{ $totals['Male'] }}</td>
                    <td style="color:white;">{{ $totals['Female'] }}</td>
                    <td style="color:white;">{{ array_sum($totals) }}</td>
                    </tr>
                  </tfoot>
                </table>    
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-1">
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
            <div class ="card-body">
              <div id="printThis">
                <div class="col-12  d-flex justify-content-center" >
                  <img src="{{asset('images/logo/new-SLSU-letter-head.png')}}" style="width: 420px; height: 140px;margin-right:30px">
                  <img src="{{asset('images/logo/bagong_pilipinas.png')}}" style="width: 110px; height: 110px;">
                </div>
                <div class="row">
                  <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 13px; border-bottom: 1px solid black; text-align:center">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                </div><br>
                <div class="row">
                  <div class="col-lg-12 " style="font-weight: 400; font-size: 23px; font-style: italic;">Office of Health Services</div>
                </div><br>
                <div class="row">
                  <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 600; font-size: 23px; font-style: bold; text-align:center">PROFILE OF PATIENTS GIVEN DENTAL SERVICES</div>
                  <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 600; font-size: 20px; font-style: bold; text-align:center">(DENTAL SERVICES)</div>
                </div><br> 
                <div class="row">
                  <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 600; font-size: 20px; font-style: bold; text-align:center;text-transform:capitalize">{{$monthName }} {{$year}}</div>
                </div><br>           
                <div class="table-responsive">
                  <table class="table studentsTable table-bordered table-striped" id="miTable" style="width:100%;color:black;">
                    <thead>
                      <tr>
                        <th style="color:rgb(0, 0, 0);">Dental Services</th>
                        <th style="color:rgb(0, 0, 0);">Student</th>
                        <th style="color:rgb(0, 0, 0);">Employee</th>
                        <th style="color:rgb(0, 0, 0);">Dependent</th>
                        <th style="color:rgb(0, 0, 0);">Total</th>
                      </tr>
                    </thead>
                    <?php
                      $remarksMap = [
                        'TOOTH EXTRACTION' => 'Tooth Extraction',
                        'CAVITY FILLING' => 'Oral Restoration',
                        'ORAL PROPHYLAXIS' => 'Oral Prophylaxis',
                        'DENTAL CHECK-UP' => 'Consultation',
                        'PROVISION OF OTC MEDICINE' => 'OTC Medicine',
                        'ISSUANCE OF DENTAL CERTIFICATE' => 'Dental Certificate'
                      ];
                  
                      $roles = ['Student', 'Employee', 'Dependent'];
                      $totals = ['Student' => 0, 'Employee' => 0, 'Dependent' => 0];
                    ?>
                  
                    <tbody>
                      @foreach ($dental_services as $service)
                      <?php
                        $serviceRemark = $remarksMap[$service];
                        $counts = [];
                  
                        foreach ($roles as $role) {
                          $count = DB::connection('mysql')
                            ->table('treatmentrecord')
                            ->whereJsonContains('remarks', [$serviceRemark])
                            ->where('campus', session('campus'))
                            ->where('role', '=', $role)
                            ->whereYear('date', '=', $year)
                            ->whereMonth('date', '=', $month)
                            ->whereNull('deleted_at')
                            ->count();

                           
                          
                          $counts[$role] = $count;
                          $totals[$role] += $count;
                        }
                  
                        $totalService = array_sum($counts);

                        dd( $totalService);
                      ?>
                      <tr>
                        <td style="text-align:left;">{{$service}}</td>
                        <td>{{$counts['Student']}}</td>
                        <td>{{$counts['Employee']}}</td>
                        <td>{{$counts['Dependent']}}</td>
                        <td>{{$totalService}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <td style="color:rgb(0, 0, 0);">Total</td>
                        <td style="color:rgb(0, 0, 0);">{{ $totals['Student'] }}</td>
                        <td style="color:rgb(0, 0, 0);">{{ $totals['Employee'] }}</td>
                        <td style="color:rgb(0, 0, 0);">{{ $totals['Dependent'] }}</td>
                        <td style="color:rgb(0, 0, 0);">{{ array_sum($totals) }}</td>
                      </tr>
                    </tfoot>
                  </table><br>
                  <table class="table studentsTable table-bordered table-striped" id="miTable" style="width:100%;color:black;">
                    <thead>
                      <tr>
                        <th style="color:rgb(0, 0, 0);">Dental Services</th>
                        <th style="color:rgb(0, 0, 0);">Male</th>
                        <th style="color:rgb(0, 0, 0);">Female</th>
                        <th style="color:rgb(0, 0, 0);">Total</th>
                      </tr>
                    </thead>
                    <?php
                      $remarksMap = [
                        'TOOTH EXTRACTION' => 'Tooth Extraction',
                        'CAVITY FILLING' => 'Oral Restoration',
                        'ORAL PROPHYLAXIS' => 'Oral Prophylaxis',
                        'DENTAL CHECK-UP' => 'Consultation',
                        'PROVISION OF OTC MEDICINE' => 'OTC Medicine',
                        'ISSUANCE OF DENTAL CERTIFICATE' => 'Dental Certificate'
                      ];
                  
                      $genders = ['Male', 'Female'];
                      $totals = ['Male' => 0, 'Female' => 0];
                    ?>
                    <tbody>
                      @foreach ($dental_services as $service)
                      <?php
                        $serviceRemark = $remarksMap[$service];
                        $counts = [];
                      
                        foreach ($genders as $gender) {
                          $count = DB::connection('mysql')
                            ->table('treatmentrecord')
                            ->whereJsonContains('remarks', [$serviceRemark])
                            ->where('campus', session('campus'))
                            ->where('gender', '=', $gender)
                            ->whereYear('date', '=', $year)
                            ->whereMonth('date', '=', $month)
                            ->whereNull('deleted_at')
                            ->count();
                          
                          $counts[$gender] = $count;
                          $totals[$gender] += $count;
                        }
                  
                        $totalService = array_sum($counts);
                      ?>
                      <tr>
                        <td style="text-align:left;">{{$service}}</td>
                        <td>{{$counts['Male']}}</td>
                        <td>{{$counts['Female']}}</td>
                        <td>{{$totalService}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <td style="color:rgb(0, 0, 0);">Total</td>
                        <td style="color:rgb(0, 0, 0);">{{ $totals['Male'] }}</td>
                        <td style="color:rgb(0, 0, 0);">{{ $totals['Female'] }}</td>
                        <td style="color:rgb(0, 0, 0);">{{ array_sum($totals) }}</td>
                      </tr>
                    </tfoot>
                  </table>    
                </div><br>
                <div style="font-weight: 600; font-size: 20px; text-align: left">
                  &emsp;Prepared by: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Noted by: <br><br><br>
                  <div style=" flex-direction: column;">
                      <input class="col-6 cert111" name="" type="text" value="{{$preparedby->FirstName ?? ''}} {{$preparedby->MiddleName ?? ''}} {{$preparedby->LastName ?? ''}} " placeholder="please input signatories"> &emsp;&emsp;<input class="col-5 cert111" name="" type="text" value="{{$noted->FirstName ?? ''}} {{$noted->MiddleName ?? ''}} {{$noted->LastName ?? ''}}" placeholder="please input signatories">
                      <input class="col-6 cert111" name="" type="text" value="{{$preparedby->EmploymentStatus ?? ''}},Dental Assistant" placeholder="please input signatories"> &emsp;&emsp;<input class="col-5 cert111" name="" type="text" value="{{$noted->Designation ?? ''}},{{$noted->Office ?? ''}}" placeholder="please input signatories">
                      <div class="row col-md-12">
                        &nbsp;&nbsp;&nbsp;Date: <input class="col-2 cert" name="" type="text" value="">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;Date:<input class="col-2 cert" name="" type="text" value=""> 
                      </div>
                  </div> 
                </div>
                {{-- <div style="display: flex; justify-content: space-between; font-weight: 600; font-size: 20px;">
                  <div style="text-align: left; flex: 1;">
                    Prepared by: <br><br><br>
                    <div style="flex-direction: column;">
                      <input class="col-6 cert111" name="" type="text" value="{{$preparedby->FirstName ?? 'please input signatories'}} {{$preparedby->MiddleName ?? ''}} {{$preparedby->LastName ?? ''}} "  placeholder="please input signatories" style="text-decoration:underline;text-decoration-thickness: 1px;"><br>
                      <input class="col-6 cert111" name="" type="text" value="{{$preparedby->EmploymentStatus ?? ''}},Dental Assistant" placeholder="please input signatories">
                      <div style="margin-top: 20px;">
                        <input name="" type="text" value="">
                        <span style="margin-left: auto;"></span>
                        <input name="" type="text" value="">
                      </div>
                    </div>
                  </div>
                  <div style=" flex: 1;">
                    Noted by: <br><br><br>
                    <div style="flex-direction: column;">
                      <input class="col-6 cert111" name="" type="text" value="{{$noted->FirstName ?? 'please input signatories'}} {{$noted->MiddleName ?? ''}} {{$noted->LastName ?? ''}}" style="text-decoration:underline;text-decoration-thickness: 1px;" placeholder="please input signatories"><br>
                      <input class="col-6 cert111" name="" type="text" value="{{$noted->Designation ?? ''}},{{$noted->Office ?? ''}}" placeholder="please input signatories">
                      <div style="margin-top: 20px;">
                        <input name="" type="text" value="">
                        <span style="margin-left: auto;"></span>
                        <input name="" type="text" value="">
                      </div>
                    </div>
                  </div>
                </div> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-1">
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