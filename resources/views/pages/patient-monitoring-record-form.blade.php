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
  @page {
    size: A4 portrait;
    margin: 39mm 8mm 19mm;
  }

  table{
    width: 100% !important;
  }
  div.site{
    text-align: left;
    margin-left: 20%;
  }
  p{
      font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
      font-size: 10px;
  }
  .page-break {
      page-break-inside: auto;
  }
  header {
    position: fixed;
    top: -35mm;
    left: 0;
    right: 0;
    height: 33mm;
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
  }
  body {
    margin: 0;
    padding: 0;
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
  }
  footer {
    position: fixed;
    bottom: -16mm;
    left: 0;
    right: 0;
    height: 14mm;
    font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
  }
  .header-layout, .footer-layout {
    border: 0;
    table-layout: fixed;
  }
  .header-layout td, .footer-layout td {
    border: 0;
    padding: 0;
    vertical-align: middle;
  }
  .campus-logo { width: 68mm; height: auto; }
  .bagong-logo { width: 18mm; height: auto; }
  .document-code { width: 31mm; height: auto; }
  .quality-logo { width: 16mm; height: auto; }
  .socotec-logo { width: 30mm; height: auto; }
  #recordTable {
    table-layout: fixed;
    font-size: 9px !important;
  }
  #recordTable th, #recordTable td {
    overflow-wrap: break-word;
    word-wrap: break-word;
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
    @php $campus_code = session('campus'); @endphp
    <table class="header-layout">
      <tr>
        <td style="width: 13%;"></td>
        <td style="width: 58%; text-align: center;">
          @if($campus_code == 1)<img class="campus-logo" src="images/logo/main-campus-logo.png" alt="SLSU">@endif
          @if($campus_code == 2)<img class="campus-logo" src="images/logo/maasin-logo.png" alt="SLSU Maasin">@endif
          @if($campus_code == 3)<img class="campus-logo" src="images/logo/tomas-oppus.png" alt="SLSU Tomas Oppus">@endif
          @if($campus_code == 4)<img class="campus-logo" src="images/logo/bontoc.png" alt="SLSU Bontoc">@endif
          @if($campus_code == 5)<img class="campus-logo" src="images/logo/san-juan.png" alt="SLSU San Juan">@endif
          @if($campus_code == 6)<img class="campus-logo" src="images/logo/hinunangan.png" alt="SLSU Hinunangan">@endif
        </td>
        <td style="width: 16%; text-align: center;"><img class="bagong-logo" src="images/logo/bagong_pilipinas.png" alt="Bagong Pilipinas"></td>
        <td style="width: 13%;"></td>
      </tr>
    </table>
    <p style="margin: 1mm 0 0; font-size: 7px; text-decoration: underline; text-align: center;">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p>
    <p style="margin: 1mm 0 0; font-weight: 700; font-size: 11px; font-style: italic; text-align: center;">Patient Monitoring Record Form</p>
  </header>
  <footer>
    <table class="footer-layout">
      <tr>
        <td style="width: 30%; text-align: left;"><img class="document-code" src="images/logo/SLSU-QF-MD03.png" alt="SLSU-QF-MD03"></td>
        <td style="width: 15%;"></td>
        <td style="width: 17%; text-align: right;"><img class="quality-logo" src="images/logo/qs_star.png" alt="Quality Standard"></td>
        <td style="width: 25%; text-align: center;"><img class="socotec-logo" src="images/logo/socotec.png" alt="ISO 9001"></td>
        <td style="width: 13%;"></td>
      </tr>
    </table>
  </footer>
  <main>
    <div class="print-margin" style="font-size:12px">
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
      <div class="form-group col-sm-12" style="font-size:12px">
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
      <table class="table table-sm  table-bordered table-striped" id="recordTable"  style="font-size:12px">
        <thead>
          <tr>
            <th style="color:rgb(0, 0, 0);text-align:center;width:12%">Date</th>
            <th style="color:rgb(0, 0, 0);text-align:center;width:31%">Chief Complaints/Findings</th>
            <th style="color:rgb(0, 0, 0);text-align:center;width:22%">Physiological Parameters</th>
            <th style="color:rgb(0, 0, 0);text-align:center;width:35%">Treatment/Recommendation</th>
          </tr>
        </thead>
        <tbody id="viewAllRecord">
          @foreach ($view as $data)
            <tr>
              <td style="text-align:center">{{ date('m-d-Y', strtotime($data->date)) }}</td>
              <td>{{ ucwords(strtolower(utf8_decode($data->findings))) }}</td>
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
                {{ ucwords(strtolower(utf8_decode($data->recommendation))) }}
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
