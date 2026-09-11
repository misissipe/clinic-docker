<html class="loading" lang="en" data-textdirection="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Expired Medicine Report</title>
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
        <div class="slsu aptos">
          <img src="images/logo/bagong_pilipinas.png">
        </div><br><br><br><br><br>
        <p class="aptos" style="font-size: 12px; text-decoration:underline; text-align:center;">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p>
        <p class="aptos" style="font-weight: 700; font-size: 16px; font-style: italic; text-align:center;">Expired Medicine Report</p>
      </div>
    </header>
     <footer><hr>
    <div>
      <img src="images/logo/other-concern.png" alt="" style="width: 150px; height:60px; float-left; vertical-align: top;margin-top:5px;margin-right:240px"> <img src="images/logo/qs_star.png" alt="" style="width: 80px; height:70px; vertical-align: middle"> <img src="images/logo/socotec.png" alt="" style="width: 140px; height:65px; float: right;"> </span><br>
    </div>
  </footer>
    <main>
      <div id="printPart" class="aptos">
        <table class="table" style="color:black;font-size:14px;">
          <thead>
            <tr>
              <th style="text-align: center;width:20%">MEDICINE NAME</th>
              <th style="text-align: center;width:5%">ITEM LEFT</th>
              <th style="text-align: center;width:8%">EXPIRATION DATE</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($view as $data)
            <tr>
              <td style="text-align: left;text-transform:capitalize">{{ $data->item_name}}</td>
              <td style="text-align: right;">{{$data->item_quantity}}</td>
              <td style="text-align: center;">{{ date('m-d-Y', strtotime($data->expiration_date))}}</td>
            </tr>
            @empty
            <tr>
              <td colspan="7" style="text-align: center; color: red;">No records found</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class='aptos' style="position: absolute; bottom: 10%; width: 100%; font-size: 14px;">
        <div style="display: flex; justify-content: space-between;">
          <div>
            <span>Prepared By:</span><span style="margin: right:40%;">Noted By:</span><br><br><br><br>
            <span >{{$preparedby->FirstName ?? ''}} {{$preparedby->MiddleName ?? ''}} {{$preparedby->LastName ?? ''}}</span><span style="margin: right:15%">{{$noted->FirstName }} {{$noted->MiddleName ?? ''}} {{$noted->LastName ?? ''}}</span><br>
            <span style="margin-right: 45%">{{$preparedby->Role ?? ''}}</span><span>&nbsp;{{$noted->Designation ?? ''}}, {{$noted->Office ?? ''}}</span><br>
            <span>Date: ___________</span><span  style="margin-left: 34%"> Date: ___________</span>
          </div>
        </div>
      </div>
    </main>
  </body>
</html>

  
              
     