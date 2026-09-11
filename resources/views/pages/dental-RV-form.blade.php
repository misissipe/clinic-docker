<html class="loading" lang="en" data-textdirection="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SLSU-QF-MD06</title>
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
    div.slsu{
      margin-top:5px;
      width:8%;
      font-size: 14px;
      float:right;
      margin-right: 330px;
      height:80%;
      text-align:center;
    }
    header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 4cm;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }
    body {
        margin-top: 4.5cm;
        margin-left: 1cm;
        margin-right: 1cm;
        margin-bottom: 2cm; 
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }
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
          </div><br><br><br><br><br>
          <p style="font-size: 12px; text-decoration:underline; text-align:center;margin-top:2%">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p>
          <p style="font-weight: 700; font-size: 16px; font-style: bold; text-align:center;">DENTAL LOGBOOK (RECORD OF VISIT)</p>
        </div>
    </header>
    <footer>
      <div><span style="font-size:12px"> <strong>Legend:</strong>  &nbsp;1-Provision of OTC Medicines &nbsp; &nbsp;2- Dental Check-up/ Consultation&nbsp; &nbsp;3-  Cavity Filling/Oral Restoration&nbsp; &nbsp;4- Oral Prophylaxis&nbsp; &nbsp;5- Tooth Extraction &nbsp; &nbsp;6- Dental Certificate</span></div>
    <div><br>
        <img src="images/logo/SLSU-QF-MD06.png" alt="" style="width: 150px; height:50px; float-left; vertical-align: top;margin-left:170px;margin-top:5px"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<img src="images/logo/sq_star.png" alt="" style="width: 230px; height:80px; vertical-align: middle"> <img src="images/logo/socotec.png" alt="" style="width: 150px; height:60px; float: right;margin-right:170px"> </span><br>
      </div>
    </footer>
    <main>
   
      <div id="printPart">
        <table class="table" style="color:black;font-size:14px">
            <thead>
                <tr>
                    <th style="text-align: center;">Date</th>
                    {{-- <th style="text-align: center;">ID Number</th> --}}
                    <th style="text-align: center;">Name of Patient</th>
                    <th style="text-align: center;">Age</th>
                    <th style="text-align: center;">Sex</th>
                    <th style="text-align: center;">Position/Course</th>
                    <th style="text-align: center;">Remarks</th>
                    <th style="text-align: center;">OR Number</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($view as $data)
                    <tr>
                        <td style="text-align: center;">{{ date('m-d-Y', strtotime($data->date)) }}</td>
                        {{-- <td>{{ $data->patientId }}</td> --}}
                        <td style="text-align: left;text-transform:capitalize;">{{ $data->firstname }} {{ utf8_decode(substr($data->middlename, 0, 1)) }}. {{ utf8_decode($data->lastname) }}</td>
                        <td>{{ $data->age }}</td>
                        <td style="text-align: left;">{{ $data->gender }}</td>
                        <td style="text-align: left;"> {{ $data->poscourse }}</td>
                        <td>
                          @php
                              $remarksMapping = [
                                  'Consultation' => 2,
                                  'OTC Medicine' => 1,
                                  'Oral Restoration' => 3,
                                  'Oral Prophylaxis' => 4,
                                  'Tooth Extraction' => 5,
                                  'Dental Certificate' => 6
                              ];
                      
                              $remarksArray = json_decode($data->remarks);
                              $convertedRemarks = array_map(function($remark) use ($remarksMapping) {
                                  return $remarksMapping[$remark] ?? $remark;
                              }, $remarksArray);
                          sort($convertedRemarks);

                          @endphp
                          {{ implode(', ', $convertedRemarks) }}
                      </td>                      
                        <td> {{ $data->ORnumber }}</td>
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

  
              
     