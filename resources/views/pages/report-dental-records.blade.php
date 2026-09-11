@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','MSMIS')

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
   margin: 5mm 10mm 5mm 10mm;  
   font-family: Cambria;
   size: Auto;
 }
</style>
@endsection
{{-- page-styles --}}
@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row" >
    <div class="col-md-11">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
        {{-- <div class="card-header" style="font-weight: bold;color:white;background-color: rgb(110, 155, 222);">VIEW RECORDS</div> --}}
          <div class ="card-body">
            <div style="text-align: center;text-transform: capitalize">
              <h5>MONTHLY ACCOMPLISHMENT REPORT</h5>
              <h6>(MEDICAL SERVICES)</h6><br>
              <h6>{{$monthName }} {{$year}}</h6>
            </div>            
            <div class="table-responsive">
              <table class="table studentsTable table-bordered table-striped" id="miTable" style="width:100%">
                <thead>
                  <tr>
                    <th style="color:white;">Medical Services</th>
                    <th colspan="2" style="color:white;">Student</th>
                    <th colspan="2" style="color:white;">Faculty & Staff</th>
                    <th colspan="2" style="color:white;">Total</th>
                    <th style="color:white;">Frequency of Delivery</th>
                    <th style="color:white;">%</th>
                  </tr>
                </thead>
                <thead>
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
                  @foreach ($dental_services as $service)
                  <tr>
                    <td style="text-align:left;">{{$service}} </td>
                    <td>
                      @if ($service === 'TOOTH EXTRACTION')
                        <?php
                        $studentTE = DB::connection('mysql')->table('treatmentrecord')->whereJsonContains('remarks', ['Tooth Extraction'])->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $studentTE }}
                        @elseif ($service === 'CAVITY FILLING')
                        <?php
                        $studentCF = DB::connection('mysql')->table('treatmentrecord')->whereJsonContains('remarks', ['Oral Restoration'])->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $studentCF }}
                        @elseif ($service === 'ORAL PROPHYLAXIS')
                        <?php
                        $studentOP = DB::connection('mysql')->table('treatmentrecord')->whereJsonContains('remarks', ['Oral Prophylaxis'])->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                          {{ $studentOP }}
                        @elseif ($service === 'DENTAL CHECK-UP')
                        <?php
                        $studentDC = DB::connection('mysql')->table('treatmentrecord')->whereJsonContains('remarks', ['Consultation'])->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $studentDC }}
                        @elseif ($service === 'PROVISION OF OTC MEDICINE')
                        <?php
                        $studentOTC = DB::connection('mysql')->table('otc_medicine')->where('purpose', '=', 'OTC Medicine')->where('role', '=', 'Student')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->count();
                        ?>
                        {{ $studentOTC }}
                      @endif</td> 
                      <td > 
                        @if ($service === 'TOOTH EXTRACTION')
                        <?php
                        $employeeTE = DB::connection('mysql')->table('treatmentrecord')->whereJsonContains('remarks', ['Tooth Extraction'])->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $employeeTE }}
                        @elseif ($service === 'CAVITY FILLING')
                        <?php
                        $employeeCF = DB::connection('mysql')->table('treatmentrecord')->whereJsonContains('remarks', ['Oral Restoration'])->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                       {{ $employeeCF }}
                       @elseif ($service === 'ORAL PROPHYLAXIS')
                       <?php
                       $employeeOP = DB::connection('mysql')->table('treatmentrecord')->whereJsonContains('remarks', ['Oral Prophylaxis'])->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                       ?>
                        {{ $employeeOP }}
                        @elseif ($service === 'DENTAL CHECK-UP')
                        <?php
                        $employeeDC = DB::connection('mysql')->table('treatmentrecord')->whereJsonContains('remarks', ['Consultation'])->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $employeeDC }}
                        @elseif ($service === 'PROVISION OF OTC MEDICINE')
                        <?php
                        $employeeOTC = DB::connection('mysql')->table('otc_medicine')->where('purpose', '=', 'OTC Medicine')->where('role', '=', 'Employee')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->count();
                        ?>
                        {{ $employeeOTC }}
                        @endif</td>
                        <td > 
                          @if ($service === 'TOOTH EXTRACTION')
                          <?php
                          $dependentTE = DB::connection('mysql')->table('treatmentrecord')->whereJsonContains('remarks', ['Tooth Extraction'])->where('role', '=', 'Dependent')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                          ?>
                          {{ $dependentTE }}
                          @elseif ($service === 'CAVITY FILLING')
                          <?php
                          $dependentCF = DB::connection('mysql')->table('treatmentrecord')->whereJsonContains('remarks', ['Oral Restoration'])->where('role', '=', 'Dependent')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                          ?>
                          {{ $dependentCF }}
                          @elseif ($service === 'ORAL PROPHYLAXIS')
                          <?php
                          $dependentOP = DB::connection('mysql')->table('treatmentrecord')->whereJsonContains('remarks', ['Oral Prophylaxis'])->where('role', '=', 'Dependent')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                          ?>
                          {{ $dependentOP }}
                          @elseif ($service === 'DENTAL CHECK-UP')
                          <?php
                          $dependentDC = DB::connection('mysql')->table('treatmentrecord')->whereJsonContains('remarks', ['Consultation'])->where('role', '=', 'Dependent')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                          ?>
                          {{ $dependentDC}}
                          @elseif ($service === 'PROVISION OF OTC MEDICINE')
                          <?php
                          $dependentOTC = DB::connection('mysql')->table('otc_medicine')->where('purpose', '=', 'OTC Medicine')->where('role', '=', 'Dependent')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->count();
                          ?>
                        {{ $dependentOTC }}
                     @endif</td>
                      <td > 
                        @if ($service === 'TOOTH EXTRACTION')
                        <?php
                        $totalTE =  $studentTE + $employeeTE + $dependentTE;
                        ?>
                        {{ $totalTE }}
                        @elseif ($service === 'CAVITY FILLING')
                        <?php
                        $totalCF = $studentCF + $employeeCF + $dependentCF ;
                        ?>
                        {{ $totalCF }}
                        @elseif ($service === 'ORAL PROPHYLAXIS')
                        <?php
                        $totalOP = $studentOP + $employeeOP + $dependentOP;
                        ?>
                          {{ $totalOP }}
                          @elseif ($service === 'DENTAL CHECK-UP')
                          <?php
                        $totalDC = $studentDC + $employeeDC + $dependentDC;
                        ?>
                        {{ $totalDC }}
                        @elseif ($service === 'PROVISION OF OTC MEDICINE')
                        <?php
                        $totalOTC = $studentOTC + $employeeOTC + $dependentOTC;
                        ?>
                      {{ $totalOTC }}
                      @endif</td>
                  </tr>
                  @endforeach
                </tbody>  
                <tfoot>
                  <tr>
                    <td style="color:white;">Total</td>
                    <td style="color:white;">{{ $MaleS }}</td>
                    <td style="color:white;">{{ $FemaleS }}</td>
                    <td style="color:white;">{{ $MaleE }}</td>
                    <td style="color:white;">{{ $FemaleE }}</td>
                    <td style="color:white;">{{ $TotalM }}</td>
                    <td style="color:white;"> {{ $TotalF }}</td>
                    <td style="color:white;">{{ $totalAll}}</td>
                    <td style="color:white;">
                    <?php
                      $genderT = $TotalM + $TotalF;
                      $total = $genderT  / $totalAll * 100;
                      $formattedTotalTotal = number_format($total, 2) . '%'
                     ?>
                     {{ $formattedTotalTotal }}</td>
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
{{--  --}}
  <div class="row justify-content-center" style="display:none" >
      <div class="col-md-8">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
        {{-- <div class="card-header" style="font-weight: bold;color:white;background-color: rgb(110, 155, 222);">VIEW RECORDS</div> --}}
          <div class ="card-body">
            <div id="printThis">
              <div class="row printed-div  d-flex justify-content-left">
                <div class="col-xl-8  col-lg-6 col-md-5 col-sm-5 d-flex justify-content-center"><img src="{{asset('images/logo/letter-SLSU-head.png')}}" style="width: 580px; height: 150px;"></div>
                  <div class="col-xl-3 col-lg-6 col-md-7 col-sm-6"><br>
                    <div class="row">
                      &emsp;&emsp;&emsp;&emsp;&emsp; <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;" >MAIN CAMPUS</div>
                    </div>
                    <div class="row">
                      &emsp;&emsp;&emsp;&emsp;&emsp; <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;">San Roque, Sogod, Southern Leyte</div>
                    </div>
                    <div class="row">
                      &emsp;&emsp;&emsp;&emsp;&emsp;<div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;">Email:&nbsp; <a href="#" >president@southernleytestateu.edu.ph</a> </div>
                    </div>
                    <div class="row">
                      &emsp;&emsp;&emsp;&emsp;&emsp;<div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;">Website:&nbsp; <a href="#" >www.southernleytestateu.edu.ph</a></div>
                    </div>
                  </div>
              </div><br><br><br><br><br><br>
              <div class="row">
                <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 13px; border-bottom: 1px solid black; text-align:center">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
              </div><br>
              <div class="row">
                <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 600; font-size: 23px; font-style: bold; text-align:center">MONTHLY ACCOMPLISHMENT REPORT</div>
                <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 600; font-size: 20px; font-style: bold; text-align:center">(MEDICAL SERVICES)</div>
              </div>   
              <br> 
              <div class="row">
                <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 600; font-size: 20px; font-style: bold; text-align:center;text-transform:capitalize">{{$monthName }} {{$year}}</div>
              </div> 
              <br>        
            <div class="table-responsive">
              <table class="table table-sm studentsTable table-bordered table-striped" id="miTable" style="font-size: 20px;width:100%;border-spacing: 10px;">
                <thead>
                  <tr>
                    <th class="border" style="font-weight: 400;font-size: 18px;color:rgb(0, 0, 0);">Medical Services</th>
                    <th colspan="2" style="font-weight: 400;font-size: 18px;color:rgb(0, 0, 0);">Student</th>
                    <th colspan="2" style="font-weight: 400;font-size: 18px;color:rgb(0, 0, 0);">Faculty & Staff</th>
                    <th colspan="2" style="font-weight: 400;font-size: 18px;color:rgb(0, 0, 0);">Total</th>
                    <th style="text-transform:capitalize;font-weight: 400;font-size: 18px;width:10%;color:rgb(0, 0, 0);">Frequency of Delivery</th>
                    <th style="font-weight: 400;font-size: 18px;color:rgb(0, 0, 0);">%</th>
                  </tr>
                </thead>
                <thead>
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
                  @foreach ($medical_services as $service)
                  <tr>
                    <td style="text-align:left;padding: 15px;">{{$service}} </td>
                    <td >
                      @if ($service === '1. Provision of OTC Medicines')
                        <?php
                          $maleOS = DB::table('medicalrecord')->where('gender', '=', 'Male')->where('purpose', '=', 'OTC Medicine')->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $maleOS }}
                        @elseif ($service === '2. Physical Assessment')
                        <?php
                        $malePS = DB::table('medicalrecord')->where('purpose', '=', 'Physical Assessment')->where('gender', '=', 'Male')->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $malePS }}
                        @elseif ($service === '3. Consultation')
                        <?php
                        $maleCS = DB::table('medicalrecord')->where('purpose', '=', 'Consultation')->where('gender', '=', 'Male')->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                          {{ $maleCS }}
                        @elseif ($service === '4. Wound Dressing')
                        <?php
                        $maleWS = DB::table('medicalrecord')->where('purpose', '=', 'Wound Dressing')->where('gender', '=', 'Male')->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $maleWS }}
                        @elseif ($service === '5. Issuance of Certificate')
                        <?php
                        $maleIS = DB::table('medicalcert')->where('purpose', '=', 'Issuance of Certificate')->where('gender', '=', 'Male')->where('role', '=', 'Student')->whereYear('generated_at', '=', $year)->whereMonth('generated_at', '=', $month)->count();
                        ?>
                        {{ $maleIS }}
                        @elseif ($service === '6. Blood Pressure')
                          <?php
                          $maleBS = DB::table('medicalrecord')->where('purpose', '=', 'Blood Pressure')->where('gender', '=', 'Male')->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                          ?>
                        {{ $maleBS }}
                        @elseif ($service === '7. Referral')
                          <?php
                          $maleRS = DB::table('referral')->where('purpose', '=', 'Referral')->where('gender', '=', 'Male')->where('role', '=', 'Student')->whereYear('generated_at', '=', $year)->whereMonth('generated_at', '=', $month)->count();
                          ?>
                        {{ $maleRS }}
                        @elseif ($service === '8. Provision of Comfort')
                        <?php
                        $malePCS = DB::table('medicalrecord')->where('purpose', '=', 'Provision of Comfort')->where('gender', '=', 'Male')->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $malePCS }}
                        @elseif ($service === '9. Other Concerns')
                        <?php
                        $maleOCS = DB::table('medicalrecord')->where('purpose', '=', 'Other Concerns')->where('gender', '=', 'Male')->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $maleOCS }}
                      @endif</td>
                    <td > 
                      @if ($service === '1. Provision of OTC Medicines')
                      <?php
                      $femaleOS = DB::table('medicalrecord')->where('purpose', '=', 'OTC Medicine')->where('gender', '=', 'Female')->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                      ?>
                      {{ $femaleOS }}
                      @elseif ($service === '2. Physical Assessment')
                      <?php
                      $femalePS = DB::table('medicalrecord')->where('purpose', '=', 'Physical Assessment')->where('gender', '=', 'Female')->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                      ?>
                       {{ $femalePS }}
                       @elseif ($service === '3. Consultation')
                       <?php
                       $femaleCS = DB::table('medicalrecord')->where('purpose', '=', 'Consultation')->where('gender', '=', 'Female')->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                       ?>
                        {{ $femaleCS }}
                      @elseif ($service === '4. Wound Dressing')
                       <?php
                       $femaleWS = DB::table('medicalrecord')->where('purpose', '=', 'Wound Dressing')->where('gender', '=', 'Female')->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                       ?>
                      {{ $femaleWS }}
                      @elseif ($service === '5. Issuance of Certificate')
                      <?php
                      $femaleIS = DB::table('medicalcert')->where('purpose', '=', 'Issuance of Certificate')->where('gender', '=', 'Female')->where('role', '=', 'Student')->whereYear('generated_at', '=', $year)->whereMonth('generated_at', '=', $month)->count();
                      ?>
                      {{ $femaleIS }}
                      @elseif ($service === '6. Blood Pressure')
                        <?php
                        $femaleBS = DB::table('medicalrecord')->where('purpose', '=', 'Blood Pressure')->where('gender', '=', 'Female')->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                      {{ $femaleBS }}
                      @elseif ($service === '7. Referral')
                        <?php
                        $femaleRS = DB::table('referral')->where('purpose', '=', 'Referral')->where('gender', '=', 'Female')->where('role', '=', 'Student')->whereYear('generated_at', '=', $year)->whereMonth('generated_at', '=', $month)->count();
                        ?>
                      {{ $femaleRS }}
                      @elseif ($service === '8. Provision of Comfort')
                      <?php
                      $femalePCS = DB::table('medicalrecord')->where('purpose', '=', 'Provision of Comfort')->where('gender', '=', 'Female')->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                      ?>
                      {{ $femalePCS }}
                      @elseif ($service === '9. Other Concerns')
                      <?php
                      $femaleOCS = DB::table('medicalrecord')->where('purpose', '=', 'Other Concerns')->where('gender', '=', 'Female')->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                      ?>
                      {{ $femaleOCS }}
                      @endif</td>
                    <td > 
                      @if ($service === '1. Provision of OTC Medicines')
                      <?php
                      $maleOE = DB::table('medicalrecord')->where('purpose', '=', 'OTC Medicine')->where('gender', '=', 'Male')->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                      ?>
                      {{ $maleOE }}
                      @elseif ($service === '2. Physical Assessment')
                      <?php
                      $malePE = DB::table('medicalrecord')->where('purpose', '=', 'Physical Assessment')->where('gender', '=', 'Male')->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                      ?>
                       {{ $malePE }}
                       @elseif ($service === '3. Consultation')
                       <?php
                       $maleCE = DB::table('medicalrecord')->where('purpose', '=', 'Consultation')->where('gender', '=', 'Male')->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                       ?>
                        {{ $maleCE }}
                        @elseif ($service === '4. Wound Dressing')
                        <?php
                        $maleWE = DB::table('medicalrecord')->where('purpose', '=', 'Wound Dressing')->where('gender', '=', 'Male')->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $maleWE }}
                        @elseif ($service === '5. Issuance of Certificate')
                        <?php
                        $maleIE = DB::table('medicalcert')->where('purpose', '=', 'Issuance of Certificate')->where('gender', '=', 'Male')->where('role', '=', 'Employee')->whereYear('generated_at', '=', $year)->whereMonth('generated_at', '=', $month)->count();
                        ?>
                      {{ $maleIE }}
                      @elseif ($service === '6. Blood Pressure')
                        <?php
                        $maleBE = DB::table('medicalrecord')->where('purpose', '=', 'Blood Pressure')->where('gender', '=', 'Male')->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                      {{ $maleBE }}
                      @elseif ($service === '7. Referral')
                        <?php
                        $maleRE = DB::table('referral')->where('purpose', '=', 'Referral')->where('gender', '=', 'Male')->where('role', '=', 'Employee')->whereYear('generated_at', '=', $year)->whereMonth('generated_at', '=', $month)->count();
                        ?>
                      {{ $maleRE }}
                      @elseif ($service === '8. Provision of Comfort')
                      <?php
                      $malePCE = DB::table('medicalrecord')->where('purpose', '=', 'Provision of Comfort')->where('gender', '=', 'Male')->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                      ?>
                      {{ $malePCE }}
                      @elseif ($service === '9. Other Concerns')
                      <?php
                      $maleOCE = DB::table('medicalrecord')->where('purpose', '=', 'Other Concerns')->where('gender', '=', 'Male')->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                      ?>
                      {{ $maleOCE }}
                      @endif</td>
                    <td > 
                      @if ($service === '1. Provision of OTC Medicines')
                      <?php
                      $femaleOE = DB::table('medicalrecord')->where('purpose', '=', 'OTC Medicine')->where('gender', '=', 'Female')->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                      ?>
                      {{ $femaleOE }}
                      @elseif ($service === '2. Physical Assessment')
                      <?php
                      $femalePE = DB::table('medicalrecord')->where('purpose', '=', 'Physical Assessment')->where('gender', '=', 'Female')->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                      ?>
                       {{ $femalePE }}
                       @elseif ($service === '3. Consultation')
                       <?php
                       $femaleCE = DB::table('medicalrecord')->where('purpose', '=', 'Consultation')->where('gender', '=', 'Female')->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                       ?>
                        {{ $femaleCE }}
                      @elseif ($service === '4. Wound Dressing')
                       <?php
                       $femaleWE = DB::table('medicalrecord')->where('purpose', '=', 'Wound Dressing')->where('gender', '=', 'Female')->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                       ?>
                        {{ $femaleWE}}
                        @elseif ($service === '5. Issuance of Certificate')
                        <?php
                        $femaleIE = DB::table('medicalcert')->where('purpose', '=', 'Issuance of Certificate')->where('gender', '=', 'Female')->where('role', '=', 'Employee')->whereYear('generated_at', '=', $year)->whereMonth('generated_at', '=', $month)->count();
                        ?>
                      {{ $femaleIE }}
                      @elseif ($service === '6. Blood Pressure')
                        <?php
                        $femaleBE = DB::table('medicalrecord')->where('purpose', '=', 'Blood Pressure')->where('gender', '=', 'Female')->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                      {{ $femaleBE }}
                      @elseif ($service === '7. Referral')
                        <?php
                        $femaleRE = DB::table('referral')->where('purpose', '=', 'Referral')->where('gender', '=', 'Female')->where('role', '=', 'Employee')->whereYear('generated_at', '=', $year)->whereMonth('generated_at', '=', $month)->count();
                        ?>
                      {{ $femaleRE }}
                      @elseif ($service === '8. Provision of Comfort')
                      <?php
                      $femalePCE = DB::table('medicalrecord')->where('purpose', '=', 'Provision of Comfort')->where('gender', '=', 'Female')->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                      ?>
                      {{ $femalePCE }}
                      @elseif ($service === '9. Other Concerns')
                      <?php
                      $femaleOCE = DB::table('medicalrecord')->where('purpose', '=', 'Other Concerns')->where('gender', '=', 'Female')->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                      ?>
                      {{ $femaleOCE }}
                      @endif</td>
                    <td >
                      @if ($service === '1. Provision of OTC Medicines')
                      <?php
                      $totalOM =  $maleOS + $maleOE;
                      ?>
                      {{ $totalOM }}
                      @elseif ($service === '2. Physical Assessment')
                      <?php
                      $totalPM =  $malePS + $malePE;
                      ?>
                       {{ $totalPM }}
                       @elseif ($service === '3. Consultation')
                       <?php
                      $totalCM =  $maleCS + $maleCE;
                       ?>
                        {{ $totalCM }}
                      @elseif ($service === '4. Wound Dressing')
                       <?php
                      $totalWM =  $maleWS + $maleWE;
                       ?>
                        {{ $totalWM }}
                        @elseif ($service === '5. Issuance of Certificate')
                        <?php
                      $totalIM =  $maleIS + $maleIE;
                        ?>
                      {{ $totalIM }}
                      @elseif ($service === '6. Blood Pressure')
                        <?php
                      $totalBM =  $maleBS + $maleBE;
                        ?>
                      {{ $totalBM }}
                      @elseif ($service === '7. Referral')
                        <?php
                      
                      $totalRM =  $maleRS + $maleRE;
                        ?>
                      {{ $totalRM }}
                      @elseif ($service === '8. Provision of Comfort')
                      <?php
                      $totalPCM =  $malePCS + $malePCE;
                      ?>
                      {{ $totalPCM }}
                      @elseif ($service === '9. Other Concerns')
                      <?php
                      $totalOCM = $maleOCS + $maleOCE;
                      ?>
                      {{ $totalOCM }}
                      @endif</td>
                    <td >
                      @if ($service === '1. Provision of OTC Medicines')
                      <?php
                      $totalOF =  $femaleOS + $femaleOE;
                      ?>
                      {{ $totalOF }}
                      @elseif ($service === '2. Physical Assessment')
                      <?php
                    
                      $totalPF =  $femalePS + $femalePE;
                      ?>
                       {{ $totalPF }}
                       @elseif ($service === '3. Consultation')
                       <?php
                    
                      $totalCF =  $femaleCS + $femaleCE;
                       ?>
                        {{ $totalCF }}
                      @elseif ($service === '4. Wound Dressing')
                       <?php
                    
                      $totalWF =  $femaleWS + $femaleWE;
                       ?>
                        {{ $totalWF }}
                        @elseif ($service === '5. Issuance of Certificate')
                        <?php
                    
                      $totalIF =  $femaleIS + $femaleIE;
                        ?>
                      {{ $totalIF }}
                      @elseif ($service === '6. Blood Pressure')
                        <?php
                      
                      $totalBF =  $femaleBS + $femaleBE;
                        ?>
                      {{ $totalBF }}
                      @elseif ($service === '7. Referral')
                        <?php
                      
                      $totalRF =  $femaleRS + $femaleRE;
                        ?>
                      {{ $totalRF }}
                      @elseif ($service === '8. Provision of Comfort')
                      <?php
                   
                      $totalPCF =  $femalePCS + $femalePCE;
                      ?>
                      {{ $totalPCF }}
                      @elseif ($service === '9. Other Concerns')
                      <?php
                      $totalOCF =  $femaleOCS + $femaleOCE;
                      ?>
                      {{ $totalOCF }}
                      @endif</td>
                    <td >
                      @if ($service === '1. Provision of OTC Medicines') <?php
                      $totalO =  $maleOS + $maleOE +  $femaleOS + $femaleOE;
                      ?>
                      {{ $totalO }}
                      @elseif ($service === '2. Physical Assessment')
                      <?php
                      $totalP =  $malePS + $malePE +  $femalePS + $femalePE;
                      ?>
                       {{ $totalP }}
                       @elseif ($service === '3. Consultation')
                       <?php
                        $totalC =  $maleCS + $maleCE +  $femaleCS + $femaleCE;
                       ?>
                        {{ $totalC }}
                      @elseif ($service === '4. Wound Dressing')
                       <?php
                       $totalW =  $maleWS + $maleWE +  $femaleWS + $femaleWE;
                       ?>
                        {{ $totalW }}
                        @elseif ($service === '5. Issuance of Certificate')
                        <?php
                        $totalI =  $maleIS + $maleIE +  $femaleIS + $femaleIE;
                        ?>
                      {{ $totalI }}
                      @elseif ($service === '6. Blood Pressure')
                        <?php
                      $totalB =  $maleBS + $maleBE +  $femaleBS + $femaleBE;
                        ?>
                      {{ $totalB }}
                      @elseif ($service === '7. Referral')
                        <?php
                        $totalR =  $maleRS + $maleRE +  $femaleRS + $femaleRE;
                        ?>
                      {{ $totalR }}
                      @elseif ($service === '8. Provision of Comfort')
                      <?php
                        $totalPC =  $malePCS + $malePCE +  $femalePCS + $femalePCE;
                      ?>
                      {{ $totalPC }}
                      @elseif ($service === '9. Other Concerns')
                      <?php
                      $totalOC =  $maleOCS + $maleOCE +  $femaleOCS + $femaleOCE;
                      ?>
                      {{ $totalOC }}
                      @endif</td>
                    <td >
                      @if ($service === '1. Provision of OTC Medicines') 
                      <?php
                      $total = $totalO  / $totalAll * 100;
                      $formattedTotalO = number_format($total, 2) . '%'
                      ?>
                    
                      {{ $formattedTotalO }}
                      @elseif ($service === '2. Physical Assessment')
                      <?php
                       $total = $totalP  / $totalAll * 100;
                      $formattedTotalP = number_format($total, 2) . '%'
                      ?>
                       {{ $formattedTotalP }}
                       @elseif ($service === '3. Consultation')
                       <?php
                        $total = $totalC / $totalAll * 100;
                        $formattedTotalC = number_format($total, 2) . '%'
                       ?>
                        {{ $formattedTotalC }}
                      @elseif ($service === '4. Wound Dressing')
                       <?php
                       $total = $totalW  / $totalAll * 100;
                      $formattedTotalW = number_format($total, 2) . '%'
                       ?>
                        {{ $formattedTotalW }}
                        @elseif ($service === '5. Issuance of Certificate')
                        <?php
                       $total = $totalI  / $totalAll * 100;
                      $formattedTotalI = number_format($total, 2) . '%'
                        ?>
                      {{ $formattedTotalI }}
                      @elseif ($service === '6. Blood Pressure')
                        <?php
                        $total = $totalB  / $totalAll * 100;
                        $formattedTotalB = number_format($total, 2) . '%'
                        ?>
                      {{ $formattedTotalB }}
                      @elseif ($service === '7. Referral')
                        <?php
                        $total = $totalR  / $totalAll * 100;
                        $formattedTotalR = number_format($total, 2) . '%'
                        ?>
                      {{ $formattedTotalR }}
                      @elseif ($service === '8. Provision of Comfort')
                      <?php
                        $total = $totalPC  / $totalAll * 100;
                        $formattedTotalPC = number_format($total, 2) . '%'
                      ?>
                      {{ $formattedTotalPC }}
                      @elseif ($service === '9. Other Concerns')
                      <?php
                       $total = $totalOC  / $totalAll * 100;
                       $formattedTotalOC = number_format($total, 2) . '%'
                      ?>
                      {{ $formattedTotalOC }}
                      @endif</td>
                  
                  </tr>
                  @endforeach
                </tbody>  
                <tfoot>
                  <tr>
                    <td style="color:rgb(0, 0, 0);padding: 15px;">Total</td>
                    <td style="color:rgb(7, 6, 6);">{{ $MaleS }}</td>
                    <td style="color:rgb(0, 0, 0), 0, 0);">{{ $FemaleS }}</td>
                    <td style="color:rgb(0, 0, 0);">{{ $MaleE }}</td>
                    <td style="color:rgb(1, 1, 1);">{{ $FemaleE }}</td>
                    <td style="color:rgb(0, 0, 0);">{{ $TotalM }}</td>
                    <td style="color:rgb(0, 0, 0);"> {{ $TotalF }}</td>
                    <td style="color:rgb(0, 0, 0);">{{ $totalAll}}</td>
                    <td style="color:rgb(0, 0, 0);"><?php
                      $genderT = $TotalM + $TotalF;
                      $total = $genderT  / $totalAll * 100;
                      $formattedTotalTotal = number_format($total, 2) . '%'
                     ?>
                     {{ $formattedTotalTotal }}</td>
                  </tr>
                </tfoot>
              </table>   
            </div>
            <div style="font-weight: 600; font-style: italic; font-size: 22px; text-align: center; padding: 0; margin-top: 0;">
              Frequency of Delivery of Medical Services
            </div>          
            <br><br><br><br><br><br><br>
            <div style="font-weight: 600; font-size: 20px; text-align: left">
              Prepared: &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Noted: <br><br><br><br><br>
              <div style=" flex-direction: column;">
                  <input class="" name="" type="text" value="MARIA EMELEE A. BASCUG, RN, MAN"> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="" name="" type="text" value="GRETTA D. GUIROY, DDM">
                  <input class="" name="" type="text" value="Nurse II"> &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="" name="" type="text" value="Director, Health Services">
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