<html class="loading" lang="en" data-textdirection="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SLSU-QF-MD05</title>
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
  thead{
  background-color: rgb(110, 155, 222);
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
          <p style="font-weight: 700; font-size: 16px; font-style: bold; text-align:center;">Medical Certificate</p>
        </div>
    </header>
    <footer>
      <div>
        <img src="images/logo/SLSU-QF-MD05.png" alt="" style="width: 140px; height:50px; float-left; vertical-align: top;margin-top:5px;margin-right:240px"> <img src="images/logo/qs_star.png" alt="" style="width: 80px; height:70px; vertical-align: middle"> <img src="images/logo/socotec.png" alt="" style="width: 140px; height:55px; float: right;"> </span><br>
      </div>
    </footer>
    <main>
      
      <div class="print-margin" style="font-size:12px">
        <div style="text-align: right">Course:
          <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 10%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
            {{$response->accro}}
        </span>
        </div>
        <div style="text-align: right">School Year:
          <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 10%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
            {{$addYear}}
        </span>
        </div><br>
        <input  class="col-11 id" type="hidden" name="id" value="" id="id" > 
        <table class="table" style="color:black;">
        <tr>
          <td colspan="4" style="border:1px solid rgb(0, 0, 0);">
            <div style="font-weight: 700; font-size: 14px; font-style: bold;color:black;">PERSONAL INFORMATION</div>
          </td>
        </tr>
        <tr >
          <td colspan="3" style="border:1px solid rgb(0, 0, 0);">
            <div style="text-align: left">
              <div style="font-weight: 400; font-size: 12px;">Name:
                <input  class="fullname cert name=" type="text" value="{{$response->firstname}} {{$response->middlename}} {{ $response->lastname}}" id="lastname" style="font-weight: 400; font-size: 12px; font-style: bold;width:100%" readonly>
              </div>
            </div>
          </td>
    
          <td style="border:1px solid rgb(0, 0, 0);">
            <div style="text-align: left">
              <div style="font-weight: 400; font-size: 12px;color:black;">Age:
                <input  class="age cert" name="" type="text" value="{{$response->age}}" id="age" style="font-weight: 400; font-size: 12px; font-style: bold;width:90%">
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="2" style="border:1px solid rgb(0, 0, 0);">
            <div style="text-align: left">
              <div style="font-weight: 400; font-size: 12px;color:black;">Date of birth:
                <input  class="bday cert" name="" type="text" value="{{$response->bday}}" id="fullname" style="font-weight: 400; font-size: 12px; font-style: bold;width:100%"> 
              </div> 
            </div>
          </td>
          <td style="border:1px solid rgb(0, 0, 0);">
            <div style="text-align: left">
              <div style="font-weight: 400; font-size: 12px;color:black;">Weight:
                <input  class=" weight cert" name="" type="text" value="{{$response->weight}}" id="fullname" style="font-weight: 400; font-size: 12px; font-style: bold;width:100%">
              </div> 
            </div>
          </td>
          <td style="border:1px solid rgb(0, 0, 0);">
            <div style="text-align: left">
              <div style="font-weight: 400; font-size: 12px;color:black;">Height:
                <input  class=" height cert" name="" type="text" value="{{$response->height}}" id="fullname" style="font-weight: 400; font-size: 12px; font-style: bold;width:90%">
              </div> 
            </div>
          </td>
        </tr>
        <tr>
          <td style="border:1px solid rgb(0, 0, 0);">
            <div style="text-align: left">
              <div style="font-weight: 400; font-size: 12px;color:black;">Blood Type:
                <input  class=" bloodtype cert" name="" type="text" value="{{$response->bloodtype}}" id="fullname" style="font-weight: 400; font-size: 12px; font-style: bold;width:100%">
              </div>  
            </div>
          </td>
          <td colspan="2" style="border:1px solid rgb(0, 0, 0);">
            <div style="text-align: left">
              <div style="font-weight: 400; font-size: 12px;color:black;">Allergies:
                <input  class=" allergies cert" name="" type="text" value="{{$response->allergies}}" id="fullname" style="font-weight: 400; font-size: 12px; font-style: bold;width:100%">
              </div> 
            </div>
          </td>
          <td style="border:1px solid rgb(0, 0, 0);">
            <div style="text-align: left">
              <div style="font-weight: 400; font-size: 12px;color:black;">Medication:
                <input  class=" medication cert" name="" type="text" value="{{$response->medication}}" id="fullname" style="font-weight: 400; font-size: 12px; font-style: bold;width:90%">
            </div> 
          </div>
          </td>
        </tr>
        <tr>
          <td colspan="2" style="border:1px solid rgb(0, 0, 0);">
            <div style="text-align: left">
              <div style="font-weight: 400; font-size: 12px;color:black;">Address:
                <input  class=" address cert" name="" type="text" value="{{$response->brgy}}, {{$response->city}} {{$response->province}}" id="fullname" style="font-weight: 400; font-size: 12px; font-style: bold;width:100%">
              </div> 
            </div>
          </td>
          <td colspan="2"style="border:1px solid rgb(0, 0, 0);">
            <div style="text-align: left">
              <div style="font-weight: 400; font-size: 12px;color:black;">Contact No.:
                <input  class=" contactNo cert" name="" type="text" value="{{$response->contactNo}}" id="fullname" style="font-weight: 400; font-size: 12px; font-style: bold;width:90%">
              </div>
            </div>
          </td>
        </tr>
        <tr>
          <td style="border:1px solid rgb(0, 0, 0);">
            <div style="text-align: left">
              <div style="font-weight: 400; font-size: 12px;color:black;">Temperature:
                <input  class=" temperature cert" name="" type="text" value="{{$response->temperature}}" id="fullname" style="font-weight: 400; font-size: 12px; font-style: bold;width:100%">
              </div>
            </div>
          </td>
          <td style="border:1px solid rgb(0, 0, 0);">
            <div style="text-align: left">
              <div style="font-weight: 400; font-size: 12px;color:black;">Pulse rate:
                <input  class=" pulse_rate cert" name="" type="text" value="{{$response->pulse_rate}}" id="fullname" style="font-weight: 400; font-size: 12px; font-style: bold;width:100%">
              </div>
            </div>
          </td>
          <td style="border:1px solid rgb(0, 0, 0);">
            <div style="text-align: left">
              <div style="font-weight: 400; font-size: 12px;color:black;">Respiratory rate:
                <input  class=" res_rate cert" name="" type="text" value="{{$response->res_rate}}" id="fullname" style="font-weight: 400; font-size: 12px; font-style: bold;width:100%">
              </div>
            </div>
          </td>
          <td style="border:1px solid rgb(0, 0, 0);">
            <div style="text-align: left">
              <div style="font-weight: 400; font-size: 12px;color:black;">Blood Pressure:
                <input  class=" bp cert" name="" type="text" value="{{$response->bp}}" id="bp" style="font-weight: 400; font-size: 12px; font-style: bold;text-align:left;width:90%">
              </div>
            </div>
          </td>
        </tr>
      </table><br>
      <div class="form-group row col-12 input" style="color:black;">
        <span style="font-weight: 700; font-size: 12px; font-style: bold;">THIS IS TO CERTIFY</span>
        <span style="font-weight: 400; font-size: 12px;">that</span> 
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 62%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{utf8_decode($response->firstname) ?? $response->firstname }} {{utf8_decode($response->middlename) ?? $response->middlename}} {{utf8_decode($response->lastname) ?? $response->lastname}}
      </span>
        <span style="font-weight: 400; font-size: 12px;">, male/female,</span>
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 30%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->accro}} - {{$response->yr}}
      </span>
        <span style="font-weight: 400; font-size: 12px;">was physically examined by the undersigned and was diagnosed of:</span>
        <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 12px; font-style: italic; margin-left: 45px; color: black;">
          course & year level
        </div>
        
      </div><br>
      <div class="form-group row col-12">
        <div style="font-weight: 700; font-size: 12px; font-style: bold; color:black;">DIAGNOSIS:</div>
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 100%; text-align: left; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->diagnosis}}
      </span>
    </div>
    
    <div class="form-group row col-12">
      <div style="font-weight: 700; font-size: 12px; font-style: bold; color: black;">REMARKS:</div>
      <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 100%; text-align: left; padding-bottom: 2px; border-bottom: 1px solid black;">
        {{$response->remarks}}
    </span>
    </div>
    
      <div class="form-group" >
        <div class="row col-12"><br>
          <span style="font-weight: 700; font-size: 12px; color:black;">THIS CERTIFICATION IS ISSUED</span>&nbsp;<span style="font-weight: 400; font-size: 12px; ">upon request of the above-name student/employee as requirement for:</span>
        </div><br>
     @php
         $cert= json_decode($response->cert_issued);
     @endphp

        <div class="checkbox-container">
          <input class="textbox" type="checkbox" id="OJT" name="cert_issued[]" value="OJT" {{ in_array('OJT', $cert) ? 'checked' : '' }}>
          <label for="OJT">On-The-Job Training</label>
      </div><br>
      <div class="checkbox-container">
          <input class="textbox" type="checkbox" id="Return for Work" name="cert_issued[]" value="Return for Work" {{ in_array('Return for Work', $cert) ? 'checked' : '' }}> 
          <label for="Return for Work">Return for Work</label>
      </div><br>
      <div class="checkbox-container">
          <input class="textbox" type="checkbox" id="Travel" name="cert_issued[]" value="Travel" {{ in_array('Travel', $cert) ? 'checked' : '' }}>
          <label for="Travel">Travel</label>
      </div><br>
      <div class="checkbox-container">
          <input class="textbox" type="checkbox" id="Off-campus Activity" name="cert_issued[]" value="Off-campus Activity" {{ in_array('Off-campus Activity', $cert) ? 'checked' : '' }}>
          <label for="Off-campus Activity">Off-campus activity</label>
      </div><br>
      <div class="checkbox-container">
          <input class="textbox" type="checkbox" id="others" name="cert_issued[]" value="Others" {{ in_array('Others', $cert) ? 'checked' : '' }}>
          <label for="others">Others, please specify</label>
          <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 60%; text-align: left; padding-bottom: 2px; border-bottom: 1px solid black;">
            {{$response->others}}
        </span>
      </div>
      <br><br><br><br><br><br>
        <div class=" row" >
          <div class="" style="margin-bottom:2%">
            <div class="form-group">
              <span style="font-weight: 400; font-size: 14px; color: black; display: inline-block; width: 40%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;margin-right:20%">
                {{utf8_decode($doctor->FirstName) ?? $doctor->FirstName}} {{utf8_decode($doctor->MiddleName) ?? $doctor->MiddleName}}. {{utf8_decode($doctor->LastName) ?? $doctor->LastName}} 
            </span>
            <span style="font-weight: 400; font-size: 14px; color: black; display: inline-block; width: 30%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
              {{$doctor->license}}
          </span>
              <span style="font-weight: 400; font-size: 12px;color:black;margin-right:30%">Signature over Printed name of Attending Physician</span>
              <span style="font-weight: 400; font-size: 12px;color:black;">License Number</span>
            </div>  
          </div>
          <div class="form-group ">Date:
            <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 35%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
              {{date('m-d-Y', strtotime($today))}}
          </span>
          </div>
        </div>
      </div>
    </main>
  </body>

</html>
