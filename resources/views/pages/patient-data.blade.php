@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Clinic Management Information System')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
{{-- page-styles --}}
@section('content')
<div class="row">
    <div class="col-12">
        <p>Read full documnetation <a href="https://datatables.net/" target="_blank">here</a></p>
    </div>
</div>
<!-- Zero configuration table -->
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h5> PATIENT HEALTH RECORD</h5>
                </div>

                <div class="col-sm-12">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" aria-controls="home" role="tab"
                        aria-selected="true">
                        <i class='fas fa-user-alt'></i>
                        <span class="align-middle"> Personal Data</span>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile" role="tab"
                        aria-selected="false">
                        <i class='fas fa-briefcase-medical'></i>
                        <span class="align-middle">Medical and Social Health History</span>
                      </a>
                    </li>
                  </ul>

                  <div class="tab-content">
                    <form action="/patient-data" method="get" id="insertData"> 
                      @csrf
                    <div class="tab-pane active" id="home" aria-labelledby="home-tab" role="tabpanel">
                              <div class="table-responsive">   
                                  {{-- <table class="table table-bordered nowrap" id="employeeLeaveList">
                                            <div style="text-align: center"> 
                                               <h6>PERSONAL DATA </h6>
                                           </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Name</label>
                                        <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-3">
                                          <div class="form-group">
                                            <label for="last_name">Last<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" >
                                          </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                              <label for="first_name">First<span class="text-danger">*</span></label>
                                              <input type="text" class="form-control" id="first_name" name="first_name">
                                            </div>
                                          </div>
                                          <div class="col-sm-3">
                                            <div class="form-group">
                                              <label for="middle_name">Middle<span class="text-danger">*</span></label>
                                              <input type="text" class="form-control" id="middle_name" name="middle_name">
                                            </div>
                                          </div>
                                      <div class="col-sm-1">
                                        <div class="form-group">
                                          <label for="age">Age<span class="text-danger">*</span></span></label>
                                          <input type="number" class="form-control" id="age" name="age">
                                        </div>
                                      </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
                                          <label for="gender">Gender<span class="text-danger">*</span></label>
                                          <input type="text" class="form-control" id="gender" name="gender">
                                        </select> 
                                        </div>
                                      </div>
                                    </div>
                                </div>
                              </div>
                                  <div class="row">
                                    <div class="col-md-12">
                                          <form class="form-horizontal custom-form" role="form">
                                            <div class="form-group">
                                            
                                                <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                  <div class="form-group">
                                                    <label for="birthday">Birthdate<span class="text-danger">*</span></label>
                                                    <input class="form-control" type="text" id="birthday" name="BirthDate">
                                                  </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                      <label for="civil">Civil Status<span class="text-danger">*</span></label>
                                                      <input class="form-control" type="text" id="civil" name="civil_status">
                                                    </div>
                                                  </div>
                                                  <div class="col-sm-3">
                                                    <div class="form-group">
                                                      <label for="nationality">Nationality<span class="text-danger">*</span></label>
                                                      <input type="text" class="form-control" id="nationality" name="nationality">
                                                    </div>
                                                  </div>
                                              <div class="col-sm-3">
                                                <div class="form-group">
                                                  <label for="contact-2">Religion<span class="text-danger">*</span></span></label>
                                                  <input type="number" class="form-control" id="religion" name="religion">
                                                </div>
                                              </div>
                                        </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-12">
                                              <form class="form-horizontal custom-form" role="form">
                                                <div class="form-group">
                                                
                                                    <div class="col-sm-12">
                                                      <div class="row">
                                                    <div class="col-sm-12">
                                                      <div class="form-group">
                                                        <label for="address">Home Address<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="address" name="address">
                                                      </div>
                                                    </div>
                                            </div>
                                          </div>
                                          <div class="row">
                                            <div class="col-md-12">
                                                  <form class="form-horizontal custom-form" role="form">
                                                    <div class="form-group">
                                                    
                                                        <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                          <div class="form-group">
                                                            <label for="fname">Father's Name</label>
                                                            <input type="text" class="form-control" id="fname" name="f_name">
                                                          </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                          <div class="form-group">
                                                            <label for="mname">Mother's Name</label>
                                                            <input type="text" class="form-control" id="mname" name="m_name">
                                                          </div>
                                                        </div>
                                                </div>
                                              </div>
                                              <div class="row">
                                                <div class="col-md-12">
                                                      <form class="form-horizontal custom-form" role="form">
                                                        <div class="form-group">
                                                        
                                                            <div class="col-sm-12">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                              <div class="form-group">
                                                                <label for="occupation">Occupation</label>
                                                                <input type="text" class="form-control" id="foccupation" name="f_occupation">
                                                              </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                              <div class="form-group">
                                                                <label for="contact-position">Occupation</label>
                                                                <input type="text" class="form-control" id="foccupation" name="m_occupation">
                                                              </div>
                                                            </div>
                                                    </div>
                                                  </div>
                                                  
                                                  <div class="row">
                                                    <div class="col-md-12">
                                                          <form class="form-horizontal custom-form" role="form">
                                                            <div class="form-group">
                                                            
                                                                <div class="col-sm-12">
                                                            <div class="row">
                                                                <div class="col-sm-6">
                                                                  <div class="form-group">
                                                                    <label for="f_officeadd">Office Address</label>
                                                                    <input type="text" class="form-control" id="f_officeadd" name="f_officeadd">
                                                                  </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                  <div class="form-group">
                                                                    <label for="m_officeadd">Office Address</label>
                                                                    <input type="text" class="form-control" id="m_officeadd" name="m_officeadd">
                                                                  </div>
                                                                </div>
                                                        </div>
                                                      </div>
                                                      <div class="row">
                                                        <div class="col-md-12">
                                                              <form class="form-horizontal custom-form" role="form">
                                                                <div class="form-group">
                                                                
                                                                    <div class="col-sm-12">
                                                                <div class="row">
                                                                    <div class="col-sm-6">
                                                                      <div class="form-group">
                                                                        <label for="guardian">Guardian</label>
                                                                        <input type="text" class="form-control" id="guardian" name="guardian">
                                                                      </div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                      <div class="form-group">
                                                                        <label for="contact-position">Parent's/Guardian Contact No.<span class="text-danger">*</span></label>
                                                                        <input type="text" class="form-control" id="p_contactNo" name="p_contactNo">
                                                                      </div>
                                                                    </div>
                                                            </div>
                                                          </div>
                                                          <div class="row">
                                                            <div class="col-md-12">
                                                                  <form class="form-horizontal custom-form" role="form">
                                                                    <div class="form-group">
                                                                    
                                                                        <div class="col-sm-12">
                                                                    <div class="row">
                                                                        <div class="col-sm-6">
                                                                          <div class="form-group">
                                                                            <label for="contact-position">Guardian Address<span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control" id="g_Address" name="g_Address">
                                                                          </div>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                          <div class="form-group">
                                                                            <label for="contact-position">Student's Contact No.<span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control" id="ContactNo" name="ContactNo">
                                                                          </div>
                                                                        </div>
                                                                    </div>
                                                                 </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  </table> --}}
                                              </div>
                                          </div>    {{-- END TAB 1 --}}
                  
                                          <div class="table-responsive">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <form  action="/patient-information" method="post">
                                                        <div class="form-group">
                                                            <input type="text" id="submitBtn"  class="form-control col-sm-2 submitBtn" placeholder="Student No." autocomplete="off">
                                                        </div>
                                                    </form>
                                                      
                                                    <div class="table-responsive">
                                                      <table class="table studentsTable table-bordered table-striped" id="myTable" style="width:100%">
                                
                                                      </table>
                                                      @include('modal.viewPatientRecord')   
                                                    </div>
                                               </div>
                                            </div>
                                      </div>
                          </form><!-- /.form-horizontal -->   
                      </div>
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
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>

{{-- //UPDATE
// $(document).on("click", "#updateBtn", function() { 
// 		$.ajax({
// 			url: "/updatePatientRecord",
// 			type: "get",
// 			cache: false,
// 			data:{
// 				family_his: $('#family_his').val(),
// 				personal_his: $('#personal_his').val(),
// 				past_illness: $('#past_illness').val(),
// 				present_illness: $('#present_illness').val(),
//                 hospitalization: $('#hospitalization').val(),
// 				medicine_mnt: $('#medicine_mnt').val(),
// 				allergies: $('#allergies').val(),
// 				immunization_his: $('#immunization_his').val(),
			
// 			},
// 			success: function(dataResult){
// 				var dataResult = JSON.parse(dataResult);
// 				if(dataResult.statusCode==200){
// 					$('.viewPatientRec').modal().hide();
// 					alert('Updated successfully!');
// 					location.reload();					
// 				}
// 			}
// 		});
// 	});
// var StudentNo = '';
// $(document).on("keyup", "#submitBtn" , function() {
//         StudentNo = this.value;
//        $('#myTable').DataTable().ajax.reload();

//        });


// 
// $("#myTable").DataTable({
//   "ajax": {
//             'url' : '/patient-information',
//             'type' : 'post',
//             'data' : function(set) {
//                 set.StudentNo = StudentNo
//             } 
//         },
        
//         'aLengthMenu' :[[10,20,50,100,-1],[10,20,50,100,'All']],

//     columns:[
//       {data:'StudentNo',name: 'StudentNo'},
//       {data:'last_name',name: 'last_name'},
//       {data:'first_name',name: 'first_name'},
//       {data:'middle_name',name: 'middle_name'},
//       {data:'Course',name: 'Course'},
//       {data:'year',name: 'year'},
//            {
//                 data: null,
//                 defaultContent: '<button type="button" class="btn btn-default editStudent" data-toggle="modal" data-target="#extraLargeModal"><i class="fa fa-edit"></i></button>',
//                 orderable: false
//             }

//     ]
// }); --}}
@endsection