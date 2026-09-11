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
  
  table, th,td{
   border: 1px solid rgb(0, 0, 0);
   border-collapse: collapse;
   text-align: center;
 }
 input {
  outline: 0;
  border-width: 0 0 1px;
  }
 /* .cert{
    outline: 0;
    border-width: 0 0 0px;
    border-color: rgb(58, 57, 57)
  } */
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
          <p style="font-weight: 700; font-size: 14px; font-style: bold; text-align:center;">Patient Health Record Form</p>
          
        </div>
    </header>
    <footer>
      <div>
        <img src="images/logo/SLSU-QF-MD05.png" alt="" style="width: 140px; height:70px; float-left; vertical-align: top"> &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;<img src="images/logo/sq_star.png" alt="" style="width: 230px; height:80px; vertical-align: middle"> <img src="images/logo/socotec.png" alt="" style="width: 150px; height:60px; float: right"> </span><br>
      </div>
    </footer>
    <main>
      
      <div class="table-responsive">
        <div class="col-sm-12">
          <div id="printPart">
          @if (isset($response))
          @if ($healthHistory === null)
          <input type="hidden" class="col-sm-8 border-0 id" name="patientId" value="{{ $newencryptedId }}" id="id" style="font-weight:400;color:rgb(58, 57, 57)" >
          <input type="hidden" class="col-sm-8 border-0 id" name="EmploymentStatus" value="{{ $response[0]['EmploymentStatus'] ?? '' }}" id="course" style="font-weight:400;color:rgb(58, 57, 57)" >
          <input type="hidden" class="col-sm-8 border-0 id" name="DepartmentName" value="{{ $response[0]['department']['DepartmentName'] ?? '' }}" id="course" style="font-weight:400;color:rgb(58, 57, 57)" >
          <input type="hidden" class="col-sm-8 border-0 id" name="EmailAddress" value="{{ $response[0]['EmailAddress'] ?? '' }}" id="firstname" style="font-weight:400;color:rgb(58, 57, 57)" >         

        <div class="row">
          <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 20px; font-style: bold; text-align:center;color:black;">Patient Health Record Form</div>
        </div>
        <div class="row">
          <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 700; font-size: 18px; font-style: bold; text-align:center;color:black;"><u>PERSONAL DATA</u></div>
        </div>
        <div class=" col-md-12" style="color: #000000">
          Name: <input  class="firstname cert" name="" type="text" value="{{ $response[0]['LastName'] ?? '' }}" id="firstname" style="width:18%;font-weight: 400; font-size: 18px; font-style: bold;text-align:center"> <input  class=" cert" name="middlename" type="text" value="{{ $response[0]['FirstName'] ?? '' }}" id="middlename" style="width:21%;font-weight: 400; font-size: 18px; font-style: bold;text-align:center"> <input  class="lastname cert" name="" type="text" value="{{ $response[0]['MiddleName'] ?? '' }}" id="lastname" style="width:20.8%;font-weight: 400; font-size: 18px; font-style: bold;text-align:center">
          Age: <input  class="age cert" name="" type="text" value="{{$age}}" id="age" style="width:5%;font-weight: 400; font-size: 18px; font-style: bold;">
          Gender: <input  class="gender cert" name="" type="text" value="{{ (new AESCipher)->decrypt($response[0]['Sex']) ?? '' }}" id="gender" style="width:7%;font-weight: 400; font-size: 18px; font-style: bold;">
        </div>
        <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 15px; font-style: italic;">
          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Last)
          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&nbsp;(First)
          &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;(Middle)
        </div>
        <div class="col-md-12" style="color: #000000">
          Date of Birth: <input class="bday cert" name="" type="text" value="{{ date('m-d-Y', strtotime((new AESCipher)->decrypt($response[0]['DateOfBirth']) ?? '')) }}" id="bday" style="width:20%;font-weight: 400; font-size: 18px; font-style: bold;">
          Civil Status: <input  class="civil_status cert" name="" type="text" value="{{ (new AESCipher)->decrypt($response[0]['CivilStatus']) ?? '' }}" id="civil_status" style="width:11%;font-weight: 400; font-size: 18px; font-style: bold;">
          Nationality: <input  class="nationality cert" name="" type="text" value="{{ (new AESCipher)->decrypt($response[0]['Citizenship']) ?? '' }}" id="nationality" style="width:11%;font-weight: 400; font-size: 18px; font-style: bold;">
          Religion: <input  class="religion cert" name="" type="text" value="" id="religion" style="width:13%;font-weight: 400; font-size: 18px; font-style: bold;">
        </div>
        <div class="col-md-12" style="color: #000000">
          Home Address: <input  class="fullname cert" name="" type="text" value="{{ (new AESCipher)->decrypt($response[0]['RBarangay']) ?? '' }} {{ $response[0]['rcitymun']['citymunDesc'] ?? '' }} {{ $response[0]['rprovince']['provDesc'] ?? '' }}" id="fullname" style="width:90.4%;font-weight: 400; font-size: 18px; font-style: bold;">
        </div>
        <div class="col-md-12" style="color: #000000">
          Father's Name: <input  class="father_name cert" name="" type="text" value="" id="father_name" style="width:40.2%;font-weight: 400; font-size: 18px; font-style: bold;">
          Mother's Name: <input  class="mother_name cert" name="" type="text" value="" id="mother_name" style="width:39.6%;font-weight: 400; font-size: 18px; font-style: bold;">
        </div>
        <div class="col-md-12" style="color: #000000">
          Occupation: <input  class="father_occu cert" name="" type="text" value="" id="father_occu" style="width:42%;font-weight: 400; font-size: 18px; font-style: bold;">
          Occupation: <input  class="mother_occu cert" name="" type="text" value="" id="mother_occu" style="width:42%;font-weight: 400; font-size: 18px; font-style: bold;">
        </div>
        <div class="col-md-12" style="color: #000000">
          Office Address: <input  class="fullname cert" name="" type="text" value="" id="fullname" style="width:40.1%;font-weight: 400; font-size: 18px; font-style: bold;">
          Office Address: <input  class="fullname cert" name="" type="text" value="" id="fullname" style="width:40.1%;font-weight: 400; font-size: 18px; font-style: bold;">
        </div>
        <div class="col-md-12" style="color: #000000">
          Guardian: <input  class="emer_name cert" name="" type="text" value="" id="emer_name" style="width:43.3%;font-weight: 400; font-size: 18px; font-style: bold;">
          Parent's/Guardian Contact No.: <input  class="fullname cert" name="" type="text" value="" id="fullname" style="width:30.8%%;font-weight: 400; font-size: 18px; font-style: bold;">
        </div>
        <div class="col-md-12" style="color: #000000">
          Guardian Address: <input  class="emer_street cert" name="" type="text" value="" id="emer_street" style="width:38.2%;font-weight: 400; font-size: 18px; font-style: bold;">
          Student's Contact No.: <input  class="fullname cert" name="" type="text" value="{{ $response[0]['Cellphone'] ?? '' }}" id="fullname" style="width:36%;font-weight: 400; font-size: 18px; font-style: bold;">
        </div>
        <br>
        <div class="line" style="border-bottom: 1px solid rgb(0, 0, 0);margin:3px"></div>
        <div class="line" style="border-bottom: 1px solid rgb(0, 0, 0);margin:3px"></div>
          <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 18px; font-style: bold; text-align:center;color:black;">PLEASE CHECK THE BOX IF ONE OF THE FOLLOWING IS APPLICABLE</div>
        <br>
          <div class="title">
            <div class="col-lg-12 d-flex justify-content-center" style="font-weight: 700; font-size: 18px; font-style: bold; text-align:center;color:black;"><u>MEDICAL AND SOCIAL HEALTH HISTORY</u></div>
          </div>
            {{-- Family Health History --}}
            <table class="table table-sm">
              <tr>
                <td style="border:1px solid rgb(0, 0, 0);width:50%;">
                  <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;color:black;">Family Health History:</div> 
                  <div class="row" >
                    <div class="col-sm-4">
                      {{-- <h6 style="font-weight:500;">Family Health History:</h6> --}}
                      <div class="form-group text-left">
                        <input type="checkbox" id="cancer" name="family_his[]" value="Cancer" style="margin-right:5%">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="cancer">Cancer</label><br>
                        <input type="checkbox" id="heart" name="family_his[]" value="Heart disease">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="heart">Heart disease</label><br>
                        <input type="checkbox" id="hypertension" name="family_his[]" value="Hypertension">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="hypertension">Hypertension</label><br>
                        <input type="checkbox" id="thyroid" name="family_his[]" value="Thyroid Disease">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="thyroid">Thyroid Disease</label><br>
                        <input type="checkbox" id="tuberculosis" name="family_his[]" value="Tuberculosis">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="tuberculosis">Tuberculosis</label><br>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group text-left">
                        <input type="checkbox" id="diabetesmellitus" name="family_his[]" value="Diabetes_Mellitus">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="diabetesmellitus">Diabetes Mellitus</label><br>
                        <input type="checkbox" id="mental" name="family_his[]" value="Mental Disorder">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="mental">Mental Disorder</label><br>
                        <input type="checkbox" id="Asthma_FamHis" name="family_his[]" value="Asthma_FamHis">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Asthma_FamHis">Asthma</label><br>
                        <input type="checkbox" id="convulsion" name="family_his[]" value="Convulsion">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="convulsion">Convulsion</label><br>
                        <input type="checkbox" id="bleeding" name="family_his[]" value="Bleeding Dyscrasia">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="bleeding">Bleeding Dyscrasia</label><br>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group text-left">
                        <input type="checkbox" id="eye" name="family_his[]" value="Eye Disorder">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="vehiceyele1">Eye Disorder</label><br>
                        <input type="checkbox" id="skin" name="family_his[]" value="Skin Problem">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="skin">Skin Problem</label><br>
                        <input type="checkbox" id="kidney" name="family_his[]" value="Kidney Problem">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="kidney">Kidney Problem</label><br>
                        <input type="checkbox" id="gastrointestinal" name="family_his[]" value="Gastrointestinal disease">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="gastrointestinal">Gastrointes Disease</label><br>
                        <input type="checkbox" id="othersFamhis" name="family_his[]" value="othersFamhis">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="othersFamhisCheckbox">Others:</label>
                        <input class="cert othersFamhis" type="text" id="othersFamhis" name="othersFamhis" value="" style="width: 55%" disabled>
                      </div>
                    </div>
                  </div>
                </td>
                <td style="border:1px solid rgb(0, 0, 0);">
                  <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;color:black;">Personal Social History:</div> 
                    <div class="form-group text-left"><input type="checkbox" id="smoking" name="personal_his[]" value="Smoking">
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="smoking">Smoking&nbsp;(</label>
                      <input class="cert sticksPerDay" type="number" id="sticksPer" name="sticksPerDay" style="width: 10%" value="" disabled>
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="day">Sticks/day</label>
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="year">for</label>
                      <input class="cert forYears" type="number" id="Years" name="forYears" value="" style="width: 10%" disabled>
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="year"> year/s)</label>
                    </div>                             
              </td>
              </tr>
              <tr>
                <td style="border: 1px solid rgb(0, 0, 0);">
                  <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;color:black;">Personal Health History:</div> 
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group text-left" >
                        <div>
                          <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;color:black;"><u>Past Illness</u></div>
                        </div>
                          <input type="checkbox" id="PrimaryComlex" name="past_illness[]" value="Primary Complex" style="color:black;">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="PrimaryComlex" >Primary Complex</label><br>
                          <input type="checkbox" id="ChickenPox" name="past_illness[]" value="Chicken Pox" style="color:black;">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="ChickenPox" >Chicken Pox</label><br>
                          <input type="checkbox" id="KidneyDisease" name="past_illness[]" value="Kidney Disease" style="color:black;">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="KidneyDisease" >Kidney Disease</label><br>
                          <input type="checkbox" id="TyphoidFever" name="past_illness[]" value="Typhoid Fever" style="color:black;">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="TyphoidFever" >Typhoid Fever</label><br>
                          <input type="checkbox" id="EarProblem" name="past_illness[]" value="Ear Problem" style="color:black;">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="EarProblem" >Ear Problem</label><br>
                          <input type="checkbox" id="HeartDisease" name="past_illness[]" value="Heart Disease" style="color:black;">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="HeartDisease" >Heart Disease</label><br>
                          <input type="checkbox" id="Leukemia" name="past_illness[]" value="Leukemia" style="color:black;">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Leukemia" >Leukemia</label><br>
                      </div>
                    </div> 
                    <div class="col-sm-4 ">
                      <div class="form-group text-left"><br>
                          <input type="checkbox" id="Asthma_PastIll" name="past_illness[]" value="Asthma_PastIll">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Asthma_PastIll">Asthma</label><br>
                          <input type="checkbox" id="Diabetic" name="past_illness[]" value="Diabetic">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Diabetic">Diabetic</label><br>
                          <input type="checkbox" id="EyeDisorder" name="past_illness[]" value="Eye Disorder">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="EyeDisorder">Eye Disorder</label><br>
                          <input type="checkbox" id="Pneumonia" name="past_illness[]"value="Pneumonia">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Pneumonia">Pneumonia</label><br>
                          <input type="checkbox" id="Dengue" name="past_illness[]" value="Dengue">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Dengue">Dengue</label><br>
                          <input type="checkbox" id="Measle" name="past_illness[]" value="Measless">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Measle">Measles</label><br>
                          <input type="checkbox" id="Hepa" name="past_illness[]" value="Hepa">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Hepa">Hepatitis</label><br>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group  text-left"><br>
                          <input type="checkbox" id="Rheumatic" name="past_illness[]" value="Rheumatic">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Rheumatic">Rheumatic</label><br>
                          <input type="checkbox" id="MentalDisorder" name="past_illness[]" value="Mental Disorder">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="MentalDisorder">Mental Disorder</label><br>
                          <input type="checkbox" id="SkinProblems" name="past_illness[]" value="Skin Problems">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="SkinProblems">Skin Problems</label><br>
                          <input type="checkbox" id="Poliomyelitis" name="past_illness[]" value="Poliomyelitis">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Poliomyelitis">Poliomyelitis</label><br>
                          <input type="checkbox" id="ThyriodDisorder" name="past_illness[]" value="Thyriod Disorder">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="ThyriodDisorder">Thyriod Disorder</label><br>
                          <input type="checkbox" id="Anemia" name="past_illness[]" value="Anemia">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Anemia">Anemia</label><br>
                          <input type="checkbox" id="Mumps" name="past_illness[]" value="Mumpss">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Mumps">Mumps</label>
                      </div>
                    </div>
                  </div>
                </td>
                <td style="border:1px solid rgb(0, 0, 0);">
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group text-left" >
                        <div>
                          <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;color:black;"><u>Present Illness</u></div>
                        </div>
                        <input type="checkbox" id="ChestPain" name="present_illness[]" value="Chest Pain">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="ChestPain">Chest Pain</label><br>
                          <input type="checkbox" id="Insomnia" name="present_illness[]" value="Insomnia">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Insomnia">Insomnia</label><br>
                          <input type="checkbox" id="JointPains" name="present_illness[]" value="Joint Pains">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="JointPains">Joint Pains</label><br>
                          <input type="checkbox" id="Dizziness" name="present_illness[]" value="Dizziness">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Dizziness">Dizziness</label><br>    
                          <input type="checkbox" id="othersPre" name="present_illness[]" value="othersPreIll">        
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="vehicle2">Others:</label>
                          <input class="cert othersPres" type="text" id="othersPre" name="othersPreIll" value="" style="width:55%" disabled>       
                      </div>
                    </div>
                    <div class="col-sm-3 ">
                      <div class="form-group text-left"><br>
                        <input type="checkbox" id="Headeaches" name="present_illness[]" value="Headeaches">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Headeaches">Headeaches</label><br>
                        <input type="checkbox" id="Indigestion" name="present_illness[]" value="Indigestion">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Indigestion">Indigestion</label><br>
                        <input type="checkbox" id="Swollen" name="present_illness[]" value="Swollen Fest">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Swollen">Swollen Fest</label><br>
                        <input type="checkbox" id="Weight" name="present_illness[]" value="Weight Loss">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Weight">Weight Loss</label><br>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group  text-left"><br>
                        <input type="checkbox" id="Nuesea" name="present_illness[]" value="Nuesea Vomiting">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Nuesea">Nuesea/Vomiting</label><br>
                        <input type="checkbox" id="Sore" name="present_illness[]" value="Sore Throat">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Sore">Sore Throat</label><br>
                        <input type="checkbox" id="Frequent" name="present_illness[]" value="Frequent Urination">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Frequent">Frequent Urination</label><br>
                        <input type="checkbox" id="Breathing" name="present_illness[]" value="Difficulty of Breathing">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 13px;" for="Breathing">Difficulty of Breathing</label><br>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="border:1px solid rgb(0, 0, 0);font-size:18px;color:#000000" class="text-left" >
                  Do you have a history of hospitalization for serious illness, operation, fracture or injury? <input  class="fullname cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 18px; font-style: bold;width:5%">If yes, please give details: <input  class="col-12 fullname cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 18px; font-style: bold;"> <br>
                  Are you taking any medicine regularly?<input  class="col-1 fullname cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 18px; font-style: bold;">If yes, name of drug/s:<input  class="fullname cert" name="" type="text" value="" id="fullname" style="width:40.8%;font-weight: 400; font-size: 18px; font-style: bold;"><br>
                  Are you allergic to any food or medicine?<input  class="col-1 fullname cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 18px; font-style: bold;">If yes, specify:<input  class=" fullname cert" name="" type="text" value="" id="fullname" style="width:46.2%;font-weight: 400; font-size: 18px; font-style: bold;">
                </td>
              </tr>
              <tr>
                <td colspan="2" style="border:1px solid rgb(0, 0, 0);" class="text-left">
                  <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 16px;color:black;"><u>Immunization History:</u></div> 
                    <div class="row">
                      <div class="col-sm-2">
                        <div class="form-group">
                          <input type="checkbox" id="BGC" name="immunization_his[]" value="BGC">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="BGC">BGC</label><br>
                          <input type="checkbox" id="chic" name="immunization_his[]" value="ChickenPox">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="chic">Chicken Pox</label><br>
                          <input type="checkbox" id="COVID" name="immunization_his[]" value="COVID-19">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="COVID">COVID-19</label><br>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <input type="checkbox" id="Polio" name="immunization_his[]" value="Polio Vaccine">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Polio">Polio Vaccine I,II,III, Booster Dose</label><br>
                          <input type="checkbox" id="DTP" name="immunization_his[]" value="DTP Vaccine">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="DTP">DTP I,II,II, Booster Dose</label><br>
                          <input type="checkbox" id="others" name="immunization_his[]" value="othersImmu">        
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="vehicle2">Others:</label>
                          <input class="cert othersImmu" type="text" id="others" name="othersImmu" value="" style="width:70%" disabled>
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <input type="checkbox" id="MumpsImmu" name="immunization_his[]" value="MumpsImmunization">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="MumpsImmu">Mumps</label><br>
                          <input type="checkbox" id="MeaslesImmu" name="immunization_his[]" value="MeaslesImmu">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="MeaslesImmu">Measles</label><br>
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <input type="checkbox" id="Typhoid" name="immunization_his[]" value="Typhoid">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Typhoid">Typhoid</label><br>
                          <input type="checkbox" id="German" name="immunization_his[]" value="GermanMeasles">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="German">German Measles</label><br>
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <input type="checkbox" id="hepatitis_A" name="immunization_his[]" value="hepatitis-A">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Hepatitis-A">Hepatitis A</label><br>
                          <input type="checkbox" id="hepatitis_B" name="immunization_his[]" value="hepatitis-B">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 14px;" for="Hepatitis-B">Hepatitis B</label><br>
                        </div>
                      </div>
                    </div>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="border:1px solid rgb(0, 0, 0);font-size:18px;color:#000000" class="text-left" >
                  <div class="d-flex justify-content-left" style="font-weight: 500; font-size: 18px;color:black;font-style: italic;"> I hereby certify that the foregoing answers are true and complete, and to the best of my knowledge.</div> <br>
                  <input  class="fullname cert" name="" type="text" value="" id="fullname" style="width:25%;font-weight: 400; font-size: 18px; font-style: bold;margin-right:30px;margin-left:40px"> <input  class="fullname cert" name="" type="text" value="" id="fullname" style="width:45%;font-weight: 400; font-size: 18px; font-style: bold;margin-right:50px;"> <input  class="fullname cert" name="" type="text" value="" id="fullname" style="width:15%;font-weight: 400; font-size: 18px; font-style: bold;">
                  <br>
                  <label style="font-size:18px;text-transform: capitalize;color:black;margin-right:100px;margin-left:100px" for="Headeaches">Signature of Student</label> <label style="font-size:18px;text-transform: capitalize;color:black;margin-right:140px" for="Headeaches">Signature of Parent/Guardian over Printed Name</label> <label style="font-size:18px;text-transform: capitalize;color:black;" for="Headeaches">Date Signed</label>
                </td>
              </tr>
            </table>
             @elseif($healthHistory !== null) 
             <input type="hidden" class=" col-sm-8 border-0 id" name="patientId" value="{{$newencryptedId}}" id="id" style="font-weight:400;color:rgb(58, 57, 57);margin-bottom:6px" >
            <div class="row">
              <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 700; font-size: 12px; font-style: bold; text-align:left;color:black;margin-bottom:3px"><u>PERSONAL DATA</u></div>
            </div>
            <div class="col-md-12" style="color: #000000; font-size: 12px; display: flex; align-items: center; gap: 5px;">
              <label for="firstname">Name:</label>
              <input class="firstname cert" type="text" id="firstname" style="width:18%; font-weight: 400; font-size: 11px; text-align: center;font-style: bold;" value="{{$firstname}}">
              <input class="cert" name="middlename" type="text" id="middlename" style="width:21%; font-weight: 400; font-size: 11px; text-align: center;font-style: bold;" value="{{$middlename}}">
              <input class="lastname cert" type="text" id="lastname" style="width:20.8%; font-weight: 400; font-size: 11px; text-align: center;font-style: bold;" value="{{$lastname}}">
              
              <label for="age">Age:</label>
              <input class="age cert" type="text" id="age" value="{{$age}}" style="width:5%; font-weight: 400; font-size: 11px;font-style: bold;">
              
              <label for="gender">Gender:</label>
              <input class="gender cert" type="text" id="gender"  value="{{$sex}}" style="width:10.3%; font-weight: 400; font-size: 11px;font-style: bold;">
            </div>

            <div class="col-lg-12 d-flex justify-content-left" style="font-weight: 400; font-size: 15px; font-style: italic;font-size: 11px;">
              <span style="margin-right:16%;margin-left:13%">(Last)</span>
              <span style="margin-right:8%;">(First)</span>
              <span style="margin-left:9%">(Middle)</span>
            </div>
            <div class="col-md-12" style="color: #000000;font-size: 12px;">
              Date of Birth: <input class="bday cert" name="" type="text" value="{{$dateofbirth}}" id="bday" style="width:20%; font-size: 11px; font-style: bold;">
              Civil Status: <input  class="civil_status cert" name="" type="text" value="{{$civilstatus}}" id="civil_status" style="width:12%; font-size: 11px; font-style: bold;">
              Nationality: <input  class="nationality cert" name="" type="text" value="{{$citizinship}}" id="nationality" style="width:11%; font-size: 11px; font-style: bold;">
              Religion: <input  class="religion cert" name="" type="text" value="" id="religion" style="width:12%; font-size: 11px; font-style: bold;">
            </div>
            <div class="col-md-12" style="color: #000000;font-size: 12px;">
              Home Address: <input  class="fullname cert" name="" type="text" value="" id="fullname" style="width:86.2%; font-size: 11px; font-style: bold;">
            </div>
            <div class="col-md-12" style="color: #000000;font-size: 12px;">
              Father's Name: <input  class="father_name cert" name="" type="text" value="" id="father_name" style="width:35.2%; font-size: 11px; font-style: bold;">
              Mother's Name: <input  class="mother_name cert" name="" type="text" value="" id="mother_name" style="width:36.8%; font-size: 11px; font-style: bold;">
            </div>
            <div class="col-md-12" style="color: #000000;font-size: 12px;">
              Occupation: <input  class="father_occu cert" name="" type="text" value="" id="father_occu" style="width:37.4%; font-size: 11px; font-style: bold;">
              Occupation: <input  class="mother_occu cert" name="" type="text" value="" id="mother_occu" style="width:39.8%;font-size: 11px; font-style: bold;">
            </div>
            <div class="col-md-12" style="color: #000000;font-size: 12px;">
              Office Address: <input  class="fullname cert" name="" type="text" value="" id="fullname" style="width:34.5%; font-size: 11px; font-style: bold;">
              Office Address: <input  class="fullname cert" name="" type="text" value="" id="fullname" style="width:37%; font-size: 11px; font-style: bold;">
            </div>
            <div class="col-md-12" style="color: #000000;font-size: 12px;">
              Guardian: <input  class="emer_name cert" name="" type="text" value="" id="emer_name" style="width:39%;font-size: 11px; font-style: bold;">
              Parent's/Guardian Contact No.: <input  class="fullname cert" name="" type="text" value="" id="fullname" style="width:25.2%; font-size: 11px; font-style: bold;">
            </div>
            <div class="col-md-12" style="color: #000000;font-size: 12px;margin-bottom:10px">
              Guardian Address: <input  class="emer_street cert" name="" type="text" value="" id="emer_street" style="width:32.3%;font-size: 11px; font-style: bold;">
              Student's Contact No.: <input  class="fullname cert" name="" type="text" value="" id="fullname" style="width:32%;font-size: 11px; font-style: bold;">
            </div>
            <div class="line" style="border-bottom: 1px solid rgb(0, 0, 0);margin:3px"></div>
            <div class="line" style="border-bottom: 1px solid rgb(0, 0, 0);margin:3px"></div>
          <div class="div" style="text-align:center;margin-bottom:10px">
             <span style="text-align:center; font-weight:bold;color:black;font-size:14px">PLEASE CHECK THE BOX IF ONE OF THE FOLLOWING IS APPLICABLE</span><br>
            <span style="text-decoration: underline; text-align:center;font-weight: bold;color:black;font-size: 12px">MEDICAL AND SOCIAL HEALTH HISTORY</span>
          </div>
              {{-- Family Health History --}}
          <table class="table table-sm" style="width:100%">
            <tr>
              <td style="width:21%;border-style:inset">
                <div class="d-flex justify-content-left" style="font-weight: 600; font-size: 12px;color:black;text-align: left;">Family Health History:</div> 
                  <div class="row" >
                    <div class="col-sm-4" style="text-align: left;">
                      <div class="form-group">
                        <input type="checkbox" id="cancer" name="family_his[]" value="Cancer" >
                        <label for="cancer" style="text-transform: capitalize; color: black; font-weight: 400; font-size: 11px;">Cancer</label><br>
                        <input type="checkbox" id="heart" name="family_his[]" value="Heart disease">
                        <label for="heart" style="text-transform: capitalize; color: black; font-weight: 400; font-size: 11px;">Heart disease</label><br>
                        <input type="checkbox" id="hypertension" name="family_his[]" value="Hypertension">
                        <label for="hypertension" style="text-transform: capitalize; color: black; font-weight: 400; font-size: 11px;">Hypertension</label><br>
                        <input type="checkbox" id="thyroid" name="family_his[]" value="Thyroid Disease">
                        <label for="thyroid" style="text-transform: capitalize; color: black; font-weight: 400; font-size: 11px;">Thyroid Disease</label><br>
                        <input type="checkbox" id="tuberculosis" name="family_his[]" value="Tuberculosis">
                        <label for="tuberculosis" style="text-transform: capitalize; color: black; font-weight: 400; font-size: 11px;">Tuberculosis</label><br>
                      </div>
                    </div>
                </td>
                <td style="width:15%">
                    <br>
                    <div class="col-sm-4" style="text-align: left;">
                      <div class="form-group">
                        <input type="checkbox" id="diabetesmellitus" name="family_his[]" value="Diabetes_Mellitus">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 9px;" for="diabetesmellitus">Diabetes Mellitus</label><br>
                        <input type="checkbox" id="mental" name="family_his[]" value="Mental Disorder">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="mental">Mental Disorder</label><br>
                        <input type="checkbox" id="Asthma_FamHis" name="family_his[]" value="Asthma_FamHis">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Asthma_FamHis">Asthma</label><br>
                        <input type="checkbox" id="convulsion" name="family_his[]" value="Convulsion">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="convulsion">Convulsion</label><br>
                        <input type="checkbox" id="bleeding" name="family_his[]" value="Bleeding Dyscrasia">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 9px;" for="bleeding">Bleeding Dyscrasia</label><br>
                      </div>
                    </div>
                </td>
                <td  colspan="2">
                  <br>
                      <div class="col-sm-4" style="text-align: left;">
                      <div class="form-group">
                        <input type="checkbox" id="eye" name="family_his[]" value="Eye Disorder">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="vehiceyele1">Eye Disorder</label><br>
                        <input type="checkbox" id="skin" name="family_his[]" value="Skin Problem">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="skin">Skin Problem</label><br>
                        <input type="checkbox" id="kidney" name="family_his[]" value="Kidney Problem">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="kidney">Kidney Problem</label><br>
                        <input type="checkbox" id="gastrointestinal" name="family_his[]" value="Gastrointestinal disease">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="gastrointestinal">Gastrointes Disease</label><br>
                        <input type="checkbox" id="othersFam" name="family_his[]" value="othersFamhis">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="vehicle2">Others:</label>
                        <input class="cert othersFamhis" type="text" id="othersFam" name="othersFamhis" value="{{$response->othersFamhis}}" style="width: 55%" disabled>
                      </div>
                    </div>
                </td>
                <td colspan="2">
                  <div class="d-flex justify-content-left" style="font-weight: 600; font-size: 12px;color:black;text-align: left;">Personal Social History:</div> 
                    <div class="row" style="text-align:left">
                        <div class="col-sm-10">
                          <br>
                          <div class="form-group text-left"><input type="checkbox" id="smoking" name="personal_his[]" value="Smoking">
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 10px;" for="smoking">Smoking&nbsp;(</label>
                            <input class="cert sticksPerDay" type="number" id="sticksPer" name="sticksPerDay" style="width: 10px%" value="" disabled>
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 10px;" for="day">Sticks/day</label>
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 10px;" for="year">for</label>
                            <input class="cert forYears" type="number" id="Years" name="forYears" value="" style="width: 10%" disabled>
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 10px;" for="year"> year/s)</label>
                          </div>
                        </div>
                        <div class="col-sm-10">
                            <div class="form-group text-left"><br>
                                <input type="checkbox" id="drinking" name="personal_his[]" value="Drinking">
                                <label  style="text-transform: capitalize;color:black;font-weight: 400; font-size: 10px;" for="drinking">Drinking&nbsp;(</label>
                                <input class="cert shot" type="number" id="shot" name="shotPerday" value="" style="width: 10%" disabled>
                                <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 10px;" for="shots">shot per</label>
                                <input class="cert beerPer" type="number" id="beerPer" name="beerPerday" value="" style="width: 10%" disabled>
                                <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 10px;" for="shots">)</label>
                                <br>
                                <label  style="text-transform: capitalize;color:black;margin-left:17.1%;font-weight: 400; font-size: 10px;" for="drinking">(</label>
                                <input class="cert" type="number" id="" name="shotPerday" value="" style="width: 10%" disabled>
                                <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 10px;" for="shots">beer per</label>
                                <input class="cert" type="number" id="" name="shotPerday" value="" style="width: 10%" disabled>
                                <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 10px;" for="shots">)</label>
                            </div>
                        </div>
                    </div> 
                </td>
              </tr>
                <tr>
                  <td>
                     <div class="d-flex justify-content-left" style="font-weight: 600; font-size: 12px;color:black;text-align: left;">Personal Health History:</div> 
                    {{-- <div class="row"> --}}
                      <div class="col-sm-4"  style="text-align: left;">
                        <div class="form-group text-left" >
                          <div>
                            <div class="d-flex justify-content-left" style="font-weight: 600; font-size: 12px;color:black;;text-align: left;"><u>Past Illness</u></div>
                          </div>
                            <input type="checkbox" id="PrimaryComlex" name="past_illness[]" value="Primary Complex" style="color:black;">
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="PrimaryComlex" >Primary Complex</label><br>
                            <input type="checkbox" id="ChickenPox" name="past_illness[]" value="Chicken Pox" style="color:black;">
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="ChickenPox" >Chicken Pox</label><br>
                            <input type="checkbox" id="KidneyDisease" name="past_illness[]" value="Kidney Disease" style="color:black;">
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="KidneyDisease" >Kidney Disease</label><br>
                            <input type="checkbox" id="TyphoidFever" name="past_illness[]" value="Typhoid Fever" style="color:black;">
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="TyphoidFever" >Typhoid Fever</label><br>
                            <input type="checkbox" id="EarProblem" name="past_illness[]" value="Ear Problem" style="color:black;">
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="EarProblem" >Ear Problem</label><br>
                            <input type="checkbox" id="HeartDisease" name="past_illness[]" value="Heart Disease" style="color:black;">
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="HeartDisease" >Heart Disease</label><br>
                            <input type="checkbox" id="Leukemia" name="past_illness[]" value="Leukemia" style="color:black;">
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Leukemia" >Leukemia</label><br>
                        </div>
                      </div> 
                  </td>
                   <td>
                     <div class="col-sm-4 "  style="text-align: left;">
                        <div class="form-group text-left"><br>
                            <input type="checkbox" id="Asthma_PastIll" name="past_illness[]" value="Asthma_PastIll">
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Asthma_PastIll">Asthma</label><br>
                            <input type="checkbox" id="Diabetic" name="past_illness[]" value="Diabetic">
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Diabetic">Diabetic</label><br>
                            <input type="checkbox" id="EyeDisorder" name="past_illness[]" value="Eye Disorder">
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="EyeDisorder">Eye Disorder</label><br>
                            <input type="checkbox" id="Pneumonia" name="past_illness[]"value="Pneumonia">
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Pneumonia">Pneumonia</label><br>
                            <input type="checkbox" id="Dengue" name="past_illness[]" value="Dengue">
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Dengue">Dengue</label><br>
                            <input type="checkbox" id="Measle" name="past_illness[]" value="Measless">
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Measle">Measles</label><br>
                            <input type="checkbox" id="Hepa" name="past_illness[]" value="Hepa">
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Hepa">Hepatitis</label><br>
                        </div>
                      </div>
                  </td>              
                    <td style="width:16%">
                    <div class="col-sm-4"  style="text-align: left;">
                      <div class="form-group  text-left"><br>
                          <input type="checkbox" id="Rheumatic" name="past_illness[]" value="Rheumatic">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Rheumatic">Rheumatic</label><br>
                          <input type="checkbox" id="MentalDisorder" name="past_illness[]" value="Mental Disorder">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="MentalDisorder">Mental Disorder</label><br>
                          <input type="checkbox" id="SkinProblems" name="past_illness[]" value="Skin Problems">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="SkinProblems">Skin Problems</label><br>
                          <input type="checkbox" id="Poliomyelitis" name="past_illness[]" value="Poliomyelitis">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Poliomyelitis">Poliomyelitis</label><br>
                          <input type="checkbox" id="ThyriodDisorder" name="past_illness[]" value="Thyriod Disorder">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="ThyriodDisorder">Thyriod Disorder</label><br>
                          <input type="checkbox" id="Anemia" name="past_illness[]" value="Anemia">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Anemia">Anemia</label><br>
                          <input type="checkbox" id="Mumps" name="past_illness[]" value="Mumpss">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Mumps">Mumps</label>
                      </div>
                    </div>
                  </td>
                   <td style="width:15%">
                      <div class="col-sm-4"  style="text-align: left;">
                        <div class="form-group text-left" >
                          <div>
                            <div class="d-flex justify-content-left" style="font-weight: 600; font-size: 12px;color:black;"><u>Present Illness</u></div>
                          </div>
                          <input type="checkbox" id="ChestPain" name="present_illness[]" value="Chest Pain">
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="ChestPain">Chest Pain</label><br>
                            <input type="checkbox" id="Insomnia" name="present_illness[]" value="Insomnia">
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Insomnia">Insomnia</label><br>
                            <input type="checkbox" id="JointPains" name="present_illness[]" value="Joint Pains">
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="JointPains">Joint Pains</label><br>
                            <input type="checkbox" id="Dizziness" name="present_illness[]" value="Dizziness">
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Dizziness">Dizziness</label><br>    
                            <input type="checkbox" id="othersPre" name="present_illness[]" value="othersPreIll">        
                            <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="vehicle2">Others:</label>
                            <input class="cert othersPres" type="text" id="othersPre" name="othersPreIll" value="" style="width:55%" disabled>       
                        </div>
                      </div>
                  </td>
                   <td style="width:14%">
                     <div class="col-sm-3 "  style="text-align: left;">
                        <div class="form-group text-left"><br>
                          <input type="checkbox" id="Headeaches" name="present_illness[]" value="Headeaches">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Headeaches">Headeaches</label><br>
                          <input type="checkbox" id="Indigestion" name="present_illness[]" value="Indigestion">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Indigestion">Indigestion</label><br>
                          <input type="checkbox" id="Swollen" name="present_illness[]" value="Swollen Fest">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Swollen">Swollen Fest</label><br>
                          <input type="checkbox" id="Weight" name="present_illness[]" value="Weight Loss">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Weight">Weight Loss</label><br>
                        </div>
                      </div>
                  </td>
                   <td>
                     <div class="col-sm-4"  style="text-align: left;">
                        <div class="form-group  text-left"><br>
                          <input type="checkbox" id="Nuesea" name="present_illness[]" value="Nuesea Vomiting">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 9px;" for="Nuesea">Nuesea/Vomiting</label><br>
                          <input type="checkbox" id="Sore" name="present_illness[]" value="Sore Throat">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Sore">Sore Throat</label><br>
                          <input type="checkbox" id="Frequent" name="present_illness[]" value="Frequent Urination">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 9px;" for="Frequent">Frequent Urination</label><br>
                          <input type="checkbox" id="Breathing" name="present_illness[]" value="Difficulty of Breathing">
                          <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 9px;" for="Breathing">Difficulty of Breathing</label><br>
                        </div>
                      </div>
                  </td>
                  
                </tr>
              <tr>
               <td colspan="6" style="border:1px solid rgb(0, 0, 0);font-size:12px;color:#000000;text-align:left" class="text-left" >
                    Do you have a history of hospitalization for serious illness, operation, fracture or injury? <input  class="fullname cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 12px; font-style: bold;width:5%">If yes, please give details: <input  class="col-12 fullname cert" name="" type="text" value="{{$response->hos_detail}}" id="fullname" style="font-weight: 400; font-size: 12px; font-style: bold;"> <br>
                    Are you taking any medicine regularly?<input  class="fullname cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 12px; font-style: bold;width:10%;">If yes, name of drug/s:<input  class="fullname cert" name="" type="text" value="{{$response->med_detail}}" id="fullname" style="width:35%;font-weight: 400; font-size: 12px; font-style: bold;"><br>
                    Are you allergic to any food or medicine?<input  class=" fullname cert" name="" type="text" value="" id="fullname" style="font-weight: 400; font-size: 12px; font-style: bold;width:10%;">If yes, specify:<input  class=" fullname cert" name="" type="text" value="{{$response->al_detail}}" id="fullname" style="width:35%;font-weight: 400; font-size: 12px; font-style: bold;">
                  </td>
              </tr>
              <tr>
                <td>
                   <div class="d-flex justify-content-left" style="font-weight: 400; font-size: 12px;color:black;"><u>Immunization History:</u></div> 
                    <div class="col-sm-2"  style="text-align: left;">
                      <div class="form-group">
                        <input type="checkbox" id="BGC" name="immunization_his[]" value="">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="BGC">BGC</label><br>
                        <input type="checkbox" id="chic" name="immunization_his[]" value="ChickenPox">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="chic">Chicken Pox</label><br>
                        <input type="checkbox" id="COVID" name="immunization_his[]" value="COVID-19">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="COVID">COVID-19</label><br>
                      </div>
                    </div>
                </td>
                <td colspan="2">
                  <div class="col-sm-4"  style="text-align: left;">
                    <div class="form-group">
                      <input type="checkbox" id="Polio" name="immunization_his[]" value="Polio Vaccine">
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Polio">Polio Vaccine I,II,III, Booster Dose</label><br>
                      <input type="checkbox" id="DTP" name="immunization_his[]" value="DTP Vaccine">
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="DTP">DTP I,II,II, Booster Dose</label><br>
                      <input type="checkbox" id="others" name="immunization_his[]" value="othersImmu">        
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="vehicle2">Others:</label>
                      <input class="cert othersImmu" type="text" id="others" name="othersImmu" value="{{$response->othersImmu}}" style="width:70%" disabled>
                    </div>
                  </div>
                </td>
                {{-- @dd($response->immunization_his) --}}
                <td>
                  <div class="col-sm-2"  style="text-align: left;">
                    <div class="form-group">
                      <input type="checkbox" id="MumpsImmu" name="immunization_his[]" value="MumpsImmunization">
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="MumpsImmu">Mumps</label><br>
                      <input type="checkbox" id="MeaslesImmu" name="immunization_his[]" value="MeaslesImmu">
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="MeaslesImmu">Measles</label><br>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="col-sm-2"  style="text-align: left;">
                    <div class="form-group">
                      <input type="checkbox" id="Typhoid" name="immunization_his[]" value="Typhoid">
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Typhoid">Typhoid</label><br>
                      <input type="checkbox" id="German" name="immunization_his[]" value="GermanMeasles">
                      <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="German">German Measles</label><br>
                    </div>
                  </div>
                </td>
                <td style="width:15%">
                  <div class="col-sm-2"  style="text-align: left;">
                      <div class="form-group">
                        <input type="checkbox" id="hepatitis_A" name="immunization_his[]" value="hepatitis-A">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Hepatitis-A">Hepatitis A</label><br>
                        <input type="checkbox" id="hepatitis_B" name="immunization_his[]" value="hepatitis-B">
                        <label style="text-transform: capitalize;color:black;font-weight: 400; font-size: 11px;" for="Hepatitis-B">Hepatitis B</label><br>
                      </div>
                    </div>
                </td>
              </tr>
              <tr>
                 <td colspan="6" style="border:1px solid rgb(0, 0, 0);font-size:11px;color:#000000;text-align:left" class="text-left" >
                    <div class="d-flex justify-content-left" style="font-weight: 800; font-size: 12px;color:black;font-style: italic;"> I hereby certify that the foregoing answers are true and complete, and to the best of my knowledge.</div> <br>
                    <input  class="fullname cert" name="" type="text" value="" id="fullname" style="width:20%;font-weight: 400; font-size: 11px; font-style: bold;margin-right:30px;margin-left:40px"> <input  class="fullname cert" name="" type="text" value="" id="fullname" style="width:40%;font-weight: 400; font-size: 11px; font-style: bold;margin-right:50px;"> <input  class="fullname cert" name="" type="text" value="" id="fullname" style="width:10%;font-weight: 400; font-size: 11px; font-style: bold;">
                    <br>
                    <label style="font-size:11px;text-transform: capitalize;color:black;margin-right:70px;margin-left:55px" for="Headeaches">Signature of Student</label> <label style="font-size:11px;text-transform: capitalize;color:black;margin-right:75px" for="Headeaches">Signature of Parent/Guardian over Printed Name</label> <label style="font-size:11px;text-transform: capitalize;color:black;" for="Headeaches">Date Signed</label>
                  </td>
              </tr>
              </table>
            @endif
            @else
             <div class="card-panel red lighten-3">
               
             </div>
           @endif
       </div>
      </div>
    </div>
    </main>
  </body>

</html>
