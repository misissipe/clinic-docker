<html class="loading" lang="en" data-textdirection="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SLSU-QF-MD04</title>
    <link rel="apple-touch-icon" href="{{asset('images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/logo/slsu.ico')}}">
    <base href="https://clinic.southernleytestateu.edu.ph/">
  </head>
<style>
    @page {
        size: A4 portrait;
        margin: 0;
    }

    html, body {
        width: 210mm;
        min-height: 297mm;
        box-sizing: border-box;
    }

    @font-face {
    font-family: 'Aptos';
    src: url("file://{{ public_path('fonts/Aptos-Regular.ttf') }}") format('truetype');
    font-weight: 400;
    font-style: normal;
}

@font-face {
    font-family: 'Aptos';
    src: url("file://{{ public_path('fonts/Aptos-Bold.ttf') }}") format('truetype');
    font-weight: 700;
    font-style: normal;
}

@font-face {
    font-family: 'Aptos';
    src: url("file://{{ public_path('fonts/Aptos-Italic.ttf') }}") format('truetype');
    font-weight: 400;
    font-style: italic;
}

.aptos {
    font-family: 'Aptos';
}

body {
    font-family: 'Aptos';
}
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
        margin-top: 4.1cm;
        margin-left: 0.8cm;
        margin-right: 0.8cm;
        margin-bottom: 1.6cm;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }
    footer {
        position: fixed;
        bottom: 0cm;
        left: 0.8cm;
        right: 0.8cm;
        height: 1.3cm;
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
    }
    tbody { vertical-align: top; }

    main {
        width: 100%;
        max-width: 194mm;
        overflow: hidden;
    }

    * {
        box-sizing: border-box;
    }

    @media print {
        html, body {
            width: 210mm;
            height: 297mm;
        }

        body {
            margin: 41mm 8mm 16mm;
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }

        main {
            transform: scale(0.94);
            transform-origin: top left;
            width: 106.38%;
        }

        table, tr, td,
        .form-group,
        .upper {
            page-break-inside: avoid;
        }
    }
   
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

  .upper {
    position: relative;
  }

  .referral-meta {
    position: absolute;
    top: 0;
    right: 0;
    width: 42%;
    line-height: 18px;
  }

  .referral-meta span {
    width: 28% !important;
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
        <p style="font-weight: 700; font-size: 16px; font-style: bold; text-align:center;font-family:'Aptos';">Referral Slip</p>
      </div>
    </header>
    <footer>
      <div>
        <img src="images/logo/SLSU-QF-MD04.png" alt="" style="width: 150px; height:60px; float-left; vertical-align: top;margin-top:5px;margin-right:240px"> <img src="images/logo/qs_star.png" alt="" style="width: 80px; height:70px; vertical-align: middle"> <img src="images/logo/socotec.png" alt="" style="width: 140px; height:65px; float: right;"> </span><br>
      </div>
    </footer>
    <main>
      <div class="upper" style="font-size: 12px;font-family:'Aptos';">
        @php
          $referTo = is_array($response->referTo) ? $response->referTo : explode(',', $response->referTo);
      @endphp
        REFERRED TO:
        <div class="form-group col-12" style="margin-bottom:5px;font-family:'Aptos';">
     
      <div style="font-weight: 400; font-size: 10px; margin-left:100px; color:black; ">
        <input class="textbox" type="checkbox" id="Hospital" name="referTo[]" value="Hospital" {{ in_array('Hospital', $referTo) ? 'checked' : '' }}>
          <label for="Hospital">HOSPITAL</label>
      </div>
      <div style="font-weight: 400; font-size: 10px; margin-left:100px; color:black; ">
        <input class="textbox" type="checkbox" id="RHU" name="referTo[]" value="RHU" {{ in_array('RHU', $referTo) ? 'checked' : '' }}>
          <label for="Hospital">RHU</label>
      </div>
      <div style="font-weight: 400; font-size: 10px; margin-left:100px; color:black; ">
        <input class="textbox" type="checkbox" id="Visiting Physician" name="referTo[]" value="Visiting Physician" {{ in_array('Visiting Physician', $referTo) ? 'checked' : '' }}>
          <label for="Visiting Physician">VISITING PHYSICIAN</label>
      </div>
      <div style="font-weight: 400; font-size: 10px; margin-left:100px; color:black;">
         <input class="textbox" type="checkbox" id="others" name="cert_issued[]" value="Others" {{ in_array('others', $referTo) ? 'checked' : '' }}>
          <label for="others">Others, please specify:</label>
          <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 30%; text-align: left; padding-bottom: 2px; border-bottom: 1px solid black;">
            {{$response->others}}
          </span>
      </div>
    </div>
        <div class="referral-meta">
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
      </div>
      
      
    <br>
    <div class="form-group col-sm-12" style="font-size: 12px; align-text:middle;color:black;font-family:'Aptos';">
      <div class="row">
        Name:
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 22%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->lastname}}
        </span>&nbsp;
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 22%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->firstname}}
        </span>&nbsp;
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 22%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->middlename}}
        </span>
        Age: 
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 7.6%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
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
      <div class="row" style="color:black;font-size: 12px;font-family:'Aptos';">
        Date of Birth:
        <span style="font-weight: 400;  color: black; display: inline-block; width: 13.5%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{date('m-d-Y', strtotime($response->bday))}}
        </span>
        Civil Status:
        <span style="font-weight: 400;  color: black; display: inline-block; width: 13.5%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->civil_stat}}
        </span>
        Religion:
        <span style="font-weight: 400;  color: black; display: inline-block; width: 21.7%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->religion}}
        </span>
        Height:
        <span style="font-weight: 400;  color: black; display: inline-block; width: 4.5%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->height}}
        </span>
        Weight:
        <span style="font-weight: 400;  color: black; display: inline-block; width: 4.5%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->weight}}
        </span>
      </div>
      <div class="row" style="color:black;font-family:'Aptos';">
        Boarding House Address:
        <span style="font-weight: 400;  color: black; display: inline-block; width: 79.4%; text-align: left; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->b_brgy }}, {{$response->b_city}}, {{$response->b_province}}
        </span>
      </div>
      <div class="row" style="color:black;font-family:'Aptos';">
        Home Address:
        <span style="font-weight: 400;  color: black; display: inline-block; width: 87.3%; text-align: left; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->brgy}}, {{$response->city}}, {{$response->province}}
        </span>
      </div>
      <div class="row" style="color:black;font-family:'Aptos';">
        Parent/Guardian:
        <span style="font-weight: 400;  color: black; display: inline-block; width: 31.24%; text-align: left; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->guardian}}
        </span>
        Parent/Guardian Contact No.:
        <span style="font-weight: 400;  color: black; display: inline-block; width: 29.8%; text-align: left; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->g_ContactNo}}
        </span>
      </div>
      <div class="row" style="color:black;font-family:'Aptos';">
        Guardian Address:
        <span style="font-weight: 400;  color: black; display: inline-block; width: 84.72%; text-align: left; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->g_Address}}
        </span>
      </div>
    </div>
    <div class="break"></div>
    <div class="line" style="border-bottom: 1px solid rgb(110, 109, 109);margin:2px;width:100%"></div>
    <div class="line" style="border-bottom: 1px solid rgb(110, 109, 109);margin:2px;width:100%;margin-bottom:10px"></div>
    <div style="color:black;font-size:12px;font-weight: 400;">
    <div class="row" style="color:black;font-size: 12px;font-family:'Aptos';">
      CHIEF COMPLAINT/S:
      <span style="font-weight: 400;  color: black; display: inline-block; width: 34%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
        {{$response->complaint ?? ''}}
      </span>
      VITAL SIGNS:
      <br>
      <span style="margin-left:54.35%">TEMP - <input type="text" class="cert d-inline-block " style="width:17.9%; display:inline-block;" value="{{$response->temp ?? ''}}" name="temp"> </span>
      PR - <input type="text" class="cert d-inline-block " style="width:15%; display:inline-block;" value="{{$response->pr ?? ''}}" name="pr"><br>
      <span style="margin-left:54.2%">RR - <input type="text" class="cert d-inline-block " style="width:20.2%; display:inline-block;" value="{{$response->rr ?? ''}}" name="rr"> </span>
      BP - <input type="text" class="cert d-inline-block " style="width:15%; display:inline-block;" value="{{$response->pb ?? ''}}" name="bp">
    </div>
    <div class="row" style="color:black;font-size: 12px;font-family:'Aptos';">
      ACTION TAKEN:
      <span style="font-weight: 400;  color: black; display: inline-block; width: 39%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
        {{$response->action_taken ?? ''}}
      </span>
      REASON/S FOR REFERRAL:
      <span style="font-weight: 400;  color: black; display: inline-block; width: 25%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
        {{$response->reason ?? ''}}
      </span>
    </div>
    <br><br>
    <div style="font-weight: 400; font-size: 12px; text-align: left;color:black;font-family:'Aptos';">
      Referred by:
      <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 35%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;margin-right:20%">
        {{$doctor->FirstName}} {{$doctor->MiddleName}} {{$doctor->LastName}} 
      </span>
    </div>
    <div class="for"  style="color:black;margin-left:100px;font-size:12px;margin-bottom:10px;font-family:'Aptos';">
      Signature over Printed Name
    </div>
    <div class="line" style="border-bottom: 1px dashed rgb(110, 109, 109);margin:3px"></div>
    <div class="line" style="border-bottom: 1px dashed rgb(110, 109, 109);margin:3px"></div>
    <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 400; font-size: 12px; font-style: italic; text-align:center;color:black;">(Cut and return to campus clinic)</div>
    <div class="row justify-content-center align-items-center" style="text-align: center;">
      @php 
        $campus_code = session('campus');
      @endphp
      @if($campus_code == 1)<img class="logo" src="images/logo/main-campus-logo.png" alt="" style="width:50%; height:auto; max-height: 50%; float: left; margin-left: 100px;">@endif
      @if($campus_code == 2)<img class="logo" src="images/logo/maasin-logo.png" alt="" style="width:50%; height:auto; max-height: 50%; float: left; margin-left: 100px;">@endif
      @if($campus_code == 3)<img class="logo" src="images/logo/tomas-oppus.png" alt="" style="width:50%; height:auto; max-height: 50%; float: left; margin-left: 100px;">@endif
      @if($campus_code == 4)<img class="logo" src="images/logo/bontoc.png" alt="" style="width:50%; height:auto; max-height: 50%; float: left; margin-left: 100px;">@endif
      @if($campus_code == 5)<img class="logo" src="images/logo/san-juan.png" alt="" style="width:50%; height:auto; max-height: 50% float: left; margin-left: 100px;">@endif
      @if($campus_code == 6)<img class="logo" src="images/logo/hinunangan.png" alt="" style="width:50%; height:auto; max-height: 50%; float: left; margin-left: 100px;">@endif
      <img src="images/logo/bagong_pilipinas.png" style="width: 85px; height: 85px; float:right; margin-right: 120px;">
      <p style="font-size: 12px; text-decoration:underline; text-align:center;white-space: nowrap;">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p>
      <p style="font-weight: 700; font-size: 14px; font-style: bold; text-align:center;margin: 0; padding: 0;">Return Slip</p>
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
    <div class="form-group col-sm-12" style="font-size: 12px;color:black;">
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
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 8.2%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
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
        <span style="font-weight: 400; font-size: 12px; color: black; display: inline-block; width: 23%; text-align: center; padding-bottom: 2px; border-bottom: 1px solid black;">
          {{$response->ContactNo}}
        </span>
      </div>
    </div>
    <div class="d-flex justify-content-left" style=" font-size: 14px; font-style: bold; color:black;">Action taken/Remarks:</div>
      <table class="table" style="color:black;font-size:12px">
        <tr>
          <td class="a" height="80px"><br><br><br><br><br><br><br>
            <span style="font-weight: bold; font-size: 12px; color: black; display: inline-block; width: 30%; text-align: center; padding-top: 2px; border-top: 1px solid black;margin-right:10px">
              Signature Over Printed Name
           </span>
          </td>
        </tr>
      </table>
    </main>
  </body>
</html>
