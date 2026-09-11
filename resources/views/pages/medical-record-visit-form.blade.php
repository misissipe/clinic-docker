<html class="loading" lang="en" data-textdirection="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SLSU-QF-MD01</title>
    <link rel="apple-touch-icon" href="{{asset('images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/logo/slsu.ico')}}">
    <base href="https://clinic.southernleytestateu.edu.ph/">
  </head>
  <style>
    div.header{
      width:100%;
      height: 100px;
      margin-bottom: 2%;
    }
    div.image{
      width:70px;
      float: left;
      height:100%;
    }
   
    img{
      width: 100%;
      height:100%;
    }
    table{
      width: 100% !important;
    }
    div.site{
      text-align: left;
      margin-left: 20%;
    }
    div.logo{
      width: 320px;
      height: 105%;
    }
    p{
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        font-size: 15px;
    }
    .page-break {
        page-break-inside: auto;
    }
    /** Define the header rules **/
    div.slsu{
      margin-top:5px;
      width:8%;
      font-size: 14px;
      float:right;
      margin-right: 330px;
      height:80%;
      text-align:center;
    }
    /** Define the header rules **/
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 4cm;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }
    body {
        margin-top: 4cm;
        margin-left: 1cm;
        margin-right: 1cm;
        margin-bottom: 2cm; 
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }

    /** Define the footer rules **/
    footer {
        position: fixed;
        bottom: 0cm;
        left: 1cm;
        right: 1cm;
        height: 2cm;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }
    tbody { vertical-align: top; }
  </style>
   <style>
    table, th,td{
   border: 1px solid rgb(0, 0, 0);
   border-collapse: collapse;
   text-align: center;
 }
 input {
  outline: 0;
  border-width: 0 0 1px;
  }
 .cert{
    outline: 0;
    border-width: 0 0 0px;
    border-color: rgb(58, 57, 57)
  }
  .checkbox-container {
        display: flex;
        align-items: center; 
        font-weight: 400;
        font-size: 12px;
        margin-left: 50px;
        color: black;
    }
    .textbox {
        transform: scale(1.5); 
        margin-right: 8px; 
        vertical-align: middle; 
        width: 20px; 
        height: 20px; 
    }
  /* thead{
  background-color: rgb(110, 155, 222);
 } */
    .card {
 
  margin-bottom: 50px;
  margin-left: auto;
  margin-right: auto;
  }
</style>
  <body>   
     <header>
        <div class="header">
          <div class="image">
            <div class="logo" style="margin-left: 7.5cm;">
              @php
                  $campus_code = session('campus');
              @endphp
              @if($campus_code == 1)<img class="logo" src="images/logo/main-campus-logo.png" alt="">@endif
              @if($campus_code == 2)<img class="logo" src="images/logo/maasin-logo.png" alt="">@endif
              @if($campus_code == 3)<img class="logo" src="images/logo/tomas-oppus.png" alt="">@endif
              @if($campus_code == 4)<img class="logo" src="images/logo/bontoc.png" alt="">@endif
              @if($campus_code == 5)<img class="logo" src="images/logo/san-juan.png" alt="">@endif
              @if($campus_code == 6)<img class="logo" src="images/logo/hinunangan.png" alt="">@endif
            </div>
          </div>
          <div class="slsu">
            <img src="images/logo/bagong_pilipinas.png">
          </div><br><br><br><br>
          <p style="font-size: 12px; text-decoration:underline; text-align:center;margin-top:1%">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p>
        <p style="font-weight: 700; font-size: 14px; text-align: center; margin: 0;">MEDICAL SERVICES LOGBOOK</p>
        <p style="font-weight: 700; font-size: 14px; text-align: center; margin: 0;">(RECORD OF VISIT)</p>

        </div>
    </header>
    <footer>
      <div style="margin-bottom:0.5%"><span style="font-size:14px"> <strong>Legend:</strong>  1- Provision of OTC Medicines &nbsp; &nbsp; &nbsp; &nbsp;2- Physical Assessment &nbsp; &nbsp; &nbsp; &nbsp;3-  Consultation&nbsp; &nbsp; &nbsp; &nbsp;4- Wound dressing   &nbsp; &nbsp; &nbsp; &nbsp;5-  Medical/Health Certificate         </span>
        <br><span style="font-size:14px">  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 6 - Blood Pressure Taking &nbsp; &nbsp; &nbsp; &nbsp;7 - Referral  &nbsp; &nbsp; &nbsp; &nbsp;8 - Provision of Comfort &nbsp; &nbsp; &nbsp; &nbsp;9 - Other Concerns        </span>
      </div>
      <div>
        <img src="images/logo/SLSU-QF-MD01.png" alt="" style="width: 150px; height:50px; float-left; vertical-align: top;margin-top:5px;margin-left:50px;margin-right:200px"> <img src="images/logo/qs_star.png" alt="" style="width: 90px; height:70px; vertical-align: middle"> <img src="images/logo/socotec.png" alt="" style="width: 140px; height:55px; float: right;margin-right:300px"> </span><br>
      </div>
    </footer>
    <main>
   
      <div id="printPart">
        {{-- <p style="font-weight: 700; font-size: 16px; font-style: bold; text-align:center;">MONTH OF:{{$monthName }}</p> --}}
        <table class="table" style="color:black;font-size:14px">
            <thead>
                <tr>
                    <th style="text-align: center;width:7%">DATE</th>
                    <th style="text-align: center;width:5%">LOG IN</th>
                     <th style="text-align: center;width:6%">LOG OUT</th>
                    {{-- <th style="text-align: center;width:10%">ID Number</th> --}}
                    <th style="text-align: center;width:17%">NAME</th>
                    <th style="text-align: center;width:6%">AGE/SEX</th>
                    <th style="text-align: center;width:12%">POSITION/COURSE & YEAR LEVEL</th>
                    <th style="text-align: center;width:18%">PERMANENT ADDRESS</th>
                    <th style="text-align: center;width:5%">REMARKS</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($view as $data)
                    <tr>
                      <td style="text-align: center">{{ date('m-d-Y', strtotime($data->date)) }}</td>
                      <td style="text-align: center">{{ date('h:i A', strtotime($data->time)) }}</td>
                      <td style="text-align: center">{{ date('h:i A', strtotime($data->logged_out)) }}</td>
                        {{-- <td>{{ $data->patientId }}</td> --}}
                        <td style="text-align: left" > 
                          @php
                            $lastName = $data->studentLastName ?? $data->employeeLastName;
                            $firstName = $data->studentFirstName ?? $data->employeeFirstName;
                            $middleName = $data->studentMiddleName ?? $data->employeeMiddleName;
                          @endphp
                          {{ $firstName ? utf8_decode($firstName) : '' }} {{ $middleName ? utf8_decode($middleName) : '' }} {{ $lastName ? utf8_decode($lastName) : '' }}
                        </td>
                        <td>{{ $data->age }}/ {{ $data->studentSex ?? $data->employeeSex }}</td>
                        <td style="text-align: left;">{{ $data->positioncourse }}  </td>
                        <td style="text-align: left; text-transform: capitalize;">
                          @php
                            $brgy = $data->studentbrgy ?? $data->employeeRBarangay;
                            $city = $data->studentcity ?? $data->employeecitymunDesc;
                            $province = $data->studentprovince ?? $data->employeeprovDesc;
                        @endphp
                        {{ utf8_decode($brgy) }}, {{ utf8_decode($city) }}, {{ utf8_decode($province) }}
                        </td>
                      
                        <td>
                        @php
                          $remarksMapping = [
                              'OTC Medicine' => 1,
                              'Physical Assessment' => 2,
                              'Consultation' => 3,
                              'Wound Dressing' => 4,
                              'Issuance of Certificate' => 5,
                              'Blood Pressure' => 6,
                              'Referral' => 7,
                              'Provision of Comfort' => 8,
                              'Other Concerns' => 9,
                          ];

                          $purposeArray = json_decode($data->purpose, true); 
                          $convertedRemarks = [];

                          if (is_array($purposeArray)) {
                              $convertedRemarks = array_map(function($remark) use ($remarksMapping) {
                                  return $remarksMapping[trim($remark)] ?? trim($remark);
                              }, $purposeArray);
                              
                              sort($convertedRemarks); 
                          }
                      @endphp

                      {{ implode(', ', $convertedRemarks) }}
                        @if(is_array($purposeArray) && in_array('Other Concerns', $purposeArray))
                            - {{ $data->specify }}
                        @endif

                      </td>                   
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: red;">No records found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    

    </main>
  </body>

</html>

  
              
     