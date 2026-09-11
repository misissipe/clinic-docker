<html class="loading" lang="en" data-textdirection="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title></title>
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
    div.slsu{
      width:12%;
      font-size: 14px;
      float:right;
      margin-right: 160px;
      height:88%;
      text-align:center;
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
    .middle {
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
  border: 1px solid rgb(58, 57, 57);
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
    border-width: 0 0 1px;
    border-color: rgb(58, 57, 57);
    
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
  textarea  {
      outline: 0;
    border-width: 0 0 1px;
    border-color: rgb(58, 57, 57)
    
    }
  label {
    text-transform: lowercase;
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
  width: 100px
 }
 .card {
 
 margin-bottom: 50px;
 margin-left: auto;
 margin-right: auto;
  }
  .btn-sm {
    width: 70px; 
  }

  .fixed-header-container {
  width: 100%;
  padding: 0;
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
          <p style="font-weight: 700; font-size: 16px; font-style: bold; text-align:center;">Referral Slip</p>
        </div>
    </header>
    <footer>
      <div>
        <img src="images/logo/SLSU-QF-MD05.png" alt="" style="width: 140px; height:70px; float-left; vertical-align: top"> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<img src="images/logo/sq_star.png" alt="" style="width: 230px; height:80px; vertical-align: middle"> <img src="images/logo/socotec.png" alt="" style="width: 150px; height:60px; float: right"> </span><br>
      </div>
    </footer>
    <main>
      <div class="upper" style="font-size: 12px;">
      <div style="text-align: right">Course:
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 10%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->course}}
      </span>
      </div>
      <div style="text-align: right">School Year:
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 10%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$addYear}}
      </span>
      </div>
      <div style="text-align: right">Date:
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 10%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{ date('m-d-Y', strtotime($response->date))}}
      </span>
      </div>
    </div>
      <div class="form-group col-12" style="margin-bottom:10px">
        <div class="row" style="font-weight: 700; font-size:  14px;font-style: bold;color:black;">
          REFERRED TO:
        </div> 
      <div style="font-weight: 400; font-size: 12px;margin-left:100px;color:black;">
       <input class="textbox" type="checkbox" id="Hospital" name="referTo[]" value="Hospital">
        HOSPITAL 
      </div>
      <div style="font-weight: 400; font-size: 12px;color:black;margin-left:100px;">
        <input class="textbox" type="checkbox" id="RHU" name="referTo[]" value="RHU">
        RHU
      </div> 
      <div style="font-weight: 400; font-size: 12px;color:black;margin-left:100px;">
        <input class="textbox" type="checkbox" id="Visiting Physician" name="referTo[]" value="Visiting Physician">
        VISITING PHYSICIAN
      </div>
      <div style="font-weight: 400; font-size: 12px;color:black;margin-left:100px;">
         <input class="textbox" type="checkbox" id="others" name="referTo[]" value="others">
          Others,please specify
          <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 30%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
            {{$response->others}}
        </span>

      </div> 
    </div>
    <div class="form-group col-sm-12" style="font-weight: 300; font-size: 12px; align-text:middle;color:black;">
      <div class="row">
        Name:
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 22%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->lastname}}
      </span>&nbsp;
        {{-- <input  class=" cert lastname" type="text" value="" id="lastname" style="width:22%;text-align:center"> --}}
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 22%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->firstname}}
      </span>&nbsp;
      <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 22%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
        {{$response->middlename}}
    </span>
        Age: 
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 6%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->age}}
      </span>
        Gender:
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 7.6%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->gender}}
      </span>
      <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 12px; font-style: italic; padding: 0; margin-left: 90px;">
        <span style="margin-right: 110px;">(Last)</span>
        <span style="margin-right: 108px;">(First)</span>
        <span>(Middle)</span>
    </div>
      </div>
      <div class="row" style="color:black;font-size: 12px;">
        Date of Birth:
        <span style="font-weight: 400;  color: black; display: inline-block; width: 12%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{date('m-d-Y', strtotime($response->bday))}}
      </span>
        Civil Status:
        <span style="font-weight: 400;  color: black; display: inline-block; width: 12%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->civil_stat}}
      </span>
        Nationality:
        <span style="font-weight: 400;  color: black; display: inline-block; width: 12%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->nationality}}
      </span>
        Religion:
        <span style="font-weight: 400;  color: black; display: inline-block; width: 21.7%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->religion}}
      </span>
      </div>
      <div class="row" style="color:black;">
        Boarding House Address:
        <span style="font-weight: 400;  color: black; display: inline-block; width: 78.4%; text-align: left; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->b_brgy }}, {{$response->b_city}}, {{$response->b_province}}
      </span>
     
      </div>
      <div class="row" style="color:black;">
        Home Address:
        <span style="font-weight: 400;  color: black; display: inline-block; width: 86.7%; text-align: left; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->brgy}}, {{$response->city}}, {{$response->province}}
      </span>
      </div>
      <div class="row" style="color:black;">
        Parent/Guardian:
        <span style="font-weight: 400;  color: black; display: inline-block; width: 29.8%; text-align: left; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->guardian}}
      </span>
        Parent/Guardian Contact No.:
        <span style="font-weight: 400;  color: black; display: inline-block; width: 29%; text-align: left; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->g_ContactNo}}
      </span>
      </div>
      <div class="row" style="color:black;">
        Guardian Address:
        <span style="font-weight: 400;  color: black; display: inline-block; width: 83.7%; text-align: left; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->g_Address}}
      </span>

      </div>
    </div>
    <div class="break"></div>
    <div class="line" style="border-bottom: 1px solid rgb(110, 109, 109);margin:2px;width:100%"></div>
    <div class="line" style="border-bottom: 1px solid rgb(110, 109, 109);margin:2px;width:100%;margin-bottom:10px"></div>

    <div class="" style="font-weight: 700; font-size: 12px;font-style: bold;color:black;margin-bottom:10px">REASON/s FOR REFERRAL:
      <span style="font-weight: 400;  color: black; display: inline-block; width: 100%; text-align: left; padding-bottom: 2px; border-bottom: 1px solid black;">
        {{$response->reason}}
    </span>
    </div><br>
    <div style="font-weight: 400; font-size: 12px; text-align: left;color:black;">
      Referred by:
      <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 35%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;margin-right:20%">
        {{$doctor->FirstName}} {{$doctor->MiddleName}}. {{$doctor->LastName}} 
    </span>
    </div>
    <div class="for"  style="color:black;margin-left:100px;font-size:12px;margin-bottom:10px">
      Signature over Printed Name
    </div>

    <div class="line" style="border-bottom: 1px dashed rgb(110, 109, 109);margin:3px"></div>
    <div class="line" style="border-bottom: 1px dashed rgb(110, 109, 109);margin:3px"></div>
    <div class="row">
      <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 400; font-size: 15px; font-style: italic; text-align:center;color:black;">(Cut and return to campus clinic)</div>
    </div>
    <div class="col-12  d-flex justify-content-center" >
      <div class="" style="width:50%;height:50%;">
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
      <div class="" style="width: 110px; height: 110px;">
        <img src="images/logo/bagong_pilipinas.png">
      </div>
  </div>
    <div class="row">
      <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 12px; border-bottom: 1px solid black; text-align:center;color:black;">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
    </div>
    <div class="row">
      <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 600; font-size: 14px; font-style: bold; text-align:center;color:black;">Return Slip</div>
    </div>
  
    <div class="upper" style="font-size: 12px;">
      <div style="text-align: right">Course:
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 10%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->course}}
      </span>
      </div>
      <div style="text-align: right">School Year:
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 10%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$addYear}}
      </span>
      </div>
    </div>
    <div class="form-group row col-12"  style="font-weight: 400; font-size: 12px;color:black;">
      Date:
      <input  class=" cert " type="text" value="" id="date">&nbsp;
    </div>  
    <div class="form-group col-sm-12" style="font-weight: 300; font-size: 12px;color:black;">
      <div class="row">
        Name:
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 22%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->lastname}}
      </span>&nbsp;
        {{-- <input  class=" cert lastname" type="text" value="" id="lastname" style="width:22%;text-align:center"> --}}
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 22%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->firstname}}
      </span>&nbsp;
      <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 22%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
        {{$response->middlename}}
    </span>
        Age: 
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 6%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->age}}
      </span>
        Gender:
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 7.6%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->gender}}
      </span>
      <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 12px; font-style: italic; padding: 0; margin-left: 90px;">
        <span style="margin-right: 110px;">(Last)</span>
        <span style="margin-right: 108px;">(First)</span>
        <span>(Middle)</span>
    </div>
      </div>
      <div class="row" style="color:black;margin-bottom:10px">
        Boarding House Address:
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 40%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->b_brgy}}, {{$response->b_city}}, {{$response->b_province}}
      </span>
        Student Contact No.:
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 20%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->ContactNo}}
      </span>
      </div>
    </div>
    <div class="d-flex justify-content-left" style="font-weight: 700; font-size: 12px; font-style: bold; text-align:center;color:black;">Action taken/Remarks:</div>
      <table class="table" style="color:black;font-size:12px">
        <tr>
          <td class="a" height="100px"><br><br><br><br>
            <span style="font-weight: bold; font-size: 12px; color: black; display: inline-block; width: 30%; text-align: center; padding-top: 2px; border-top: 1px solid black;margin-right:10px">
              Signature Over Printed Name
           </span>
          </td>
        </tr>
      </table>
    </main>
  </body>

</html>
