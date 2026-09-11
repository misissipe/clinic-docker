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
            <div style="text-transform: capitalize; font-style: italic;">
              <h6>Office of Health Services</h6>
            </div>
            <div style="text-align: center;">
              <h5>PROFILE OF PATIENTS GIVEN DENTAL SERVICES</h5>
              <h6>(DENTAL SERVICES)</h6><br>
              <h6>{{$monthName }} {{$year}}</h6>
            </div>            
            <div class="table-responsive">
              <table class="table studentsTable table-bordered table-striped" id="miTable" style="width:100%">
                <thead>
                  <tr>
                    <th style="color:white;">Dental Services</th>
                    <th style="color:white;">Student</th>
                    <th style="color:white;">Employee</th>
                    <th style="color:white;">Dependent</th>
                    <th style="color:white;">Total</th>
                  </tr>
                </thead>
                {{-- <thead>
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
                </thead> --}}
                <tbody>
                  @foreach ($dental_services as $service)
                  <tr>
                    <td style="text-align:left;">{{$service}} </td>
                    <td>
                      @if ($service === 'TOOTH EXTRACTION')
                        <?php
                        $studentTE = DB::connection('mysql')
                        ->table('treatmentrecord')->whereJsonContains('remarks', ['Tooth Extraction'])->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $studentTE }}
                        @elseif ($service === 'CAVITY FILLING')
                        <?php
                        $studentCF = DB::connection('mysql')
                        ->table('treatmentrecord')->whereJsonContains('remarks', ['Oral Restoration'])->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $studentCF }}
                        @elseif ($service === 'ORAL PROPHYLAXIS')
                        <?php
                        $studentOP = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Oral Prophylaxis'])->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                          {{ $studentOP }}
                        @elseif ($service === 'DENTAL CHECK-UP')
                        <?php
                        $studentDC = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Consultation'])->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $studentDC }}
                        @elseif ($service === 'PROVISION OF OTC MEDICINE')
                        <?php
                        $studentOTC = DB::table('otc_medicine')->where('purpose', '=', 'OTC Medicine')->where('role', '=', 'Student')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->count();
                        ?>
                        {{ $studentOTC }}
                      @endif</td> 
                      <td > 
                        @if ($service === 'TOOTH EXTRACTION')
                        <?php
                        $employeeTE = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Tooth Extraction'])->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $employeeTE }}
                        @elseif ($service === 'CAVITY FILLING')
                        <?php
                        $employeeCF = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Oral Restoration'])->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                       {{ $employeeCF }}
                       @elseif ($service === 'ORAL PROPHYLAXIS')
                       <?php
                       $employeeOP = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Oral Prophylaxis'])->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                       ?>
                        {{ $employeeOP }}
                        @elseif ($service === 'DENTAL CHECK-UP')
                        <?php
                        $employeeDC = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Consultation'])->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $employeeDC }}
                        @elseif ($service === 'PROVISION OF OTC MEDICINE')
                        <?php
                        $employeeOTC = DB::table('otc_medicine')->where('purpose', '=', 'OTC Medicine')->where('role', '=', 'Employee')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->count();
                        ?>
                        {{ $employeeOTC }}
                        @endif</td>
                        <td > 
                          @if ($service === 'TOOTH EXTRACTION')
                          <?php
                          $dependentTE = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Tooth Extraction'])->where('role', '=', 'Dependent')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                          ?>
                          {{ $dependentTE }}
                          @elseif ($service === 'CAVITY FILLING')
                          <?php
                          $dependentCF = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Oral Restoration'])->where('role', '=', 'Dependent')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                          ?>
                          {{ $dependentCF }}
                          @elseif ($service === 'ORAL PROPHYLAXIS')
                          <?php
                          $dependentOP = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Oral Prophylaxis'])->where('role', '=', 'Dependent')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                          ?>
                          {{ $dependentOP }}
                          @elseif ($service === 'DENTAL CHECK-UP')
                          <?php
                          $dependentDC = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Consultation'])->where('role', '=', 'Dependent')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                          ?>
                          {{ $dependentDC}}
                          @elseif ($service === 'PROVISION OF OTC MEDICINE')
                          <?php
                          $dependentOTC = DB::table('otc_medicine')->where('purpose', '=', 'OTC Medicine')->where('role', '=', 'Dependent')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->count();
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
                    <td style="color:white;"> 
                    <?php
                      $totalS =  $studentTE + $studentCF + $studentOP + $studentDC + $studentOTC;
                      ?>
                      {{ $totalS }}
                    </td>
                    <td style="color:white;">
                      <?php
                      $totalE =  $employeeTE + $employeeCF + $employeeOP + $employeeDC + $employeeOTC;
                      ?>
                      {{ $totalE }}
                    </td>
                    <td style="color:white;">
                      <?php
                      $totalD =  $dependentTE + $dependentCF + $dependentOP + $dependentDC + $dependentOTC;
                      ?>
                      {{ $totalD }}
                    </td>
                    <td style="color:white;">
                      <?php
                      $totalAll = $totalS + $totalE +$totalD;
                      ?>
                      {{ $totalAll }}
                    </td>
                  </tr>
                </tfoot>
              </table>  
              <table class="table studentsTable table-bordered table-striped" id="miTable" style="width:100%">
                <thead>
                  <tr>
                    <th style="color:white;">Dental Services</th>
                    <th style="color:white;">Male</th>
                    <th style="color:white;">Female</th>
                    <th style="color:white;">Total</th>
                  </tr>
                </thead>
                {{-- <thead>
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
                </thead> --}}
                <tbody>
                  @foreach ($dental_services as $service)
                  <tr>
                    <td style="text-align:left;">{{$service}} </td>
                    <td>
                      @if ($service === 'TOOTH EXTRACTION')
                        <?php
                          $MTE = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Tooth Extraction'])->where('gender', '=', 'Male')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $MTE }}
                        @elseif ($service === 'CAVITY FILLING')
                        <?php
                        $MCF = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Oral Restoration'])->where('gender', '=', 'Male')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $MCF }}
                        @elseif ($service === 'ORAL PROPHYLAXIS')
                        <?php
                        $MOP = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Oral Prophylaxis'])->where('gender', '=', 'Male')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                          {{ $MOP }}
                        @elseif ($service === 'DENTAL CHECK-UP')
                        <?php
                        $MDC = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Consultation'])->where('gender', '=', 'Male')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $MDC }}
                        @elseif ($service === 'PROVISION OF OTC MEDICINE')
                        <?php
                        $MOTC =  DB::table('otc_medicine')->where('purpose', '=', 'OTC Medicine')->where('gender', '=', 'Male')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->count();
                        ?>
                        {{ $MOTC }}
                      @endif</td> 
                      <td > 
                        @if ($service === 'TOOTH EXTRACTION')
                        <?php
                        $FTE = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Tooth Extraction'])->where('gender', '=', 'Female')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $FTE }}
                        @elseif ($service === 'CAVITY FILLING')
                        <?php
                        $FCF = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Oral Restoration'])->where('gender', '=', 'Female')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                       {{ $FCF }}
                       @elseif ($service === 'ORAL PROPHYLAXIS')
                       <?php
                       $FOP = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Oral Prophylaxis'])->where('gender', '=', 'Female')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                       ?>
                        {{ $FOP }}
                        @elseif ($service === 'DENTAL CHECK-UP')
                        <?php
                        $FDC = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Consultation'])->where('gender', '=', 'Female')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $FDC }}
                        @elseif ($service === 'PROVISION OF OTC MEDICINE')
                        <?php
                        $FOTC = DB::table('otc_medicine')->where('purpose', '=', 'OTC')->where('gender', '=', 'Female')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->count();
                        ?>
                        {{ $FOTC }}
                        @endif</td>
                      <td > 
                        @if ($service === 'TOOTH EXTRACTION')
                        <?php
                        $GTE =  $MTE + $FTE ;
                        ?>
                        {{ $GTE }}
                        @elseif ($service === 'CAVITY FILLING')
                        <?php
                        $GCF = $MCF + $FCF  ;
                        ?>
                        {{ $GCF }}
                        @elseif ($service === 'ORAL PROPHYLAXIS')
                        <?php
                        $GOP = $MOP + $FOP ;
                        ?>
                          {{ $GOP }}
                          @elseif ($service === 'DENTAL CHECK-UP')
                          <?php
                        $GDC = $MDC + $FDC;
                        ?>
                        {{ $GDC }}
                        @elseif ($service === 'PROVISION OF OTC MEDICINE')
                        <?php
                        $GOTC = $MOTC + $FOTC;
                        ?>
                      {{ $GOTC }}
                      @endif</td>
                  </tr>
                  @endforeach
                </tbody>  
                <tfoot>
                  <tr>
                    <td style="color:white;">Total</td>
                    <td style="color:white;"> 
                    <?php
                      $totalM =  $MTE + $MCF + $MOP + $MDC + $MOTC;
                      ?>
                      {{ $totalM }}
                    </td>
                    <td style="color:white;">
                      <?php
                      $totalF =  $FTE + $FCF + $FOP + $FDC + $FOTC;
                      ?>
                      {{ $totalF }}
                    </td>
                    <td style="color:white;">
                      <?php
                      $totalAll= $totalF + $totalM ;
                      ?>
                      {{ $totalAll }}
                    </td>
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
                <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 13px; border-bottom: 1px solid black; text-align:center">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
              </div><br>
              <div class="row">
                <div class="col-lg-12 " style="font-weight: 400; font-size: 23px; font-style: italic;">Office of Health Services</div>
              </div> 
              <br>
              <div class="row">
                <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 600; font-size: 23px; font-style: bold; text-align:center">PROFILE OF PATIENTS GIVEN DENTAL SERVICES</div>
                <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 600; font-size: 20px; font-style: bold; text-align:center">(DENTAL SERVICES)</div>
              </div>   
              <br> 
              <div class="row">
                <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 600; font-size: 20px; font-style: bold; text-align:center;text-transform:capitalize">{{$monthName }} {{$year}}</div>
              </div> 
              <br>           
              <div class="table-responsive">
                <table class="table studentsTable table-bordered table-striped" id="miTable" style="width:100%">
                  <thead>
                    <tr>
                      <th style="color:rgb(0, 0, 0);">Dental Services</th>
                      <th style="color:rgb(0, 0, 0);">Student</th>
                      <th style="color:rgb(0, 0, 0);">Employee</th>
                      <th style="color:rgb(0, 0, 0);">Dependent</th>
                      <th style="color:rgb(0, 0, 0);">Total</th>
                    </tr>
                  </thead>
                  {{-- <thead>
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
                  </thead> --}}
                  <tbody>
                    @foreach ($dental_services as $service)
                    <tr>
                      <td style="text-align:left;">{{$service}} </td>
                      <td>
                        @if ($service === 'TOOTH EXTRACTION')
                          <?php
                          $studentTE = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Tooth Extraction'])->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                          ?>
                          {{ $studentTE }}
                          @elseif ($service === 'CAVITY FILLING')
                          <?php
                          $studentCF = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Oral Restoration'])->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                          ?>
                          {{ $studentCF }}
                          @elseif ($service === 'ORAL PROPHYLAXIS')
                          <?php
                          $studentOP = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Oral Prophylaxis'])->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                          ?>
                            {{ $studentOP }}
                          @elseif ($service === 'DENTAL CHECK-UP')
                          <?php
                          $studentDC = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Consultation'])->where('role', '=', 'Student')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                          ?>
                          {{ $studentDC }}
                          @elseif ($service === 'PROVISION OF OTC MEDICINE')
                          <?php
                          $studentOTC = DB::table('otc_medicine')->where('purpose', '=', 'OTC Medicine')->where('role', '=', 'Student')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->count();
                          ?>
                          {{ $studentOTC }}
                        @endif</td> 
                        <td > 
                          @if ($service === 'TOOTH EXTRACTION')
                          <?php
                          $employeeTE = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Tooth Extraction'])->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                          ?>
                          {{ $employeeTE }}
                          @elseif ($service === 'CAVITY FILLING')
                          <?php
                          $employeeCF = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Oral Restoration'])->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                          ?>
                         {{ $employeeCF }}
                         @elseif ($service === 'ORAL PROPHYLAXIS')
                         <?php
                         $employeeOP = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Oral Prophylaxis'])->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                         ?>
                          {{ $employeeOP }}
                          @elseif ($service === 'DENTAL CHECK-UP')
                          <?php
                          $employeeDC = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Consultation'])->where('role', '=', 'Employee')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                          ?>
                          {{ $employeeDC }}
                          @elseif ($service === 'PROVISION OF OTC MEDICINE')
                          <?php
                          $employeeOTC = DB::table('otc_medicine')->where('purpose', '=', 'OTC Medicine')->where('role', '=', 'Employee')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->count();
                          ?>
                          {{ $employeeOTC }}
                          @endif</td>
                          <td > 
                            @if ($service === 'TOOTH EXTRACTION')
                            <?php
                            $dependentTE = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Tooth Extraction'])->where('role', '=', 'Dependent')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                            ?>
                            {{ $dependentTE }}
                            @elseif ($service === 'CAVITY FILLING')
                            <?php
                            $dependentCF = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Oral Restoration'])->where('role', '=', 'Dependent')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                            ?>
                            {{ $dependentCF }}
                            @elseif ($service === 'ORAL PROPHYLAXIS')
                            <?php
                            $dependentOP = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Oral Prophylaxis'])->where('role', '=', 'Dependent')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                            ?>
                            {{ $dependentOP }}
                            @elseif ($service === 'DENTAL CHECK-UP')
                            <?php
                            $dependentDC = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Consultation'])->where('role', '=', 'Dependent')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                            ?>
                            {{ $dependentDC}}
                            @elseif ($service === 'PROVISION OF OTC MEDICINE')
                            <?php
                            $dependentOTC = DB::table('otc_medicine')->where('purpose', '=', 'OTC Medicine')->where('role', '=', 'Dependent')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->count();
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
                      <td style="color:rgb(0, 0, 0);">Total</td>
                      <td style="color:rgb(0, 0, 0), 1, 1);"> 
                      <?php
                        $totalS =  $studentTE + $studentCF + $studentOP + $studentDC + $studentOTC;
                        ?>
                        {{ $totalS }}
                      </td>
                      <td style="color:rgb(0, 0, 0);">
                        <?php
                        $totalE =  $employeeTE + $employeeCF + $employeeOP + $employeeDC + $employeeOTC;
                        ?>
                        {{ $totalE }}
                      </td>
                      <td style="color:rgb(0, 0, 0);">
                        <?php
                        $totalD =  $dependentTE + $dependentCF + $dependentOP + $dependentDC + $dependentOTC;
                        ?>
                        {{ $totalD }}
                      </td>
                      <td style="color:rgb(0, 0, 0);">
                        <?php
                        $totalAll = $totalS + $totalE +$totalD;
                        ?>
                        {{ $totalAll }}
                      </td>
                    </tr>
                  </tfoot>
                </table>  <br><br><br>
                <table class="table studentsTable table-bordered table-striped" id="miTable" style="width:100%">
                  <thead>
                    <tr>
                      <th style="color:rgb(0, 0, 0);">Dental Services</th>
                      <th style="color:rgb(0, 0, 0);">Male</th>
                      <th style="color:rgb(0, 0, 0);">Female</th>
                      <th style="color:rgb(0, 0, 0);">Total</th>
                    </tr>
                  </thead>
                  {{-- <thead>
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
                  </thead> --}}
                  <tbody>
                    @foreach ($dental_services as $service)
                  <tr>
                    <td style="text-align:left;">{{$service}} </td>
                    <td>
                      @if ($service === 'TOOTH EXTRACTION')
                        <?php
                          $MTE = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Tooth Extraction'])->where('gender', '=', 'Male')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $MTE }}
                        @elseif ($service === 'CAVITY FILLING')
                        <?php
                        $MCF = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Oral Restoration'])->where('gender', '=', 'Male')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $MCF }}
                        @elseif ($service === 'ORAL PROPHYLAXIS')
                        <?php
                        $MOP = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Oral Prophylaxis'])->where('gender', '=', 'Male')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                          {{ $MOP }}
                        @elseif ($service === 'DENTAL CHECK-UP')
                        <?php
                        $MDC = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Consultation'])->where('gender', '=', 'Male')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $MDC }}
                        @elseif ($service === 'PROVISION OF OTC MEDICINE')
                        <?php
                        $MOTC =  DB::table('otc_medicine')->where('purpose', '=', 'OTC Medicine')->where('gender', '=', 'Male')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->count();
                        ?>
                        {{ $MOTC }}
                      @endif</td> 
                      <td > 
                        @if ($service === 'TOOTH EXTRACTION')
                        <?php
                        $FTE = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Tooth Extraction'])->where('gender', '=', 'Female')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $FTE }}
                        @elseif ($service === 'CAVITY FILLING')
                        <?php
                        $FCF = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Oral Restoration'])->where('gender', '=', 'Female')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                       {{ $FCF }}
                       @elseif ($service === 'ORAL PROPHYLAXIS')
                       <?php
                       $FOP = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Oral Prophylaxis'])->where('gender', '=', 'Female')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                       ?>
                        {{ $FOP }}
                        @elseif ($service === 'DENTAL CHECK-UP')
                        <?php
                        $FDC = DB::table('treatmentrecord')->whereJsonContains('remarks', ['Consultation'])->where('gender', '=', 'Female')->whereYear('date', '=', $year)->whereMonth('date', '=', $month)->count();
                        ?>
                        {{ $FDC }}
                        @elseif ($service === 'PROVISION OF OTC MEDICINE')
                        <?php
                        $FOTC = DB::table('otc_medicine')->where('purpose', '=', 'OTC')->where('gender', '=', 'Female')->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->count();
                        ?>
                        {{ $FOTC }}
                        @endif</td>
                      <td > 
                        @if ($service === 'TOOTH EXTRACTION')
                        <?php
                        $GTE =  $MTE + $FTE ;
                        ?>
                        {{ $GTE }}
                        @elseif ($service === 'CAVITY FILLING')
                        <?php
                        $GCF = $MCF + $FCF  ;
                        ?>
                        {{ $GCF }}
                        @elseif ($service === 'ORAL PROPHYLAXIS')
                        <?php
                        $GOP = $MOP + $FOP ;
                        ?>
                          {{ $GOP }}
                          @elseif ($service === 'DENTAL CHECK-UP')
                          <?php
                        $GDC = $MDC + $FDC;
                        ?>
                        {{ $GDC }}
                        @elseif ($service === 'PROVISION OF OTC MEDICINE')
                        <?php
                        $GOTC = $MOTC + $FOTC;
                        ?>
                      {{ $GOTC }}
                      @endif</td>
                  </tr>
                  @endforeach
                  </tbody>  
                  <tfoot>
                    <tr>
                      <td style="color:rgb(0, 0, 0);">Total</td>
                      <td style="color:rgb(0, 0, 0);"> 
                      <?php
                        $totalM =  $MTE + $MCF + $MOP + $MDC + $MOTC;
                        ?>
                        {{ $totalM }}
                      </td>
                      <td style="color:rgb(0, 0, 0);">
                        <?php
                        $totalF =  $FTE + $FCF + $FOP + $FDC + $FOTC;
                        ?>
                        {{ $totalF }}
                      </td>
                      <td style="color:rgb(0, 0, 0);">
                        <?php
                        $totalAll= $totalF + $totalM ;
                        ?>
                        {{ $totalAll }}
                      </td>
                    </tr>
                  </tfoot>
                </table>    
            </div>    
            <br><br><br>
            <div style="font-weight: 600; font-size: 20px; text-align: left">
              Prepared and Submitted by: <br><br><br>
              <div style=" flex-direction: column;">
                  <input class="" name="" type="text" value="GRETTA D. GUIROY, DDM" style="text-decoration:underline;text-decoration-thickness: 1px;"><br>
                  <input class="" name="" type="text" value="Dentist, Director Health Services">
                  <div class="row col-md-12">
                   <input class="col-2" name="" type="text" value="">&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="col-2 " name="" type="text" value=""> 
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