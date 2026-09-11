@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Record')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
    table, th,td,tr{
  border: 1px solid rgb(225, 225, 225);
  border-collapse: collapse;
  padding: 1px;
  text-align: center;
  }

    .container {
      display: flex;
      justify-content: space-between;
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

  .dropdown-item:hover {
    background-color: rgb(110, 155, 222);
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
  }rgb(0, 0, 0)

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
  <div class="row">
    @if (isset($record))
    @if ($request->has('id'))
    <div class="col-md-10">
      <div class="row">
        <div class="col-md-12">
          <div class="card border h-150">
            <div class="card-header border " style="background-color:rgb(110, 155, 222);color:#ffffff;height:50px;font-size:15px;font-weight:800; display: flex; align-items: center;"><i class="fas fa-file-alt" style='font-size:15px'></i> REFERRAL SLIP RECORDS</div>
              <div class="card-body mt-0 p-1">
                <div class="table-responsive view-all">  
                  <table class="table table-sm recordTable table-bordered table-hover datatables" id="recordTable">
                    <thead>
                      <tr>
                        <th style="color:white;">Action</th>
                        <th style="color:white;">Date</th>
                        <th style="color:white;">Referred to</th>
                        <th style="color:white;">Reason for referral</th>  
                        <th style="color:white;">Status</th>  
                        <th style="color:white;">File</th>  
                        <th style="color:white;">Remarks</th> 
                       
                      </tr>
                    </thead>
                    <tbody id="preView">  
                    @foreach ($record as $data)
                      <tr>    
                        <td>
                           <div class="dropdown">
                              <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item @if($data->status == 'Approved') disabled @endif" href="#" data-toggle="modal" data-target="#editReferral" data-id={{$cipher->encrypt($data->id)}}><i class="bx bx-pencil"></i>&nbsp;Edit</a>
                                 <a class="dropdown-item @if($data->status == 'Approved') disabled @endif" href="#" data-toggle="modal" data-target="#deleteReferral" data-id={{$cipher->encrypt($data->id)}}><i class="bx bx-trash"></i>&nbsp;Delete</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item print @if($data->status == 'Pending' || $data->status == '' || $data->status == 'Disapproved' || !empty($data->file_name)) disabled @endif" href="#" data-id={{$cipher->encrypt($data->id)}} ><i class="bx bx-printer"></i>&nbsp;Print</a>
                                <a class="dropdown-item @if($data->status == 'Pending' || $data->status == '' || $data->status == 'Disapproved') disabled @endif" href="#" data-id={{$cipher->encrypt($data->id)}} data-toggle="modal" data-target="#uploadReturnSlip"><i class="bx bx-upload"></i>&nbsp;Upload</a>
                              </div>
                            </div>                                                 
                        </td>
                        <td>{{ date('m-d-Y', strtotime ($data->date))}}</td>
                        <td> @if (strpos($data->referTo, 'Others') !== false)
                              {{ $data->others }}
                            @else
                               {{ $data->referTo }}
                            @endif
                        </td>
                        <td>{{$data->reason}}</td>
                        <td class="@if($data->status == 'Pending') pending-status @elseif($data->status == 'Approved') approved-status @elseif($data->status == 'Disapproved') disapproved-status @endif">{{$data->status}}</td>
                        <td>@if ($data->file_name)
                            <a href="/storage/Laravel/return_slip/{{$data->file_name}}">
                              <img src="/storage/Laravel/return_slip/{{$data->file_name}}" alt="img" width="100" height="70">
                            </a>
                          @endif
                        </td>
                        <td>{{$data->stat_remarks}}</td>
                
                      </tr>
                    @endforeach  
                    </tbody>
                  </table>
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
                <div class="card-footer">
                  <button type="button" class="btn btn-primary btn-custom float-right" id="home">Back</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="card">
            <div class="card-header align-center " style="background-color:rgb(110, 155, 222);display: flex; flex-direction: column; align-items: center; justify-content: center;height:100px;">
                @if ($name->gender === 'Female')
                <img class="img-fluid" src="{{asset('images/logo/42101748.png')}}" alt="branding logo" style="max-width: 80px; max-height: 80px;">
                @elseif ($name->gender === 'Male')
                <img class="img-fluid" src="{{asset('images/logo/43514861.png')}}" alt="branding logo" style="max-width: 80px; max-height: 80px;">
                @endif
            </div> 
            <div class="card-body" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 20px;">
              <label style="font-size: 18px;" id="id">{{$name->patientId}}</label>
              <label class="inline-cursor" id="firstname">{{utf8_decode($name->firstname)}}</label>
              <input class="form-control" name="role" type="" value="{{$role}}" id="" hidden>
            </div>
          </div>                
        </div>
{{-- end if here --}}
        @elseif ($request->has('to_id'))
          <div class="col-md-10">
            <div class="row">
              <div class="col-md-12">
                <div class="card border">
                  <div class="card-header border " style="background-color:rgb(110, 155, 222);color:#ffffff;height:50px;font-size:15px;font-weight:800; display: flex; align-items: center;"><i class="fas fa-file-alt" style='font-size:15px'></i> REFERRAL SLIP RECORDS</div>
                    <div class="card-body mt-0 p-1">
                      <div class="table-responsive view-all">  
                        <table class="table table-sm recordTable table-bordered table-striped datatables" id="recordTable">
                          <thead>
                              <tr>
                                <th style="color:white;">Action</th>
                                <th style="color:white;">Date</th>
                                <th style="color:white;">Referred to</th>
                                <th style="color:white;">Reason for referral</th>  
                                <th style="color:white;">Status</th>  
                                <th style="color:white;">File</th>  
                                <th style="color:white;">Remarks</th> 
                              </tr>
                          </thead>
                          <tbody id="preView">  
                            @foreach ($record as $data)
                              <tr>  
                                <td>
                                  <div class="dropdown">
                                    <span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                      <a class="dropdown-item @if($data->status == 'Approved') disabled @endif" href="#" data-toggle="modal" data-target="#editReferral" data-id={{$cipher->encrypt($data->id)}}><i class="bx bx-pencil"></i>&nbsp;Edit</a>
                                      <a class="dropdown-item @if($data->status == 'Approved') disabled @endif" href="#" data-toggle="modal" data-target="#deleteReferral" data-id={{$cipher->encrypt($data->id)}}><i class="bx bx-trash"></i>&nbsp;Delete</a>
                                      <div class="dropdown-divider"></div>
                                      <a class="dropdown-item print @if($data->status == 'Pending' || $data->status == '' || $data->status == 'Disapproved' || !empty($data->file_name)) disabled @endif" href="#" data-id={{$cipher->encrypt($data->id)}} ><i class="bx bx-printer"></i>&nbsp;Print</a>
                                      <a class="dropdown-item @if($data->status == 'Pending' || $data->status == '' || $data->status == 'Disapproved') disabled @endif" href="#" data-id={{$cipher->encrypt($data->id)}} data-toggle="modal" data-target="#uploadReturnSlip"><i class="bx bx-upload"></i>&nbsp;Upload</a>
                                    </div>
                                  </div>                                           
                              </td>  
                                <td>{{ date('m-d-Y', strtotime ($data->date))}}</td>
                                <td> @if (strpos($data->referTo, 'Others') !== false)
                                        {{ $data->others }}
                                     @else
                                        {{ $data->referTo }}
                                      @endif</td>
                                <td>{{$data->reason}}</td>
                                <td class="@if($data->status == 'Pending') pending-status @elseif($data->status == 'Approved') approved-status @elseif($data->status == 'Disapproved') disapproved-status @endif">{{$data->status}}</td>
                                <td>@if ($data->file_name)
                                <a href="/storage/Laravel/return_slip/{{$data->file_name}}">
                                  <img src="/storage/Laravel/return_slip/{{$data->file_name}}" alt="img" width="100" height="70">
                                </a>
                              @else
                              @endif</td>
                                <td>{{$data->stat_remarks}}</td>
                        
                            </tr>
                            @endforeach  
                          </tbody>
                        </table>
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
                    <div class="card-footer">
                      <button type="button" class="btn btn-primary btn-custom float-right" id="home">Back</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-2">
              <div class="card">
                <div class="card-header align-center " style="background-color:rgb(110, 155, 222);display: flex; flex-direction: column; align-items: center; justify-content: center;height:100px;">
                  @if ($name->gender === 'Female')
                  <img class="img-fluid" src="{{asset('images/logo/42101748.png')}}" alt="branding logo" style="max-width: 80px; max-height: 80px;">
                  @elseif ($name->gender === 'Male')
                  <img class="img-fluid" src="{{asset('images/logo/43514861.png')}}" alt="branding logo" style="max-width: 80px; max-height: 80px;">
                  @endif
                </div> 
                <div class="card-body" style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 20px;">
                  <label style="font-size: 18px;" id="id">{{$name->patientId}}</label>
                  <label class="inline-cursor" id="firstname">{{utf8_decode($name->firstname)}}</label>
                  <input class="form-control" name="role" type="" value="{{$role}}" id="" hidden>
                </div>
              </div>                
            </div>
           @endif
           @else
           <div class="card-panel red lighten-3">
              <span class="white-text">{{ session('error') }}</span>
            </div>
          @endif
        @include('modal.editReferral')
        @include('modal.uploadReturnSlip')
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
//Back button
 $(document).ready(function(){
        $("#home").click(function(){
          window.history.back();
      })
    })

// PRINT
 $(document).on('click', '.print', function(){
    var id = $(this).data('id'); 
    var role = $('input[name="role"]').val();
      
    if (role === 'Student') {
      window.location.href = "/referral-generated-referral-slip?to_id=" + encodeURIComponent(id)  + "&role=Student";
    } else if (role === 'Employee') {
      window.location.href = "/referral-generated-referral-slip?to_id=" + encodeURIComponent(id)  + "&role=Employee";
    }
 });


//Show Modal for UploadSlip
$("#uploadReturnSlip").on("shown.bs.modal", function(e) {
    console.log('hrdthdfg');
    $.ajax({
      type: 'POST',
      url: '/modalUpload',
      data: { id: $(e.relatedTarget).data("id") },
      success: function(response) {

        var referTo = JSON.parse(response.uploadReturnSlip.referTo);
        if (referTo.includes("Others")) {
            referTo = response.uploadReturnSlip.others;
        }

        $('.id').val(response.newID);
        $('.fullname').val(response.uploadReturnSlip.lastname + ', ' + response.uploadReturnSlip.firstname + ' ' + response.uploadReturnSlip.middlename);
        $('.referTo').val(referTo);
        $('.reason').val(response.uploadReturnSlip.reason);
        // $('#file').val(response.uploadReturnSlip.file_name);

        // var fileName = response.data[0].file_name;
        // var iframeSrc = "/storage/Laravel/return_slip/" + fileName;
        // var iframeHtml = '<iframe src="' + iframeSrc + '" frameborder="0" width="100%" height="400"></iframe>';

        // $('.iframe-container').html(iframeHtml);
        }
    });
});

document.getElementById("firstname").addEventListener("mouseenter", function() {
  Swal.fire({
    title: "<small>Firstname: <b>{{utf8_decode($name->firstname)}}</b></small> <br>" +
           "<small>Middlename: <b>{{utf8_decode($name->middlename)}}</b></small> <br>" +
           "<small>Lastname:  <b>{{utf8_decode($name->lastname)}}</b></small>",
    icon: "info",
    showConfirmButton: false,
    allowOutsideClick: true,
    allowEscapeKey: true,
    timerProgressBar: true,
    toast: true,
    position: "top-end"
  });
});

document.getElementById("firstname").addEventListener("mouseleave", function() {
  Swal.close();
});

    
//Show Modal for preview
  $("#editReferral").on("hide.bs.modal", function(e){
      $("input:checkbox").each(function() {
          $(this).prop("checked", false);  
      });
  })

 $("#editReferral").on("shown.bs.modal", function(e){
  const id= $(e.relatedTarget).data("id");
  console.log(id);

    $.ajax({
      type: 'POST',
      url: '/modalView',
      data: { id:id },

      success: function(response) {
        var  referTo = response.view.referTo
        var today = new Date();
        var formattedDate = today.getFullYear()+'-'+(today.getMonth()+1).toString().padStart(2, '0')+'-'+today.getDate().toString().padStart(2, '0');

        $('.id').val(response.newID); 
        $('.patientId').val(response.view.patientId); 
        $('.fullname').val([response.view.firstname]+' '+[response.view.middlename]+' '+[response.view.lastname]);
        
        $('.date').val(formattedDate);
        $('.others').val(response.view.others);
        $('.reason').val(response.view.reason);

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
    var id = $('#cert_id').val();
    var role = form.find('[name="role"]').val();
    console.log(role)

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
          var role = response.role;
          console.log(role);
          if (role === 'Student') {
            window.location.href = "/referral-preview-slip?to_id=" + encodeURIComponent(response.id) + "&role=Student";
          } else if (role === 'Employee') {
            window.location.href = "/referral-preview-slip?to_id=" + encodeURIComponent(response.id)  + "&role=Employee";
          }
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
      
  function selectCheckbox(id) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    var othersInput = document.getElementById('othersinput');

    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].id != id) {
            checkboxes[i].checked = false;
        }
    }

    if (id == 'others') {
        othersInput.disabled = false;
    } else {
        othersInput.disabled = true;
        othersInput.value = '';
    }
  }

$(document).ready(function() {
$('.datatables').DataTable({
    'aLengthMenu' :[[10,20,50,100,-1],[10,20,50,100,'All']],

    "order": [[ 3, "asc" ], [ 0, "desc" ]], 
        "columnDefs": [
            { "orderable": false, "targets": 5 } 
        ]
  })
 });


</script>
@endsection