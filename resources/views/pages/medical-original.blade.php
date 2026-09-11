@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','MSMIS')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<style>
    table, th,td{
   border: 1px solid rgb(0, 0, 0);
   border-collapse: collapse;
   text-align: center;
 }

 input {
  outline: 0;
  border-width: 0;
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
</style>
<style>
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
  .pending-status {
  color: rgb(99, 175, 211); /* light blue */
  text-shadow:  5px rgba(113, 207, 238, 0.5);
  }

  .approved-status {
    color:  rgb(99, 211, 108); /* green */
    text-shadow:  5px rgba(113, 238, 121, 0.5);
  }

  .disapproved-status {
    color: rgb(211, 99, 99); /* red */
    text-shadow:  5px rgba(238, 113, 113, 0.5);
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
   margin: 5mm 10mm 5mm 10mm;  
   font-family: Cambria;
   size: Auto;
 }
</style>
@endsection
{{-- page-styles --}}

@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row justify-content-center">
      <div class="col-12">
          <div class="card" style="width: 80rem;" >
            <div class="card-header">
              {{-- style="display : none" --}}
              <ul class="nav nav-tabs border-0" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="search-tab" data-toggle="tab" href="#search" aria-controls="search" role="tab"
                  aria-selected="true" style="display : none" >
                  <span class="align-middle">Search</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="add-tab" data-toggle="tab" href="#add" aria-controls="add" role="tab"
                  aria-selected="false" style="display : none">
                  <span class="align-middle">Add</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="view-tab" data-toggle="tab" href="#view" aria-controls="view" role="tab"
                  aria-selected="false" style="display : none">
                  <span class="align-middle">View</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="list-tab" data-toggle="tab" href="#list" aria-controls="list" role="tab"
                  aria-selected="false" style="display : none">
                  <span class="align-middle">list</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="status-tab" data-toggle="tab" href="#status" aria-controls="status" role="tab"
                  aria-selected="false" style="display : none">
                  <span class="align-middle">status</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="print-tab" data-toggle="tab" href="#print" aria-controls="print" role="tab"
                  aria-selected="false" style="display : none" >
                  <span class="align-middle">print</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="show-tab" data-toggle="tab" href="#show" aria-controls="show" role="tab"
                  aria-selected="false" style="display : none">
                  <span class="align-middle">show</span>
                  </a>
                </li>
              </ul>

              <div class="tab-content">
{{-- search-tab --}}
                <div class="tab-pane active" id="search" aria-labelledby="search-tab" role="tabpanel">
                  <div class="table-responsive">
                    <h5 style="font-weight: bold; font-style: italic;color:royalblue)">PATIENT RECORDS</h5><br>
                    <div class="alert bg-rgba-info   alert-dismissible fade show" role="alert">
                      <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form  action="/patient-information" method="post" id="submitBtn">
                      <div class="input-group mb-3">
                        <input type="text" class="form-control col-sm-2" placeholder="Search" id="searchInput">
                        <div class="input-group-append">
                          <button class="btn btn-primary submitBtn" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                      </div>
                      </form>  
                      <div class="table-ressaveCertaddCertponsive" >
                        <table class="table studentsTable table-bordered table-striped" id="myTable" style="width:100%">
                          <thead>
                            <tr>
                                <th style="color:white;">Patient ID</th>
                                <th style="color:white;">Last Name</th>
                                <th style="color:white;">First Name</th>
                                <th style="color:white;">Middle Name</th>
                                <th style="color:white;">Create</th>
                                <th style="color:white;">Action</th>
                            </tr>
                        </thead>
                        </table><br><br>
                        @include('modal.viewFindings')   
                      </div>   
                  </div>
                </div>
{{-- add-tab --}}
                <div class="tab-pane " id="add" aria-labelledby="add-tab" role="tabpanel">
                  <div class="table-responsive">
                    <h5 style="font-weight: bold; font-style: italic;color:royalblue)">PERSONAL INFORMATION</h5><br>
                    <form action="/addCert"  method="post" id="saveCert">
                      @csrf
                        <input  class="form-control id col-2" name="patientId" type="text" value="" id="id" hidden> 
                        {{-- <input  class="form-control col-2 id" name="" type="text" value="" id="" hidden>  --}}
                      <div class="form-group row col-12">
                          <label for="example-text-input" class="" style="width: 7.9%">Name</label>
                        <div class="col-3">
                          <input class="form-control firstname" type="text" name="firstname" value="" id="example-text-input" placeholder="First Name" readonly>
                        </div>
                        <div class="col-3">
                          <input class="form-control middlename" type="text" name="middlename" value="" id="example-text-input" placeholder="Middle Name" readonly>
                        </div>
                        <div class="col-3">
                          <input class="form-control lastname" type="text" name="lastname" value="" id="example-text-input" placeholder="Last Name" readonly>
                        </div>
                          <label for="example-search-input" class="">Age</label>
                        <div class="col-1">
                          <input class="form-control age" type="text" name="age" value="" id="example-search-input" readonly>
                        </div>
                      </div>
                      <div class="form-group row col-12">
                        <label for="example-text-input" class="" style="width: 7.9%">Address</label>
                      <div class="col-3">
                          <input class="form-control brgy" type="text" name="brgy" value="" id="example-text-input" placeholder="Barangay" readonly>
                      </div>
                      <div class="col-3">
                          <input class="form-control city" type="text" name="city" value="" id="example-text-input" placeholder="City" readonly>
                      </div>
                      <div class="col-3">
                          <input class="form-control province" type="text" name="province" value="" id="example-text-input" placeholder="Province" readonly>
                      </div>
                    </div>
                      <div class="form-group row col-12">
                          <label for="example-tel-input" class="">Date of Birth</label>
                      <div class="col-2">
                            <input class="form-control BirthDate" type="date" name="bday" value="" id="BirthDate" readonly>
                        </div>
                            <label for="example-url-input" class=""style="width: 8.2%">Contact No.</label>
                        <div class="col-2">
                            <input class="form-control contactNo" type="number" name="contactNo" value="" id="example-url-input" readonly>
                        </div> 
                        <label for="example-password-input" class="" style="width: 8.5%">Weight (kg)<span class="text-danger">*</span></label>
                        <div class="col-1">
                            <input class="form-control weight @error('weight') is-invalid @enderror" name="weight" value="{{ old('weight') }}" required autocomplete="weight" type="number" id="">
                        </div>
                            <label for="example-number-input" class="" style="width: 8.2%">Height (cm)<span class="text-danger">*</span></label>
                        <div class="col-1">
                            <input class="form-control @error('height') is-invalid @enderror" name="height" value="{{ old('height') }}" required autocomplete="height" type="number" id="">
                          </div>
                      </div>
                      <div class="form-group row col-12">
                            <label for="example-datetime-local-input" class="" style="width: 7.9%">Blood Type<span class="text-danger">*</span></label>
                          <div class="col-1">
                            <input class="form-control bloodtype @error('bloodtype') is-invalid @enderror" name="bloodtype" value="{{ old('bloodtype') }}" required autocomplete="bloodtype" type="text" id="">
                          </div>
                            <label for="example-date-input" class="">Temperature (°C)<span class="text-danger">*</span></label>
                          <div class="col-1">
                            <input class="form-control @error('temperature') is-invalid @enderror" name="temperature" value="{{ old('temperature') }}" required autocomplete="temperature" type="number" id="">
                          </div>
                          <label for="example-month-input" class="">Pulse Rate<span class="text-danger">*</span></label>
                        <div class="col-1">
                            <input class="form-control @error('pulse_rate') is-invalid @enderror" name="pulse_rate" value="{{ old('pulse_rate') }}" required autocomplete="pulse_rate" type="number" id="">
                        </div>
                            <label for="example-week-input" class="">Respiratory Rate<span class="text-danger">*</span></label>
                        <div class="col-1">
                            <input class="form-control @error('res_rate') is-invalid @enderror" name="res_rate" value="{{ old('res_rate') }}" required autocomplete="res_rate" type="text" id="">
                        </div>
                            <label for="example-time-input" class="">Blood Pressure<span class="text-danger">*</span></label>
                        <div class="col-1">
                            <input class="form-control @error('bp') is-invalid @enderror" name="bp" value="{{ old('bp') }}" required autocomplete="bp" type="text" id="">
                        </div>
                      </div>     
                        <div class="form-group row col-12">
                            <label for="example-time-input" class="" style="width: 7.9%">Allergies<br>(if any)</label>
                        <div class="col-5">
                            <input class="form-control " name="allergies" value=""  type="text" id="">
                        </div>
                            <label for="example-time-input" class="">Medication <br> (if any)</label>
                        <div class="col-5">
                            <input class="form-control " name="medication" value="" type="text" id="">
                        </div>
                      </div>
                      <div class="form-group row col-12">
                          <label for="example-time-input" class="" style="width: 7.9%">Diagnosis<span class="text-danger">*</span></label>
                        <div class="col-5">
                            <textarea class="form-control @error('diagnosis') is-invalid @enderror" name="diagnosis" value="{{ old('diagnosis') }}" required autocomplete="diagnosis" id="diagnosis" rows="5"></textarea>
                        </div>
                            <label for="example-time-input" class="" style="width: 6.7%">Remarks<span class="text-danger">*</span></label>
                        <div class="col-5">
                            <textarea class="form-control @error('remarks') is-invalid @enderror" name="remarks" value="{{ old('remarks') }}" required autocomplete="weight"  id="remarks" rows="5"></textarea>
                        </div>
                      </div>         
                      <div class="form-group">
                        <div>
                            THIS CERTIFICATION IS ISSUED upon request of the above-name student/employee as requirement for:<span class="text-danger">*</span>
                        </div>
                        <input type="checkbox" id="OJT" name="cert_issued[]" value="OJT" onclick="selectCheckbox('OJT')">
                        <label for="ChestPain">On-the-Job Training</label><br>
                        <input type="checkbox" id="work" name="cert_issued[]" value="Return for Work" onclick="selectCheckbox('work')">
                        <label for="Insomnia">Return for Work</label><br>
                        <input type="checkbox" id="Travel" name="cert_issued[]" value="Travel" onclick="selectCheckbox('Travel')">
                        <label for="JointPains">Travel</label><br>
                        <input type="checkbox" id="Off-campus Activity" name="cert_issued[]" value="Off-campus Activity" onclick="selectCheckbox('Off-campus Activity')">
                        <label for="Dizziness">Off-campus activity</label><br>
                        <input type="checkbox" id="others" name="cert_issued[]" value="Others" onclick="selectCheckbox('others')">            
                        <label for="vehicle2">Others,please specify</label><br>
                        <input class="form-control othersPreIll col-sm-3 others_input" type="text" id="others_input" name="others" value="" disabled>
                    </div><br>
                        <div class="col-12">
                          <button type="button" class="btn btn-default btn-custom float-right" id="cancelBtn">Cancel</button>
                          <button type="submit" class="btn btn-primary btn-custom float-right saveCert" id="saveCert">save</button><br>
                        </div>
                      </form>
                  </div>
                </div>
{{-- approval-tab --}}
                <div class="tab-pane" id="view" aria-labelledby="view-tab" role="tabpanel">
                  <div class="table-responsive">
                    <form action="/approve" method="POST" id="pendingForm" >
                      @csrf
                       <div class="">
                         <button type="button" id="backbutton" class="btn btn-outline-default btn-custom float-right button" data-dismiss="modal">Back</button>
                         <button type="submit" class="btn btn-outline-primary float-right button">Submit for Approval</button>
                       </div><br><br>
                       <input  class="col-11 id" type="text" name="id" value="" id="id" hidden> 
                       <input  class="col-11" type="text" name="status" value="Pending" hidden>
                     </form>  
                     <hr>
                     <div id="printThis">
                      <div class="row printed-div  d-flex justify-content-left">
                        <div class="col-xl-8 col-lg-5 col-md-5 col-sm-5 d-flex justify-content-center"><img src="{{asset('images/logo/letter-SLSU-head.png')}}" style="width: 300px; height: 100px;"> </div>
                          <div class="col-xl-4 col-lg-6 col-md-7 col-sm-6"><br>
                            <div class="row">
                              <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 12px;" >MAIN CAMPUS</div></div>
                            <div class="row">
                              <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 12px;">San Roque, Sogod, Southern Leyte</div>
                            </div>
                            <div class="row">
                              <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 12px;">Email:&nbsp; <a href="#" >president@southernleytestateu.edu.ph</a> </div>
                            </div>
                            <div class="row">
                              <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 12px;">Website:&nbsp; <a href="#" >www.southernleytestateu.edu.ph</a></div>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 12px; border-bottom: 1px solid black; text-align:center">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                      </div>
                      <div class="row">
                       <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 15px; font-style: bold; text-align:center">Medical Certificate</div></div>
                      <div class="class print-body">
                       <div style="text-align: right">
                        <div style="font-weight: 400; font-size: 12px;">Course:
                          <input  class="col-2 course " name="course" type="text" value="" id="course" style="font-weight: 400; font-size: 12px; font-style: bold;">
                        </div>
                      </div>
                      <div style="text-align: right">
                       <div style="font-weight: 400; font-size: 12px;">School Year:
                        <input  class="col-2 " name="" type="text" value="" id="" style="font-weight: 400; font-size: 12px; font-style: bold;">
                       </div>
                      </div> <br>
                      <table class="table">
                          <tr>
                            <td colspan="4" style="border:1px solid rgb(0, 0, 0);">
                                <div style="font-weight: 650; font-size: 12px; font-style: bold;">PERSONAL INFORMATION</div>
                            </td>
                        </tr>
                        <tr >
                            <td colspan="3" style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Name:
                                    <input  class="col-10 fullname cert name=" type="text" value="" id="lastname" style="font-weight: 400; font-size: 12px; font-style: bold;">
                                  </div>
                                </div>
                                </td>
                            <td style="border:1px solid rgb(0, 0, 0);">
                              <div style="text-align: left">
                                <div style="font-weight: 400; font-size: 12px;">Age:
                                    <input  class="col-7 age cert" name="age" type="text" value="" id="age" style="font-weight: 400; font-size: 12px; font-style: bold;">
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2" style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Date of birth:
                                    <input  class="col-7 bday cert" name="bday" type="text" value="" id="bday" style="font-weight: 400; font-size: 12px; font-style: bold;"> 
                                  </div> 
                                </div>
                                </td>
                                <td style="border:1px solid rgb(0, 0, 0);">
                                    <div style="text-align: left">
                                      <div style="font-weight: 400; font-size: 12px;">Weight (kg):
                                        <input  class="col-7 weight cert" name="weight" type="text" value="" id="weight" style="font-weight: 400; font-size: 12px; font-style: bold;">
                                      </div> 
                                    </div>
                              </td>
                              <td style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Height (cm):
                                    <input  class="col-7 height cert" name="height" type="text" value="" id="height" style="font-weight: 400; font-size: 12px; font-style: bold;">
                                  </div> 
                                </div>
                            </td>
                          </tr>
                          <tr>
                            <td style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Blood Type:
                                    <input  class="col-5 bloodtype cert" name="bloodtype" type="text" value="" id="bloodtype" style="font-weight: 400; font-size: 12px; font-style: bold;">
                                  </div>  
                                </div>
                            </td>
                            <td colspan="2" style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Allergies (if any):
                                    <input  class="col-7 allergies cert" name="allergies" type="text" value="" id="allergies" style="font-weight: 400; font-size: 12px; font-style: bold;">
                                  </div> 
                                </div>
                            </td>
                            <td style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Medication (if any):
                                    <input  class="col-7 medication cert" name="medication" type="text" value="" id="medication" style="font-weight: 400; font-size: 12px; font-style: bold;">
                                  </div> 
                                </div>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="3" style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Address:
                                    <input  class="col-10 address cert" name="" type="text" value="" id="address" style="font-weight: 400; font-size: 12px; font-style: bold;">
                                  </div> 
                                </div>
                                </td>
                            <td style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Contact No.:
                                    <input  class="col-8 contactNo cert" name="" type="text" value="" id="contactNo" style="font-weight: 400; font-size: 12px; font-style: bold;text-align:left">
                                  </div>
                                </div>
                            </td>
                          </tr>
                          <tr>
                            <td style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Temperature:
                                    <input  class="col-5 temperature cert" name="" type="text" value="" id="temperature" style="font-weight: 400; font-size: 12px; font-style: bold;">
                                  </div>
                                </div>
                            </td>
                            <td style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Pulse rate:
                                    <input  class="col-5 pulse_rate cert" name="" type="text" value="" id="pulse_rate" style="font-weight: 400; font-size: 12px; font-style: bold;">
                                  </div>
                                </div>
                            </td>
                            <td style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Respiratory rate:
                                    <input  class="col-4 res_rate cert" name="" type="text" value="" id="res_rate" style="font-weight: 400; font-size: 12px; font-style: bold;">
                                  </div> 
                                </div>
                            </td>
                            <td style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Blood Pressure:
                                    <input  class="col-5 bp cert" name="" type="text" value="" id="bp" style="font-weight: 400; font-size: 12px; font-style: bold;text-align:left">
                                  </div>
                                </div>
                            </td>
                          </tr>
                      </table>
                      <div class="form-group row col-12 input">
                        <div style="font-weight: 700; font-size: 12px; font-style: bold;">THIS IS TO CERTIFY</div>&nbsp;<div style="font-weight: 400; font-size: 12px;">that</div>
                            <input  class=" text-uppercase  name " type="text" value="" id="name"  style="width:80%;font-weight: 400; font-size: 12px; font-style: bold;text-align:center">
                            <div style="font-weight: 400; font-size: 12px;" >,male/female,</div>
                            <input  class=" text-uppercase  cy" type="text" value="" id="cy"  style="width:30%;font-weight: 400; font-size: 12px; font-style: bold;text-align:center"><div style="font-weight: 400; font-size: 12px;">physically examine by the undersigned and was diagnoised of:</div>
                            <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 13px; font-style: italic;padding:0;">
                              &emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;(course & year level)
                            </div>
                          
                      </div>
                      <div class="form-group row col-12">
                        <div style="font-weight: 700; font-size: 12px; font-style: bold;">DIAGNOSIS:</div>
                          <textarea class="col-12 diagnosis "  name="recommendation" value="" id="diagnosis" rows="1" style="font-weight: 400; font-size: 12px;"></textarea>
                        </div>
                      <div class="form-group row col-12">
                        <div style="font-weight: 700; font-size: 12px; font-style: bold;">REMARKS:</div>
                          <textarea class="col-12 remarks"  name="recommendation" value="" id="remarks" rows="1" style="font-weight: 400; font-size: 12px;"></textarea>
                        </div>
                      <div class="form-group" >
                        <div class="row col-12">
                          <div style="font-weight: 700; font-size: 12px; ">THIS CERTIFICATION IS ISSUED </div>&nbsp;<div style="font-weight: 400; font-size: 12px; ">upon request of the above-name student/employee as requirement for:</div>
                        </div><br>
                        <div style="font-weight: 400; font-size: 12px;">
                          <input class="textbox" type="checkbox" id="OJT" name="cert_issued[]" value="OJT">
                            On-The-Job Training
                            <div style="font-weight: 400; font-size: 12px;">
                            <input class="textbox" type="checkbox" id="Return for Work" name="cert_issued[]" value="Return for Work">
                            Return for Work</div> 
                            <div style="font-weight: 400; font-size: 12px;">
                            <input class="textbox" type="checkbox" id="Travel" name="cert_issued[]" value="Travel">
                            Travel</div>
                            <div style="font-weight: 400; font-size: 12px;">
                            <input class="textbox" type="checkbox" id="Off-campus Activity" name="cert_issued[]" value="Off-campus Activity">
                            Off-campus activity</div>
                            <div style="font-weight: 400; font-size: 12px;">
                            <input class="textbox" type="checkbox" id="others" name="cert_issued[]" value="others">
                            Others,please specify
                            <input class="others col-sm-2 others" type="text" id="others" name="others" value="" >
                            </div> 
                        </div><br><br>
                        <div class=" row" >
                          <div class="col-sm-7">
                              <div class="form-group">
                                  &nbsp;<input  class="col-5 " type="text" value="EDMUNDO R. VILLA, MD., MM" id="example-text-input" style="font-weight: 400; font-size: 12px;text-align:center">
                                  <div style="font-weight: 400; font-size: 12px;">&nbsp;Signature over Printed name of Attending Physician</div>
                              </div>
                          </div>
                        <div class="col-sm-4">
                          <div class="form-group w-50">
                              <input  class="col-8 " type="text" value="052764" id="example-text-input" style="font-weight: 400; font-size: 12px;text-align:center">
                              <div style="font-weight: 400; font-size: 12px;">&emsp;&emsp;License Number</div>
                          </div>
                        </div>
                      </div>
                      </div>
                      <div class="form-group row col-12 ">
                        <div style="font-weight: 400; font-size: 12px;">Date:
                          <input type="text" class="col-8"  name="recommendation" value="" id="recommendation" rows="1">
                        </div>
                      </div>
                    </div>
                  
                    <div class="row footer-end"> <br><br>
                      {{-- <div class="col-1"></div> --}}
                      <div class="col-lg-9 col-md-8">
                          <div class="row">
                              <div class="col-md-4 d-flex justify-content-left" style="font-size: 12px;">Doc. Code SLSU-QF-MD05</span></div>
                              <div class="col-md-4 d-flex justify-content-left" style="font-size: 12px;">FOLLOW US HERE:</div>
                          </div>
                          <div class="row">
                              <div class="col-md-4 d-flex justify-content-left" style="font-size: 12px;">Revision: 02</div>
                              <div class="col-md-3 d-flex justify-content-left" style="font-size: 12px;">https://www.facebook.com/southernleytestateu/</div>
                          </div>
                          <div class="row">
                              <div class="col-md-4 d-flex justify-content-left" style="font-size: 12px;">Date: 08 April 2022</div>
                              <div class="col-md-3 d-flex justify-content-left" style="font-size: 12px;">https://www.youtube.com/c/SouthernLeyteStateUniversity</div>
                          </div>
                      </div>
                      <div class="col-md-3 col-sm-3"> 
                          <img src="{{asset('images/logo/socotec.png')}}" style="width: 55%; height: 70%;"></div>
                      </div>
                    </div>
                    </div>
                  </div>
{{-- list-tab --}}
                  <div class="tab-pane" id="list" aria-labelledby="list-tab" role="tabpanel">
                    <div class="table-responsive">
                      <div class="title">
                        <h5 style="font-weight: bold; font-style: italic;color:royalblue)">MEDICAL CERTIFICATE RECORDS</h5> <br>
                      </div>
                      <div class="row col-12" style="font-size:17px;font-weight:400;color:rgb(58, 57, 57)" >            
                        Name:
                        <input type="text" class=" col-sm-5 border-0 fullname" name=""  id="fullname" style="font-weight:400;color:rgb(58, 57, 57)" readonly>
                      </div><hr>
                      <table class="table recordTable table-bordered col-sm zero-configuration" id="recordTable">
                        <thead>
                          <tr>
                              <th style="color:white;">Date</th>
                              <th style="color:white;">Diagnosis</th>
                              <th style="color:white;">Remarks</th>
                              <th style="color:white;">Issued for</th>
                              <th style="color:white;">Status</th>
                              <th style="color:white;">Action</th>
                          </tr>
                        </thead>
                        <tbody id="viewAllRecord">  
                                
                        </tbody>
                      </table>
                      <hr>
                      <div class="col-12">
                        <button type="button" class="btn btn-primary btn-custom float-right" id="returnHome">Back</button>
                      </div>
                    </div>
                  </div>
{{-- status-tab --}}
                  <div class="tab-pane" id="status" aria-labelledby="status-tab" role="tabpanel">
                    <div class="table-responsive">
                      <div class="title">
                        <h5 style="font-weight: bold; font-style: italic;color:royalblue)">STATUS</h5> <br>
                      </div>
                      <div class="row col-12" style="font-size:17px;font-weight:400;color:rgb(58, 57, 57)" >            
                        Name:
                        <input type="text" class=" col-sm-8 border-0 fullname" name=""  id="fullname" style="font-weight:400;color:rgb(58, 57, 57)" readonly>
                      </div><hr>
                      <table class="table recordTable table-bordered col-sm " id="recordTable">
                        <thead>
                          <tr>
                            <th style="color:white;">Date</th>
                            <th style="color:white;">Issued for</th>
                            <th style="color:white;">Status</th>
                            <th style="color:white;">Remarks</th>
                            <th style="color:white;">Action</th>
                          </tr>
                        </thead>
                        <tbody id="viewStatus">  
                          
                        </tbody>
                      </table>
                      <div class="col-12">
                        <button type="button" class="btn btn-primary btn-custom float-right" id="gotosearch">Back</button>
                      </div>
                    </div>
                  </div>
{{-- print-tab --}}
                  <div class="tab-pane" id="print" aria-labelledby="print-tab" role="tabpanel">
                    <div class="table-responsive">
                      <div class="">
                        {{-- <button type="button" id="cancelBtnprint" class="btn btn-default btn-custom float-right button" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary float-right button" id="btnPrint" type="button"  data-dismiss="modal">Print</button> --}}
                      </div><br>
                      <div id="printPart">
                      @include('pages.SLSU-Header')
                        <br><br><br><br><br><br><br>
                      <div class="row">
                        <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 15px; border-bottom: 1px solid black; text-align:center">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 24px; font-style: bold; text-align:center">Medical Certificate</div>
                      </div>
                      <div class="class print-body">
                        <div style="text-align: right">
                        <div style="font-weight: 400; font-size: 20px;">Course:
                          <input  class="col-2 course " name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 20px; font-style: bold;">
                        </div>
                      </div>
                      <div style="text-align: right">
                        <div style="font-weight: 400; font-size: 20px;">School Year:
                          <input  class="col-2" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 20px; font-style: bold;">
                        </div>
                      </div><br>

                      <table class="table">
                        <input  class="col-11 id" type="text" name="id" value="" id="id" hidden> 
                      <tr>
                        <td colspan="4" style="border:1px solid rgb(0, 0, 0);">
                          <div style="font-weight: 700; font-size: 24px; font-style: bold;">PERSONAL INFORMATION</div>
                        </td>
                      </tr>
                      <tr >
                        <td colspan="3" style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 20px;">Name:
                              <input  class="col-7 fullname cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 18px; font-style: bold;">
                            </div>
                          </div>
                        </td>
                        <td style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 20px;">Age:
                              <input  class="col-7 age cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 18px; font-style: bold;">
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 20px;">Date of birth:
                              <input  class="col-7 bday cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 18px; font-style: bold;"> 
                            </div> 
                          </div>
                        </td>
                        <td style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 20px;">Weight:
                              <input  class="col-7 weight cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 18px; font-style: bold;">
                            </div> 
                          </div>
                        </td>
                        <td style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 20px;">Height:
                              <input  class="col-7 height cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 18px; font-style: bold;">
                            </div> 
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 20px;">Blood Type:
                              <input  class="col-5 bloodtype cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 18px; font-style: bold;">
                            </div>  
                          </div>
                        </td>
                        <td colspan="2" style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 20px;">Allergies:
                              <input  class="col-7 allergies cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 18px; font-style: bold;">
                            </div> 
                          </div>
                        </td>
                        <td style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 20px;">Medication:
                              <input  class="col-6 medication cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 18px; font-style: bold;">
                          </div> 
                        </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 20px;">Address:
                              <input  class="col-9 address cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 18px; font-style: bold;">
                            </div> 
                          </div>
                        </td>
                        <td colspan="2"style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 20px;">Contact No.:
                              <input  class="col-9 contactNo cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 18px; font-style: bold;">
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 20px;">Temperature:
                              <input  class="col-5 temperature cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 18px; font-style: bold;">
                            </div>
                          </div>
                        </td>
                        <td style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 18px;">Pulse rate:
                              <input  class="col-5 pulse_rate cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 18px; font-style: bold;">
                            </div>
                          </div>
                        </td>
                        <td style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 18px;">Respiratory rate:
                              <input  class="col-4 res_rate cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 18px; font-style: bold;">
                            </div>
                          </div>
                        </td>
                        <td style="border:1px solid rgb(0, 0, 0);">
                          <div style="text-align: left">
                            <div style="font-weight: 400; font-size: 17px;">Blood Pressure:
                              <input  class="col-sm-5 bp cert" name="" type="text" value="" id="bp" style="font-weight: 400; font-size: 18px; font-style: bold;text-align:left">
                            </div>
                          </div>
                        </td>
                      </tr>
                    </table>
                    <div class="form-group row col-12 input">
                      <div style="font-weight: 700; font-size: 24px; font-style: bold;">THIS IS TO CERTIFY</div>&nbsp;<div style="font-weight: 400; font-size: 20px;">that</div>
                          <input  class="text-uppercase  name " type="text" value="" id="name"  style="font-weight: 400; font-size: 20px; font-style: bold;text-align:center;width:63%">
                      <div style="font-weight: 400; font-size: 20px;" >, male/female,</div>
                          <input  class="col-4 text-uppercase cy" type="text" value="" id="cy"  style="font-weight: 400; font-size: 20px; font-style: bold;text-align:center">
                      <div style="font-weight: 400; font-size: 20px;"> was physically examine by the undersigned and was diagnoised of:</div>
                      <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 20px; font-style: italic;">
                        &emsp;&emsp;&emsp;&emsp;course & year level
                      </div>
                    </div><br>
                    <div class="form-group row col-12">
                      <div style="font-weight: 700; font-size: 24px; font-style: bold;">DIAGNOSIS:</div>
                        <textarea class="col-12 diagnosis "  name="recommendation" value="" id="recommendation" rows="1" style="font-weight: 400; font-size: 20px;"></textarea>
                    </div>
                    <div class="form-group row col-12">
                    <div style="font-weight: 700; font-size: 24px; font-style: bold;">REMARKS:</div>&nbsp;&nbsp;&nbsp;
                        <textarea class="col-12 remarks"  name="recommendation" value="" id="recommendation" rows="1" style="font-weight: 400; font-size: 20px;"></textarea>
                    </div>
                    <div class="form-group" >
                      <div class="row col-12"><br>
                        <div style="font-weight: 700; font-size: 24px; ">THIS CERTIFICATION IS ISSUED</div>&nbsp;<div style="font-weight: 400; font-size: 20px; ">upon request of the above-name student/employee as requirement for:</div>
                      </div><br>
                      <div style="font-weight: 400; font-size: 20px;">
                      &emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="OJT" name="cert_issued[]" value="OJT">
                      On-The-Job Training
                      <div style="font-weight: 400; font-size: 20px;">
                      &emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="Return for Work" name="cert_issued[]" value="Return for Work">
                      Return for Work</div> 
                      <div style="font-weight: 400; font-size: 20px;">
                      &emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="Travel" name="cert_issued[]" value="Travel">
                      Travel</div>
                      <div style="font-weight: 400; font-size: 20px;">
                      &emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="Off-campus Activity" name="cert_issued[]" value="Off-campus Activity">
                      Off-campus activity</div>
                      <div style="font-weight: 400; font-size: 20px;">
                      &emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="others" name="cert_issued[]" value="others">
                      Others,please specify
                      <input class="others col-sm-3 " type="text" id="others" name="others" value="" style="font-weight: 400; font-size: 18px;">
                      </div> 
                    </div><br><br><br><br>
                    <div class=" row" >
                      <div class="col-sm-7">
                        <div class="form-group">
                          <input  class="col-9 " type="text" value="EDMUNDO R. VILLA, MD., MM" id="example-text-input" style="font-weight: 400; font-size: 22px;text-align:center;">
                        <div style="font-weight: 400; font-size: 20px;">Signature over Printed name of Attending Physician</div>
                        </div>
                      </div>
                      <div class="col-sm-5">
                        <div class="form-group w-50">
                          <input  class="col-12 " type="text" value="052764" id="example-text-input" style="font-weight: 400; font-size: 22px;text-align:center;">
                            <div style="font-weight: 400; font-size: 20px;">&emsp;&emsp;License Number</div>
                        </div>
                      </div>
                      <div class="form-group col-12">
                        <div style="font-weight: 400; font-size: 20px;">Date:
                          <input type="text" class="col-2"  name="recommendation" value="" id="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row footer-end">
                  <br><br><br>
                  {{-- <div class="col-1"></div> --}}
                  <div class="col-lg-9 col-md-8">
                      <div class="row">
                          <div class="col-md-4 d-flex justify-content-left" style="font-size: 15px;">Doc. Code SLSU-QF-MD05</div>
                          <div class="col-md-4 d-flex justify-content-left" style="font-size: 15px;">FOLLOW US HERE:</div>
                      </div>
                      <div class="row">
                          <div class="col-md-4 d-flex justify-content-left" style="font-size: 15px;">Revision: 02</div>
                          <div class="col-md-3 d-flex justify-content-left" style="font-size: 15px;font-style:italic;">https://www.facebook.com/southernleytestateu/</div>
                      </div>
                      <div class="row">
                          <div class="col-md-4 d-flex justify-content-left" style="font-size: 15px;">Date: 08 April 2022</div>
                          <div class="col-md-3 d-flex justify-content-left" style="font-size: 15px;font-style:italic;">https://www.youtube.com/c/SouthernLeyteStateUniversity</div>
                      </div>
                  </div>
                  <div class="col-md-3 col-sm-3"> 
                      <img src="{{asset('images/logo/socotec.png')}}" style="width: 200px; height: 90px;"></div>
                  </div>
                </div>
                  </div>
                </div>
{{-- show-tab --}}    
                <div class="tab-pane" id="show" aria-labelledby="show-tab" role="tabpanel">
                  <div class="table-responsive">

                       <div class="">
                        <button type="button" id="cancelBtnprint" class="btn btn-default btn-custom float-right button" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary float-right button" id="btnPrint" type="button"  data-dismiss="modal">Print</button>
                       </div><br><br>
                       <hr>
                       <input  class="col-11 id" type="text" name="id" value="" id="id" hidden> 
                       <input  class="col-11" type="text" name="status" value="Pending" hidden>
 
                      <div class="row printed-div  d-flex justify-content-left">
                        <div class="col-xl-8 col-lg-5 col-md-5 col-sm-5 d-flex justify-content-center"><img src="{{asset('images/logo/letter-SLSU-head.png')}}" style="width: 300px; height: 100px;"> </div>
                          <div class="col-xl-2 col-lg-4 col-md-5 col-sm-4"><br>
                            <div class="row">
                              <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 12px;" >MAIN CAMPUS</div></div>
                            <div class="row">
                              <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 12px;">San Roque, Sogod, Southern Leyte</div>
                            </div>
                            <div class="row">
                              <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 12px;">Email:&nbsp; <a href="#" >president@southernleytestateu.edu.ph</a> </div>
                            </div>
                            <div class="row">
                              <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 12px;">Website:&nbsp; <a href="#" >www.southernleytestateu.edu.ph</a></div>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 12px; border-bottom: 1px solid black; text-align:center">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                      </div>
                      <div class="row">
                       <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 15px; font-style: bold; text-align:center">Medical Certificate</div></div>
                      <div class="class print-body">
                       <div style="text-align: right">
                        <div style="font-weight: 400; font-size: 12px;">Course:
                          <input  class="col-2 course" name="course" type="text" value="" id="" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                        </div>
                      </div>
                      <div style="text-align: right">
                       <div style="font-weight: 400; font-size: 12px;">School Year:
                        <input  class="col-2 " name="" type="text" value="" id="" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                       </div>
                      </div> <br>
                      <table class="table">
                          <tr>
                            <td colspan="4" style="border:1px solid rgb(0, 0, 0);">
                                <div style="font-weight: 650; font-size: 12px; font-style: bold;">PERSONAL INFORMATION</div>
                            </td>
                        </tr>
                        <tr >
                            <td colspan="3" style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Name:
                                    <input  class="col-10 fullname cert name=" type="text" value="" id="lastname" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                  </div>
                                </div>
                                </td>
                            <td style="border:1px solid rgb(0, 0, 0);">
                              <div style="text-align: left">
                                <div style="font-weight: 400; font-size: 12px;">Age:
                                    <input  class="col-7 age cert" name="age" type="text" value="" id="age" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                </div>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2" style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Date of birth:
                                    <input  class="col-7 bday cert" name="bday" type="text" value="" id="bday" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly> 
                                  </div> 
                                </div>
                                </td>
                                <td style="border:1px solid rgb(0, 0, 0);">
                                    <div style="text-align: left">
                                      <div style="font-weight: 400; font-size: 12px;">Weight:
                                        <input  class="col-7 weight cert" name="weight" type="text" value="" id="weight" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                      </div> 
                                    </div>
                              </td>
                              <td style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Height:
                                    <input  class="col-7 height cert" name="height" type="text" value="" id="height" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                  </div> 
                                </div>
                            </td>
                          </tr>
                          <tr>
                            <td style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Blood Type:
                                    <input  class="col-5 bloodtype cert" name="bloodtype" type="text" value="" id="bloodtype" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                  </div>  
                                </div>
                            </td>
                            <td colspan="2" style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Allergies:
                                    <input  class="col-7 allergies cert" name="allergies" type="text" value="" id="allergies" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                  </div> 
                                </div>
                            </td>
                            <td style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Medication:
                                    <input  class="col-7 medication cert" name="medication" type="text" value="" id="medication" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                  </div> 
                                </div>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="3" style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Address:
                                    <input  class="col-10 address cert" name="" type="text" value="" id="address" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                  </div> 
                                </div>
                                </td>
                            <td style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Contact No.:
                                    <input  class="col-8 contactNo cert" name="" type="text" value="" id="contactNo" style="font-weight: 400; font-size: 12px; font-style: bold;text-align:left" readonly>
                                  </div>
                                </div>
                            </td>
                          </tr>
                          <tr>
                            <td style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Temperature:
                                    <input  class="col-5 temperature cert" name="" type="text" value="" id="temperature" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                  </div>
                                </div>
                            </td>
                            <td style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Pulse rate:
                                    <input  class="col-5 pulse_rate cert" name="" type="text" value="" id="pulse_rate" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                  </div>
                                </div>
                            </td>
                            <td style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Respiratory rate:
                                    <input  class="col-4 res_rate cert" name="" type="text" value="" id="res_rate" style="font-weight: 400; font-size: 12px; font-style: bold;" readonly>
                                  </div> 
                                </div>
                            </td>
                            <td style="border:1px solid rgb(0, 0, 0);">
                                <div style="text-align: left">
                                  <div style="font-weight: 400; font-size: 12px;">Blood Pressure:
                                    <input  class="col-5 bp cert" name="" type="text" value="" id="bp" style="font-weight: 400; font-size: 12px; font-style: bold;text-align:left" readonly> 
                                  </div>
                                </div>
                            </td>
                          </tr>
                      </table>
                      <div class="form-group row col-12 input">
                        <div style="font-weight: 600; font-size: 12px; font-style: bold;">THIS IS TO CERTIFY that</div>&nbsp;<div style="font-weight: 400; font-size: 12px;">that</div>
                            <input  class="text-uppercase  name " type="text" value="" id="name"  style="font-weight: 400; font-size: 12px; font-style: bold;text-align:center;width:80%" readonly> 
                            <div style="font-weight: 400; font-size: 12px;" >,male/female,</div>
                            <input  class="col-3 text-uppercase  cy" type="text" value="" id="cy"  style="font-weight: 400; font-size: 12px; font-style: bold;text-align:center;width:30"readonly ><br>
                            <div style="font-weight: 400; font-size: 12px;">physically examine by the undersigned and was diagnoised of:</div>
                            <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 12px; font-style: italic;">
                              &emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp;(course & year level)
                            </div>
                      </div>
                      <div class="form-group row col-12">
                        <div style="font-weight: 600; font-size: 12px; font-style: bold;">DIAGNOSIS:</div>
                          <textarea class="col-12 diagnosis "  name="recommendation" value="" id="diagnosis" rows="1" style="font-weight: 400; font-size: 12px;" readonly></textarea>
                        </div>
                      <div class="form-group row col-12">
                        <div style="font-weight: 600; font-size: 12px; font-style: bold;">REMARKS:</div>&nbsp;&nbsp;&nbsp;
                          <textarea class="col-12 remarks"  name="recommendation" value="" id="remarks" rows="1" style="font-weight: 400; font-size: 12px;" readonly></textarea>
                        </div>
                      <div class="form-group" >
                        <div class="row col-12">
                          <div style="font-weight: 700; font-size: 12px; ">THIS CERTIFICATION IS ISSUED</div>&nbsp;<div style="font-weight: 400; font-size: 12px; ">upon request of the above-name student/employee as requirement for:</div>
                        </div>
                        <div style="font-weight: 400; font-size: 12px;">
                          &emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="OJT" name="cert_issued[]" value="OJT">
                          On-The-Job Training
                          <div style="font-weight: 400; font-size: 12px;">
                          &emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="Return for Work" name="cert_issued[]" value="Return for Work">
                          Return for Work</div> 
                          <div style="font-weight: 400; font-size: 12px;">
                          &emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="Travel" name="cert_issued[]" value="Travel">
                          Travel</div>
                          <div style="font-weight: 400; font-size: 12px;">
                          &emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="Off-campus Activity" name="cert_issued[]" value="Off-campus Activity">
                          Off-campus activity</div>
                          <div style="font-weight: 400; font-size: 12px;">
                          &emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="others" name="cert_issued[]" value="others">
                          Others,please specify
                          <input class="others col-sm-2 " type="text" id="others" name="others" value="" style="font-weight: 400; font-size: 18px;">
                          </div> 
                        </div><br><br>
                        <div class=" row" >
                          <div class="col-sm-7">
                              <div class="form-group">
                                &nbsp;<input  class="col-5 " type="text" value="EDMUNDO R. VILLA, MD., MM" id="example-text-input" style="font-weight: 400; font-size: 15px;text-align:center;">
                                  <div style="font-weight: 400; font-size: 12px;">&nbsp;Signature over Printed name of Attending Physician</div>
                              </div>
                          </div>
                        <div class="col-sm-4">
                          <div class="form-group w-50">
                              <input  class="col-8 " type="text" value="052764" id="example-text-input" style="font-weight: 400; font-size: 15px;text-align:center;">
                              <div style="font-weight: 400; font-size: 12px;">&emsp;&emsp;License Number</div>
                          </div>
                        </div>
                        <div class="form-group col-12 ">
                          <div style="font-weight: 400; font-size: 12px;">Date:
                            <input type="text" class="col-1"  name="recommendation" value="" id="recommendation" rows="1">
                          </div>
                        </div>
                      </div>
                      </div>
                      <div class="row footer-end"> <br><br>
                        {{-- <div class="col-1"></div> --}}
                        <div class="col-lg-9 col-md-8">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-left" style="font-size: 12px;">Doc. Code SLSU-QF-MD05</span></div>
                                <div class="col-md-4 d-flex justify-content-left" style="font-size: 12px;">FOLLOW US HERE:</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-left" style="font-size: 12px;">Revision: 02</div>
                                <div class="col-md-3 d-flex justify-content-left" style="font-size: 12px;font-style:italic;">https://www.facebook.com/southernleytestateu/</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-left" style="font-size: 12px;">Date: 08 April 2022</div>
                                <div class="col-md-3 d-flex justify-content-left" style="font-size: 12px;font-style:italic;">https://www.youtube.com/c/SouthernLeyteStateUniversity</div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3"> 
                            <img src="{{asset('images/logo/socotec.png')}}" style="width: 55%; height: 70%;"></div>
                        </div>
                    </div>
                    </div>
                </div>
                @include('modal.preview-medical-certificate')
              </div>{{-- end-tab-content--}} 
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

//Search-InputF
 $(document).ready(function() {
  $("#submitBtn").submit(function() {
    event.preventDefault();
    var search = $('#searchInput').val();
         $.ajax({
            type:'post',
            url:'/medical-certificate',
            data:{search:search},

            success:function(data){
              $('#myTable').html(data);   
            } 
         })
       })
 });

function selectCheckbox(id) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].id != id) {
            checkboxes[i].checked = false;
        }
    }
    if (id == 'others') {
        document.getElementById('others_input').disabled = false;
    } else {
        document.getElementById('others_input').disabled = true;
    }
}

function selectBox(id) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    var othersInput = document.getElementById('othersinput');
    
    if (id == 'others') {
        othersInput.disabled = false;
    } else {
        othersInput.disabled = true;
        document.getElementById('others').checked = false;
        if (id == 'OJT') {
            othersInput.value = '';
        }
        else if (id == 'Return for Work') {
            othersInput.value = '';
        }
        else if (id == 'Travel') {
            othersInput.value = '';
        }
        else if (id == 'Off-campus Activity') {
            othersInput.value = '';
        }
    }
    
    // Uncheck all checkboxes except the selected one
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].id != id) {
            checkboxes[i].checked = false;
        }
    }
}



//Add Form / To create
  $("#saveCert").submit(function(e) {
            e.preventDefault();

            var form = $(this);
            var actionUrl = form.attr('action');

            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(), 
                success: function(response){
                  if (response.status == 200) {

             Swal.fire({
                title: response['success'],
                icon: 'success',
                confirmButtonText: 'proceed',           
              }).then((response2) => {
              
              if (response2.isConfirmed) {
                console.log(response.others)
                var  cert_issued = response.cert_issued;
                var dateArr = response.bday.split('-'); 
                var year = dateArr[0];
                var month = dateArr[1];
                var day = dateArr[2];
                var newDateStr = month + '/' + day + '/' + year;   

                $("input:checkbox").each(function() {
                        if (cert_issued.includes($(this).prop("value"))) {
                            $(this).prop("checked", true);
                        }
                    });

                $('.id').val(response.certId);
                $('#id').val(response.patientId);
                $('.fullname').val([response.lastname]+', '+[response.firstname]+' '+[response.middlename]);
                $('#name').val([response.lastname]+', '+[response.firstname]+' '+[response.middlename]);
                $('#course').val(response.course);
                $('.cy').val([response.course]+' - '+[response.yr]);
                $('#age').val(response.age);
                $('.bday').val(newDateStr);
                $('#weight').val(response.weight);
                $('#height').val(response.height);
                $('#bloodtype').val(response.bloodtype);
                $('#allergies').val(response.allergies);
                $('#medication').val(response.medication);
                $('.address').val([response.brgy]+', '+[response.city]+', '+[response.province]);
                $('#contactNo').val(response.contactNo);
                $('#temperature').val(response.temperature);
                $('#pulse_rate').val(response.pulse_rate);
                $('#res_rate').val(response.res_rate);
                $('#bp').val(response.bp);
                $('.diagnosis').val(response.diagnosis);
                $('.remarks').val(response.remarks);
                $('.others').val(response.others);

                $('.tab-pane').removeClass('active')
                $('#view').addClass('active')
                $('.nav-link').removeClass('active')
                $('#view-tab').addClass('active')
                $("#view").removeAttr("style").hide()
                $("#view").show()
               }
              })
             } 
            }
          })
        });

//view
  $("#preview").on("hide.bs.modal", function(e){
      $("input:checkbox").each(function() {
          $(this).prop("checked", false);  
      });
  })

  $("#preview").on("shown.bs.modal", function(e){ 
    // const id = $(this).data('id');
 
    $.ajax({
    type: 'post',
    url: '/view',
    data:{ id: $(e.relatedTarget).data("id")},
    dataType: 'json',
   
    success: function(response) {
      console.log(response.id)
      console.log(response.others)

            var  cert_issued = response.cert_issued;
            var dateArr = response.bday.split('-'); 
            var year = dateArr[0];
            var month = dateArr[1];
            var day = dateArr[2];
            var newDateStr = month + '/' + day + '/' + year;
  

          $("input:checkbox").each(function() {
                  if (cert_issued.includes($(this).prop("value"))) {
                      $(this).prop("checked", true);
                  }
              });

              $('.id').val(response.id);
              $('#id').val(response.patientId);
              $('.lastname').val(response.lastname);
              $('.firstname').val(response.firstname);
              $('.middlename').val(response.middlename);
              $('.bday').val(newDateStr);
              $('.weight').val(response.weight);
              $('.height').val(response.height);
              $('.bloodtype').val(response.bloodtype);
              $('.allergies').val(response.allergies);
              $('.medication').val(response.medication);
              $('.temperature').val(response.temperature);
              $('.pulse_rate').val(response.pulse_rate);
              $('.res_rate').val(response.res_rate);
              $('.bp').val(response.bp);
              $('.diagnosis').val(response.diagnosis);
              $('.remarks').val(response.remarks);
              $('.othersinput').val(response.others);

              
              // $('.tab-pane').removeClass('active')
              // $('#view').addClass('active')
              // $('.nav-link').removeClass('active')
              // $('#view-tab').addClass('active')
              // $("#view").removeAttr("style").hide()
              // $("#view").show()
        }
      })
    })

//List
 $(document).on('click', '.view', function(){
    var table = $('.zero-configuration').DataTable();

    $.ajax({
        url: '/view-list', // replace with your endpoint that returns JSON data
        type: 'POST',
        data: { patientId: $(this).data('id') },
        dataType: 'json',
        success: function(response) {
          $('.tab-pane').removeClass('active')
        $('#list').addClass('active')
        $('.nav-link').removeClass('active')
        $('#list-tab').addClass('active')
      
        $("#list").removeAttr("style").hide()
          $("#list").show()

          if (response.data.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No records found.',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                $('a[href="#search"]').tab('show');
                location.reload();
                $("#search").hide();
            });
            return;
        }
            $.each(response.data, function(index, data) {
            $('.fullname').val([data.firstname]+' '+[data.middlename]+' '+[data.lastname]);
            var dateArr = data.date.split('-'); 
            var year = dateArr[0];
            var month = dateArr[1];
            var day = dateArr[2];
            var newDateStr = month + '/' + day + '/' + year;      
            var jsonString = data.cert_issued;
            var cert_issued = JSON.parse(jsonString);


            var editBtn = '<button type="button"

          if (data.status === 'Approved') {
              editBtn = '<button type="button" class="btn btn-default editStudent" data-id="' + data.id + '" disabled><i class="fa fa-edit"></i></button>';
          }
          
          if (cert_issued.includes("Others")) {
            cert_issued = data.others;
          }

          var row = table.row.add([
              newDateStr,
              data.diagnosis,
              data.remarks,
              cert_issued,
              data.status,
              editBtn
          ]).draw(false).node();

                $(row).addClass('tr');
                if (data.status === 'Pending') {
                    $('td', row).eq(4).addClass('pending-status');
                  }
                  else if (data.status === 'Approved') {
                    $('td', row).eq(4).addClass('approved-status');
                  }
                  else if (data.status === 'Disapproved') {
                    $('td', row).eq(4).addClass('disapproved-status');
                  }
            });
        }
    });
 });

//Status
 $(document).on('click', '.status', function(){
  // const id = $(this).data('id');
 
    $.ajax({
    type: 'post',
    url: '/status',
    data: { patientId: $(this).data('id') },
    dataType: 'json',
   
    success: function(response) {
      console.log(response.patientId)

   
        $('.tab-pane').removeClass('active')
        $('#status').addClass('active')
        $('.nav-link').removeClass('active')
        $('#status-tab').addClass('active')
      
        $("#status").removeAttr("style").hide()
        $("#status").show()

        if (response.data.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No records found.',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                $('a[href="#home"]').tab('show');
                location.reload();
                $("#home").hide();
            });
            return;
        }
          response.data.forEach(element => {
          console.log(element.status);     
          $('.fullname').val([element.firstname]+' '+[element.middlename]+' '+[element.lastname]);
        
            var dateArr = element.date.split('-'); 
            var year = dateArr[0];
            var month = dateArr[1];
            var day = dateArr[2];
            var newDateStr = month + '/' + day + '/' + year;      
            var jsonString = element.cert_issued;
            var cert_issued = JSON.parse(jsonString);
            var status = element.status;
            
            if (cert_issued.includes("Others")) {
            cert_issued = data.others;
          }
          
            if (status === 'Pending') {
              $('#viewStatus').append('<tr>\
              <td>'+newDateStr+'</td>\
              <td>'+cert_issued+'</td>\
              <td class="pending-status">'+element.status+'</td>\
              <td>'+element.stat_remarks+'</td>\
              <td><button type="button" class="btn btn-default printBtnStatus" data-id="'+element.id+'" disabled><i class="fa fa-print" style="font-size:15px"></i></button></td>\
            </tr>');
            } else if(status === 'Approved'){
            $('#viewStatus').append('<tr>\
              <td>'+newDateStr+'</td>\
              <td>'+cert_issued+'</td>\
              <td class="approved-status">'+element.status+'</td>\
              <td>'+element.stat_remarks+'</td>\
              <td><button type="button" class="btn btn-default printBtnStatus" data-id="'+element.id+'"><i class="fa fa-print" style="font-size:15px"></i></button></td>\
            </tr>');
          }
         else if (status === 'Disapproved') {
            $('#viewStatus').append('<tr>\
              <td>'+newDateStr+'</td>\
              <td>'+cert_issued+'</td>\
              <td class="disapproved-status">'+element.status+'</td>\
              <td>'+element.stat_remarks+'</td>\
              <td><button type="button" class="btn btn-default printBtnStatus" data-id="'+element.id+'" disabled><i class="fa fa-print" style="font-size:15px"></i></button></td>\
            </tr>');
          }
        
          }
          )
        }
        })
      })
    


//PrintTab 
 $(document).on('click', '.printBtnStatus', function(){
  
          $.ajax({
            type: 'post',
            url: '/print',
            data: { id: $(this).data('id') },
            dataType: 'json',
          
          success: function(response){

              $('.tab-pane').removeClass('active')
              $('#show').addClass('active')
              $('.nav-link').removeClass('active')
              $('#show-tab').addClass('active')
              $("#show").removeAttr("style").hide()
              $("#show").show()

                console.log(response.cert_issued)
                var  cert_issued = response.cert_issued
                var dateArr = response.bday.split('-'); 
                var year = dateArr[0];
                var month = dateArr[1];
                var day = dateArr[2];
                var newDateStr = month + '/' + day + '/' + year;

                $("input:checkbox").each(function() {
                        if (cert_issued.includes($(this).prop("value"))) {
                            $(this).prop("checked", true);
                        }
                    });

                $('.id').val(response.id);
                $('#id').val(response.patientId);
                $('.fullname').val([response.lastname]+', '+[response.firstname]+' '+[response.middlename]);
                $('.contactNo').val(response.contactNo);
                $('.name').val([response.lastname]+', '+[response.firstname]+' '+[response.middlename]);
                $('.course').val(response.course);
                $('.cy').val([response.course]+' - '+[response.yr]);
                $('.age').val(response.age);
              
                $('.weight').val(response.weight);
                $('.height').val(response.height);
                $('.bloodtype').val(response.bloodtype);
                $('.allergies').val(response.allergies);
                $('.medication').val(response.medication);
                $('.address').val([response.brgy]+', '+[response.city]+', '+[response.province]);
                $('.contactNo').val(response.contactNo);
                $('.temperature').val(response.temperature);
                $('.pulse_rate').val(response.pulse_rate);
                $('.res_rate').val(response.res_rate);
                $('.bp').val(response.bp);
                $('.diagnosis').val(response.diagnosis);
                $('.remarks').val(response.remarks);
                $('.others').val(response.others);
               }
            })
           })
       

//AddModal
 $(document).on('click', '.add', function(){
  // const id = $(this).data('id');
 
    $.ajax({
    type: 'post',
    url: '/add-new',
    data: { id: $(this).data('id') },
    dataType: 'json',
   
    success: function(response) {
      console.log(response.id)

      var dateArr = response.BirthDate.split('-'); 
                var year = dateArr[0];
                var month = dateArr[1];
                var day = dateArr[2];
                var newDateStr = month + '-' + day + '-' + year;

      $("input:checkbox").each(function() {
                    $(this).prop("checked", false);  
            });

        $('.id').val(response.id);
        $('.lastname').val(response.last_name);
        $('.firstname').val(response.first_name);
        $('.middlename').val(response.middle_name);
        $('.age').val(response.age);
        $('.BirthDate').val(response.BirthDate);
        $('.contactNo').val(response.ContactNo);
        $('.course').val(response.Course);
        $('.year').val(response.year);
        $('.brgy').val(response.brgy);
        $('.city').val(response.city);
        $('.province').val(response.province);
       


        $('.tab-pane').removeClass('active')
        $('#add').addClass('active')
        $('.nav-link').removeClass('active')
        $('#add-tab').addClass('active')
      
        $("#add").removeAttr("style").hide()
        $("#add").show()
    },
  })
 })

//Pending Status
  $("#pendingForm").submit(function(e) {
      e.preventDefault();
      var form = $(this);
      var actionUrl = form.attr('action');

        $.ajax({
          type: "POST",
          url: actionUrl,
          data: form.serialize(), 

            success: function(response){
              if (response.status == 200) {
                //  $('#history').tab('show')
              Swal.fire({
                  title: response['success'],
                  icon: 'success',
                  confirmButtonText: 'Okay',
                }).then((response) => {
                
                if (response.isConfirmed) {
                   location.reload()
                }
              })
            }
          }
              
        });
      });

//Update
 $("#updateRecord").submit(function(e) {
            e.preventDefault();

          var form = $(this);
          var actionUrl = form.attr('action');

          $.ajax({
              type: "POST",
              url: actionUrl,
              data: form.serialize(), 
              success: function(response){
                if (response.status == 200) {
                  Swal.fire({
                title: response['success'],
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Proceed',
                cancelButtonText: 'Update Only'
              }).then((response2) => {
                if (response2.isConfirmed) {
                  console.log(response.others)
              console.log(response.cert_issued)
              var  cert_issued = response.cert_issued
              var dateArr = response.bday.split('-'); 
                var year = dateArr[0];
                var month = dateArr[1];
                var day = dateArr[2];
                var newDateStr = month + '/' + day + '/' + year;
              $("input:checkbox").each(function() {
                      if (cert_issued.includes($(this).prop("value"))) {
                          $(this).prop("checked", true);
                      }
                  });
              $('#preview').modal('hide');
              $('.id').val(response.id);
              $('#id').val(response.patientId);
              $('.fullname').val([response.lastname]+', '+[response.firstname]+' '+[response.middlename]);
              $('#name').val([response.lastname]+', '+[response.firstname]+' '+[response.middlename]);
              $('#course').val(response.course);
              $('.cy').val([response.course]+' - '+[response.yr]);
              $('#age').val(response.age);
              $('.bday').val(newDateStr);
              $('#weight').val(response.weight);
              $('#height').val(response.height);
              $('#bloodtype').val(response.bloodtype);
              $('#allergies').val(response.allergies);
              $('#medication').val(response.medication);
              $('.address').val([response.brgy]+', '+[response.city]+', '+[response.province]);
              $('#contactNo').val(response.contactNo);
              $('#temperature').val(response.temperature);
              $('#pulse_rate').val(response.pulse_rate);
              $('#res_rate').val(response.res_rate);
              $('#bp').val(response.bp);
              $('.diagnosis').val(response.diagnosis);
              $('.remarks').val(response.remarks);
              $('.others').val(response.others);

              $('.tab-pane').removeClass('active')
              $('#view').addClass('active')
              $('.nav-link').removeClass('active')
              $('#view-tab').addClass('active')
              $("#view").removeAttr("style").hide()
              $("#view").show()
                } else if (response2.dismiss === Swal.DismissReason.cancel) {
                  Swal.fire({
                  title: "Updated Successfully",
                  text: "The record has been updated successfully.",
                  icon: "success",
                  buttons: {
                      confirm: {
                          text: "OK",
                          value: true,
                          visible: true,
                          className: "",
                          closeModal: true
                }
            }
        }).then((response3) => {
                if (response3.isConfirmed) {
                  location.reload();
                }
              })
            }
            })
          
        console.log(response);
        }
      }
     });
   });


//Back button in View
 $(document).ready(function(){
    $("#cancelBtnprint").click(function(){
          $('a[href="#search"]').tab('show');
          location.reload();
          $("#search").hide()
  })
 });

  $(document).ready(function(){
      $("#backbutton").click(function(){
            $('a[href="#search"]').tab('show');
            location.reload();
            $("#search").hide()
    })
  });
  $(document).ready(function(){
      $("#cancelBtn").click(function(){
            $('a[href="#search"]').tab('show');
            location.reload();
            $("#search").hide()
    })
  });
  
  $(document).ready(function(){
      $("#returnHome").click(function(){
            $('a[href="#search"]').tab('show');
            location.reload();
          $("#search").hide()
    })
  })


  $(document).ready(function(){
        $("#gotosearch").click(function(){
              $('a[href="#search"]').tab('show');
              location.reload();
            $("#search").hide()

      })
    })

//Print 
 document.getElementById("btnPrint").onclick = function () {
      printElement(document.getElementById("printPart"));
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


</script>

@endsection