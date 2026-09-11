<!-- Modal -->
@php
use App\Http\Controllers\AESCipher;
@endphp  
<style> 
    table, th,td{
   border: 1px solid rgb(58, 57, 57);
   border-collapse: collapse;
   padding: 1px;
   text-align: center;
 }
 input {
  outline: 0;
  border-width: 0 0 1px;
  border-color: rgb(58, 57, 57)
 }
</style>
<style>
 textarea  {
    outline: 0;
  border-width: 0 0 1px;
  border-color: rgb(58, 57, 57)
  }
</style>
  <style>
    .modal-header
     {
         background-color: rgb(110, 155, 222);
     }
</style>
<div class="modal fade" id="editStudentinfo" tabindex="-1" role="dialog" aria-labelledby="editStudentinfoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 style="font-weight: bold;color:white;" class='col-12 modal-title'>EDIT</h5>
        </div>
            <div id="nonPrintable" class="modal-body">
                <div class="form-group">
                    <form action="/updatePersonal" method="POST" id="updatePesonal"> 
                        @csrf
                  <input type="hidden" class="id" name="id" id="id"  value="" placeholder="" >
                 
                    {{-- <div class="col-sm-12">
                     <div class="row">            
                           Name:
                           <input type="text" class=" col-sm-8 border-0 fullname" name="fullname"  id="fullname"  readonly>
                      </div>
                   </div> --}}
                 </div><hr>
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="address">Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control FirstName @error('FirstName') is-invalid @enderror" name="FirstName" value="{{ old('FirstName') }}"  autocomplete="FirstName" id="FirstName" placeholder="First Name">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="address"></label>
                        <input type="text" class="form-control MiddleName @error('MiddleName') is-invalid @enderror" name="MiddleName" value="{{ old('MiddleName') }}"  autocomplete="MiddleName" id="MiddleName" placeholder="Middle Name">
                      </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address"></label>
                          <input type="text" class="form-control LastName @error('LastName') is-invalid @enderror" name="LastName" value="{{ old('LastName') }}"  autocomplete="LastName" id="LastName" placeholder="Last Name">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Birth Date<span class="text-danger">*</span></label>
                          <input type="date" class="form-control BirthDate @error('BirthDate') is-invalid @enderror" name="BirthDate" value="{{ old('BirthDate') }}"  autocomplete="BirthDate" id="BirthDate">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Age<span class="text-danger">*</span></label>
                          <input type="text" class="form-control Age @error('Age') is-invalid @enderror" name="Age" value="{{ old('Age') }}"  autocomplete="Age" id="Age" readonly>
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Contact No.<span class="text-danger">*</span></label>
                          <input type="text" class="form-control ContactNo @error('ContactNo') is-invalid @enderror" name="ContactNo" value="{{ old('ContactNo') }}"  autocomplete="ContactNo" id="ContactNo">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Civil Status<span class="text-danger">*</span></label>
                          <input type="text" class="form-control civil_status @error('civil_status') is-invalid @enderror" name="civil_status" value="{{ old('civil_status') }}"  autocomplete="civil_status" id="civil_status">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Nationality<span class="text-danger">*</span></label>
                          <input type="text" class="form-control nationality @error('nationality') is-invalid @enderror" name="nationality" value="{{ old('nationality') }}"  autocomplete="nationality" id="nationality">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Religion<span class="text-danger">*</span></label>
                          <input type="text" class="form-control religion @error('religion') is-invalid @enderror" name="religion" value="{{ old('religion') }}"  autocomplete="religion" id="religion">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Address<span class="text-danger">*</span></label>
                          <input type="text" class="form-control brgy @error('brgy') is-invalid @enderror" name="brgy" value="{{ old('brgy') }}"  autocomplete="brgy" id="brgy" placeholder="Brgy">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address"></label>
                          <input type="text" class="form-control city @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}"  autocomplete="city" id="city" placeholder="City">
                        </div>
                      </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address"></label>
                          <input type="text" class="form-control province @error('province') is-invalid @enderror" name="province" value="{{ old('province') }}"  autocomplete="province" id="province" placeholder="Province">
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-sm-5">
                        <div class="form-group">
                          <label for="address">Course<span class="text-danger">*</span></label>
                          <select name="courses" id="courses" class="form-control courses @error('courses') is-invalid @enderror" required>
                              <option disabled selected>-Select-</option>
                                @php
                                $campus = session('campus');
    
                                $coursesList= [
                                    1 => ['Bachelor of Elementary Education','Bachelor of Industrial Technology',"'Bachelor of Science in Civil Engineering'", 'Bachelor of Science in Computer Engineering','Bachelor of Science in Criminology','Bachelor of Science in Electrical Engineering','Bachelor of Science in Food Technology','Bachelor of Science in Hospitality and Management','Bachelor of Science in Information Technology','Bachelor of Science in Mechanical Engineering','Bachelor of Science in Tourism Manangement','Bachelor of Technology and Livelihood Education','Master of Arts in Teaching','Master in Management','Master of Technology Education','Master of Science in Information Technology','Doctor of Philosophy in Technology Management'],
                                    2 => ['Bachelor in Public Administration', 'Bachelor in Social Work', 'Bachelor in Science Teaching'],
                                    3 => ['Bachelor of Elementary Education', 'Bachelor of Physical Education', 'Bachelor of Science in Business Administration', 'Bachelor of Science in Information Technology', 'Bachelor of Secondary Education', 'Doctor of Education', 'Laboratory  High School', 'Master of Arts in Education', 'Senior High School'],
                                    4 => ['Bachelor of Science in Fisheries', 'BSInfoTech', 'Bachelor of Science in Marine Biology', 'Bachelor of Science in Agriculture','Practical Nursing'],
                                    5 => ['Bachelor of Science in Agriculture', 'BSEntrep', 'Bachelor of Secondary Education', 'Bachelor of Science in Industrial Technology', 'Bachelor of Science in Information Technology', 'Bachelor of Science in Management Accounting', 'Bachelor of Science in Office Administration', 'Bachelor of Technology and Livelihood Education'],
                                    6 => ['Bachelor of Agricultural Technology', 'Bachelor of Science in Agriculture', 'Bachelor of Science in Agricultural Engineering', 'Bachelor of Science in Agroforestry', 'Bachelor of Science in Agribusiness', 'Bachelor of Science in Environmental Science', 'Bachelor of Science in Environmental Studies', 'Bachelor of Science in Information Technology', 'Bachelor of Technology and Livelihood Education'],
                                ];

                                $co = $coursesList[$campus] ?? [];
                                @endphp
                            
                                @foreach ($co as $c)
                                <option value="{{ $c }}">{{ $coursesList[$c] ?? $c }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                      <div class="col-sm-4">
                        <div class="form-group">
                          <label for="address">Major<span class="text-danger">*</span></label>
                          <select name="major" id="major" class="form-control major @error('major') is-invalid @enderror" required>
                            <option disabled selected>-Select-</option>
                            @php
                            $campus = session('campus');

                              $majorList = [
                                  1 => ['NONE','Automotive Technology','Drafting Technology', 'Electrical Technology','Electronics Technology','Food Preparation and Services Technology', 'General Education','Heating, Ventilation, Air-Conditioning and Refrigeration Technology', 'Home Economics','Industrial Arts','Information and Communication Technology', 'Networking','Programming','English Language Teaching','Filipino Language Teaching','Mathematics Teaching', 'Science Teaching'],
                                  2 => ['NONE'],
                                  3 => ['English', 'Filipino', 'Mathematics', 'Science', 'Social Studies', 'General Education', 'Human Resource Management', 'Marketing Management', 'Programming'],
                                  4 => ['NONE'],
                                  5 => ['Automotive Technology', 'Electrical Technology', 'Electronics Technology', 'Biological Science', 'English', 'Filipino', 'Mathematics', 'Social Entrepreneurship', 'Culinary Arts','Hospitality Management','Home Economics','Industrial Arts'],
                                  6 => ['English', 'Mathematics', 'Science', 'Agri-Fishery Arts', 'Information  Communication Technology', 'Animal Science', 'Crop Science', 'General'],
                              ];

                            $majors = $majorList[$campus] ?? [];
                            @endphp
                        
                            @foreach ($majors as $major)
                            <option value="{{ $major }}">{{ $majorList[$major] ?? $major }}</option>
                            @endforeach
                       </select>
                        </div>
                      </div>
                      <div class="col-sm-2">
                        <div class="form-group">
                          <label for="address">Accro<span class="text-danger">*</span></label>
                          <select name="accro" id="accro" class="form-control accro @error('accro') is-invalid @enderror" required>
                            <option disabled selected>-Select-</option>
                            @php
                            $campus = session('campus');

                            $courseList = [
                                1 => ['BEED', 'BSCrim', 'BSCE', 'BSComPE', 'BSFT', 'BSHRTM', 'BSHM', 'BSInfoTech', 'BSIT', 'BSME', 'BSEE', 'BSTM', 'BTLEd', 'BIT', 'MAT', 'MM', 'MTE', 'MSIT', 'PhD-TM'],
                                2 => ['BSA', 'BSSW', 'BST'],
                                3 => ['BEED', 'BPEd', 'BSBA', 'BSIT', 'BSED', 'EdD', 'LHS', 'MAEd', 'SHS'],
                                4 => ['BSFi', 'BSInfoTech', 'BSMB', 'BSA','PN'],
                                5 => ['BSA', 'BSEntrep', 'BSED', 'BSIndutech', 'BSIT', 'BSMA', 'BSOA', 'BTLEd'],
                                6 => ['BAT', 'BSA', 'BSAE', 'BSAF', 'BSAB', 'BSE', 'BSES', 'BSIT', 'BTLEd'],
                            ];

                            $courses = $courseList[$campus] ?? [];
                            @endphp
                        
                            @foreach ($courses as $code)
                            <option value="{{ $code }}">{{ $courseList[$code] ?? $code }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-1">
                        <div class="form-group">
                          <label for="address">Year<span class="text-danger">*</span></label>
                          <input type="text" class="form-control StudentYear " name="StudentYear" value=""  id="StudentYear">
                        </div>
                      </div>
                    </div>
                  <br>
                  <div class="modal-footer">
                        <button id="submitBtn" type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
