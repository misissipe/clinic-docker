@extends('layouts.contentLayoutMaster')
{{-- title --}}
@section('title','Status')

{{-- vendor style --}}
@section('vendor-styles')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/css/tables/datatable/datatables.min.css')}}">
<style>
  table,td,tr{
  border: 1px solid rgb(226, 222, 222);
  border-collapse: collapse;
  padding: 1px;
   }
   input {
   outline: 0;
   border-width: 0 0 0px;
   border-color: rgb(58, 57, 57)
   }
   textarea  {
     outline: 0;
   border-width: 0;
   border-color: rgb(58, 57, 57)
   }
   .ph-card-header
   {
       background-color: #3a76c5;
   }
   thead{
     background-color: rgb(110, 155, 222);
   }
   ul
   {  
       cursor:pointer;  
   }  
   li:hover {
   background-color: rgba(220, 225, 229, 0.953);
  }
  .cell-border{
     border-color: rgb(138, 138, 138);
   }
   .border{
     border-color: rgb(0, 0, 0);
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
       position:relative;
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
{{-- page-styles --}}
@section('content')
<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card active">
        <div class="card-content">
          <div class="card-body">
            <label style="font-size:18px">PATIENT LOG-IN STATUS</label>
            <br>
             <form action="/status-logged-out" method="post" id="logoutButton">
             @csrf
            <table class="table table-sm cell-border zero-configuration " id="disToday">
              <thead>
                <tr>
                  <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:10%">date / time </th>
                  <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:20%">name </th>
                  <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:2%">age</th>
                  <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:2%">sex</th>
                  <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:5%">postion / course & year level</th>
                  <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:10%">purpose of visit</th>
                  <th style="color:white;text-align: center;border: 1px solid rgb(226, 222, 222);width:15%">action</th>
                </tr>
              </thead>
              <tbody id="viewAllRecord">
                @foreach ($data as $status)
                <tr>
                  <td style="text-align: center">
                    {{ date('m-d-Y', strtotime($status->date)) }} / {{ date('h:i A', strtotime($status->time)) }}
                  </td>
                  <td style="text-align: left;">
                    @php
                      $lastName   = $status->studentLastName   ?? $status->employeeLastName ?? $status->dependentLastName ;
                      $firstName  = $status->studentFirstName  ?? $status->employeeFirstName ?? $status->dependentFirstName ;
                      $middleName = $status->studentMiddleName ?? $status->employeeMiddleName ?? $status->dependentMiddleName ;
                    @endphp

                    {{ utf8_decode($lastName ?? '') }},
                    {{ utf8_decode($firstName ?? '') }}
                    {{ $middleName ? utf8_decode(substr($middleName, 0, 1)) . '.' : '' }}
                  </td>
                  <td style="text-align: center">{{ $status->age }}</td>
                  <td style="text-align: center">{{ $status->studentSex ?? $status->employeeSex ?? $status->dependentSex  }}</td>
                  <td style="text-align: left">{{ $status->positioncourse }}</td>
                  <td>{{ implode(',', json_decode($status->purpose)) }}</td>
                  <td style="text-align:center">
                    <a href="#" class="dropdown-item logoutButton" data-id="{{ $status->id }}"><i class="fa fa-sign-out"></i> Log Out</a>
                  </td>
                </tr>
                @endforeach
              </tbody> 
            </table>
          </form>
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
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
<script>
$.ajaxSetup({ headers : { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }});
  var patientId = 0;
$(document).on('click', '.logoutButton', function(e) {
  e.preventDefault();

  var id = $(this).data('id');

  Swal.fire({
    title: 'Are you sure?',
    text: "Do you want to log out this record?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'OK',
    cancelButtonText: 'Cancel',
    showDenyButton: true,
    denyButtonText: 'Select Time'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: '/status-logged-out',
        type: 'POST',
        data: { id: id },
          success: function(response) {
            if (response.message === 'Logged out successfully') {
              Swal.fire('Success!', 'The record has been logged out.', 'success')
                .then(() => location.reload());
            } else {
              Swal.fire('Error!', 'Failed to log out record.', 'error');
            }
          },
          error: function(err) {
            console.error(err);
            Swal.fire('Error!', 'Something went wrong.', 'error');
          }
      });
    } else if (result.isDenied) {
      Swal.fire({
        title: 'Select Time',
        input: 'time',
        inputLabel: 'Pick a logout time',
        inputAttributes: {
          step: 60
        },
        showCancelButton: true,
        confirmButtonText: 'Save'
      }).then((timeResult) => {
        if (timeResult.isConfirmed && timeResult.value) {
          $.ajax({
            url: '/status-logged-out',
            type: 'POST',
            data: { 
              id: id,
              time: timeResult.value
            },
            success: function(response) {
              if (response.message === 'Logged out successfully') {
                Swal.fire('Success!', 'The record has been logged out with selected time.', 'success')
                  .then(() => location.reload());
              } else {
                Swal.fire('Error!', 'Failed to log out record.', 'error');
              }
            },
            error: function(err) {
              console.error(err);
              Swal.fire('Error!', 'Something went wrong.', 'error');
            }
          });
        }
      });
    }
  });
});
</script>
@endsection