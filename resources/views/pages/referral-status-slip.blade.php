@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Status')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
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
  .inline-cursor {
    text-align: center;
    font-size: 12px;
    font-weight: 800;
    text-transform: capitalize;
    transition: font-size 0.3s, color 0.3s;
  }

  .inline-cursor:hover {
    font-size: 16px; 
    color: #000000;
    cursor: pointer;
  }
</style>
@endsection
{{-- page-styles --}}
@section('content')
<section id="basic-datatable">
  <div class="row">
    @if (isset($status))
    @if ($request->has('id'))
    <div class="col-md-10">
      <div class="row">
        <div class="col-md-12">
          <div class="card border">
            <div class="card-header  " style="background-color:rgb(110, 155, 222);color:#ffffff;height:50px;font-size:15px;font-weight:800; display: flex; align-items: center;"><i class="fas fa-file-alt" style='font-size:15px'></i> PATIENT RECORDS</div>
              <div class="card-body mt-0 p-1">
                <table class="table recordTable table-bordered table-striped col-sm zero-configuration" id="recordTable">
                  <thead>
                    <tr>
                      <th style="color:white;">Date</th>
                      <th style="color:white;">ReferTo</th>
                      <th style="color:white;">Status</th>
                      <th style="color:white;">Remarks</th>
                      <th style="color:white;">Action</th>
                    </tr>
                  </thead>
                  <tbody id="viewStatus">  
                    @foreach ($status as $data)
                    <tr>    
                      <td>{{ date('m-d-Y', strtotime ($data->date))}}</td>
                      <td> @if (strpos($data->referTo, 'Others') !== false)
                        {{ $data->others }}
                      @else
                        {{ $data->referTo }}
                      @endif</td>
                      <td class="@if($data->status == 'Pending') pending-status @elseif($data->status == 'Approved') approved-status @elseif($data->status == 'Disapproved') disapproved-status @endif">{{$data->status}}</td>
                      <td>{{$data->stat_remarks}}</td>
                      <td>
                        <button type="button" class="btn btn-default print" data-id="{{$data->id}}" data-cert-id="{{$data->id}}" @if($data->status == 'Pending' || $data->status == 'Disapproved') disabled @endif><i class="fa fa-print"></i></button>
                      </td>           
                    </tr>
                    @endforeach  
                  </tbody>
                </table>  
                      </div>
                   <div class="card-footer">
                    <button type="button" class="btn btn-primary btn-custom float-right" id="gotosearch">Back</button>
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
                <label class="inline-cursor" id="firstname">{{$name->firstname}}</label>
              </div>
            </div>                
          </div>
            @elseif ($request->has('to_id'))
            <div class="col-md-10">
            <div class="row">
              <div class="col-md-12">
                <div class="card border">
                  <div class="card-header " style="background-color:rgb(110, 155, 222);color:#ffffff;height:50px;font-size:15px;font-weight:800;"><i class="fas fa-file-alt" style='font-size:15px'></i> PATIENT RECORDS</div>
                    <div class="card-body mt-0 p-1">
                          <div class="table-responsive" >
                            <table class="table recordTable table-bordered table-striped col-sm zero-configuration" id="recordTable">
                              <thead>
                                <tr>
                                  <th style="color:white;">Date</th>
                                  <th style="color:white;">ReferTo</th>
                                  <th style="color:white;">Status</th>
                                </tr>
                              </thead>
                              <tbody id="viewStatus">  
                                @foreach ($status as $data)
                                <tr>    
                                  <td>{{ date('m-d-Y', strtotime ($data->date))}}</td>
                                  <td> @if (strpos($data->referTo, 'Others') !== false)
                                    {{ $data->others }}
                                  @else
                                    {{ $data->referTo }}
                                  @endif</td>
                                  <td class="@if($data->status == 'Pending') pending-status @elseif($data->status == 'Approved') approved-status @elseif($data->status == 'Disapproved') disapproved-status @endif">{{$data->status}}</td>
                                </tr>
                                @endforeach  
                              </tbody>
                            </table>
                          </div>   
                        </div>
                    <div class="card-footer">
                      <button type="button" class="btn btn-primary btn-custom float-right" id="gotosearch">Back</button>
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
                  <label class="inline-cursor" id="firstname">{{$name->firstname}}</label>
                </div>
              </div>                
            </div>
          @endif
          @else
            <div class="card-panel red lighten-3">
              <span class="white-text">{{ session('error') }}</span>
            </div>
          @endif
              {{-- @include('modal.editReferral')
              @include('modal.uploadReturnSlip') --}}
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

document.getElementById("firstname").addEventListener("mouseenter", function() {
  Swal.fire({
    title: "<small>Firstname: <b>{{$name->firstname}}</b></small> <br>" +
           "<small>Middlename: <b>{{$name->middlename}}</b></small> <br>" +
           "<small>Lastname:  <b>{{$name->lastname}}</b></small>",
    icon: "info",
    showConfirmButton: false,
    allowEscapeKey: true,
    timerProgressBar: true,
    toast: true,
    position: "top-end"
  });
});

document.getElementById("firstname").addEventListener("mouseleave", function() {
  Swal.close();
});
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

//Back button
$(document).ready(function(){
        $("#gotosearch").click(function(){
          window.location.href = '/referral-slip'
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