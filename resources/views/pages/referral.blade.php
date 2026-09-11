@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','MSMIS')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
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
  .textbox {
    transform: scale(1.5);
    margin: 4px;
    accent-color: rgb(58, 57, 57);
    width: 50px;
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
  .btn-sm {
    width: 70px; /* adjust the width as needed */
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
 left: 150px;
   }
   /* .print-body{
     position: absolute;
     top: 20px;
     left: 0px;
     right: 0px;
     max-width: 12in;
     max-height: 13in;
   }*/
   /* .footer-end{
   position:  relative;
   bottom: 1px;
   left: 100px;
   }  */
   
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
   size: A4;
 }
 </style>
@endsection
{{-- page-styles --}}

@section('content')
{{-- <div class="row">
    <div class="col-12">
        <p>Read full documnetation <a href="https://datatables.net/" target="_blank">here</a></p>
    </div>
</div> --}}
<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row justify-content-center">
    <div class="col-12">
        <div class="card" style="width: 80rem;" >
              <div class="card-header">
                <ul class="nav nav-tabs border-0" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="record-tab" data-toggle="tab" href="#record" aria-controls="record" role="tab"
                      aria-selected="true" style="display : none">
                      <i class="bx bx-file align-middle"></i>
                      <span class="align-middle"> Patient record</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="refer-tab" data-toggle="tab" href="#refer" aria-controls="refer" role="tab"
                      aria-selected="false" style="display : none" >
                      <i class="bx bxs-user align-middle"></i>
                      <span class="align-middle">Referral Slip</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="generate-tab" data-toggle="tab" href="#generate" aria-controls="generate" role="tab"
                      aria-selected="false" style="display : none">
                      <i class="bx bxs-bookmark-star align-middle"></i>
                      <span class="align-middle">Generate Referral Slip</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="approval-tab" data-toggle="tab" href="#approval" aria-controls="approval" role="tab"
                      aria-selected="false" style="display : none">
                      <i class="bx bx-list-ul align-middle"></i>
                      <span class="align-middle">approval</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="return-tab" data-toggle="tab" href="#return" aria-controls="return" role="tab"
                      aria-selected="false" style="display : none">
                      <i class="bx bx-list-ul align-middle"></i>
                      <span class="align-middle">Upload Referral Slip</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="view-tab" data-toggle="tab" href="#view" aria-controls="view" role="tab"
                      aria-selected="false" style="display : none" >
                      <i class="bx bx-list-ul align-middle"></i>
                      <span class="align-middle">Records</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="print-tab" data-toggle="tab" href="#print" aria-controls="print" role="tab"
                      aria-selected="false" style="display : none">
                      <i class="bx bx-list-ul align-middle"></i>
                      <span class="align-middle">print</span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="status-tab" data-toggle="tab" href="#status" aria-controls="status" role="tab"
                      aria-selected="false" style="display : none"  >
                      <i class="bx bx-list-ul align-middle"></i>
                      <span class="align-middle">status</span>
                    </a>
                  </li>
                </ul>
                <div class="tab-content">
{{--record-tab--}}
                  <div class="tab-pane active" id="record" aria-labelledby="record-tab" role="tabpanel">
                    <h5 style="font-weight: bold; font-style: italic;color:royalblue)">PATIENT RECORDS</h5><br>
                    <div class="table-responsive">
                      <div class="col-12">
                        <div class="form-group">
                            <form  action="/add-patient" method="post" id="submitBtn">
                              <div class="input-group mb-3">
                                <input type="text" class="form-control col-sm-2" placeholder="Search" id="searchInput">
                                <div class="input-group-append">
                                  <button class="btn btn-primary submitBtn" type="submit"><i class="fas fa-search"></i></button>
                                </div>
                              </div>
                              </form>  
                            <div class="table-responsive">
                              <table class="table studentsTable table-bordered table-striped" id="myTable" style="width:100%">
                                <thead>
                                  <tr>
                                    <th style="color:white;">id</th>
                                    <th style="color:white;">Last Name</th>
                                    <th style="color:white;">First Name</th>
                                    <th style="color:white;">Middle Name</th>
                                    <th style="color:white;">Create</th>
                                    <th style="color:white;">Action</th>
                                  </tr>
                              </thead>
                              </table>
                              {{-- @include('modal.viewPatientRecord')    --}}
                              <br><br><br><br>
                            </div>
                        </div>
                        @if (session()->has('success'))
                        <script>
                            setTimeout(function() {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: '{{ session()->get('success') }}'
                                });
                            }, 1000);
                        </script>
                       @endif
                      </div>
                    </div>
                  </div>
{{--add-tab  --}}
                  <div class="tab-pane " id="refer" aria-labelledby="refer-tab" role="tabpanel">
                    <div class="table-responsive">
                        <h5 style="font-weight: bold; font-style: italic;color:royalblue)">INFORMATION</h5>
                      <form  action="/saveReferral" method="post" id="saveRefer">
                        @csrf
                        <div style="text-align: right">
                          Date:
                             <input  class="form-control date col-sm-2 course cert float-right" name="date" type="date" value="" id="date">
                           </div>
                           <div class="form-group col-12">
                            <div style="font-weight: 500; font-size: 15px;font-style: bold;">REFERRED TO:<span class="text-danger">*</span></div>
                            <div style="font-weight: 400; font-size: 13px;">
                              &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="hospital" name="referTo[]" value="Hospital" onclick="selectCheckbox('hospital')">
                              <label for="hospital">HOSPITAL</label>
                            </div>
                            <div style="font-weight: 400; font-size: 13px;">
                              &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="rhu" name="referTo[]" value="RHU" onclick="selectCheckbox('rhu')">
                              <label for="rhu">RHU</label>
                            </div> 
                            <div style="font-weight: 400; font-size: 13px;">
                              &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="visiting_physician" name="referTo[]" value="Visiting Physician" onclick="selectCheckbox('visiting_physician')">
                              <label for="visiting_physician">VISITING PHYSICIAN</label>
                            </div>
                            <div style="font-weight: 400; font-size: 13px;">
                              &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="others" name="referTo[]" value="Others" onclick="selectCheckbox('others')">
                              <label for="others">OTHERS (please specify)</label>
                              <input class="others col-sm-2 cert others" type="text" id="others_text" name="others" value="" disabled >
                            </div> 
                          </div>
                        <div class="form-group">
                          <input type="text" class="form-control id" id="id" name="patientId" hidden >
                        </div>
                          <div class="form-group">
                            <div class="col-sm-12">
                          <div class="row">
                              <div class="col-sm-3">
                                <label for="last_name">Name</label>
                                <div class="form-group">
                                  <label for="last_name">Last Name</label>
                                  <input type="text" class="form-control lastname" name="lastname"id="last_name" readonly>
                                </div>
                              </div>
                              <div class="col-sm-3">
                                  <div class="form-group">
                                    <br>
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control firstname"  name="firstname"id="first_name" readonly>
                                  </div>
                                </div>
                                <div class="col-sm-3">
                                  <div class="form-group">
                                    <br>
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" class="form-control middlename" name="middlename" id="middle_name" readonly>
                                  </div>
                                </div>
                            <div class="col-sm-1">
                              <div class="form-group">
                                <br>
                                <label for="age">Age</label>
                                <input type="number" class="form-control age" id="age" readonly>
                              </div>
                            </div>
                          <div class="col-sm-2">
                              <div class="form-group">
                                <br>
                                <label for="age">Gender</label>
                                <input type="number" class="form-control age" id="age" readonly>
                                </select>
                              </select> 
                              </div>
                            </div>
                          </div>
                      </div>
                      </div>
                     <div class="col-sm-12">
                      <label for="address">Boarding House Address</label>
                      <div class="row">
                       <div class="col-sm-4">
                         <div class="form-group">
                          <label for="address">Barangay<span class="text-danger">*</span></label>
                          <input type="text" class="form-control @error('b_brgy') is-invalid @enderror" name="b_brgy" value="{{ old('b_brgy') }}" required autocomplete="b_brgy" id="b_brgy">
                         </div>
                        </div>
                        <div class="col-sm-4">
                          <div class="form-group">
                           <label for="address">City<span class="text-danger">*</span></label>
                           <input type="text" class="form-control @error('b_city') is-invalid @enderror" name="b_city" value="{{ old('b_city') }}" required autocomplete="b_city" id="b_city">
                          </div>
                         </div>
                         <div class="col-sm-4">
                          <div class="form-group">
                           <label for="address">Province<span class="text-danger">*</span></label>
                           <input type="text" class="form-control @error('b_province') is-invalid @enderror" name="b_province" value="{{ old('b_province') }}" required autocomplete="b_province" id="b_province">
                          </div>
                         </div>
                       </div>
                      </div>
                      <input type="text" class="form-control" id="" name="file[]" value="No File Upload" hidden>
                          <div class="col-sm-12">
                            <div style="font-weight: 700; font-size: 15px;font-style: bold;">REASON/s FOR REFERRAL:</div>
                            <textarea class="form-control col-12 @error('reason') is-invalid @enderror" name="reason" value="{{ old('reason') }}" required autocomplete="reason" id="reason" rows="5"></textarea>
                          </div>
                          <br>
                          <div class="form-group">
                            <button type="button" class="btn btn-default btn-custom float-right button" id="cancel">Cancel</button>
                            <button type="submit" class="btn btn-primary float-right button" type="button" >Save</button>
                          </div> 
                      </form>
                    </div>
                   </div>
{{--generate-tab--}}
                  <div class="tab-pane " id="generate" aria-labelledby="generate-tab" role="tabpanel">
                     <h5 style="font-weight: bold; font-style: italic;color:royalblue)">GENERATE REFERRAL SLIP</h5>
                    <div id="printThis">
                      <div class="row printed-div  d-flex justify-content-left">
                        <div class="col-xl-8  col-lg-6 col-md-5 col-sm-5 d-flex justify-content-center"><img src="{{asset('images/logo/letter-SLSU-head.png')}}" style="width: 550px; height: 130px;">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-7 col-sm-6"><br>
                          <div class="row">
                            &emsp;&emsp;&emsp;&emsp;&emsp; <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;" >MAIN CAMPUS</div>
                          </div>
                          <div class="row">
                            &emsp;&emsp;&emsp;&emsp;&emsp; <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;">San Roque, Sogod, Southern Leyte</div>
                          </div>
                          <div class="row">
                            &emsp;&emsp;&emsp;&emsp;&emsp;<div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;">Email:&nbsp; <a href="#" >president@southernleytestateu.edu.ph</a> </div>
                          </div>
                          <div class="row">
                            &emsp;&emsp;&emsp;&emsp;&emsp;<div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;">Website:&nbsp; <a href="#" >www.southernleytestateu.edu.ph</a></div>
                          </div>
                        </div>
                     </div><br><br><br><br><br><br>
                      <div class="row">
                        <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 13px; border-bottom: 1px solid black; text-align:center">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                        </div>
                        <div class="row">
                        <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 600; font-size: 20px; font-style: bold; text-align:center">Referral Slip</div>
                        </div>
                      <div style="font-weight: 400; font-size: 18px; text-align: right">
                        Course:
                        <input  class="col-sm-2 course cert " name="" type="text" value="" id="fullname">
                      </div>
                      <div  style="font-weight: 400; font-size: 18px;text-align: right">
                        School Year:
                        <input  class="col-2 cert" name="" type="text" value="" id="fullname" >
                      </div>
                      <div  style="font-weight: 400; font-size: 18px;text-align: right">
                        Date:
                        <input  class="col-sm-2 date cert " name="" type="text" value="" id="date">
                      </div>
                      <div class="form-group col-12">
                        <div class="row" style="font-weight: 700; font-size:  20px;font-style: bold;">
                          REFERRED TO:
                        </div> 
                      <div style="font-weight: 400; font-size: 18px;">
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="Hospital" name="referTo[]" value="Hospital">
                        HOSPITAL 
                      </div>
                        <div style="font-weight: 400; font-size: 18px;">
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="RHU" name="referTo[]" value="RHU">
                        RHU</div> 
                        <div style="font-weight: 400; font-size: 18px;">
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="Visiting Physician" name="referTo[]" value="Visiting Physician">
                        VISITING PHYSICIAN</div>
                         <div style="font-weight: 400; font-size: 18px;">
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="others" name="referTo[]" value="others">
                        Others,please specify
                        <input class="others col-sm-2 cert" type="text" id="others" name="others" value="" >
                      </div> 
                      </div>
                       <div class="form-group col-sm-12" style="font-weight: 300; font-size: 18px; align-text:middle;">
                        <div class="row">
                            Name:
                            <input  class=" cert lastname" type="text" value="" id="example-text-input" style="width:22%;text-align:center">&nbsp;
                            <input  class=" cert firstname" type="text" value="" id="example-text-input" style="width:20%;text-align:center">&nbsp;
                            <input  class=" cert middlename" type="text" value="" id="example-text-input" style="width:20%;text-align:center">
                            Age:
                            <input  class="cert age" type="text" value="" id="example-text-input" style="width:8%;text-align:center">
                            Gender:
                            <input  class=" cert gender" type="text" value="" id="example-text-input" style="width:15%;text-align:center">
                          <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 13px; font-style: italic;padding:0;">
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Last)
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(First)
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Middle)
                          </div>
                        </div>
                        <div class="row">
                            Date of Birth:
                            <input  class=" cert BirthDate" type="text" value="" id="example-text-input" style="width:17%">
                            Civil Status:
                            <input  class=" cert civil_status" type="text" value="" id="example-text-input" style="width:16%">
                            Nationality:
                           <input  class=" cert nationality" type="text" value="" id="example-text-input" style="width:16%">
                            Religion:
                           <input  class="cert religion" type="text" value="" id="example-text-input" style="width:17%">
                        </div>
                        <div class="row">
                            Boarding House Address:
                            <input  class=" cert bhAddress" type="text" value="" id="example-text-input" style="width:81%">
                        </div>
                        <div class="row">
                            Home Address:
                            <input  class=" cert address" type="text" value="" id="example-text-input" style="width:88.5%">
                        </div>
                        <div class="row">
                            Parent/Guardian:
                            <input  class=" cert guardian" type="text" value="" id="example-text-input" style="width:42%">
                            Parent/Guardian Contact No.:
                            <input  class="cert p_contactNo" type="text" value="" id="example-text-input" style="width:23%">
                        </div>
                        <div class="row">
                            Guardian Address:
                            <input  class=" cert g_Address" type="text" value="" id="example-text-input" style="width:86%;">
                        </div>
                    </div><br class="break">
                    <div class="line" style="border-bottom: 1px solid rgb(110, 109, 109);margin:5px"></div>
                    <div class="line" style="border-bottom: 1px solid rgb(110, 109, 109);margin:5px"></div>
                    <br>
                    <div class="" style="font-weight: 700; font-size: 18px;font-style: bold;">REASON/s FOR REFERRAL:
                      <textarea class=" remarks"  name="reason" value="" id="reason" rows="1" style="width:100%;"></textarea>
                    </div><br><br>
                        <div style="font-weight: 400; font-size: 18px; text-align: left">
                          Referred by:
                            <input  class="col-3 cert" name="" type="text" value="EDMUNDO R. VILLA, MD., MM"  style="text-align:center">
                        </div>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                        Signature over Printed Name
                        <br><br>
                        <div class="line" style="border-bottom: 3px dashed rgb(110, 109, 109);margin:3px"></div>
                        <div class="line" style="border-bottom: 3px dashed rgb(110, 109, 109);margin:3px"></div>
                       <div class="row">
                        <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 400; font-size: 15px; font-style: italic; text-align:center">(Cut and return to campus clinic)</div>
                        </div>
                       <div class="row printed-div  d-flex justify-content-left">
                        <div class="col-xl-8  col-lg-6 col-md-5 col-sm-5 d-flex justify-content-center"><img src="{{asset('images/logo/letter-SLSU-head.png')}}" style="width: 550px; height: 130px;">
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-7 col-sm-6"><br>
                          <div class="row">
                            &emsp;&emsp;&emsp;&emsp;&emsp; <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;" >MAIN CAMPUS</div>
                          </div>
                          <div class="row">
                            &emsp;&emsp;&emsp;&emsp;&emsp; <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;">San Roque, Sogod, Southern Leyte</div>
                          </div>
                          <div class="row">
                            &emsp;&emsp;&emsp;&emsp;&emsp;<div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;">Email:&nbsp; <a href="#" >president@southernleytestateu.edu.ph</a> </div>
                          </div>
                          <div class="row">
                            &emsp;&emsp;&emsp;&emsp;&emsp;<div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;">Website:&nbsp; <a href="#" >www.southernleytestateu.edu.ph</a></div>
                          </div>
                        </div>
                      </div>
                        <br><br><br><br><br><br>
                       <div class="row">
                        <div class="col-lg-12 d-flex justify-content-center"><p style="font-size: 13px; border-bottom: 1px solid black; text-align:center">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</p></div>
                        </div>
                        <div class="row">
                        <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 600; font-size: 20px; font-style: bold; text-align:center">Return Slip</div>
                        </div>
                        <div style="font-weight: 400; font-size: 18px;text-align: right">
                        Course:
                          <input  class="col-2 course cert " name="" type="text" value="" id="fullname">
                        </div>
                        <div style="font-weight: 400; font-size: 18px;text-align: right">
                        School Year:
                        <input  class="col-2 cert" name="" type="text" value="" id="fullname" >
                        </div>
                        <div class="form-group row col-12"  style="font-weight: 400; font-size: 18px;">
                          Date:
                          <input  class="col-md-1 cert " type="text" value="" id="example-text-input">&nbsp;
                        </div>  

                        <div class="form-group col-sm-12" style="font-weight: 300; font-size: 18px;">
                          <div class="row">
                              Name:
                              <input  class=" cert lastname" type="text" value="" id="example-text-input" style="width:22%;text-align:center">&nbsp;
                              <input  class=" cert firstname" type="text" value="" id="example-text-input" style="width:20%;text-align:center">&nbsp;
                              <input  class=" cert middlename" type="text" value="" id="example-text-input" style="width:20%text-align:center">
                              Age:
                              <input  class="cert age" type="text" value="" id="example-text-input" style="width:8%;text-align:center">
                              Gender:
                              <input  class=" cert gender" type="text" value="" id="example-text-input" style="width:15%;text-align:center">
                              <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 13px; font-style: italic;padding:0;">
                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Last)
                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(First)
                                &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Middle)
                              </div>
                          </div>
                          <div class="row">
                            Boarding House Address:
                            <input  class=" cert address" type="text" value="" id="example-text-input" style="width:50.7%">
                            Student Contact No.:
                            <input  class=" cert contactNo" type="text" value="" id="example-text-input" style="width:15.5%">
                          </div>
                      </div>
                          <div class="d-flex justify-content-left" style="font-weight: 700; font-size: 20px; font-style: bold; text-align:center">Action taken/Remarks:</div>
                          <table class="table">
                            <tr >
                              <td class="a" height="100px"><br><br><br><br>
                                <div style="text-align: right;">
                                    <input  class="col-3 cert " name="" type="text" value="" id="" style="text-align:center">
                                </div>
                                 Signature over Printed Name&emsp;
                              </td>
                            </tr>
                          </table>
                          <div class="row footer-end">
                            {{-- <div class="col-1"></div> --}}
                            <div class="col-lg-9 col-md-8">
                                <div class="row">&emsp;&emsp;&emsp;&emsp;&emsp;
                                    <div class="col-md-4 d-flex justify-content-left" style="font-size: 15px;">Doc. Code SLSU-QF-MD04</span></div>
                                    <div class="col-md-4 d-flex justify-content-left" style="font-size: 15px;">FOLLOW US HERE:</div>
                                </div>
                                <div class="row">&emsp;&emsp;&emsp;&emsp;&emsp;
                                    <div class="col-md-4 d-flex justify-content-left" style="font-size: 15px;">Revision: 02</div>
                                    <div class="col-md-3 d-flex justify-content-left" style="font-size: 15px;">https://www.facebook.com/southernleytestateu/</div>
                                </div>
                                <div class="row">&emsp;&emsp;&emsp;&emsp;&emsp;
                                    <div class="col-md-4 d-flex justify-content-left" style="font-size: 15px;">Date: 08 April 2022</div>
                                    <div class="col-md-3 d-flex justify-content-left" style="font-size: 15px;">https://www.youtube.com/c/SouthernLeyteStateUniversity</div>
                                </div>
                             </div>
                                <div class="col-md-3 col-sm-3"> 
                                  <img src="{{asset('images/logo/socotec.png')}}" style="width: 80%; height: 70%;"></div>
                                </div>
                       
                        
                    </div>
                  </div>
{{--return-tab--}}
                  <div class="tab-pane" id="return" aria-labelledby="return-tab" role="tabpanel">
                    <div class="table-responsive">
                      <h5 style="font-weight: bold; font-style: italic;color:royalblue)">UPLOAD RETURN SLIP</h5> <br>
                        <input type="text" class="id" name="id" id="id" placeholder="id" hidden >
                           <div class="row col-12" style="font-size:17px;font-weight:400;color:rgb(58, 57, 57)">            
                                 Name:
                                 <input type="text" class=" col-sm-4 fullname" name="lastname"  id="fullname"  readonly>
                            </div>
                        <hr>   
                    </div>
                    <div class="table-responsive view-all">
                      <table class="table recordTable table-bordered table-striped col-sm" id="recordTable" >
                        {{-- <form action="{{ route('search') }}" method="post">
                          <div class="form-group">
                            <input type="text" id="searchTxt"  class="form-control col-sm-2" name="search" placeholder="Search" autocomplete="off">
                          </div>
                        </form> --}}
                          <thead>
                              <tr>
                                  <th style="color:white;">Date</th>
                                  <th style="color:white;">Referred to</th>
                                  <th style="color:white;">Reason for referral</th>  
                                  <th style="color:white;">File</th>  
                                  <th style="color:white;">Action</th>
                              </tr>
                          </thead>
                          <tbody id="viewHere">  
                            
                          </tbody>
                      </table>
                  </div>
                  <div class="form-group">
                    <button type="button"  class="btn btn-secondary  float-right" id="backToSearch">Back</button>
                  </div>
                  @include('modal.uploadReturnSlip')
                  </div>
{{--approval-tab--}}
                  <div class="tab-pane" id="approval" aria-labelledby="approval-tab" role="tabpanel">
                    <form action="/approval" method="POST" id="pendingSlip" >
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
                        <div class="col-xl-8  col-lg-6 col-md-5 col-sm-5 d-flex justify-content-center"><img src="{{asset('images/logo/letter-SLSU-head.png')}}" style="width: 300; height: 100px;">
                        </div>
                        <div class="col-xl-2 col-lg-4 col-md-5 col-sm-4"><br>
                          <div class="row">
                            <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 12px;" >MAIN CAMPUS</div>
                          </div>
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
                        <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 17px; font-style: bold; text-align:center">Referral Slip</div>
                        </div>
                        <div class="col-sm-12" style="text-align: right">
                        Course:
                        <input  class="course cert " name="" type="text" value="" id="course" style="width:10%">
                      </div>
                      <div class="col-sm-12" style="text-align: right">
                        School Year:
                        <input  class="cert" name="" type="text" value="" id="fullname" style="width:10%">
                      </div><br>
                      <div class="col-sm-12" style="text-align: right">
                        Date:
                        <input  class=" date cert " name="date" type="text" value="" id="date" style="width:10%">
                      </div>
                      <div class="form-group col-12">
                        <div class="row" style="font-weight: 600; font-size: 15px;font-style: bold;">
                        REFERRED TO:
                        </div> 
                      <div style="font-weight: 400; font-size: 12px;">
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="Hospital" name="referTo[]" value="Hospital">
                        HOSPITAL 
                      </div>
                        <div style="font-weight: 400; font-size: 12px;">
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="RHU" name="referTo[]" value="RHU">
                        RHU</div> 
                        <div style="font-weight: 400; font-size: 12px;">
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="Visiting Physician" name="referTo[]" value="Visiting Physician">
                        VISITING PHYSICIAN</div>
                         <div style="font-weight: 400; font-size: 12px;">
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="others" name="referTo[]" value="Others">
                        OTHERS,(please specify)
                        <input class="others col-sm-2 cert" type="text" id="others" name="others" value="" >
                      </div> 
                    </div>
                    <div class="form-group col-sm-12" >
                        <div class="row"> 
                            Name:
                            <input  class=" cert lastname" type="text" value="" id="lastname" style="width:21%; text-align:center">&nbsp;
                            <input  class=" cert firstname" type="text" value="" id="firstname" style="width:20%; text-align:center">&nbsp;
                            <input  class=" cert middlename" type="text" value="" id="middlename" style="width:20%; text-align:center">
                            Age:
                            <input  class="cert age" type="text" value="" id="age" style="width:10%;text-align:center">
                            Gender:
                            <input  class=" cert gender" type="text" value="" id="gender" style="width:15.4%;text-align:center">
                          <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 15px; font-style: italic;">
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Last)
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(First)
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Middle)
                          </div>
                        </div>
                        <div class="row">
                            Date of Birth:
                            <input  class=" cert bday" type="text" value="" id="bday" style="width:18%;text-align:center">
                            Civil Status:
                            <input  class=" cert civil_status" type="text" value="" id="civil_status" style="width:16%;text-align:center">
                            Nationality:
                           <input  class=" cert nationality" type="text" value="" id="nationality" style="width:18%;text-align:center">
                            Religion:
                           <input  class="cert religion" type="text" value="" id="religion" style="width:19.3%;text-align:center">
                        </div>
                        <div class="row">
                            Boarding House Address:
                            <input  class=" cert bhAddress" type="text" value="" id="bhAddress" style="width:83.4%">
                        </div>
                        <div class="row">
                            Home Address: &nbsp;
                            <input  class=" cert address" type="text" value="" id="address" style="width:88.7%">
                        </div>
                        <div class="row">
                            Parent/Guardian:
                            <input  class=" cert guardian" type="text" value="" id="guardian" style="width:35.5%">
                            Parent/Guardian Contact No.:
                            <input  class="cert p_contactNo" type="text" value="" id="p_contactNo" style="width:35%">
                        </div>
                        <div class="row">
                            Guardian Address:
                            <input  class=" cert g_Address" type="text" value="" id="g_Address" style="width:87.5%;">
                        </div>
                    </div><br>
                    <div class="line" style="border-bottom: 1px solid rgb(110, 109, 109);margin:3px"></div>
                    <div class="line" style="border-bottom: 1px solid rgb(110, 109, 109);margin:3px"></div>
                    <br>
                    <div class="" style="font-weight: 700; font-size: 15px;font-style: bold;">REASON/s FOR REFERRAL:
                      <textarea class=" reason"  name="reason" value="" id="reason" rows="1" style="width:100%;"></textarea>
                    </div><br><br>
                    <div class="col-sm-12 row" >
                      Referred by:<br>
                      <input  class="cert " name="" type="text" value="" id="" style="width:20%;">
                        </div>
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;Signature over Printed Name
                        <br><br>
                        <div class="line" style="border-bottom: 1px dashed rgb(110, 109, 109);margin:3px"></div>
                        <div class="line" style="border-bottom: 1px dashed rgb(110, 109, 109);margin:3px"></div>
                       <div class="row">
                        <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 400; font-size: 15px; font-style: italic; text-align:center">(Cut and return to campus clinic)</div>
                        </div>
                       <div class="row printed-div  d-flex justify-content-left">
                        <div class="col-xl-8  col-lg-6 col-md-5 col-sm-5 d-flex justify-content-center"><img src="{{asset('images/logo/letter-SLSU-head.png')}}" style="width: 300; height: 100px;">
                        </div>
                        <div class="col-xl-2 col-lg-4 col-md-5 col-sm-4"><br>
                          <div class="row">
                             <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 12px;" >MAIN CAMPUS</div>
                          </div>
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
                        <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 17px; font-style: bold; text-align:center">Return Slip</div>
                        </div>
                        <div class="col-sm-12" style="text-align: right">
                        Course:
                          <input  class="course cert " name="" type="text" value="" id="" style="width:10%">
                        </div>
                        <div class="col-sm-12" style="text-align: right">
                        School Year:
                        <input  class="cert" name="" type="text" value="" id="fullname" style="width:10%">
                        </div>
                        Date:
                        <input  class="col-1 date cert" name="" type="text" value="" id="date" >
                        <br><br>
                        <div class="form-group col-sm-12" >
                          <div class="row"> 
                            Name:
                            <input  class=" cert lastname" type="text" value="" id="lastname" style="width:21%; text-align:center">&nbsp;
                            <input  class=" cert firstname" type="text" value="" id="firstname" style="width:20%; text-align:center">&nbsp;
                            <input  class=" cert middlename" type="text" value="" id="middlename" style="width:20%; text-align:center">
                            Age:
                            <input  class="cert age" type="text" value="" id="age" style="width:10%;text-align:center">
                            Gender:
                            <input  class=" cert gender" type="text" value="" id="gender" style="width:15.4%;text-align:center">
                          <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 15px; font-style: italic;">
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Last)
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(First)
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Middle)
                          </div>
                        </div>
                          <div class="row">
                              Boarding House Address:
                              <input  class=" cert bhAddress" type="text" value="" id="bhAddress" style="width:55%">
                              Student Contact No.:
                              <input  class=" cert contactNo" type="text" value="" id="contactNo" style="width:15.9%">
                          </div>
                      </div>
                          <div class="form-group row col-12">
                          <div class=" d-flex justify-content-left" style="font-weight: 700; font-size: 15px; font-style: bold;">Action taken/Remarks:</div>
                          <table class=" table">
                            <tr >
                              <td class="col-sm-12 a " height="100px"><br><br><br><br>
                                <div style="text-align: right;">
                                    <input  class=" cert " name="" type="text" value="" id="" style="width:22%;text-align:center">
                                </div>
                                 Signature over Printed Name&emsp;
                              </td>
                            </tr>
                          </table>
                        </div>
                       <div class="row footer-end">
                        {{-- <div class="col-1"></div> --}}
                        <div class="col-lg-9 col-md-8">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-left" style="font-size: 15px;">Doc. Code SLSU-QF-MD04</span></div>
                                <div class="col-md-4 d-flex justify-content-left" style="font-size: 15px;">FOLLOW US HERE:</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-left" style="font-size: 15px;">Revision: 02</div>
                                <div class="col-md-3 d-flex justify-content-left" style="font-size: 15px;">https://www.facebook.com/southernleytestateu/</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-left" style="font-size: 15px;">Date: 08 April 2022</div>
                                <div class="col-md-3 d-flex justify-content-left" style="font-size: 15px;">https://www.youtube.com/c/SouthernLeyteStateUniversity</div>
                            </div>
                         </div>
                            <div class="col-md-3 col-sm-3"> 
                              <img src="{{asset('images/logo/socotec.png')}}" style="width: 55%; height: 70%;"></div>
                            </div>
                        </div>
                  </div>
{{--view-tab--}}
                  <div class="tab-pane" id="view" aria-labelledby="view-tab" role="tabpanel">
                    <div class="table-responsive">
                        <div class="title">
                          <h5 style="font-weight: bold; font-style: italic;color:royalblue)">RECORD</h5>
                        </div>
                          <div class="col-sm-12">
                            <input type="text" class="id" name="patientId" id="id" placeholder="id" hidden ><br>
                              <div class="form-group col-sm-12">
                                 <div class="row" style="font-size:17px;font-weight:400;color:rgb(58, 57, 57)">          
                                       Name:
                                       <input type="text" class=" col-sm-7 fullname" name="firstname"  id="firstname"  readonly>
                                 </div>
                              </div><hr>
                          </div>
                      <div class="table-responsive view-all">
                        <table class="table recordTable table-bordered table-striped col-sm zero-configuration" id="recordTable">
                          {{-- <form action="{{ route('search') }}" method="post">
                            <div class="form-group">
                              <input type="text" id="searchTxt"  class="form-control col-sm-2" name="search" placeholder="Search" autocomplete="off">
                            </div>
                          </form> --}}
                            <thead>
                                <tr>
                                    <th style="color:white;">Date</th>
                                    <th style="color:white;">Referred to</th>
                                    <th style="color:white;">Reason for referral</th>  
                                    <th style="color:white;">Status</th>  
                                    <th style="color:white;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="preView">  
                              
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                      {{-- <button type="submit" class="btn btn-primary">Sign up</button> --}}
                      <button type="button"  id="backBtn" class="btn btn-secondary  float-right">Back</button>
                    </div>
                    @include('modal.editReferral')
                </div>
              </div>
{{--print-tab--}}
                  <div class="tab-pane " id="print" aria-labelledby="print-tab" role="tabpanel">
                    <div class="">
                      <button type="button" class="btn btn-default btn-custom float-right button" id="returnHome">Cancel</button>
                      <button type="button" class="btn btn-primary float-right button" id="btnPrint" type="button"  data-dismiss="modal">Print</button>
                    </div> <br><br>
                    <hr>
                   
                    <div id="printThis">
                      <div class="row printed-div  d-flex justify-content-left">
                        <div class="col-xl-8  col-lg-6 col-md-5 col-sm-5 d-flex justify-content-center"><img src="{{asset('images/logo/letter-SLSU-head.png')}}" style="width: 300; height: 100px;">
                        </div>
                        <div class="col-xl-2 col-lg-4 col-md-5 col-sm-4"><br>
                          <div class="row">
                            <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 12px;" >MAIN CAMPUS</div>
                          </div>
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
                        <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 17px; font-style: bold; text-align:center">Referral Slip</div>
                        </div>
                        <div class="col-sm-12" style="text-align: right">
                        Course:
                        <input  class="course cert " name="" type="text" value="" id="course" style="width:10%">
                      </div>
                      <div class="col-sm-12" style="text-align: right">
                        School Year:
                        <input  class="cert" name="" type="text" value="" id="fullname" style="width:10%">
                      </div><br>
                      <div class="col-sm-12" style="text-align: right">
                        Date:
                        <input  class=" date cert " name="" type="text" value="" id="date" style="width:10%">
                      </div>
                      <div class="form-group col-12">
                        <div class="row" style="font-weight: 600; font-size: 15px;font-style: bold;">
                        REFERRED TO:
                        </div> 
                      <div style="font-weight: 400; font-size: 12px;">
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="Hospital" name="referTo[]" value="Hospital">
                        HOSPITAL 
                      </div>
                        <div style="font-weight: 400; font-size: 12px;">
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="RHU" name="referTo[]" value="RHU">
                        RHU</div> 
                        <div style="font-weight: 400; font-size: 12px;">
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="Visiting Physician" name="referTo[]" value="Visiting Physician">
                        VISITING PHYSICIAN</div>
                         <div style="font-weight: 400; font-size: 12px;">
                          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<input class="textbox" type="checkbox" id="others" name="referTo[]" value="others">
                        OTHERS,(please specify)
                        <input class="others col-sm-2 cert" type="text" id="others" name="others" value="" >
                      </div> 
                    </div>
                    <div class="form-group col-sm-12" >
                        <div class="row"> 
                            Name:
                            <input  class=" cert lastname" type="text" value="" id="lastname" style="width:21%; text-align:center">&nbsp;
                            <input  class=" cert firstname" type="text" value="" id="firstname" style="width:20%; text-align:center">&nbsp;
                            <input  class=" cert middlename" type="text" value="" id="middlename" style="width:20%; text-align:center">
                            Age:
                            <input  class="cert age" type="text" value="" id="age" style="width:10%;text-align:center">
                            Gender:
                            <input  class=" cert gender" type="text" value="" id="gender" style="width:15.4%;text-align:center">
                          <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 15px; font-style: italic;">
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Last)
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(First)
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Middle)
                          </div>
                        </div>
                        <div class="row">
                            Date of Birth:
                            <input  class=" cert BirthDate" type="text" value="" id="BirthDate" style="width:18%;text-align:center">
                            Civil Status:
                            <input  class=" cert civil_status" type="text" value="" id="civil_status" style="width:17.5%;text-align:center">
                            Nationality:
                           <input  class=" cert nationality" type="text" value="" id="nationality" style="width:18%;text-align:center">
                            Religion:
                           <input  class="cert religion" type="text" value="" id="religion" style="width:18%;text-align:center">
                        </div>
                        <div class="row">
                            Boarding House Address:
                            <input  class=" cert bhAddress" type="text" value="" id="bhAddress" style="width:83.5%">
                        </div>
                        <div class="row">
                            Home Address: &nbsp;
                            <input  class=" cert address" type="text" value="" id="address" style="width:89%">
                        </div>
                        <div class="row">
                            Parent/Guardian:
                            <input  class=" cert guardian" type="text" value="" id="guardian" style="width:36%">
                            Parent/Guardian Contact No.:
                            <input  class="cert p_contactNo" type="text" value="" id="p_contactNo" style="width:35%">
                        </div>
                        <div class="row">
                            Guardian Address:
                            <input  class=" cert g_Address" type="text" value="" id="g_Address" style="width:88%;">
                        </div>
                    </div><br>
                    <div class="line" style="border-bottom: 1px solid rgb(110, 109, 109);margin:3px"></div>
                    <div class="line" style="border-bottom: 1px solid rgb(110, 109, 109);margin:3px"></div>
                    <br>
                    <div class="" style="font-weight: 700; font-size: 15px;font-style: bold;">REASON/s FOR REFERRAL:
                      <textarea class=" recommendation"  name="recommendation" value="" id="recommendation" rows="1" style="width:100%;"></textarea>
                    </div><br><br>
                    <div class="col-sm-12 row" >
                      Referred by:<br>
                      <input  class="cert " name="" type="text" value="" id="" style="width:20%;">
                        </div>
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;Signature over Printed Name
                        <br><br>
                        <div class="line" style="border-bottom: 1px dashed rgb(110, 109, 109);margin:3px"></div>
                        <div class="line" style="border-bottom: 1px dashed rgb(110, 109, 109);margin:3px"></div>
                       <div class="row">
                        <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 400; font-size: 15px; font-style: italic; text-align:center">(Cut and return to campus clinic)</div>
                        </div>
                       <div class="row printed-div  d-flex justify-content-left">
                        <div class="col-xl-8  col-lg-6 col-md-5 col-sm-5 d-flex justify-content-center"><img src="{{asset('images/logo/letter-SLSU-head.png')}}" style="width: 300; height: 100px;">
                        </div>
                        <div class="col-xl-2 col-lg-4 col-md-5 col-sm-4"><br>
                          <div class="row">
                             <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 12px;" >MAIN CAMPUS</div>
                          </div>
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
                        <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 17px; font-style: bold; text-align:center">Return Slip</div>
                        </div>
                        <div class="col-sm-12" style="text-align: right">
                        Course:
                          <input  class="course cert " name="" type="text" value="" id="" style="width:10%">
                        </div>
                        <div class="col-sm-12" style="text-align: right">
                        School Year:
                        <input  class="cert" name="" type="text" value="" id="fullname" style="width:10%">
                        </div>
                        <div class="col-sm-12">
                          Date:
                          <input  class="col-1 " name="" type="text" value="" id="date" >
                          </div><br><br>
                        <div class="form-group col-sm-12" >
                          <div class="row"> 
                            Name:
                            <input  class=" cert lastname" type="text" value="" id="lastname" style="width:21%; text-align:center">&nbsp;
                            <input  class=" cert firstname" type="text" value="" id="firstname" style="width:20%; text-align:center">&nbsp;
                            <input  class=" cert middlename" type="text" value="" id="middlename" style="width:20%; text-align:center">
                            Age:
                            <input  class="cert age" type="text" value="" id="age" style="width:10%;text-align:center">
                            Gender:
                            <input  class=" cert gender" type="text" value="" id="gender" style="width:15.4%;text-align:center">
                          <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 15px; font-style: italic;">
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Last)
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(First)
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Middle)
                          </div>
                        </div>
                          <div class="row">
                              Boarding House Address:
                              <input  class=" cert bhAddress" type="text" value="" id="bhAddress" style="width:55%">
                              Student Contact No.:
                              <input  class=" cert " type="text" value="" id="contactNo" style="width:15.9%">
                          </div>
                      </div>
                          <div class="form-group row col-12">
                          <div class=" d-flex justify-content-left" style="font-weight: 700; font-size: 15px; font-style: bold;">Action taken/Remarks:</div>
                          <table class=" table">
                            <tr >
                              <td class="col-sm-12 a " height="100px"><br><br><br><br>
                                <div style="text-align: right;">
                                    <input  class="cert " name="" type="text" value="" id="" style="width:23%;text-align:center">
                                </div>
                                 Signature over Printed Name&emsp;
                              </td>
                            </tr>
                          </table>
                        </div>
                       <div class="row footer-end">
                        {{-- <div class="col-1"></div> --}}
                        <div class="col-lg-9 col-md-8">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-left" style="font-size: 15px;">Doc. Code SLSU-QF-MD04</span></div>
                                <div class="col-md-4 d-flex justify-content-left" style="font-size: 15px;">FOLLOW US HERE:</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-left" style="font-size: 15px;">Revision: 02</div>
                                <div class="col-md-3 d-flex justify-content-left" style="font-size: 15px;">https://www.facebook.com/southernleytestateu/</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-left" style="font-size: 15px;">Date: 08 April 2022</div>
                                <div class="col-md-3 d-flex justify-content-left" style="font-size: 15px;">https://www.youtube.com/c/SouthernLeyteStateUniversity</div>
                            </div>
                         </div>
                            <div class="col-md-3 col-sm-3"> 
                              <img src="{{asset('images/logo/socotec.png')}}" style="width: 55%; height: 70%;"></div>
                            </div>
                        </div>
                    </div>
{{--status-tab--}}
                    <div class="tab-pane" id="status" aria-labelledby="status-tab" role="tabpanel">
                      <div class="table-responsive">
                        <div class="title">
                          <h5 style="font-weight: bold; font-style: italic;color:royalblue)">STATUS</h5> <br>
                        </div>
                        <div class="row col-12" style="font-size:17px;font-weight:400;color:rgb(58, 57, 57)" >            
                          Name:
                          <input type="text" class=" col-sm-8 border-0 fullname" name=""  id="fullname" style="font-weight:400;color:rgb(58, 57, 57)" readonly>
                        </div><hr>
                        <table class="table recordTable table-bordered table-striped col-sm " id="recordTable">
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
                  </div>{{--end-tab-content--}}
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script>
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});
//Search-Input 
  $(document).ready(function() {
    $("#submitBtn").submit(function(e) {
      e.preventDefault();
      var search = $('#searchInput').val();
          $.ajax({
              type:'post',
              url:'/referral',
              data:{search:search},

              success:function(data){
                $('#myTable').html(data);   
              } 
          })
        })
  });
//Add or Create New Record Action 1
  $(document).on('click', '.add', function(){
    // const id = $(this).data('id');
  
      $.ajax({
      type: 'post',
      url: '/referral-view-information',
      data: { id: $(this).data('id') },
      dataType: 'json',
    
      success: function(response) {
        console.log(response);
        id = response.id;
        console.log(response.id);
        var today = new Date();
        var formattedDate = today.getFullYear()+'-'+(today.getMonth()+1).toString().padStart(2, '0')+'-'+today.getDate().toString().padStart(2, '0');

          $('.id').val(response.id);
          $('.lastname').val(response.last_name);
          $('.firstname').val(response.first_name);
          $('.middlename').val(response.middle_name);
          $('.course').val(response.course);
          $('.age').val(response.age);
          $('.gender').val(response.gender);
          $('.date').val(formattedDate);

          $('.tab-pane').removeClass('active')
          $('#refer').addClass('active')
          $('.nav-link').removeClass('active')
          $('#refer-tab').addClass('active')
        
          $("#record").removeAttr("style").hide()
          $("#refer").show()
      },
    })
  })
//Preview record Action 2
 $(document).on('click', '.viewRecord', function(){
  var table = $('.zero-configuration').DataTable();
  $.ajax({
    type: 'post',
    url: '/view-record',
    data: { patientId: $(this).data('id') },
    dataType: 'json',
    success: function(response) {
      $('.tab-pane').removeClass('active')
      $('#view').addClass('active')
      $('.nav-link').removeClass('active')
      $('#view-tab').addClass('active')
      $("#view").removeAttr("style").hide()
      $("#view").show()

      if (response.data.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No records found.',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                $('a[href="#record"]').tab('show');
                location.reload();
                $("#record").hide();
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
        var jsonString = data.referTo;
        var referTo = JSON.parse(jsonString);

        
        var editBtn =   '<button type="button" class="btn btn-default edit" data-id="' + data.id + '" data-toggle="modal" data-target="#editReferral"><i class="fa fa-edit"></i></button>';

          if (data.status === 'approved') {
              editBtn = '<button type="button" class="btn btn-default edit" data-id="' + data.id + '" disabled><i class="fa fa-edit"></i></button>';
          }

          if (referTo.includes("Others")) {
              referTo = data.others;
          }
          
        var row = table.row.add([
          newDateStr,
          referTo,
          data.reason,
          data.status,
       editBtn
        ]).draw(false).node();

        $(row).addClass('tr');

          if (data.status === 'Pending') {
            $(row).find('td:eq(3)').addClass('pending-status');
          }
          else if (data.status === 'Approved') {
            $(row).find('td:eq(3)').addClass('approved-status');
          }
          else if (data.status === 'Disapproved') {
            $(row).find('td:eq(3)').addClass('disapproved-status');
          }
      });
    },
  })
 })


//Upload view record Action 3
 $(document).on('click', '.upload', function(){
  // const id = $(this).data('id');


    $.ajax({
    type: 'post',
    url: '/return-slip',
    data: { patientId: $(this).data('id') },
    dataType: 'json',
   
    success: function(response) {
      id = response.id;
      console.log(response.id);

        $('.tab-pane').removeClass('active')
        $('#return').addClass('active')
        $('.nav-link').removeClass('active')
        $('#return-tab').addClass('active')
      
        $("#return").removeAttr("style").hide()
        $("#return").show()
        if (response.data.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'No records found.',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                $('a[href="#record"]').tab('show');
                location.reload();
                $("#record").hide();
            });
            return;
        }
        
          response.data.forEach(element => {
            console.log(element.lastname);     
                    $('.id').val(element.patientId);
                    $('.fullname').val([element.firstname]+' '+[element.middlename]+' '+[element.lastname]);
                    $('.reason').val(element.reason);
                
                  var dateArr = element.date.split('-'); 
                  var year = dateArr[0];
                  var month = dateArr[1];
                  var day = dateArr[2];
                  var newDateStr = month + '/' + day + '/' + year;
                  var jsonString = element.referTo;
                  var referTo = JSON.parse(jsonString);
                  var jsonNew = element.file; 
                  var file = JSON.parse(jsonNew);
                  // var date = new Date(element.date);
                  // var now = new Date();
                  
                  if (referTo.includes("Others")) {
                      referTo = element.others;
                  }
          
                    $('#viewHere').append('<tr>\
                    <td>'+newDateStr+'</td>\
                    <td>'+referTo+'</td>\
                    <td>'+element.reason+'</td>\
                    <td>'+file+'</a></td>\
                    <td>'+'<button type="button" id="mybutton" class="btn btn-default viewbutton" data-id="'+element.id+'" data-toggle="modal" data-target="#uploadReturnSlip"><i class="fa fa-upload" style="font-size:15px"></i></button>'+'</td>\
                    </tr>');
          }); 
        },
      })
    })

//To Print from record
 $(document).on('click', '.printBtn', function(){
  // const id = $(this).data('id');
 
    $.ajax({
    type: 'post',
    url: '/print-record',
    data: { id: $(this).data('id') },
    dataType: 'json',
   
    success: function(response) {
      console.log(response);
      id = response.id;
      console.log(response.id);
      console.log(response.cert_issued)
                var  referTo = response.referTo

                $("input:checkbox").each(function() {
                        if (referTo.includes($(this).prop("value"))) {
                            $(this).prop("checked", true);
                        }
                    });

                $('.id').val(response.id);
                $('#id').val(response.patientId);
                $('.lastname').val(response.lastname);
                $('.firstname').val(response.firstname);
                $('.middlename').val(response.middlename);
                $('#course').val(response.Course);
                $('.age').val(response.age);
                $('.gender').val(response.gender);
                $('.bday').val(response.BirthDate); 
                $('.civil_status').val(response.civil_status);
                $('.nationality').val(response.nationality);
                $('.religion').val(response.religion);
                $('.address').val([response.brgy]+', '+[response.city]+', '+[response.province])
                $('.bhAddress').val([response.b_brgy]+', '+[response.b_city]+', '+[response.b_province]);;
                $('#contactNo').val(response.ContactNo);
                $('.guardian').val(response.guardian);
                $('.p_contactNo').val(response.p_contactNo);
                $('.g_Address').val(response.g_Address);
                $('.reason').val(response.reason);
                $('.others').val(response.others);

                $('.tab-pane').removeClass('active')
                $('#print').addClass('active')
                $('.nav-link').removeClass('active')
                $('#print-tab').addClass('active')
                $("#print").removeAttr("style").hide()
                $("#print").show()
      }
    })
  });

//Save SWAL ALERT 
 $("#saveRefer").submit(function(e) {
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
                console.log(response.BirthDate)
                $('.patientId').val(response.id);
                var  referTo = response.referTo
                var dateArr = response.BirthDate.split('-'); 
                  var year = dateArr[0];
                  var month = dateArr[1];
                  var day = dateArr[2];
                  var newDateStr = month + '/' + day + '/' + year;
                
                  var date = response.date.split('-'); 
                  var year = date[0];
                  var month = date[1];
                  var day = date[2];
                  var newdate = month + '/' + day + '/' + year;


                $("input:checkbox").each(function() {
                        if (referTo.includes($(this).prop("value"))) {
                            $(this).prop("checked", true);
                        }
                    });

                $('.id').val(response.id);
                $('#id').val(response.patientId);
                $('.lastname').val(response.lastname);
                $('.firstname').val(response.firstname);
                $('.middlename').val(response.middlename);
                $('#course').val(response.Course);
                $('.age').val(response.age);
                $('.gender').val(response.gender);
                $('.bday').val(newDateStr);
                $('.date').val(newdate);
                $('.civil_status').val(response.civil_status);
                $('.nationality').val(response.nationality);
                $('.religion').val(response.religion);
                $('.address').val([response.brgy]+', '+[response.city]+', '+[response.province])
                $('.bhAddress').val([response.b_brgy]+', '+[response.b_city]+', '+[response.b_province]);;
                $('#contactNo').val(response.ContactNo);
                $('.guardian').val(response.guardian);
                $('.p_contactNo').val(response.p_contactNo);
                $('.g_Address').val(response.g_Address);
                $('.reason').val(response.reason);
                $('.others').val(response.others);

                $('.tab-pane').removeClass('active')
                $('#approval').addClass('active')
                $('.nav-link').removeClass('active')
                $('#approval-tab').addClass('active')
                $("#approval").removeAttr("style").hide()
                $("#approval").show()
              }
              })
              console.log(response);
              }
              else if(response.error== 'Duplicate'){
                    Swal.fire({
                    title: response['error'],
                    icon: 'error',
                    confirmButtonText: 'okay',
                    }).then((response) => {

                    if (response.isConfirmed) {
                      location.reload()
                    }
                    })
                    }
                  }
            });
        });

//Print Document
  document.getElementById("btnPrint").onclick = function () {
      printElement(document.getElementById("printThis"));
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
//Back button
 $(document).ready(function(){
        $("#returnHome").click(function(){
              $('a[href="#record"]').tab('show');
              location.reload();
            $("#record").hide()

      })
    })

  $(document).ready(function(){
        $("#cancel").click(function(){
              $('a[href="#record"]').tab('show');
              location.reload();
            $("#record").hide()

      })
    })
  $(document).ready(function(){
        $("#backToSearch").click(function(){
              $('a[href="#record"]').tab('show');
              location.reload();
            $("#record").hide()

      })
    })
    $(document).ready(function(){
        $("#gotosearch").click(function(){
              $('a[href="#record"]').tab('show');
              location.reload();
            $("#record").hide()

      })
    })
    $(document).ready(function(){
        $("#backBtn").click(function(){
              $('a[href="#record"]').tab('show');
              location.reload();
            $("#record").hide()

      })
    })
    
    
//Show Modal for preview
  $("#editReferral").on("hide.bs.modal", function(e){
      $("input:checkbox").each(function() {
          $(this).prop("checked", false);  
      });
  })

 $("#editReferral").on("shown.bs.modal", function(e){
    $.ajax({
        type: 'POST',
        url: '/modalView',
        data: { id: $(e.relatedTarget).data("id")},

        success: function(response) {
       console.log(response.others);
          var  referTo = response.referTo
          var today = new Date();
          var formattedDate = today.getFullYear()+'-'+(today.getMonth()+1).toString().padStart(2, '0')+'-'+today.getDate().toString().padStart(2, '0');

         


          $('.id').val(response.id); 
          $('.fullname').val([response.firstname]+' '+[response.middlename]+', '+[response.lastname]);
          
          $('.date').val(formattedDate);
          $('.others').val(response.others);
          $('.reason').val(response.reason);

           $("input:checkbox").each(function() {
                if (referTo.includes($(this).prop("value"))) {
                    $(this).prop("checked", true);
                }
            });

        }
    })
 })

//Save SWAL ALERT  from modal
 $("#saveEditRefer").submit(function(e) {
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
        console.log(response.referTo)
        $('.patientId').val(response.id);

          var  referTo = response.referTo;
          $("input:checkbox").each(function() {
                        if (referTo.includes($(this).prop("value"))) {
                            $(this).prop("checked", true);
                        }
                    });
          var dateArr = response.BirthDate.split('-'); 
          var year = dateArr[0];
          var month = dateArr[1];
          var day = dateArr[2];
          var newDateStr = month + '/' + day + '/' + year;
                
          var date = response.date.split('-'); 
          var year = date[0];
          var month = date[1];
          var day = date[2];
          var newdate = month + '/' + day + '/' + year;

        $('.id').val(response.id);
        $('#id').val(response.patientId);
        $('.lastname').val(response.lastname);
        $('.firstname').val(response.firstname);
        $('.middlename').val(response.middlename);
        $('#course').val(response.Course);
        $('.age').val(response.age);
        $('.gender').val(response.gender);
        $('.bday').val(newDateStr);
        $('.date').val(newdate);
        $('.civil_status').val(response.civil_status);
        $('.nationality').val(response.nationality);
        $('.religion').val(response.religion);
        $('.address').val([response.brgy]+', '+[response.city]+', '+[response.province])
        $('.bhAddress').val([response.b_brgy]+', '+[response.b_city]+', '+[response.b_province]);;
        $('#contactNo').val(response.ContactNo);
        $('.guardian').val(response.guardian);
        $('.p_contactNo').val(response.p_contactNo);
        $('.g_Address').val(response.g_Address);
        $('.reason').val(response.reason);
        $('.others').val(response.others);

        

        $('.tab-pane').removeClass('active')
        $('#approval').addClass('active')
        $('.nav-link').removeClass('active')
        $('#approval-tab').addClass('active')
        $("#approval").removeAttr("style").hide()
        $("#approval").show()
        $("#editReferral").modal('hide')
      }
      else if (response2.dismiss === Swal.DismissReason.cancel) {
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
            }
          }
        });
        });

     
//Show Modal for UploadSlip
 $("#uploadReturnSlip").on("shown.bs.modal", function(e){
    $.ajax({
        type: 'POST',
        url: '/modalUpload',
        data: { id: $(e.relatedTarget).data("id")},

        success: function(response) {
        console.log(response.id);
        var jsonString = response.referTo;
        var referTo = JSON.parse(jsonString);

        if (referTo.includes("Others")) {
                      referTo = response.others;
                  }
                  
          $('.id').val(response.id); 
          $('.fullname').val([response.lastname]+', '+[response.firstname]+' '+[response.middlename]);
          $('.referTo').val(referTo);
          $('.reason').val(response.reason);

        }
    })
 })
//Pending Status
 $("#pendingSlip").submit(function(e) {
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

//Show Modal for Medical
 $("#editMedicalRecord").on("shown.bs.modal", function(e){
    $.ajax({
        type: 'POST',
        url: '/showAddModal',
        data: { id: $(e.relatedTarget).data("id")},

        success: function(response) {
        console.log(response.id);
        var jsonString = response.referTo;
        var referTo = JSON.parse(jsonString);

          $('.id').val(response.id); 
          $('.fullname').val([response.lastname]+', '+[response.firstname]+' '+[response.middlename]);
        }
    })
 })


//Status
 $(document).on('click', '.status', function(){
  // const id = $(this).data('id');
 
    $.ajax({
    type: 'post',
    url: '/status-view',
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

        
          response.data.forEach(element => {
          console.log(element.status);     
          $('.fullname').val([element.firstname]+' '+[element.middlename]+' '+[element.lastname]);
        
            var dateArr = element.date.split('-'); 
            var year = dateArr[0];
            var month = dateArr[1];
            var day = dateArr[2];
            var newDateStr = month + '/' + day + '/' + year;      
            var jsonString = element.referTo;
            var referTo = JSON.parse(jsonString);
            var status = element.status;
            
  
            if (referTo.includes("Others")) {
              referTo = element.others;
          }
          
            if (status === 'Pending') {
              $('#viewStatus').append('<tr>\
                <td>'+newDateStr+'</td>\
                <td>'+referTo+'</td>\
                <td class="pending-status">'+element.status+'</td>\
                <td>'+element.stat_remarks+'</td>\
                <td><button type="button" class="btn btn-default printBtn" data-id="'+element.id+'" disabled><i class="fa fa-print" style="font-size:15px"></i></button></td>\
              </tr>');
            } else if (status === 'Approved') {
              $('#viewStatus').append('<tr>\
                <td>'+newDateStr+'</td>\
                <td>'+referTo+'</td>\
                <td class="approved-status">'+element.status+'</td>\
                <td>'+element.stat_remarks+'</td>\
                <td><button type="button" class="btn btn-default printBtn" data-id="'+element.id+'"><i class="fa fa-print" style="font-size:15px"></i></button></td>\
              </tr>');
            } else if (status === 'Disapproved') {
              $('#viewStatus').append('<tr>\
                <td>'+newDateStr+'</td>\
                <td>'+referTo+'</td>\
                <td class="disapproved-status">'+element.status+'</td>\
                <td>'+element.stat_remarks+'</td>\
                <td><button type="button" class="btn btn-default printBtn" data-id="'+element.id+'" disabled><i class="fa fa-print" style="font-size:15px"></i></button></td>\
              </tr>');
            }
        })
      }
    })
  })


// disable text input when checkbox is unchecked
  function selectCheckbox(id) {
      var checkboxes = document.querySelectorAll('input[type="checkbox"]');
      var othersInput = document.getElementById('others_text');

      // Uncheck all checkboxes except the selected one
      for (var i = 0; i < checkboxes.length; i++) {
          if (checkboxes[i].id != id) {
              checkboxes[i].checked = false;
          }
      }

      // Enable/disable the "Others" text input field
      if (id == 'others') {
          othersInput.disabled = false;
      } else {
          othersInput.disabled = true;
          othersInput.value = '';
      }
  }


</script>
@endsection