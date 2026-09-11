<html class="loading" lang="en" data-textdirection="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SLSU-QF-MD16</title>
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
    width:12%;
    font-size: 14px;
    float:right;
    margin-right: 160px;
    height:88%;
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
      height: 1.5cm;
      font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
  }
  tbody { vertical-align: top; }
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
  </style>
  <body>
    <header>
        <div class="header">
          <div class="image">
            <div class="logo" style="margin-left: 3.5cm;">
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
          <p style="font-size: 12px; text-decoration:underline; text-align:center;">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p>
          {{-- <p style="font-weight: 700; font-size: 16px; font-style: italic; text-align:center;">Patient Monitoring Record Form</p> --}}
        </div>
    </header>
    <footer>
      <span style="font-weight: 400; font-size: 16px; color: black; display: inline-block; width: 100%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
      
      </span>
      <div>
        <img src="images/logo/SLSU-QF-MD16.png" alt="" style="width: 150px; height:60px; float-left; vertical-align: top"> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<img src="images/logo/sq_star.png" alt="" style="width: 230px; height:80px; vertical-align: middle"> <img src="images/logo/socotec.png" alt="" style="width: 150px; height:60px; float: right"> </span><br>
      </div>
    </footer>
    <main>
      <div id="printPart">
        <div class="col-lg-12 d-flex flex-column align-items-center justify-content-center" style="text-align: center;margin-bottom:20px">
          <div style="text-align: center; width: 50%; margin: auto;">
            <div style="font-weight: bold; font-size: 16px;">
                {{$doctor->FirstName}} {{$doctor->MiddleName}} {{$doctor->LastName}}
            </div>
            <hr style="border: 1px solid black; margin: 1px auto; width: 100%;">
            <div style="font-size: 14px;">
                Dentist
            </div>
        </div>
        
      </div>
      <br>
        <div class="row">
          <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 20px; font-style: bold; text-align:center;color:black;">CERTIFICATION</div>
        </div><br>
        <div class="class print-body">
          <div class="row col-12">
            <div style="font-weight: 400; font-size: 16px; font-style: bold;color:black;">To whom this may concern:</div>
            </div><br>

            <div class="form-group row input" style="color:black;margin-bottom:50px">
              <div class="div" tyle="color:black;margin-bottom:5px">
            <span style="font-weight: 500; font-size: 16px; font-style: bold;margin-left:50px;">THIS IS TO CERTIFY</span>
            <span style="font-weight: 400; font-size: 16px;">that Mr./Ms./Mrs.</span> 
            <span style="font-weight: 400; font-size: 16px; color: black; display: inline-block; width: 45%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
              {{$response->firstname}} {{$response->middlename}} {{$response->lastname}}
            </span>
          </div>
            <div class="div" style="color:black;margin-bottom:5px">
            <span style="font-weight: 400; font-size: 16px;">of</span>
            <span style="font-weight: 400; font-size: 16px; color: black; display: inline-block; width: 69%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
              {{$response->brgy}} {{$response->city}} {{$response->province}}
            </span>
            <span class="text-uppercase cy" style="font-weight: 600; font-size: 16px; font-style: bold; text-align: center; width: 67%;" readonly></span>
            <span style="font-weight: 400; font-size: 16px; color: black;"> has been treated by the </span>
          </div>
          <div class="div" style="color:black;margin-bottom:5px">
            <span style="font-weight: 400; font-size: 16px; color: black;"> undersigned for</span>
            <span style="font-weight: 400; font-size: 16px16px; color: black; display: inline-block; width: 50%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
              {{$response->treated_by}}
            </span>
            .
          </div>
           </div>
          <div class="div" style="margin-bottom:57%">
            <div class="form-group row  input" style="color:black;margin-bottom:5px">
              <span style="font-weight: 400; font-size: 16px;margin-left:50px;">It is recommended that he/she must</span>  
              <span style="font-weight: 400; font-size: 16px; color: black; display: inline-block; width: 25%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
                {{$response->no_days}}
              </span>
              <span style="font-weight: 400; font-size: 16px;">day(s) of rest.</span>
            </div>
            <div class="form-group row cinput" style="color:black;margin-bottom:5px">
            <span style="font-weight: 400; font-size: 16px;margin-left:50px;">This is issued upon his/her request for whatever legal purpose it may serve.</span>
            </div>
            <div class="form-group row col-12 input" style="color:black;">
              <span style="font-weight: 400; font-size: 16px;margin-left:50px;">Given this</span>
              <span style="font-weight: 400; font-size: 16px; color: black; display: inline-block; width: 10%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
                {{$formattedDay}}
              </span>
              <span style="font-weight: 400; font-size: 16px;">day of</span>
              <span style="font-weight: 400; font-size: 16px; color: black; display: inline-block; width: 20%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
                {{$month}}. {{$year}}
              </span>
              <span style="font-weight: 400; font-size: 16px;">at Southern Leyte State University</span>
              <span style="font-weight: 400; font-size: 16px;">  
                @php
                $campus_add = [
                  1 => 'Main Campus, San Roque, Sogod',
                  2 => 'Maasin City Campus, Maasin City',
                  3 => 'Tomas Oppus Campus, San Isidro, Tomas Oppus',
                  4 => 'Bontoc Campus, Bontoc',
                  5 => 'San Juan Campus, San Juan',
                  6 => 'Hinunangan Campus, Hinunangan',
              ];
              $campus = session('campus');
                @endphp
                
                @if($campus)
                    <div style="font-weight: 400; font-size: 16px;">
                        {{ $campus_add[$campus] }}, Southern Leyte, Philippines.
                    </div>
                @endif
              </span>
            </div>
          </div>
        </div>
        <div class="row" style="color: black;margin-bottom:5px">
          <div class="form-group col-12 text-right"> 
              <div style="font-weight: 400; font-size: 16px;margin-bottom:5px">
                <span style="font-weight: 400; font-size: 16px; color: black; display: inline-block; width: 40%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;margin-left:60%;">
                  {{$doctor->FirstName}} {{$doctor->MiddleName}}. {{$doctor->LastName}} 
              </span>
              </div>
          </div>
          <div class="form-group row " style="margin-left:60%">
            <label class="col-auto col-form-label" style="font-weight: 400; font-size: 16px;">
                License No.
            </label>                
            <span style="font-weight: 400; font-size: 16px; color: black; display: inline-block; width: 66%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
                    {{$doctor->license}}
                </span>
        </div>
    </div>
    </main>
  </body>
</html>