<html class="loading" lang="en" data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>SLSU-QF-MD03</title>
  <link rel="apple-touch-icon" href="{{asset('images/ico/apple-icon-120.png')}}">
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/logo/slsu.ico')}}">
  <base href="https://clinic.southernleytestateu.edu.ph/">
</head>
<style>
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
     font-family: 'Aptos';
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
  table,td,th{
    border: 1px solid rgb(58, 57, 57);
    border-collapse: collapse;
    padding: 1px;
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
  .inline-cursor {
    text-align: center;
    font-size: 12px;
    font-weight: 800;
    text-transform: capitalize;
    transition: font-size 0.3s, color 0.3s;
  }
  .inline-cursor:hover {
    font-size: 15px; 
    color: #000000;
    cursor: pointer;
  }
  .cert{
    outline: 0;
    border-width: 0 0 1px;
    border-color: rgb(58, 57, 57);
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
      <p class='aptos' style="font-size: 12px; text-decoration:underline; text-align:center;">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p>
      <p class='aptos' style="font-weight: 700; font-size: 16px; font-style: italic; text-align:center;">Patient Monitoring Record Form</p>
    </div>
  </header>
  <footer>
    <div>
      <img src="images/logo/SLSU-QF-MD03.png" alt="" style="width: 150px; height:60px; float-left; vertical-align: top;margin-top:5px;margin-right:240px"> <img src="images/logo/qs_star.png" alt="" style="width: 80px; height:70px; vertical-align: middle"> <img src="images/logo/socotec.png" alt="" style="width: 140px; height:65px; float: right;"> </span><br>
    </div>
  </footer>
  <main>
    <div class="print-margin aptos" style="font-size:12px">
      <div style="text-align: right">
        <div >Course:
          <input  class=" course cert" name="" type="text" value="{{$info->accro ?? ''}}" id="fullname" style="width:10%;">
        </div>
      </div>
      <div style="text-align: right">
        <div>School Year:
          <input  class="cert" name="" type="text" value="{{$addYear ?? ''}}" id="fullname" style="width:10%;">
        </div>
      </div><br>
      <div class="form-group col-sm-12" style="font-size:12px;font-family:Aptos">
        <div class="row">
            Name:
            <input  class=" cert lastname" type="text" value="{{ ucwords(strtolower($info->LastName))}}" id="example-text-input" style="width:20%;text-align:center;">&nbsp;
            <input  class=" cert firstname" type="text" value="{{ ucwords(strtolower($info->FirstName))}}" id="example-text-input" style="width:20%;text-align:center">&nbsp;
            <input  class=" cert middlename" type="text" value="{{ ucwords(strtolower($info->MiddleName))}}" id="example-text-input" style="width:20%;text-align:center">
            Age:
            <input  class="cert age" type="text" value="{{$age}}" id="example-text-input" style="width:5%;text-align:center">
            Gender:
            <input  class=" cert gender" type="text" value="{{$info->Sex}}" id="example-text-input" style="width:9%;text-align:center">
            <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 13px; font-style: italic; padding: 0; margin-left: 85px;">
              <span style="margin-right: 100px;">(Last)</span>
              <span style="margin-right: 100px;">(First)</span>
              <span>(Middle)</span>
          </div>
          
        </div>
      </div><br>
      <table class="table table-sm  table-bordered table-striped aptos" id="recordTable"  style="font-size:12px;">
        <thead>
          <tr>
            <th style="color:rgb(0, 0, 0);text-align:center;width:10%;font-family:'Aptos'">Date</th>
            <th style="color:rgb(0, 0, 0);text-align:center;width:30%;font-family:'Aptos'">Chef Complaints/Findings</th>
            <th style="color:rgb(0, 0, 0);text-align:center;width:30%;font-family:'Aptos'">Physiological Parameters</th>
            <th style="color:rgb(0, 0, 0);text-align:center;width:30%;font-family:'Aptos'">Treatment/Recommendation</th>
          </tr>
        </thead>
        <tbody id="viewAllRecord">
          @foreach ($view as $data)
            <tr>
              <td style="text-align:center">{{ date('m-d-Y', strtotime($data->date)) }}</td>
              <td>{{ ($data->findings)}}</td>
              <td>
                {!! $data->parameters
                    ? $data->parameters
                    : "W: $data->weight <br> 
                       H: $data->height <br> 
                       Blood-Type: $data->blood_type <br> 
                       Temp: $data->temp <br> 
                       Pulse: $data->pulse <br> Res 
                       Rate: $data->res_rate <br> 
                       BP: $data->bp" 
                !!}
               </td>                  
              <td style="position: relative; height: 120px;">
                {{ ($data->recommendation) }}
                {{-- <span style="position: absolute; bottom: 0; right: 0; width: 50%; text-align: center; padding-top: 2px; border-top: 1px solid black;">
                  Signature
                </span> --}}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </main>
  </body>
</html>